<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    //
    protected $fillable = ['seat_number'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
	}

	public function departureTime()
    {
        return $this->belongsTo(Departure_time::class);
	}

	public function destination()
    {
        return $this->belongsTo(Destiantion::class);
	}

}
