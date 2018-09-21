<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$rivka = Employee:: create([
            'nip' => 123,
            'employee_name' => 'Rivka',
            'gender' => 'female',
            'job_section' => 'Admin',
            'phone' => '081233455',
            'address' => 'Tangerang'
        ]);

        User:: create([
        	'name'=> 'admin',
        	'email'=> 'admin@gmail.com',
            'password'=>bcrypt ('secret'),
        	'employee_id'=> $rivka->id
        ]);

    }
}
