<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonCash extends Model
{
      protected $fillable = [
        'card_type',
        'bank_id',
        'no_card',
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

    public function getCardTypeAttribute($value)
    {
        $type = 'CREDIT';
        if ($value) {
            // debit == 1
            $type = 'DEBIT';
        }
        return $type;
    }
}
