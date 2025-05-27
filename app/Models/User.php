<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // ✅ এখানে HasApiTokens যুক্ত করুন

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function designation()
    {
        return $this->hasOne(Designation::class);
    }

    public function donations()
    {
        return $this->hasMany(Donor::class);
    }

    public function didRegistrations()
    {
        return $this->hasMany(DidRegistration::class);
    }


}
