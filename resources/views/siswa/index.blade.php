@extends('layouts.app')

@section('content')
<div class="container card card-body">
    @if(session('sukses'))
    <div class="alert alert-success" role="alert">
        {{session('sukses')}}
    </div>        
    @endif

    <div class="row">
        <div class="col-md-6">
            <h1>Data Siswa</h1>
        </div>
        <div class="col-md-6">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                Tambah Data Siswa
            </button>
            

        </div>
    </div>

    <table class="table table-hover">
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th  class="text-center">Aksi</th>

        </tr>
        @foreach ($data_siswa as $siswa)
        <tr>
            <td>{{ $siswa->id }}</td>
            <td>{{ $siswa->nama_lengkap }}</td>
            <td>{{ $siswa->jenis_kelamin }}</td>
            <td>{{ $siswa->alamat }}</td>
            <td class="text-center">
                <a href="/siswa/{{$siswa->id}}/edit" style="color:blue">Edit</a> |
                 
                <a href="/siswa/{{$siswa->id}}/delete" style="color:red">Delete</a>
            </td>
        </tr>
        @endforeach
    </table>
    <div>
            <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                      </li>
                    </ul>
                  </nav>
    </div>
</div>




            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                    <form action="/siswa/create" method="POST">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin" id="exampleFormControlSelect1">
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Alamat</label>
                                <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        
                            <div class="float-right">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    </div>  
                    </div>
                </div>
@endsection