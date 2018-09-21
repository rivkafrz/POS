<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class User extends Model
{
    use CrudTrait;

    protected $table = 'users';
    protected $fillable = ['name','email','password','work_time_id'];
    protected $hidden = ['password'];

    public function workTime()
    {
        return $this->belongsTo(Work_time::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords ($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt ($value);
    }
}
