@extends('layouts.app')
<title>PINGPONG MANIA</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                                <h3>Pembelian</h3>
                        </div>
                        <div class="col-md-3 offset-3">
                            <input type="text" id="myInput" class="form-control" name="" id="" placeholder="Search..">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-hover">
        
                        <tr>
                            <th class="">ID Transaksi</th>
                            <th>Nama Pemesan</th>
                            <th>Subtotal</th>
                            <th class="text-center">Aksi</th>
                
                        </tr>
                        @foreach ($pembayaran as $row)
                        <tbody  id="myTable">
                                <tr>
                            <td style="padding-left:4%;">{{ $row->id_transaksi}}</td>
                            <td>{{ $row->nama_pemesan }}</td>
                            <td>Rp. {{ $row->subtotal }}</td>
                       @if ($row->status === "Belum Bayar")
                       <td class="text-center"><a href="home/{{$row->id_transaksi}}/struk"><button class="btn btn-warning " style="font-weight:600">Belum Bayar</button></a></td>
                       @elseif($row->status === "Sudah Bayar")
                       <td class="text-center"><a href="home/{{$row->id_transaksi}}/cetak_struk" target="_blank"><button class="btn btn-primary " style="font-weight:600">Sudah Bayar</button></a></td>
                       @endif
                        </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
