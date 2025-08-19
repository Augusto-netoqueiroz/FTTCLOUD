<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsEndpoint extends Model
{
    public $timestamps = false;
    protected $table = 'ps_endpoints';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','transport','aors','auth','context','disallow','allow','direct_media','force_rport',
        'rewrite_contact','rtp_symmetric','dtls_auto_generate_cert','media_encryption','webrtc',
        'callerid','from_domain','language','dtmf_mode'
    ];

    public function authRef() { return $this->belongsTo(PsAuth::class, 'auth', 'id'); }
    public function transportRef() { return $this->belongsTo(PsTransport::class, 'transport', 'id'); }
}
