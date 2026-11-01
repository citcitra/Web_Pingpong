<div class="container ">
    <div class="row">
    
    <div class="col-md-12 offset-">
        <h1>Struk</h1>
            <label >Nama Pemesan</label>
        <input type="text"   value="{{$laporan[0]->nama_pemesan}}"><br>
            <label >Yang Dipesan</label>
            <input type="text"   value="@foreach ($laporan as $item) {!!$item->nama_menu!!}, @endforeach"><br>
   
            <label >Total Bayar</label>
        <input type="text"   value="{{$laporan[0]->subtotal}}"><br>

            <label >Bayar</label>
        <input type="text"   value="{{$laporan[0]->bayar}}"><br>
        
        <label >Kembalian</label>
        <input type="text"   value="{{$laporan[0]->kembalian}}"><br>
        
        <label >Status</label>
        <input type="text"   value="{{$laporan[0]->status}}"><br>
    </div>
    </div>
</div>