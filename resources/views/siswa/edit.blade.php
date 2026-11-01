@extends('layouts.app')

@section('content')
<div class="container card card-body">
    @if(session('sukses'))
    <div class="alert alert-success" role="alert">
        {{session('sukses')}}
    </div>        
    @endif
    <div class="row">
           <div class="col-md-6 offset-3">
               <br>
                <h1>Edit Data Siswa</h1>  
           <form action="/siswa/{{$siswa->id}}/update" method="POST">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input type="text" value="{{$siswa->nama_lengkap}}" name="nama_lengkap" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                        <select class="form-control"  name="jenis_kelamin" id="exampleFormControlSelect1">
                            <option value="L" @if($siswa->jenis_kelamin == 'L') selected @endif>Laki - Laki</option>
                            <option value="P" @if($siswa->jenis_kelamin == 'P') selected @endif>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                        <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3">{{$siswa->alamat}}</textarea>
                        </div>
                    
                        <div class="float-right">
                                <a href="/siswa/" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                </form>
           </div>
    </div>
</div>
@endsection