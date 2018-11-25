<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Customer extends Model
{
	use CrudTrait;
   	protected $fillable = ['name','phone'];

	public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
