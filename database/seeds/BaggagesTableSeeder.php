<?php

use Illuminate\Database\Seeder;
use App\Ticket;
use App\Baggage;

class BaggagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Baggage::create([
            'amount'    => '100',
            'ticket_id' => Ticket::first()->id
        ]);

        Baggage::create([
            'amount'    => '110',
            'ticket_id' => Ticket::first()->id
        ]);
    }
}
