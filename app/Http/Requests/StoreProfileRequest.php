<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id|unique:profiles,user_id',
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'nationality' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'nid_or_birth_cert' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'college_id' => 'nullable|exists:colleges,id',
            'session_year' => 'nullable|string|max:20',
            'batch' => 'nullable|string|max:50',
            'roll_number' => 'nullable|string|max:50',
            'bmdc_reg_number' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'fb_link' => 'nullable|url',
            'present_address' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
        ];
    }
}
