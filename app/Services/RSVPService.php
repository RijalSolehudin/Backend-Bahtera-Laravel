<?php

namespace App\Services;

use App\Models\RSVP;
use App\Models\Invitation;
use App\Models\Guest;

class RSVPService
{
    public function createRSVP(Invitation $invitation, array $data)
    {
        // Ensure guest belongs to invitation
        $guest = Guest::find($data['guest_id']);
        if ($guest->invitation_id !== $invitation->id) {
            throw new \Exception('Guest not found in this invitation');
        }

        return RSVP::create(array_merge($data, ['invitation_id' => $invitation->id]));
    }
}