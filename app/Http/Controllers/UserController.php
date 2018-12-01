<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Alert;

class UserController extends Controller
{
    public function updateInfo(Request $request)
    {
        Auth::user()->employee->update($request->all());
        Alert::success('Successfully update info')->flash();
        return redirect()->back();
    }
}
