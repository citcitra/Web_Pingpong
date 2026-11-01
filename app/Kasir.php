<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'nama_menu', 'harga', 'gambar'
       ];
}