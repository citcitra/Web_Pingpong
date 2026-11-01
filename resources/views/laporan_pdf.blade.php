<div class="row">
    <style>

    *{font-size: 14px;}
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <div class="col-md-12">
            <h1>Riwayar Pemesanan</h1>
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
