<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
