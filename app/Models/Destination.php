<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Destination extends Model
{
    use CrudTrait;
    
    protected $table = 'destinations';
    protected $fillable = ['to','price','code'];
    public function seat()
    {
        return $this->hasMany(Seat::class);
    }
}
