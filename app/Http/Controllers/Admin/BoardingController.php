<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Departure_time;

class BoardingController extends Controller
{
    public function create()
    {
    	$destinations = Destination::all();
    	$departures = Departure_time::all();
        return view('boarding.create', compact('destinations', 'departures'));
    }
}
