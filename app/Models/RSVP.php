<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RSVP extends Model
{
    protected $table = 'rsvps';
    protected $fillable = ['invitation_id', 'guest_id', 'status', 'people_count', 'message'];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
