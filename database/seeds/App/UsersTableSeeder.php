<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class App\UsersTableSeeder extends Seeder
{
    public function run()
    {
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
        $leader->employee_id = $rivka->id;
        $leader->save ();
        $leader->attachRole ($leaderRole);


        //membuat sample ticketing
        $ticketing = new User();
        $ticketing->email = "ticketing@gmail.com";
        $ticketing->password =bcrypt ('secretticketing');
        $ticketiing->employee_id = $rivka->id;
        $ticketing->save ();
        $ticketing->attachRole ($ticketingRole); 
       
    }

}
