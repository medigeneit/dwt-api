<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DidRegistration extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'birth_date',
        'father_name',
        'mother_name',
        'college_id',
        'session',
        'batch',
        'blood_group',
        'religion',
        'nationality',
        'present_address',
        'permanent_address',
        'roll',
        'nid',
        'bmdc',
        'facebook_link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

}
