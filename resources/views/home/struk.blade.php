@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row">

           <div class="col-md-4 offset-4 card card-body">
               <br>
                <h1>Struk</h1><hr> 
                <form name="sum" action="/home/{{$view[0]->id_transaksi}}/update" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pemesan</label>
                        <input type="text" readonly value="{{$view[0]->nama_pemesan}}" name="nama_menu" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Pesanan</label>
                        <input class="form-control" readonly  type="text" value="@foreach ($view as $item) {!!$item->nama_menu!!}, @endforeach ">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Total</label>
                        <input class="form-control" readonly id="subtotal" name="subtotal"  type="text" value="{{$view[0]->subtotal}}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Bayar</label>
                                <input class="form-control" id="uang" required name="bayar" type="text" value="" onkeyup="pembayaran()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Kembalian</label>
                                <input class="form-control" required readonly id="kembali" name="kembalian" type="text" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" readonly hidden  name="status" type="text" value="Sudah Bayar">
                                </div>
                        </div>

                    
                        <div class="float-right">
                        <a href="cetak_struk" target="_blank" class="btn btn-secondary">Cetak</a>
                                <button href="cetak_struk" target="_blank" type="submit" class="btn btn-danger">Bayar</button>
                        </div>
                    </form>
           </div>
        
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style>
.form-control{
    background-color: #ffffff;
}</style>
<script>
    function pembayaran(){
        var bil1 = parseFloat(document.sum.subtotal.value);
        var bil2 = parseFloat(document.sum.uang.value);
        document.sum.kembali.value = bil2 - bil1;
    }
</script>
@endsection