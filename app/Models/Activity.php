<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'category',
        'description',
        'location',
        'activity_date',
        'photo',
        'status',
        ];
}
