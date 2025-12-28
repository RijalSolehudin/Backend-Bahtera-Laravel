<?php

namespace App\Services;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class InvitationService
{
    public function getUserInvitations()
    {
        return Auth::user()->invitations;
    }

    public function createInvitation(array $data)
    {
        return Invitation::create(array_merge($data, ['user_id' => Auth::id()]));
    }

    public function updateInvitation(Invitation $invitation, array $data)
    {
        $invitation->update($data);
        return $invitation;
    }

    public function deleteInvitation(Invitation $invitation)
    {
        $invitation->delete();
    }

    public function findBySlug($slug)
    {
        return Invitation::where('slug', $slug)->first();
    }
}