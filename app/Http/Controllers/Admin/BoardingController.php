<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Departure_time;
use App\Customer;

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
    }

    public function tickets($phone)
    {
    	$customer = Customer::where('phone', $phone)->first();
        if ($customer == null) {
            return response()->json(['tickets' => 0]);
        } else {
    	   return response()->json($customer->tickets);
        }
    }
}
