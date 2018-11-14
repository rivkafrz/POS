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
        return $this->hasMany(Seat::class)->where('refund', 0);
    }

    public function cash()
    {
        return $this->hasOne(Cash::class);
    }

    public function nonCash()
    {
        return $this->hasOne(NonCash::class);
    }
    
    // Alias

    public function to()
    {
        return $this->destination();
    }


}
