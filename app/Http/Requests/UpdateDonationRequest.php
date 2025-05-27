<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonationRequest extends FormRequest
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
            'type' => 'required|in:supreme,elite,premium,standard,basic',
            'donation_type' => 'required|in:trust_fund,campaign,case_specific',
            'amount' => 'required|numeric|min:1',
            'ssl_transaction_id' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,confirmed,failed',
        ];
    }
}
