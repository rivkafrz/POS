<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignLocation extends Model
{
    public function manifest()
    {
        return $this->hasMany(Manifest::class);
    }
}
