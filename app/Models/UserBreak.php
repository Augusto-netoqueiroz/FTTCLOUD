<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBreak extends Model
{
    protected $fillable = [
        'user_session_id',
        'type',
        'started_at',
        'ended_at',
    ];

    protected $dates = ['started_at', 'ended_at'];

    public function session()
    {
        return $this->belongsTo(UserSession::class, 'user_session_id');
    }
}
