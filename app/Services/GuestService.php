<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\Invitation;

class GuestService
{
    public function getGuestsForInvitation(Invitation $invitation)
    {
        return $invitation->guests;
    }

    public function createGuest(Invitation $invitation, array $data)
    {
        return Guest::create(array_merge($data, ['invitation_id' => $invitation->id]));
    }

    public function updateGuest(Guest $guest, array $data)
    {
        $guest->update($data);
        return $guest;
    }

    public function deleteGuest(Guest $guest)
    {
        $guest->delete();
    }
}