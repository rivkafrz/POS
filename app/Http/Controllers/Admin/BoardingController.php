<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Departure_time;
use App\Customer;
use App\Ticket;
use App\Seat;
use Auth;
use App\Baggage;

class BoardingController extends Controller
{
    public function create()
    {
    	$destinations = Destination::all();
    	$departures = Departure_time::all();
        return view('boarding.create', compact('destinations', 'departures'));
    }

    public function store(Request $form)
    {
        dd($form->all());
        $customer = Customer::firstOrCreate([
            'phone' => $form->phone,
            'name'  => $form->customer
        ]);
        
        $ticket = Ticket::create([
            'code'                  => $form->code,
            'note'                  => $form->note,
            'departure_time_id'     => $form->departureTime,
            'destination_id'        => $form->destination,
            'assign_location_id'    => Auth::user()->workTime->assignLocation->id,
            'customer_id'           => $customer->id,
            'note'                  => $form->note
        ]);

        foreach ($form->selectedSeat as $seat) {
            Seat::create([
                'seat_number'          => $seat,
                'ticket_id'            => $ticket->id,
                'departure_time_id'    => $form->departureTime,
                'destination_id'       => $form->destination,
                'assign_location_id'   => Auth::user()->workTime->assignLocation->id
            ]);
        };
        
        foreach ($form->baggages as $amount) {
            Baggage::create([
                'amount'        => $amount,
                'ticket_id'     => $ticket->id
            ]);
        };
    }

    public function update($id, Request $form)
    {
        $ticket = Ticket::find($id);
        foreach ($ticket->seats as $seat) {
            Seat::find($seat->id)->delete();
        }

        foreach ($form->selectedSeat as $seat) {
            $ticket->seats()->create([
                'seat_number'          => $seat,
                'departure_time_id'    => $form->departureTime,
                'destination_id'       => $form->destination,
                'assign_location_id'   => Auth::user()->workTime->assignLocation->id
            ]);
        }
    }

    public function tickets($phone)
    {
    	$customer = Customer::where('phone', $phone)->first();
        if ($customer == null) {
            return response()->json(['tickets' => 0]);
        } else {
    	   return response()->json(['tickets' => $customer->tickets->count()]);
        }
    }

    public function customer($phone)
    {
        return response()->json(Customer::where('phone', $phone)->first());
    }

    public function show($code)
    {
        $ticket = Ticket::where('code', $code)->first();

        if ($ticket == null) {
            return response()->json(null);
        }

        return response()->json($ticket->load(['customer', 'baggages', 'departureTime', 'to', 'seats']));
    }

    public function seats($to, $time)
    {
        $seat = Seat::where('destination_id', $to)
                    ->where('departure_time_id', $time);

        return response()->json($seat->get());
    }
}
