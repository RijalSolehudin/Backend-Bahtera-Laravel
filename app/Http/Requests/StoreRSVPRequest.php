<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRSVPRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guest_id' => 'required|exists:guests,id',
            'status' => 'required|in:attending,not_attending,maybe',
            'people_count' => 'nullable|integer|min:1|max:10',
            'message' => 'nullable|string|max:500',
        ];
    }
}