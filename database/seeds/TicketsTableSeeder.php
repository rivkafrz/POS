<?php

use Illuminate\Database\Seeder;
use App\Ticket;
use App\DepartureTime;
use App\Destination;
use App\AssignLocation;
use App\Customer;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ticket::create([
            'code'                  => 'kmzwa8awaa',
            'departure_time_id'     => DepartureTime::first()->id,
            'destination_id'        => Destination::first()->id,
            'assign_location_id'    => AssignLocation::first()->id,
            'customer_id'           => Customer::first()->id
        ]);
    }
}
