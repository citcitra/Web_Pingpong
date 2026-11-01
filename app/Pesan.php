<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'nama_menu', 'harga', 'gambar'
       ];
}
