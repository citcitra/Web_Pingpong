<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kasir;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_kasir = \App\Kasir::all();
        return view('kasir.index',['data_kasir' => $data_kasir ]);
        
    }
    public function create(Request $request){
        // if($request->hasFile('gambar'))
        // {
        //     $destination = "upload";
        //     $gambar = $request->file("gambar");
        //     $gambar->move($destination,$gambar->getClientOriginalName());
        //     $upload = new upload;
        //     \App\Kasir::create($request->all());
        //     $upload->gambar = $gambar->getClientOriginalName();
        //     $upload->save();
        // }
        $foto = $request->file('gambar');
        $namaFile = Carbon::now()->timestamp . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('upload/'),$namaFile);
        Kasir::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'gambar' => $namaFile
        ]);

            
        return redirect('/kasir')->with('sukses','Data Berhasil Di Input');
    }

    public function edit($id){
        $kasir = \App\Kasir::find($id);
        return view('kasir/edit',['kasir' => $kasir]);  
    }

    public function update(Request $request,$id){
        $kasir = \App\Kasir::find($id);
        $kasir->update($request->all());
        return redirect('/kasir')->with('sukses','Data Berhasil Di Update');
    }
    public function delete ($id){
        $kasir = \App\Kasir::find($id);
        $kasir->delete();
        return redirect('/kasir')->with('sukses','Data Berhasil Di Hapus');
    }
}

