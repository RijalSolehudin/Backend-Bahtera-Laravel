<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Or check if user is authenticated
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'time' => 'required|string',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'template' => 'required|string|max:255',
            'slug' => 'required|string|unique:invitations,slug|max:255',
            'cover_image' => 'nullable|string|url',
        ];
    }

    public function messages(): array
    {
        return [
            'date.after' => 'The date must be a future date.',
            'slug.unique' => 'This slug is already taken.',
        ];
    }
}