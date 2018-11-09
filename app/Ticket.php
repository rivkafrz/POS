<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = [
        'code',
        'departure_time_id',
        'destination_id',
        'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function departureTime()
    {
        return $this->belongsTo(DepartureTime::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    
    public function baggages()
    {
        return $this->hasMany(Baggage::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    
    // Alias

    public function to()
    {
        return $this->destination();
    }
}
