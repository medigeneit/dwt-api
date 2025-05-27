<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         return [
            'phone'     => 'nullable|string',
            'name'      => 'nullable|string',
            'user_id'   => 'nullable|exists:users,id',
            'type'      => 'required|in:supreme,elite,premium,standard,basic',
            'donation_type' => 'required|in:trust_fund,campaign,case_specific',
            'amount'             => 'required|numeric|min:1',
            'ssl_transaction_id' => 'nullable|string|max:255',
            'status'             => 'nullable|in:pending,confirmed,failed',
        ];
    }
}
