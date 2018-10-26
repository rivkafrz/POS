<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
	}
}
