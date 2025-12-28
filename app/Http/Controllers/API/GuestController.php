<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Http\Resources\GuestResource;
use App\Services\GuestService;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    protected $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    public function index(Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $guests = $this->guestService->getGuestsForInvitation($invitation);

        return GuestResource::collection($guests);
    }

    public function store(StoreGuestRequest $request, Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $guest = $this->guestService->createGuest($invitation, $request->validated());

        return new GuestResource($guest);
    }

    public function update(UpdateGuestRequest $request, Invitation $invitation, Guest $guest)
    {
        if ($invitation->user_id !== Auth::id() || $guest->invitation_id !== $invitation->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $guest = $this->guestService->updateGuest($guest, $request->validated());

        return new GuestResource($guest);
    }

    public function destroy(Invitation $invitation, Guest $guest)
    {
        if ($invitation->user_id !== Auth::id() || $guest->invitation_id !== $invitation->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->guestService->deleteGuest($guest);

        return response()->json(['message' => 'Guest deleted'], 204);
    }
}
