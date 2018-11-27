<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Ticket;
use Carbon\Carbon;

class EOD extends Model
{
    use CrudTrait;
    protected $fillable = [
        'user_id',
        'assign_location_id',
        'work_time_id',
        'approved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getApprovedAttribute($value)
    {
        $status = [
            'Unapproved',
            'Approved'
        ];
        return $status[$value];
    }

    public function assignLocation()
    {
        return $this->belongsTo(AssignLocation::class);
    }

    public function workTime()
    {
        return $this->belongsTo(WorkTime::class);
    }

    public function openTransaction()
    {

        $ticket = Ticket::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString() . '%')
        ->where('user_id', $this->user_id)
        ->orderBy('created_at', 'asc')
        ->first()
        ->created_at;

        return date('G:i:s A', strtotime($ticket));
    }

    public function tickets()
    {
        return Ticket::where('created_at', 'like', Carbon::parse($this->created_at)->toDateString() . '%')
                ->where('user_id', $this->user_id)
                ->orderBy('created_at', 'asc')
                ->get();
    }
}
