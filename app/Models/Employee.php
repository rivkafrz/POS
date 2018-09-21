<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Employee extends Model
{
    use CrudTrait;


    protected $table = 'employees';
    protected $fillable = ['nip','employee_name','gender','job_section','phone','address'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
