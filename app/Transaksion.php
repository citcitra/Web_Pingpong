<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksion extends Model
{
    protected $table = 'transaksi';
    protected $fillable = ['id_transaksi','nama_pemesan','','subtotal','bayar','kembalian','status'];
}
