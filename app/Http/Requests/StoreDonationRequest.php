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
            'phone'              => 'nullable|string',
            'name'               => 'nullable|string',
            'user_id'            => 'nullable',
            'category_id'        => 'nullable',
            'category_type'      => 'nullable',
            'donation_type'      => 'required',
            'amount'             => 'required|numeric|min:1',
            'ssl_transaction_id' => 'nullable|string|max:255',
            'status'             => 'nullable|in:pending,confirmed,failed',
        ];
    }
}
