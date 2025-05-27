<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
     protected $fillable = [
        'name',
        'nickname',
        'code',
        'ownership_type',
        'university',
        'institute_type',
        'location',
        'status',
    ];
    
    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
}
