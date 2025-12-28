<?php

namespace App\Services;

use App\Models\Wish;
use App\Models\Invitation;

class WishService
{
    public function createWish(Invitation $invitation, array $data)
    {
        return Wish::create(array_merge($data, ['invitation_id' => $invitation->id]));
    }
}