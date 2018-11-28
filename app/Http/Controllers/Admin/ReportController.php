<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\EOD;
use Carbon\Carbon;

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

    public function apiReport($type, $from, $to, $assign)
    {
        switch ($type) {
            case 'daily':
                return $this->reportDaily($from, $to);
                break;
            case 'manifest':
                return $this->reportManifest($from, $to);
                break;
            case 'summary':
                return $this->reportDaily($from, $to);
                break;
        }
    }


    public function reportDaily($from, $to)
    {
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        if ($from > $to) {
            $temp = $to;
            $to   = $from;
            $from  = $temp;
        }

        $response = [$from->toDateString()];
        
        while ($from->toDateString() != $to->toDateString()) {
            $response = array_merge($response, [$from->addDay()->toDateString()]);
        }
        
        return response()->json($response);
    }

    public function reportManifest($from, $to)
    {
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        if ($from > $to) {
            $temp = $to;
            $to   = $from;
            $from  = $temp;
        }
        
        $response = [$from->toDateString()];
        while ($from->toDateString() != $to->toDateString()) {
            $response = array_merge($response, [$from->addDay()->toDateString()]);
        }
        
        return response()->json($response);
    }
}
