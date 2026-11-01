<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class upload extends Model
{
    protected $table = 'upload';
    protected $fillable = ['nama','filename'];
}
