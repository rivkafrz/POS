<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Employee;
use App\WorkTime;
use App\AssignLocation;
use App\DepartureTime;
use App\Customer;
use App\Destination;
use App\Seat;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/*

    	Untuk membuat seeder menggunakan perintah
    	php artisan make:seeder NamaSeederNya

    	Kemarin salah command kayaknya, make:seed ya ?

    	kodingan yang ada di file DatabaseSeeder di kesiniin soalnya ada beberapa variable yang dipake

    	Jalanin seedernya sekalian sama fresh migrasi biar gak ada duplikasi data di database yang bisa bikin error

    	*/

        //membuat role admin
        $adminRole = new Role();
        $adminRole->id =1;
        $adminRole->name = "admin";
        $adminRole->display_name = "Admin";
        $adminRole->save();

        //membuat role leader
        $leaderRole = new Role();
        $leaderRole->id = 2;
        $leaderRole->name = "leader";
        $leaderRole->display_name = "Leader";
        $leaderRole->save ();

        //membuat role ticketing
        $ticketingRole = new Role();
        $ticketingRole->id = 3;
        $ticketingRole->name = "ticketing";
        $ticketingRole->display_name = "Ticketing";
        $ticketingRole->save ();

        $rivka = Employee:: create([
            'nip' => 123,
            'employee_name' => 'Rivka',
            'gender' => 'female',
            'job_section' => 'Admin',
            'phone' => '081233455',
            'address' => 'Tangerang'  
        ]);

        $faris = Employee:: create([
            'nip' => 321,
            'employee_name' => 'faris',
            'gender' => 'male',
            'job_section' => 'ticketing',
            'phone' => '0817457565576',
            'address' => 'Tangerang'
        ]);

        $melan = Employee:: create([
            'nip' => 456,
            'employee_name' => 'melan',
            'gender' => 'female',
            'job_section' => 'leader',
            'phone' => '0812798989787',
            'address' => 'Tangerang'
        ]);

        $terminal1 = AssignLocation:: create([
            'assign_location' => 'Terminal 1 A',
            'code_location' => 'BSH01'

        ]);

        $shift1 = WorkTime:: create([
            'Work_time' => 'Shift 1',
            'assign_location_id' =>  $terminal1->id

        ]);

        $jam = DepartureTime:: create([
            'boarding_time' => '2018-10-31 07:00:00',
           

        ]);
        
        $customer = Customer:: create([
            'name' => 'Melan',
            'phone' => '0817777772347'
           

        ]);

         $jurusan = Destination:: create([
            'to' => 'Batununggal(BDG)',
            'price' => '115000',
            'code'=> '01'
           

        ]);


        //membuat sample admin
        $admin = new User();
        $admin->email = "admin@gmail.com";
        $admin->password = bcrypt ('secret');
        $admin->employee_id = $rivka->id;
        $admin->save ();
        $admin->attachRole ($adminRole); 
        

        //membuat sample leader
        $leader = new User();
        $leader->email = "leader@gmail.com";
        $leader->password =bcrypt ('secretleader');
        $leader->employee_id = $faris->id;
        $leader->save ();
        $leader->attachRole ($leaderRole);


        //membuat sample ticketing
        $ticketing = new User();
        $ticketing->email = "ticketing@gmail.com";
        $ticketing->password =bcrypt ('secretticketing');
        $ticketing->employee_id = $melan->id;
        $ticketing->save ();
        $ticketing->attachRole ($ticketingRole); 
    }
}
