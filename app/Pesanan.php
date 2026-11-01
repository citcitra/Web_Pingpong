<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'Pesanan';
    protected $fillable = [
        'id_pesananan', 'id_transaksi', 'id_menu'
       ];
}
