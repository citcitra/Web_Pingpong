<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pembayaran = \App\Transaksi::latest('id_transaksi')->get();
        return view('home',['pembayaran' => $pembayaran ]);
    }
    public function edit($id){
        $view = \App\Pembelian::where('id_transaksi', $id)->get();
        return view('home/struk',['view' => $view]);  
        
    }
    
    public function update(Request $request,$id){
        $pembayaran = \App\Transaksi::find($id);
        $pembayaran->update($request->all());
        return redirect('home')->with('sukses','Data Berhasil Di Update');
    }
    public function cetak_pdf($id)
    {
        $laporan = \App\Pembelian::where('id_transaksi',$id)->get();
        
    	$pdf = PDF::loadview('home/laporan_struk',['laporan'=>$laporan]);
        return $pdf->stream();
    }
}
