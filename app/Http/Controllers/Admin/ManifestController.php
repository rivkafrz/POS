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

class ManifestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $det = DepartureTime::all();
        $asl = AssignLocation::all();
        $des = Destination::all();

        return view('manifest.index', compact('det', 'asl', 'des'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(ManifestRequest $request)
    {
        Manifest::create($request->all());
        Alert::success('Successfully create Manifest')->flash();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function manifest($time, $assign, $to, $departure)
    {
        return response()->json(Seat::manifest(Carbon::parse($time), AssignLocation::find($assign) , Destination::find($to), DepartureTime::find($departure))->orderBy('seat_number')->get()->load(['ticket']));
    }
}
