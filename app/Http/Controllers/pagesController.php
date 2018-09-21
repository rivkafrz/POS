<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pagesController extends Controller
{
	public function welcome(){


    return redirect()->route('backpack');
    }
}
