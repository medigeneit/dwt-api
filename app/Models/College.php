<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
     protected $fillable = [
        'name',
        'code',
        'university',
        'location',
        'status'
    ];
    
    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
}
