<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'Menu';
    protected $fillable = [
        'nama_menu', 'harga', 'gambar'
       ];
}
