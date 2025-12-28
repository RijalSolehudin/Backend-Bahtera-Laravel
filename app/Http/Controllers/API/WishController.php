<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWishRequest;
use App\Http\Resources\WishResource;
use App\Services\WishService;
use App\Models\Invitation;

class WishController extends Controller
{
    protected $wishService;

    public function __construct(WishService $wishService)
    {
        $this->wishService = $wishService;
    }

    public function store(StoreWishRequest $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->first();

        if (!$invitation) {
            return response()->json(['message' => 'Invitation not found'], 404);
        }

        $wish = $this->wishService->createWish($invitation, $request->validated());

        return new WishResource($wish);
    }
}
