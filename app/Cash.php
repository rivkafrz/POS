<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
      protected $fillable = [
        'amount',
        'change',
        
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
