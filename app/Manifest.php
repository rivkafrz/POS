<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;

class Manifest extends Model
{
    use CrudTrait;
    protected $fillable = [
            'driver',
            'no_body',
            'departure_time_id',
            'destination_id',
            'user_id',
            'assign_location_id'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departureTime()
    {
        return $this->belongsTo(DepartureTime::class);
    }

    public function assignLocation()
    {
        return $this->belongsTo(AssignLocation::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function ticket()
    {
        return Seat::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString().'%')
            ->where('departure_time_id', $this->departure_time_id)
            ->where('assign_location_id', $this->assign_location_id)
            ->where('destination_id', $this->destination_id)
            ->where('refund', 0)
            ->where('checked', 1)
            ->get();
    }

    public function passenger($status)
    {
        return Seat::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString().'%')
            ->where('departure_time_id', $this->departure_time_id)
            ->where('assign_location_id', $this->assign_location_id)
            ->where('destination_id', $this->destination_id)
            ->where('refund', 0)
            ->where('checked', $status)
            ->get()
            ->count();
    }

    public function cash()
    {
        $seat = Seat::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString().'%')
            ->where('departure_time_id', $this->departure_time_id)
            ->where('assign_location_id', $this->assign_location_id)
            ->where('destination_id', $this->destination_id)
            ->where('refund', 0)
            ->get()
            ->groupBy('ticket_id');

        $price = 0;
        foreach ($seat as $s) {
            if (is_null($s->first()->first()->ticket->nonCash)) {
                $price += $s->first()->first()->ticket->amount;
            }
        }

        return $price;
    }

    public function nonCash()
    {
        $seat = Seat::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString().'%')
            ->where('departure_time_id', $this->departure_time_id)
            ->where('assign_location_id', $this->assign_location_id)
            ->where('destination_id', $this->destination_id)
            ->where('refund', 0)
            ->get()
            ->groupBy('ticket_id');

        $price = 0;
        foreach ($seat as $s) {
            if (is_null($s->first()->first()->ticket->cash)) {
                $price += $s->first()->first()->ticket->amount;
            }
        }

        return $price;
    }

    public function ticketings()
    {
        $seat = Seat::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString().'%')
            ->where('departure_time_id', $this->departure_time_id)
            ->where('assign_location_id', $this->assign_location_id)
            ->where('destination_id', $this->destination_id)
            ->where('refund', 0)
            ->get()
            ->groupBy('ticket_id');
        $t = [];
        foreach ($seat as $ticket) {
            $t = array_merge($t, [$ticket->first()->first()->ticket->user->employee]);
        }

        return $t;
    }

    public function workTime()
    {
        $seat = Seat::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString().'%')
            ->where('departure_time_id', $this->departure_time_id)
            ->where('assign_location_id', $this->assign_location_id)
            ->where('destination_id', $this->destination_id)
            ->where('refund', 0)
            ->get()
            ->groupBy('ticket_id');

        return $seat->first()->first()->ticket->workTime;
    }
}

