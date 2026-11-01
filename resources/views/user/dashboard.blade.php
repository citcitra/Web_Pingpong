@extends('layouts.app')

@section('content')

<div class="container">

    <div class="text-center mb-5">
        <h1>PingPong Mania</h1>
        <p>Every Launch Makes You Better.</p>
    </div>

    {{-- Pesan Notifikasi Sukses / Gagal --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h4>Mode Latihan</h4>
                    <p>Pilih pola latihan sesuai kebutuhan.</p>
                    <button class="btn btn-primary">
                        Pilih Mode
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h4>Kecepatan Bola</h4>
                    <p>Atur kecepatan pelontaran bola.</p>

                    <select class="form-control">
                        <option>Rendah</option>
                        <option>Sedang</option>
                        <option>Tinggi</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h4>Interval Bola</h4>
                    <p>Atur jeda setiap pelontaran.</p>

                    <select class="form-control">
                        <option>2 Detik</option>
                        <option>3 Detik</option>
                        <option>5 Detik</option>
                    </select>

                </div>
            </div>
        </div>

    </div>


    <div class="row">

        <div class="col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">

                    <h4>Arah Bola</h4>

                    <button class="btn btn-secondary m-1">
                        Kiri
                    </button>

                    <button class="btn btn-secondary m-1">
                        Tengah
                    </button>

                    <button class="btn btn-secondary m-1">
                        Kanan
                    </button>

                </div>
            </div>
        </div>


        <div class="col-md-6 mb-4">

            <div class="card text-center">

                <div class="card-body">

                    <h4>Kontrol Latihan</h4>

                    @php
                        // Cek apakah user saat ini sedang ada di antrean aktif untuk slot 1
                        $myQueue = \App\WaitingList::where('user_id', Auth::id())
                                                    ->where('slot_id', $slotId ?? 1)
                                                    ->where('status', 'waiting')
                                                    ->first();
                    @endphp

                    {{-- 1. KONDISI JIKA USER SEDANG MENGANTRE --}}
                    @if($myQueue)
                        <div class="alert alert-warning mb-3">
                            Slot penuh. <strong>Posisi Antrean Anda: Nomor {{ $myQueue->position }}</strong>
                        </div>
                        <form action="{{ route('waiting-list.cancel', $myQueue->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-lg m-2">
                                BATALKAN ANTREAN
                            </button>
                        </form>
                        <button class="btn btn-danger btn-lg m-2" disabled>
                            STOP
                        </button>

                    {{-- 2. KONDISI JIKA SLOT PENUH DAN USER BELUM MENGANTRE --}}
                    @elseif($slotPenuh ?? true)
                        <div class="alert alert-danger mb-3 p-2" style="font-size: 14px;">
                            Mesin sedang digunakan oleh pengguna lain.
                        </div>
                        <form action="{{ route('waiting-list.join', $slotId ?? 1) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg m-2">
                                GABUNG ANTREAN
                            </button>
                        </form>
                        <button class="btn btn-danger btn-lg m-2" disabled>
                            STOP
                        </button>

                    {{-- 3. KONDISI NORMAL JIKA SLOT KOSONG --}}
                    @else
                        <form action="{{ route('machine.control') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg m-2">
                                START
                            </button>
                        </form>

                        <form action="{{ route('machine.stop') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg m-2">
                                STOP
                            </button>
                        </form>
                    @endif

                </div>

            </div>

        </div>

    </div>


    <div class="card">

        <div class="card-body">

            <h4>Riwayat Latihan</h4>

            <table class="table">

                <thead>

                    <tr>
                        <th>Tanggal</th>
                        <th>Mode</th>
                        <th>Kecepatan</th>
                        <th>Durasi</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>28-09-2026</td>
                        <td>Random</td>
                        <td>Sedang</td>
                        <td>10 Menit</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
