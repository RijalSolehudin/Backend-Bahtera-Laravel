<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRSVPRequest;
use App\Http\Resources\RSVPResource;
use App\Services\RSVPService;
use App\Models\Invitation;

class RSVPController extends Controller
{
    protected $rsvpService;

    public function __construct(RSVPService $rsvpService)
    {
        $this->rsvpService = $rsvpService;
    }

    public function store(StoreRSVPRequest $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->first();

        if (!$invitation) {
            return response()->json(['message' => 'Invitation not found'], 404);
        }

        $rsvp = $this->rsvpService->createRSVP($invitation, $request->validated());

        return new RSVPResource($rsvp);
    }
}
