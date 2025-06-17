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
            'did_registration_id' => $this->did_registration_id,
            'type' => $this->type,
            'zone' => $this->zone,
            'permanent_district_id' => $this->permanent_district_id,
            'permanent_upazila_id' => $this->permanent_upazila_id,
            'current_district_id' => $this->current_district_id,
            'current_upazila_id' => $this->current_upazila_id,
            'hospital_or_institute_name' => $this->hospital_or_institute_name,
            'class_grade' => $this->class_grade,
            'alternate_phone' => $this->alternate_phone,
            'skill_expertise' => $this->skill_expertise,
            'description' => $this->description,
            'work_experience' => $this->work_experience,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
