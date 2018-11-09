<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baggage extends Model
{
    protected $fillable = [
        'amount',
        'ticket_id'
    ];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
