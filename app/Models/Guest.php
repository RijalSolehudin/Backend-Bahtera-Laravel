<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['invitation_id', 'name', 'phone', 'email', 'code'];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
    public function rsvp()
    {
        return $this->hasOne(RSVP::class);
    }
}
