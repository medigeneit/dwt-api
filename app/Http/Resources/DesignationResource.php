<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'did_number' => $this->did_number,
            'type' => $this->type,
            'zone' => $this->zone,
            'permanent_district' => $this->permanentDistrict->name ?? null,
            'permanent_upazila' => $this->permanentUpazila->name ?? null,
            'current_district' => $this->currentDistrict->name ?? null,
            'current_upazila' => $this->currentUpazila->name ?? null,
            'hospital_or_institute_name' => $this->hospital_or_institute_name,
            'class_grade' => $this->class_grade,
            'alternate_phone' => $this->alternate_phone,
            'skill_expertise' => $this->skill_expertise,
            'description' => $this->description,
            'work_experience' => $this->work_experience,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,

             // ✅ Full address (district + upazila + address)
            'permanent_address' => trim(
                ($this->permanentUpazila->name ?? '') . ', ' .
                ($this->permanentDistrict->name ?? '') . 
                ($this->permanent_address ? ' - ' . $this->permanent_address : '')
            ),
            'current_address' => trim(
                ($this->currentUpazila->name ?? '') . ', ' .
                ($this->currentDistrict->name ?? '') . 
                ($this->current_address ? ' - ' . $this->current_address : '')
            ),
        ];
    }
}
