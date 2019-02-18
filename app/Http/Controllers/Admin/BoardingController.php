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
use App\Manifest;
use Alert;
use App\Http\Requests\TicketRequest;
use PDF;

class BoardingController extends Controller
{
    public function create()
    {
        if (Auth::user()->settingIsUnset()) {
            Alert::error('Please set your Setting')->flash();
            return redirect()->route('backpack.dashboard');
        }
        if (!is_null(Auth::user()->eods()->where('created_at', 'like', now()->toDateString() . '%')->first())) {
            Alert::success('EOD already created, redirect you back.')->flash();
            return redirect()->back();
        }
    	$destinations = Destination::all();
        $departures = Departure_time::orderBy('boarding_time', 'asc')->get();
        // $departures = Model::orderBy('field', 'asc/desc')->get();
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
            'user_id'               => Auth::user()->id,
            'work_time_id'          => Auth::user()->workTime->id
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

        if ($form->print) {
            $pdf = PDF::loadView('pdf.ticket', compact('ticket'))->setPaper([0,0, 226.78, 340.16]);
            return $pdf->stream('ticket.pdf');
        } else {
            Alert::success('Ticket successfully created')->flash();
            return redirect()->back();
        }
    }

    public function update($id, Request $form)
    {
        $ticket = Ticket::where('code', $form->find)->first();
        $before_seat = $ticket->seats->count();

        // Jika DepartureTime berubah
        if ($ticket->departure_time_id != $form->departureTime) {
            $ticket->update([
                'departure_time_id' => $form->departureTime
            ]);
        }
        if (is_null($form->selectedSeat)) {
            // dd('Refund Semua');
            // Pengurangan Ticket.amount
            $ticket->update([
                'amount' => 0,
                'refund' => $ticket->seats->count() * $ticket->destination->price
            ]);

            foreach($ticket->seats as $seat){
                $seat->update(['refund' => 1]);
            }

        } elseif ($ticket->seats->count() > count($form->selectedSeat)) {
            // dd('Refund Sebagian / Change Sebagian');
            $before_seat = $ticket->seats->count();
            $ticket->update([
                'amount' => count($form->selectedSeat) * $ticket->destination->price,
                'refund' => ($ticket->seats->count() - count($form->selectedSeat)) * $ticket->destination->price
            ]);

            foreach($ticket->seats as $seat){
                // Seat yang tidak dipilih kembali status refund = true
                if (!in_array($seat->seat_number, $form->selectedSeat)) {
                    $seat->update([
                        'refund' => 1
                    ]);
                }
            }

            // Seat baru yang dipilih tidak sama dengan Seat sebelumnya di masuk database
            foreach ($form->selectedSeat as $newSeat) {
                if (Seat::seats(Dest::find($ticket->destination->id), DepartureTime::find($form->departureTime), true)->where('seat_number', $newSeat)->first() == null) {
                    Seat::create([
                        'seat_number'       => $newSeat,
                        'departure_time_id' => $form->departureTime,
                        'destination_id'    => $ticket->destination->id,
                        'assign_location_id'    => $ticket->destination->id,
                        'ticket_id'         => $ticket->id
                    ]);
                    // Hapus Redudant reund seat
                    $ticket = Ticket::where('code', $form->find)->first();
                    $ticket->seats(1)->first()->delete();
                }
            }


        } elseif ($ticket->seats->count() ==  count($form->selectedSeat)) {
            // dd('Change Semua');
            // Remove Semua Seat
            foreach ($ticket->seats as $seat) {
                $seat->delete();
            }

            // Tambah Seat yang dipilih

            foreach ($form->selectedSeat as $new) {
                Seat::create([
                    'seat_number'       => $new,
                    'departure_time_id' => $form->departureTime,
                    'destination_id'    => $ticket->destination->id,
                    'assign_location_id'    => $ticket->destination->id,
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
        $reponse = $ticket->load(['customer', 'baggages', 'departureTime', 'to', 'seats']);
        $reponse = array_merge($reponse->toArray(), ['is_today' => $ticket->isToday()]);
        return response()->json($reponse);
    }

    public function seats($to, $time)
    {
        $seat = Seat::where('created_at', 'like', now()->toDateString() . '%')
                    ->where('destination_id', $to)
                    ->where('departure_time_id', $time)
                    ->where('refund', 0);

        return response()->json($seat->get());
    }

    public function manifest($assignLocation, $destination, $departureTime)
    {
        $man = Manifest::where('created_at', 'like', now()->toDateString() . '%')
                    ->where('assign_location_id', $assignLocation)
                    ->where('destination_id', $destination)
                    ->where('departure_time_id', $departureTime)
                    ->first();
        return response()->json(['locked' => !is_null($man)]);
    }
}
