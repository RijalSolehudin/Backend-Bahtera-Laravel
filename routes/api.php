<?php
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\InvitationController;
use App\Http\Controllers\API\GuestController;
use App\Http\Controllers\API\RSVPController;
use App\Http\Controllers\API\WishController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

# Public: lihat undangan + kirim RSVP/ucapan
Route::get('/public/invitations/{slug}', [InvitationController::class,'publicShow']);
Route::post('/invitations/{slug}/rsvp', [RSVPController::class,'store']);
Route::post('/invitations/{slug}/wish', [WishController::class,'store']);

# Protected: user/admin
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/user', [AuthController::class,'me']);
    Route::apiResource('invitations', InvitationController::class);
    Route::get('invitations/{invitation}/guests', [GuestController::class,'index']);
    Route::post('invitations/{invitation}/guests', [GuestController::class,'store']);
    Route::put('invitations/{invitation}/guests/{guest}', [GuestController::class,'update']);
    Route::delete('invitations/{invitation}/guests/{guest}', [GuestController::class,'destroy']);
});
