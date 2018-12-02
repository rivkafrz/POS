<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;

class Ticket extends Model
{
    use CrudTrait;
    protected $fillable = [
        'code',
        'departure_time_id',
        'destination_id',
        'customer_id',
        'amount',
        'refund',
        'work_time_id',
        'user_id'
    ];

    public function workTime()
    {
        return $this->belongsTo(WorkTime::class);
    }

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

    public function seats($refund = 0)
    {
        return $this->hasMany(Seat::class)->where('refund', $refund);
    }

    public function cash()
    {
        return $this->hasOne(Cash::class);
    }

    public function nonCash()
    {
        return $this->hasOne(NonCash::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formattedSeat()
    {
        $str = '';
        foreach ($this->seats as $seat) {
            $str = $str . $seat->seat_number . ", ";
        }
        return substr($str, 0, -2);
    }
    
    // Alias

    public function to()
    {
        return $this->destination();
    }

    public static function eod($user_id)
    {
        $time = now()->toDateString();
        return Ticket::where('user_id', $user_id)
                    ->where('created_at', 'like', $time . '%');
    }

    public function isToday()
    {
        return Carbon::parse($this->created_at)->isToday();
    }


}
