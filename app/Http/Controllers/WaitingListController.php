<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WaitingList;
use Auth;

class WaitingListController extends Controller
{
    /**
     * Mengizinkan user untuk masuk ke daftar tunggu (waiting list)
     */
    public function join(Request $request, $slotId)
    {
        $userId = Auth::id(); // Mengambil ID user yang sedang login

        // 1. Cek apakah user sudah masuk di waiting list untuk slot ini sebelumnya
        $alreadyWaiting = WaitingList::where('user_id', $userId)
                                     ->where('slot_id', $slotId)
                                     ->where('status', 'waiting')
                                     ->exists();

        if ($alreadyWaiting) {
            return redirect()->back()->with('error', 'Anda sudah berada di dalam daftar tunggu slot ini.');
        }

        // 2. Hitung jumlah orang yang sedang mengantre saat ini di slot tersebut
        $currentQueueCount = WaitingList::where('slot_id', $slotId)
                                         ->where('status', 'waiting')
                                         ->count();

        // 3. Tentukan nomor urut posisi (nomor antrean saat ini + 1)
        $nextPosition = $currentQueueCount + 1;

        // 4. Simpan data antrean baru ke database
        WaitingList::create([
            'user_id' => $userId,
            'slot_id' => $slotId,
            'position' => $nextPosition,
            'status' => 'waiting'
        ]);

        return redirect()->back()->with('success', 'Berhasil masuk daftar tunggu! Anda berada di urutan ke-' . $nextPosition);
    }

    /**
     * Jika user membatalkan status waiting list mereka sendiri
     */
    public function cancel($id)
    {
        $waitingItem = WaitingList::findOrFail($id);
        
        // Pastikan hanya pemilik antrean yang bisa membatalkan
        if ($waitingItem->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $slotId = $waitingItem->slot_id;
        $canceledPosition = $waitingItem->position;

        // 1. Ubah status antrean menjadi 'canceled' dan kosongkan nomor posisinya
        $waitingItem->update([
            'status' => 'canceled',
            'position' => 0
        ]);

        // 2. OTOMATISASI: Geser naik semua orang yang mengantre di belakang orang yang batal tadi
        $behindQueues = WaitingList::where('slot_id', $slotId)
                                    ->where('status', 'waiting')
                                    ->where('position', '>', $canceledPosition)
                                    ->get();

        foreach ($behindQueues as $queue) {
            $queue->decrement('position'); // Mengurangi posisi sebesar 1 (Contoh: urutan 3 jadi urutan 2)
        }

        return redirect()->back()->with('success', 'Anda telah keluar dari daftar tunggu.');
    }
}
