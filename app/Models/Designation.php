<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'did_number',
        'type',
        'zone',
        'permanent_district_id',
        'permanent_upazila_id',
        'current_upazila_id',
        'current_district_id',
        'hospital_or_institute_name',
        'work_experience',
        'class_grade',
        'alternate_phone',
        'skill_expertise',
        'description',
    ];

     // 🔗 DID registration relation
    public function didRegistration()
    {
        return $this->belongsTo(DidRegistration::class , 'did_number', 'did_number');
    }

    // 🔗 Permanent District
    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'permanent_district_id');
    }

    // 🔗 Permanent Upazila
    public function permanentUpazila()
    {
        return $this->belongsTo(Upazila::class, 'permanent_upazila_id');
    }

    // 🔗 Current District
    public function currentDistrict()
    {
        return $this->belongsTo(District::class, 'current_district_id');
    }

    // 🔗 Current Upazila
    public function currentUpazila()
    {
        return $this->belongsTo(Upazila::class, 'current_upazila_id');
    }
}
