<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assign_location;
use App\Models\User;
use Auth;

class SettingsController extends Controller
{
    public function getWorkTime(Request $request)
    {
    	$location = Assign_location::find($request->assign_location);
    	if (isset($request->settings)) {
    		User::find(Auth::user()->id)->update([
    			'work_time_id' => $request->work_time
    		]);
    		return redirect()->route('backpack.dashboard');
    	} else {
	    	return view('vendor.backpack.base.dashboard');
    	}
    }
}
