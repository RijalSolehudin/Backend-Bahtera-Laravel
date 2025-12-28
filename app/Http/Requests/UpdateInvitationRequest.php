<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'bride_name' => 'sometimes|required|string|max:255',
            'groom_name' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date|after:today',
            'time' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string',
            'template' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:invitations,slug,' . $this->route('invitation')->id . '|max:255',
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