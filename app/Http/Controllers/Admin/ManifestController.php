<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ManifestRequest;
use App\Http\Controllers\Controller;
use App\DepartureTime;
use App\Destination;
use App\AssignLocation;
use App\Seat;
use App\Manifest;
use Carbon\Carbon;
use Alert;
use Auth;

class ManifestController extends Controller
{
    public function index()
    {
        if (is_null(Auth::user()->workTime)) {
            Alert::error('Settings is unset')->flash();
            return redirect()->route('backpack.dashboard');
        }
        $det = DepartureTime::all();
        $asl = AssignLocation::all();
        $des = Destination::all();

        return view('manifest.index', compact('det', 'asl', 'des'));
    }

    public function store(ManifestRequest $request)
    {
        Manifest::create($request->all());
        Alert::success('Successfully create Manifest')->flash();
        return redirect()->back();
    }

    public function show($al, $dt, $d)
    {
        $res = Manifest::where('created_at', 'like', now()->toDateString() . '%')
            ->where('assign_location_id', $al)
            ->where('departure_time_id', $dt)
            ->where('destination_id', $d)
            ->first();

        return response()->json($res);
    }

    public function manifest($time, $assign, $to, $departure)
    {
        $response = Seat::manifest(Carbon::parse($time), AssignLocation::find($assign) , Destination::find($to), DepartureTime::find($departure))->orderBy('seat_number', 'asc')
            ->get()
            ->load(['ticket']);
        return response()->json($response);
    }

    public function passengerCheck($id)
    {
        Seat::find($id)->update(['checked' => 1]);
        return response()->json(Seat::find($id));
    }
}
