@extends('layouts.app')

@section('content')
<div class="btn-btn-danger">
<a href="{{route('menu.create')}}">Create</a>
</div>
<table class="table table-bordered table-striped">
    <tr>
     <th width="10%">Image</th>
     <th width="35%">Nama Menu</th>
     <th width="35%">Harga</th>
     <th width="30%">Action</th>
    </tr>
    @foreach($data as $row)
     <tr>
      <td><img src="{{ URL::to('/') }}/images/{{ $row->gambar }}" class="img-thumbnail" width="75" /></td>
      <td>{{ $row->nama_menu }}</td>
      <td>{{ $row->harga }}</td>
      <td>
       
      </td>
     </tr>
    @endforeach
   </table>
   {!! $data->links() !!}
@endsection