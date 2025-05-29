<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = 'otps';
    
    protected $fillable = ['phone', 'code', 'expires_at'];
    public $timestamps = true;
}
