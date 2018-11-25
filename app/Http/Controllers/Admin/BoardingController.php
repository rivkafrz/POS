<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Departure_time;
use App\DepartureTime;
use App\Destination as Dest;
use App\Customer;
use App\Ticket;
use App\Seat;
use App\Cash;
use App\Bank;
use App\NonCash;
use Auth;
use App\Baggage;
use Alert;
use App\Http\Requests\TicketRequest;
use PDF;

class BoardingController extends Controller
{
    public function create()
    {
        if (!is_null(Auth::user()->eods()->where('created_at', 'like', now()->toDateString() . '%')->first())) {
            Alert::success('EOD already created, redirect you back.')->flash();
            return redirect()->back();
        }
    	$destinations = Destination::all();
        $departures = Departure_time::all();
        $banks = Bank::all();
        return view('boarding.create', compact('destinations', 'departures', 'banks'));
    }

    public function store(TicketRequest $form)
    {
        $customer = Customer::firstOrCreate([
            'phone' => $form->phone,
            'name'  => $form->customer
        ]);
        $amount = Destination::find($form->destination)->price * count($form->selectedSeat);
        $ticket = Ticket::create([
            'code'                  => $form->code,
            'note'                  => $form->note,
            'departure_time_id'     => $form->departureTime,
            'destination_id'        => $form->destination,
            'assign_location_id'    => Auth::user()->workTime->assignLocation->id,
            'customer_id'           => $customer->id,
            'amount'                => $amount,
            'user_id'               => Auth::user()->id
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
            if ($amount != 0 or $amount != null) {
                Baggage::create([
                    'amount'        => $amount,
                    'ticket_id'     => $ticket->id
                ]);
            }
        };

        // cash == 1
        if ($form->payment_type){
            Cash::create([
                'change'    => $form->cash_change,
                'ticket_id' => $ticket->id

            ]);
        } else {
            $bank = Bank::firstOrCreate([
                'name' => str_slug($form->bank_name)
            ]);

            NonCash::create([
                'card_type' => $form->card_type,
                'bank_id'   => $bank->id,
                'no_card'   => $form->no_card,
                'ticket_id' => $ticket->id

            ]);
        }

        $pdf = PDF::loadView('pdf.ticket', compact('ticket'))->setPaper([0,0, 226.78, 340.16]);
        return $pdf->stream('ticket.pdf');
    }

    public function update($id, Request $form)
    {
        $ticket = Ticket::where('code', $form->find)->first();
        
        // Jika DepartureTime berubah
        if ($ticket->departure_time_id != $form->departureTime) {
            $ticket->update([
                'departure_time_id' => $form->departureTime
            ]);
        }

        // update Seat
        foreach($ticket->seats as $seat){
            // Seat yang tidak dipilih kembali status refund = true
            if (!in_array($seat->seat_number, (is_null($form->selectedSeat) ? [] : $form->selectedSeat))) {
                $seat->update([
                    'refund' => 1
                ]);
            }
        }

        // Seat baru yang dipilih tidak sama dengan Seat sebelumnya di masuk database
        foreach ((is_null($form->selectedSeat) ? [] : $form->selectedSeat) as $newSeat) {
            if (Seat::seats(Dest::find($ticket->destination->id), DepartureTime::find($form->departureTime), true)->where('seat_number', $newSeat)->first() == null) {
                Seat::create([
                    'seat_number'       => $newSeat,
                    'departure_time_id' => $form->departureTime,
                    'destination_id'    => $ticket->destination->id,
                    'ticket_id'         => $ticket->id
                 ]);
            }
        }

        // Update Baggage
        foreach ($ticket->baggages as $baggage) {
            $baggage->delete();
        }
        if (isset($form->baggages)) {
            foreach ($form->baggages as $baggage) {
                if ($baggage != null) {
                    $ticket->baggages()->create([
                        'amount' => $baggage
                    ]);
                }
            }
        }

        // hapus semua baggage jika semua kursi refund
        if (is_null($form->selectedSeat)) {
            $ticket = Ticket::where('code', $form->find)->first();
            foreach ($ticket->baggages as $baggage) {
                $baggage->delete();
            }
        }

        Alert::success('Ticket updated successfully')->flash();
        return redirect()->back();
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
        $seat = Seat::where('created_at', 'like', now()->toDateString() . '%')
                    ->where('destination_id', $to)
                    ->where('departure_time_id', $time)
                    ->where('refund', 0);

        return response()->json($seat->get());
    }
}
