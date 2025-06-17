<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'did_number' => 'required|string|exists:did_registrations,did_number',

            'type' => 'required|string',
            'zone' => 'nullable|string|max:100',
            'permanent_district_id' => 'nullable|integer|exists:districts,id',
            'permanent_upazila_id' => 'nullable|integer|exists:upazilas,id',
            'current_upazila_id' => 'nullable|integer|exists:upazilas,id',
            'current_district_id' => 'nullable|integer|exists:districts,id',
            'hospital_or_institute_name' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:255',
            'alternate_phone' => 'nullable|string|max:30',
            'skill_expertise' => 'required|string',
            'description' => 'required|string',
            'work_experience' => 'required|string',
        ];
    }
}
