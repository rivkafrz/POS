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

        $rivka = Employee:: create([
            'nip' => 321,
            'employee_name' => 'faris',
            'gender' => 'male',
            'job_section' => 'ticketing',
            'phone' => '0817457565576',
            'address' => 'Tangerang'
        ]);

        $rivka = Employee:: create([
            'nip' => 456,
            'employee_name' => 'melan',
            'gender' => 'female',
            'job_section' => 'leader',
            'phone' => '0812798989787',
            'address' => 'Tangerang'
        ]);

        $a = Assign_location:: create([
            'assign_location' => 'Terminal 1 A'
        ]);

        $w =Work_time:: create([
            'Work_time' => 'Shift 1',
            'assign_location_id' =>  $a->id 
        ]);


        

        $this -> call (App\UsersTableSeeder::class);

    }
}
