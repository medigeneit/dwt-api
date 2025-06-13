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
            'did_register_id' => 'nullable|exists:did_registrations,id',
            'type' => 'required|string|max:50',
            'zone' => 'nullable|string|max:100',
            'college_id' => 'nullable|exists:colleges,id',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'hospital_or_institute_name' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:255',
            'alternate_phone' => 'nullable|string|max:30',
            'skill_expertise' => 'required|string',
            'description' => 'required|string',
            'previous_experience' => 'required|string',
        ];
    }
}
