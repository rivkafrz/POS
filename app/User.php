<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Yadahan\AuthenticationLog\AuthenticationLogable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use AuthenticationLogable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function employee()
    {
        return $this->belongsTo(Models\Employee::class);
    }

    public function workTime()
    {
        return $this->belongsTo(Models\Work_time::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function eods()
    {
        return $this->hasMany(EOD::class);
    }
}
