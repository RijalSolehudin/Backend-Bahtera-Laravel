<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'bride_name',
        'groom_name',
        'date',
        'time',
        'city',
        'address',
        'template',
        'slug',
        'cover_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
    public function rsvps()
    {
        return $this->hasMany(RSVP::class);
    }
    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }
}
