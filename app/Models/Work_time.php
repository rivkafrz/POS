<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Work_time extends Model
{
    use CrudTrait;

    protected $table = 'work_times';
    protected $fillable = ['work_time', 'assign_location_id'];

    public function assignLocation()
    {
        return $this->belongsTo(Assign_location::class);
    }

    public function users()
    {
     	return $this->hasMany(user::class);
    }
}
