<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\upload;
class uploadController extends Controller
{
    function index(){
        return view('uploadfile');
    }
    function insert(Request $request){
 
        if($request->hasFile('filename'))
        {
            $destination = "upload";
            $filename = $request->file("filename");
            $filename->move($destination,$filename->getClientOriginalName());
            $upload = new upload;
            $upload->nama = $request->nama;
            $upload->filename = $filename->getClientOriginalName();
            $upload->save();
        }
                return redirect('/uploadfile');
    }
}
