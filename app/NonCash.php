<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonCash extends Model
{
      protected $fillable = [
        'card_type',
        'bank',
        'no_card'
        
        ];
        
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
