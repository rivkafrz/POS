<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\EOD;
use Alert;

class EODController extends Controller
{
    public function eod()
    {
        Alert::success('EOD successfully created')->flash();
        Auth::user()->eods()->create([
                'assign_location_id' => Auth::user()->workTime->assignLocation->id,
                'work_time_id' => Auth::user()->workTime->id,
            ]);
        return redirect()->route('backpack.dashboard');
    }

    public function approve(Request $request)
    {
        $eod = EOD::find($request->eod_id);
        $eod->update(['approved' => 1]);
        Alert::success('Successfully approve EOD')->flash();
        return redirect()->route('crud.eod.index');
    }
}
