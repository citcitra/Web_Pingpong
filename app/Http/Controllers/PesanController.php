<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index(){
        $data_kasir = \App\Kasir::all();
        return view('pesan.index',['data_kasir' => $data_kasir ]);
    }
    public function create(Request $request){
       $transaksi = \App\Transaksion::create($request->all());
        // var_dump($transaksi->id);die;

        $i = 0;
        foreach ($request->makanan as $row) {
        // var_dump($row);die;

            $pesanan = new \App\Pesanan();
            $pesanan->id_transaksi = $transaksi->id;
            $pesanan->id_menu = (int)$row[$i];
            $pesanan->save();
        }
        return redirect('/pesan')->with('sukses','Berhasil, Pesanan Sedang Di Proses');
    }
}
