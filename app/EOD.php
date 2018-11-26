<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class EOD extends Model
{
    use CrudTrait;
    protected $fillable = [
        'user_id',
        'assign_location_id',
        'work_time_id',
        'approved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return substr($value, 11, 5) . " WIB";
    }

    public function getApprovedAttribute($value)
    {
        $status = [
            'Unapproved',
            'Approved'
        ];
        return $status[$value];
    }

    public function assignLocation()
    {
        return $this->belongsTo(AssignLocation::class);
    }
}
