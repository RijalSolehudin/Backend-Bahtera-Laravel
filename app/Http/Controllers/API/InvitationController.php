<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use App\Http\Resources\InvitationResource;
use App\Services\InvitationService;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    protected $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    public function publicShow($slug)
    {
        $invitation = $this->invitationService->findBySlug($slug);

        if (!$invitation) {
            return response()->json(['message' => 'Invitation not found'], 404);
        }

        return new InvitationResource($invitation);
    }

    public function index()
    {
        $invitations = $this->invitationService->getUserInvitations();

        return InvitationResource::collection($invitations);
    }

    public function store(StoreInvitationRequest $request)
    {
        $invitation = $this->invitationService->createInvitation($request->validated());

        return new InvitationResource($invitation);
    }

    public function show(Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new InvitationResource($invitation);
    }

    public function update(UpdateInvitationRequest $request, Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $invitation = $this->invitationService->updateInvitation($invitation, $request->validated());

        return new InvitationResource($invitation);
    }

    public function destroy(Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->invitationService->deleteInvitation($invitation);

        return response()->json(['message' => 'Invitation deleted'], 204);
    }
}
