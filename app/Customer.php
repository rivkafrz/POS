<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
       protected $fillable = ['name','phone'];

       public function seat()
    {
        return $this->hasMany(Seat::class);
    }
}
