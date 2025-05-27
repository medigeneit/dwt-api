<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDidRegistrationRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'phone_email'   => 'required|string',
            'birth_date'    => 'required|date',
            'father_name'   => 'required|string|max:255',
            'mother_name'   => 'required|string|max:255',
            'college_id'    => 'required',
            'session'       => 'required',
            'batch'         => 'required|string|max:50',
            'blood_group'   => 'nullable|string|max:10',
            'religion'      => 'nullable|string|max:50',
            'nationality'   => 'nullable|string|max:100',
            'present_address'   => 'nullable|string',
            'permanent_address' => 'nullable|string',
        ];
    }
}
