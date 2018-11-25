<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DepartureTime extends Model
{

    protected $fillable = [
        'boarding_time'
    ];
   
   public function manifest()
    {
        return $this->hasMany(Manifest::class);
    }

    public function formatTime()
    {
        return substr(Carbon::parse($this->boarding_time)->toTimeString(), 0, 5);
    }
}
