<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Services\RaspberryPiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

// Import Model WaitingList dan Mail Notification untuk fitur Daftar Tunggu
use App\Models\WaitingList;
use App\Mail\WaitingListApprovedMail;
use Illuminate\Support\Facades\Mail;

class PingPongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $userId = auth()->id();
        $sessions = TrainingSession::where('user_id', $userId)->latest()->limit(8)->get();
        $totalSessions = TrainingSession::where('user_id', $userId)->where('status', 'completed')->count();
        $averageScore = TrainingSession::where('user_id', $userId)->whereNotNull('score')->avg('score');
        $totalSeconds = (int) TrainingSession::where('user_id', $userId)->where('status', 'completed')->sum('duration_seconds');
        
        // Pengecekan sesi aktif global di mesin Raspberry Pi
        $activeSession = TrainingSession::where('status', 'running')->latest()->first();

        // LOGIKA WAITING LIST UNTUK BLADE VIEW:
        $slotId = 1; // Default ID slot untuk mesin tunggal ini
        
        // Slot penuh jika ada sesi yang berjalan dan yang menggunakan BUKAN user yang sedang login
        $slotPenuh = false;
        if ($activeSession && (int) $activeSession->user_id !== (int) $userId) {
            $slotPenuh = true;
        }

        return view('pingpong.dashboard', compact('sessions', 'totalSessions', 'averageScore', 'totalSeconds', 'activeSession', 'slotId', 'slotPenuh'));
    }

    public function stop(RaspberryPiClient $raspberry)
    {
        // Dedicated endpoint avoids the start/configure rate limiter blocking STOP.
        try {
            $reply = $raspberry->send([
                'action' => 'stop',
                'request_id' => bin2hex(random_bytes(16)),
            ]);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }

        $active = TrainingSession::where('status', 'running')->latest()->first();
        $slotId = 1; // Default ID slot latihan untuk pencarian antrean

        if ($active) {
            $endedAt = Carbon::now();
            $active->ended_at = $endedAt;
            $active->duration_seconds = max(0, $active->started_at ? $active->started_at->diffInSeconds($endedAt) : 0);
            $active->status = 'completed';
            $active->save();

            // LOGIKA OTOMATISASI NAIK ANTREAN WAITING LIST:
            // 1. Cari user di antrean nomor 1 pada slot ini
            $nextQueue = WaitingList::where('slot_id', $slotId)
                                    ->where('status', 'waiting')
                                    ->where('position', 1)
                                    ->first();

            if ($nextQueue) {
                // 2. Ubah status antrean nomor 1 menjadi disetujui (approved)
                $nextQueue->update([
                    'status' => 'approved',
                    'position' => 0 // Set 0 karena sudah keluar dari nomor tunggu antrean
                ]);

                // 3. Kirim notifikasi link email asli dengan SMTP Gmail yang sudah diaktifkan sebelumnya
                try {
                    Mail::to($nextQueue->user->email)->send(new WaitingListApprovedMail($nextQueue->user));
                } catch (\Exception $mailException) {
                    // Mencegah aplikasi crash jika koneksi SMTP internet lokal sedang terputus
                }

                // 4. Geser naik nomor posisi antrean orang-orang di belakangnya (2 jadi 1, 3 jadi 2, dst.)
                $remainingQueues = WaitingList::where('slot_id', $slotId)
                                              ->where('status', 'waiting')
                                              ->orderBy('position', 'asc')
                                              ->get();

                foreach ($remainingQueues as $queue) {
                    $queue->decrement('position');
                }
            }
        }

        return response()->json(['message' => 'Perintah STOP diterima Raspberry Pi dan antrean diperbarui.', 'device' => $reply]);
    }

    public function history(Request $request)
    {
        $query = TrainingSession::where('user_id', auth()->id())->latest();
        if ($request->filled('mode')) {
            $query->where('mode', $request->input('mode'));
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }
        $sessions = $query->paginate(15)->appends($request->only('mode', 'date'));
        return view('pingpong.history', compact('sessions'));
    }

    public function control(Request $request, RaspberryPiClient $raspberry)
    {
        $data = $request->validate([
            'action' => 'required|in:start,configure',
            'mode' => 'required|in:target_shooting,multi_ball,game_mode,custom',
            'speed' => 'required|in:low,medium,high',
            'interval_seconds' => 'required|integer|min:1|max:30',
            'direction' => 'required|in:left,center,right,random',
        ]);

        $userId = auth()->id();
        $action = $data['action'];
        $globalActive = TrainingSession::where('status', 'running')->latest()->first();
        if ($globalActive && (int) $globalActive->user_id !== (int) $userId) {
            return response()->json(['message' => 'Mesin sedang digunakan oleh sesi pengguna lain. Tunggu sampai sesi tersebut dihentikan.'], 409);
        }

        $command = [
            'action' => $action,
            'request_id' => bin2hex(random_bytes(16)),
            'mode' => $data['mode'],
            'speed' => $data['speed'],
            'interval_seconds' => (int) $data['interval_seconds'],
            'direction' => $data['direction'],
        ];

        try {
            // Send to the device first. Database status only changes after Pi accepts the command.
            $deviceReply = $raspberry->send($command);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }

        if ($action === 'start') {
            DB::transaction(function () use ($userId, $data) {
                TrainingSession::where('user_id', $userId)->where('status', 'running')->update([
                    'status' => 'stopped', 'ended_at' => Carbon::now(),
                ]);
                TrainingSession::create([
                    'user_id' => $userId,
                    'mode' => $data['mode'],
                    'speed' => $data['speed'],
                    'interval_seconds' => (int) $data['interval_seconds'],
                    'direction' => $data['direction'],
                    'status' => 'running',
                    'started_at' => Carbon::now(),
                ]);
            });
        } else {
            $active = TrainingSession::where('user_id', $userId)->where('status', 'running')->latest()->first();
            if ($active) {
                $active->mode = $data['mode'];
                $active->speed = $data['speed'];
                $active->interval_seconds = (int) $data['interval_seconds'];
                $active->direction = $data['direction'];
                $active->save();
            }
        }

        return response()->json([
            'message' => $action === 'start' ? 'Perintah START diterima Raspberry Pi.' : ($action === 'stop' ? 'Perintah STOP diterima Raspberry Pi.' : 'Pengaturan latihan dikirim ke Raspberry Pi.'),
            'device' => $deviceReply,
        ]);
    }
}
