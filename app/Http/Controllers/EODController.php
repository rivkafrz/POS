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
        Auth::user()->eods()->create();
        return redirect()->back();
    }
}
