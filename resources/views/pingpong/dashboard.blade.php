@extends('layouts.app')
@section('title', 'Dashboard — PingPong Mania')
@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
    <div><div class="eyebrow">DASHBOARD PENGGUNA</div><h1 class="page-title">Halo, {{ Auth::user()->name }} 👋</h1><div class="muted">Siap meningkatkan skill pingpong hari ini?</div></div>
    <span class="control-status mt-2"><span id="status-dot" class="status-dot {{ $activeSession ? 'running' : '' }}"></span><span id="status-text">{{ $activeSession ? 'Latihan berjalan' : 'Mesin tidak aktif' }}</span></span>
</div>
<div class="row mb-4">
    <div class="col-md-4 mb-3"><div class="stat-card"><div class="stat-icon">▣</div><div class="stat-number">{{ $totalSessions }}</div><div class="stat-label">Sesi latihan selesai</div></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><div class="stat-icon">◉</div><div class="stat-number">{{ $averageScore === null ? '—' : number_format($averageScore, 0) . '%' }}</div><div class="stat-label">Skor rata-rata (diisi setelah evaluasi)</div></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><div class="stat-icon">◷</div><div class="stat-number">{{ floor($totalSeconds / 3600) }}j {{ floor(($totalSeconds % 3600) / 60) }}m</div><div class="stat-label">Total durasi latihan selesai</div></div></div>
</div>
<div class="hero-banner mb-4"><div class="eyebrow" style="color:#91c7ff">YOUR NEXT SESSION</div><h3 class="mt-2">Latihan yang konsisten, progres yang nyata.</h3><p class="mb-3">Pilih mode latihan dan sesuaikan pengaturan mesin sebelum memulai.</p><a href="#mode-latihan" class="btn btn-light">Atur latihan &nbsp; ↓</a></div>
<div class="row" id="mode-latihan">
    <div class="col-lg-7 mb-4"><div class="panel h-100"><div class="panel-title">Pengaturan Mesin</div><div id="control-alert" class="alert d-none" role="alert"></div>
        <form id="machine-form">
            <div class="form-group"><label for="mode">Mode latihan</label><select class="form-control" id="mode" name="mode"><option value="target_shooting">Target Shooting</option><option value="multi_ball">Multi Ball</option><option value="game_mode">Game Mode</option><option value="custom">Custom Training</option></select></div>
            <div class="form-row"><div class="form-group col-md-6"><label for="speed">Kecepatan bola</label><select class="form-control" id="speed" name="speed"><option value="low">Rendah</option><option value="medium" selected>Sedang</option><option value="high">Tinggi</option></select></div><div class="form-group col-md-6"><label for="interval_seconds">Interval pelontaran</label><select class="form-control" id="interval_seconds" name="interval_seconds"><option value="1">1 detik</option><option value="2" selected>2 detik</option><option value="3">3 detik</option><option value="5">5 detik</option><option value="10">10 detik</option><option value="15">15 detik</option><option value="30">30 detik</option></select></div></div>
            <div class="form-group"><label>Arah bola</label><div class="d-flex flex-wrap" role="group"><label class="btn btn-outline-primary mr-2 mb-2"><input type="radio" name="direction" value="left" autocomplete="off"> Kiri</label><label class="btn btn-outline-primary mr-2 mb-2"><input type="radio" name="direction" value="center" autocomplete="off" checked> Tengah</label><label class="btn btn-outline-primary mr-2 mb-2"><input type="radio" name="direction" value="right" autocomplete="off"> Kanan</label><label class="btn btn-outline-primary mb-2"><input type="radio" name="direction" value="random" autocomplete="off"> Acak</label></div></div>
            <div class="d-flex flex-wrap align-items-center mt-4"><button type="button" id="start-btn" class="btn btn-primary mr-2 mb-2">▶ START</button><button type="button" id="apply-btn" class="btn btn-outline-primary mr-2 mb-2">Terapkan Pengaturan</button><button type="button" id="stop-btn" class="btn btn-danger mb-2">■ STOP</button></div>
            <small class="muted d-block mt-2">Perintah dikirim ke Raspberry Pi melalui jaringan lokal. Jika perangkat tidak tersambung, dashboard akan menampilkan error dan tidak mengklaim mesin berjalan.</small>
        </form>
    </div></div>
    <div class="col-lg-5 mb-4"><div class="panel h-100"><div class="panel-title">Panduan Koneksi</div><div class="d-flex mb-3"><div class="stat-icon mr-3">①</div><div><strong>Pastikan Raspberry Pi aktif</strong><div class="muted">Website dan Raspberry Pi harus berada di jaringan lokal yang dapat saling menjangkau.</div></div></div><div class="d-flex mb-3"><div class="stat-icon mr-3">②</div><div><strong>Periksa konfigurasi server</strong><div class="muted">Isi RASPBERRY_PI_URL dan RASPBERRY_PI_TOKEN di file .env server Laravel.</div></div></div><div class="d-flex"><div class="stat-icon mr-3">③</div><div><strong>Gunakan emergency stop fisik</strong><div class="muted">Jangan jadikan tombol web sebagai satu-satunya cara menghentikan mesin.</div></div></div><hr><div class="panel-title">Sesi Terakhir</div>@if($activeSession)<span class="badge-soft">Sedang berjalan</span><div class="muted mt-2">{{ str_replace('_',' ', ucfirst($activeSession->mode)) }} · {{ ucfirst($activeSession->speed) }} · {{ $activeSession->interval_seconds }} detik</div>@else<div class="muted">Belum ada sesi aktif. Tekan START untuk mengirim perintah ke mesin.</div>@endif</div></div>
