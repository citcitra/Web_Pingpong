@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@section('content')
<div class="container card card-body">
        @if(session('sukses'))
        <div class="alert alert-success" role="alert">
            {{session('sukses')}}
        </div>        
        @endif

<div class="row">
        <div class="col-md-6">
            <h1>Menu Makanan</h1>
            <div class="row">
                <div class="col-md-6 offset-2">
                    <span><button type="button" style="margin-top:-40px;margin-right:-10px" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                        Tambah Menu
                    </button></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Button trigger modal -->
            <div class="row">
                  <div class="col-md-6 offset-6">
                        <input class="float-right form-control" id="myInput"  type="text" id="search" name="" id="" placeholder="Search..">
                  </div>
            </div>

        </div>
    </div>
    <table class="table table-hover">
        
        <tr>
            <th>No</th>
            <th style="padding-left:2%;">Gambar</th>
            <th>Nama Menu</th>
            <th>Harga</th>
            <th  class="text-center">Aksi</th>

        </tr>
        @foreach ($data_kasir as $row)
        <tbody id="myTable">
                <tr>
                        <td>{{ $row->id }}</td>
                        <td><img src="{{ asset('upload/' . $row->gambar ) }}" class="img-thumbnail"  width="75" /></td>
                        <td>{{ $row->nama_menu }}</td>
                        <td>Rp. {{ $row->harga }}</td>
                        <td class="text-center">
                            <a href="/kasir/{{$row->id}}/edit" style="color:blue">Edit</a> |
                             
                            <a href="/kasir/{{$row->id}}/delete" style="color:red">Delete</a>
                        </td>
                    </tr>
        </tbody>
        @endforeach
    </table>
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

{{-- MODAL --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Input Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
        <form action="/kasir/create" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div>
                    <input type="file"  onchange="readURL(this);" name="gambar" value="" class="" id="exampleInputEmail1" aria-describedby="emailHelp" ><br><br>
                </div>
                <div class="gambar">
                    <img id="preview_gambar" src="#" class="img-thumbnail" width="200" alt="No Image"><br><br>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Menu</label>
                    <input type="text" name="nama_menu" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Menu">
                </div>
                <div class="form-group">
                        <label for="exampleInputEmail1">Harga</label>
                        <input type="text" name="harga" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Harga">
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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
    function readURL(input) { // Mulai membaca inputan gambar
    if (input.files && input.files[0]) {
    var reader = new FileReader(); // Membuat variabel reader untuk API FileReader
    
    reader.onload = function (e) { // Mulai pembacaan file
    $('#preview_gambar') // Tampilkan gambar yang dibaca ke area id #preview_gambar
    .attr('src', e.target.result)
    .width(250); // Menentukan lebar gambar preview (dalam pixel)
    //.height(200); // Jika ingin menentukan lebar gambar silahkan aktifkan perintah pada baris ini
    };
    
    reader.readAsDataURL(input.files[0]);
    }
    }
    </script>
    
@endsection