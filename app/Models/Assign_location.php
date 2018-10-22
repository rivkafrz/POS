<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Assign_location extends Model
{
    use CrudTrait;

    protected $table = 'assign_locations';
    protected $fillable = ['assign_location','code_location'];

    public function workTimes()
    {
        return $this->hasMany(Work_time::class);
    }
    
}
 