</div>
<div class="panel"><div class="d-flex justify-content-between align-items-center flex-wrap"><div class="panel-title mb-0">Riwayat Latihan Terbaru</div><a href="{{ route('training.history') }}" class="btn btn-outline-primary btn-sm">Lihat semua</a></div><div class="table-responsive mt-3"><table class="table"><thead><tr><th>Tanggal</th><th>Mode</th><th>Kecepatan</th><th>Interval</th><th>Arah</th><th>Status</th><th>Durasi</th></tr></thead><tbody>@forelse($sessions as $session)<tr><td>{{ $session->created_at->format('d M Y H:i') }}</td><td>{{ ucwords(str_replace('_',' ',$session->mode)) }}</td><td>{{ ucfirst($session->speed) }}</td><td>{{ $session->interval_seconds }} dtk</td><td>{{ ucfirst($session->direction) }}</td><td>{{ ucfirst($session->status) }}</td><td>{{ floor($session->duration_seconds / 60) }}m {{ $session->duration_seconds % 60 }}s</td></tr>@empty<tr><td colspan="7" class="text-center muted py-4">Belum ada riwayat. Riwayat akan tercatat setelah kamu mengendalikan mesin.</td></tr>@endforelse</tbody></table></div></div>
@endsection
@push('scripts')
<script>
(function(){
    var form=document.getElementById('machine-form'), alertBox=document.getElementById('control-alert');
    function showMessage(message,ok){alertBox.className='alert '+(ok?'alert-success':'alert-danger');alertBox.textContent=message;}
    function settings(){var data={};new FormData(form).forEach(function(value,key){data[key]=value;});return data;}
    function send(action){var payload=settings();payload.action=action;var buttons=form.querySelectorAll('button');buttons.forEach(function(b){b.disabled=true;});
        var endpoint=action==='stop' ? '{{ route('machine.stop') }}' : '{{ route('machine.control') }}';
        fetch(endpoint,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')},credentials:'same-origin',body:JSON.stringify(payload)})
        .then(function(response){return response.json().then(function(body){if(!response.ok){throw new Error(body.message||'Perintah gagal dikirim.');}return body;});})
        .then(function(body){showMessage(body.message,true);if(action==='start'){document.getElementById('status-text').textContent='Perintah diterima';document.getElementById('status-dot').classList.add('running');}if(action==='stop'){document.getElementById('status-text').textContent='Perintah STOP diterima';document.getElementById('status-dot').classList.remove('running');}})
        .catch(function(error){showMessage(error.message||'Terjadi kesalahan koneksi.',false);})
        .finally(function(){buttons.forEach(function(b){b.disabled=false;});});
    }
    document.getElementById('start-btn').addEventListener('click',function(){send('start');});
    document.getElementById('apply-btn').addEventListener('click',function(){send('configure');});
    document.getElementById('stop-btn').addEventListener('click',function(){send('stop');});
})();
</script>
@endpush
