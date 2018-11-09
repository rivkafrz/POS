<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   	protected $fillable = ['name','phone'];

	public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
