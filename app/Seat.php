<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seat extends Model
{
    /*

    Step step test relasi

    Pastiin udah ada datanya dulu minimal satu
    Ini kan modelnya Seat, seenngaknya Seat harus ada satu di database.
    Seat kan butuh Customer, DepartureTime, sama Destination. Nah ini harus jadi sebelum Seat.

    Kalo udah data Seat udah ada di database read dulu pake kodingan

    $variable = Seat::first()
    ini artinya cari data pertama di model Model (Seat), bukan seat aja berlaku semua model dan ingat sebagai $variable

    nah trus test relasinya

    $variable->relasinya

    contoh :

    $variable->customer

    */
    protected $fillable = [
        'seat_number',
        'ticket_id',
        'departure_time_id',
        'destination_id',
        'assign_location_id'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
	}

	public function departureTime()
    {
        return $this->belongsTo(DepartureTime::class);
	}

	public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    
    public static function seats(AssignLocation $from, Destination $to, DepartureTime $departure)
    {
        $time = Carbon::now()->toDateString();

        return Seat::where('assign_location_id', $from->id)
                    ->where('destination_id', $to->id)
                    ->where('departure_time_id', $departure->id)
                    ->where('created_at', 'like', $time . '%');
    }

}
