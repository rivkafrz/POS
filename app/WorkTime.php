<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    public function assignLocation()
    {
        return $this->belongsTo(AssignLocation::class);
    }
}
