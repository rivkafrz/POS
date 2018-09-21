<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Work_time;
use App\Models\Assign_location;
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

        $a = Assign_location:: create([
            'assign_location' => 'terminal 1A'
        ]);

        $w =Work_time:: create([
            'Work_time' => 'Shift 1',
            'assign_location_id' =>  $a->id 
        ]);


        User:: create([
        	'name'=> 'admin',
        	'email'=> 'admin@gmail.com',
            'password'=> 'secret',
        	'employee_id'=> $rivka->id
        ]);

    }
}
