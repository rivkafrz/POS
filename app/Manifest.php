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
            'assign_location_id'
        ];


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
}
