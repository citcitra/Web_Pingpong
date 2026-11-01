@extends('layouts.app')
<script src="https://kit.fontawesome.com/319489147f.js"></script>
@section('content')
<div class="container card card-body">
        @if(session('sukses'))
        <div class="alert alert-success" role="alert">
            {{session('sukses')}}
        </div>        
        @endif

<div class="row">
        <div class="col-md-6">
            <h1>Menu Makanan</h1>
        </div>
        <div class="col-md-6">
            <!-- Button trigger modal -->
            <div class="float-right">
                <a href="/laporan/cetak_pdf">
                        
                    <button class="btn btn-primary btn-lg"><i class="fas fa-file-import"> Cetak PDF</i></button>
                </a>
            </div>
            
            

        </div>
    </div>
    <table class="table table-hover">
        
        <tr>
            <th style="padding-left:2%;">ID Transaksi</th>
            <th>Pemesan</th>
            <th>Yang Harus Dibayar</th>
            <th>Uang</th>
            <th>Kembalian</th>
            <th>Status</th>


        </tr>
        @foreach ($laporan as $row)
        <tr>
            <td  style="padding-left:4%;">{{ $row->id_transaksi }}</td>
            <td>{{ $row->nama_pemesan }}</td>
            <td style="padding-left:1%">Rp. {{ $row->subtotal }}</td>
            <td>Rp. {{ $row->bayar }}</td>
            <td>Rp. {{ $row->kembalian }}</td>
            @if ($row->status === 'Belum Bayar')
            <td style="color:red">{{ $row->status }}</td>
        @else
        <td>{{ $row->status }}</td>
        @endif


        </tr>
        @endforeach
    </table>
</div>

{{-- MODAL --}}
@endsection