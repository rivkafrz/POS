<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Work_time extends Model
{
    use CrudTrait;

    protected $table = 'work_times';
    protected $fillable = ['assign_location_id', 'work_time'];

    public function assignLocation()
    {
        return $this->belongsTo(Assign_location::class);
    }

    public function users()
    {
     	return $this->hasMany(user::class);
    }
}
