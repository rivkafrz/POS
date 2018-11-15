<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
      protected $fillable = [
        'change',
        'ticket_id'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
