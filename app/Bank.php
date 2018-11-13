<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name'
    ];

    public function getNameAttribute($value)
    {
        return strtoupper(str_replace('-', ' ', $value));
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['name'] = str_slug($value);
    }
}
