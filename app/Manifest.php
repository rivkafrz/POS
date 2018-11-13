<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
   
   protected $fillable = [
        'driver',
        'no_body'
        
        ];


    public function departureTime()
    {
        return $this->belongsTo(DepartureTime::class);
    }

    public function assignLocation()
    {
        return $this->belongsTo(AssignLocation::class);
    }

}
