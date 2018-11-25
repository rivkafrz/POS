<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartureTime extends Model
{
	
    protected $fillable = [
        'boarding_time'
    ];
   
   public function manifest()
    {
        return $this->hasMany(Manifest::class);
    }


}
