<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsAuth extends Model
{
    public $timestamps = false;
    protected $table = 'ps_auths';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id','auth_type','username','password'];
}
