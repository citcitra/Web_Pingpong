<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    // Daftarkan kolom yang boleh diisi secara massal
    protected $fillable = ['user_id', 'slot_id', 'position', 'status'];

    // Relasi: Mengetahui siapa user yang sedang mengantre
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
