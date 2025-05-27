<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAboutUsRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section' => 'required|in:vision_mission,programs,founder,permanent_advisors,central_executives',
            'title' => 'required|string|max:255|unique:about_us,title',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
        ];
    }
}
