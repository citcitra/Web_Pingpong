<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    protected $fillable = [
        'user_id', 'mode', 'speed', 'interval_seconds', 'direction',
        'status', 'started_at', 'ended_at', 'duration_seconds', 'score',
    ];

    protected $dates = ['started_at', 'ended_at', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
