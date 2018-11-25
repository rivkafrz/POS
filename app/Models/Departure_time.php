<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;

class Departure_time extends Model
{
    use CrudTrait;
    protected $table = 'departure_times';
    protected $fillable = ['boarding_time'];
    public function seat()
    {
        return $this->hasMany(Seat::class);
    }

    public function manifest()
    {
        return $this->belongsTo(Manifest::class);
    }

    public function getJamKeberangkatanAttribute($value)
    {
        $time = Carbon::parse($value);
        return $time->hour.":".$time->minute;
    }

    public function getBoardingTimeAttribute($value)
    {
        return substr(Carbon::parse($value)->toTimeString(), 0 , 5);
    }
}
