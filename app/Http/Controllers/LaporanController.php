<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Pembelian;
use PDF;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        // $data_kasir = \App\Kasir::all();
        // return view('laporan',['data_kasir' => $data_kasir ]);
        $laporan = \App\transaksi::all();
        return view('laporan',['laporan'=> $laporan]);
    }
    public function cetak_pdf()
    {
        $laporan = \App\Transaksi::all();
        
    	$pdf = PDF::loadview('laporan_pdf',['laporan'=>$laporan]);
        return $pdf->stream();
    }
}
