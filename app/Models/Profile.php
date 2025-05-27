<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'father_name',
        'mother_name',
        'dob',
        'blood_group',
        'nationality',
        'religion',
        'nid_or_birth_cert',
        'image',
        'college_id',
        'session_year',
        'batch',
        'roll_number',
        'bmdc_reg_number',
        'did_number',
        'mobile',
        'fb_link',
        'present_address',
        'permanent_address',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }
}
