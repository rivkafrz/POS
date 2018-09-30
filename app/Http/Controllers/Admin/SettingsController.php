<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assign_location;
use App\Models\User;
use Auth;
use Alert;

class SettingsController extends Controller
{
    public function getWorkTime(Request $request)
    {
    	$location = Assign_location::find($request->assign_location);
    	if (isset($request->settings)) {
    		User::find(Auth::user()->id)->update([
    			'work_time_id' => $request->work_time
    		]);
            Alert::success('Saved')->flash();
    		return redirect()->route('backpack.dashboard');
    	} else {
	    	return view('vendor.backpack.base.dashboard');
    	}
    }
}
