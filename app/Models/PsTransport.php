<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsTransport extends Model
{
    public $timestamps = false;
    protected $table = 'ps_transports';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','type','protocol','bind','cert_file','priv_key_file','method',
        'allow_reload','external_signaling_address','external_signaling_port'
    ];
}
