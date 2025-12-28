<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'bride_name' => $this->bride_name,
            'groom_name' => $this->groom_name,
            'date' => $this->date,
            'time' => $this->time,
            'city' => $this->city,
            'address' => $this->address,
            'template' => $this->template,
            'slug' => $this->slug,
            'cover_image' => $this->cover_image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'guests_count' => $this->guests()->count(),
            'rsvps_count' => $this->rsvps()->count(),
            'wishes_count' => $this->wishes()->count(),
        ];
    }
}