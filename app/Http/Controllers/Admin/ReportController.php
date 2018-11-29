<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\EOD;
use App\AssignLocation;
use App\Manifest;
use Carbon\Carbon;
use App\Exports\DailyManifestExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function create()
    {
        $al = AssignLocation::all();
        return view('report.create', compact('al'));
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

    public function excelDaily($assign, $from)
    {
        $from = Carbon::parse($from);
        if ($assign == 0) {
            $manifest = Manifest::where('created_at', 'like', $from->toDateString() . '%')
            ->get();
        } else {
            $manifest = Manifest::where('created_at', 'like', $from->toDateString() . '%')
                            ->where('assign_location_id', $assign)
                            ->get();
        }

        return Excel::download(new DailyManifestExport($manifest, $assign), 'users.xlsx');
    }
}
