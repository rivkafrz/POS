<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class TicketController extends Controller
{
    public function ticket()
    {
        $pdf = PDF::loadView('pdf.ticket')->setPaper([0,0, 226.78, 340.16]);
        return $pdf->stream('ticket.pdf');        
    }
}
