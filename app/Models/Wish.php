<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $fillable = ['invitation_id', 'name', 'message'];
    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
