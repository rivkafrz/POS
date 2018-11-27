<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\EOD;

class ReportController extends Controller
{
    public function create()
    {
        return view('report.create');
    }

    public function pdfEOD(Request $request)
    {
        $data['eod'] = EOD::find($request->eod_id);
        $pdf = PDF::loadView('report.pdf.eod', $data);
        return $pdf->stream('eod.pdf');
    }
}
