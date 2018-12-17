<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\EOD;
use App\AssignLocation;
use App\Manifest;
use App\Destination;
use Carbon\Carbon;
use App\Exports\DailyManifestExport;
use App\Exports\RefundExport;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class ReportController extends Controller
{

    protected $manifest;
    
    public function create()
    {
        $al = AssignLocation::all();
        $dt = Destination::all();
        return view('report.create', compact('al', 'dt'));
    }

    public function pdfEOD(Request $request)
    {
        $data['eod'] = EOD::find($request->eod_id);
        $pdf = PDF::loadView('report.pdf.eod', $data);
        return $pdf->stream('eod.pdf');
    }

    public function apiReport($type, $from, $to, $assign)
    {
        if ($type == 'summary') {
            return $this->fetchingSummary($from, $to);
        } else {
            return $this->fetchingReport($from, $to, $type);
        }
        
    }

    public function fetchingSummary($from, $to)
    {
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        $months = [];
        $range = $to->format('m') - $from->format('m');

        $from->subMonth();

        for ($i=0; $i <= $range; $i++) { 
            array_push($months, $from->addMonth()->format('F'));
        }

        return response()->json($months);
    }


    public function fetchingReport($from, $to)
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

    public function pdfSummary($al, $month)
    {
        $data['month'] = $month;
        $data['als'] = AssignLocation::all();
        $pdf = PDF::loadView('report.pdf.summary', $data);
        return $pdf->stream("summary-$month.pdf");
    }

    public function excelDaily($assign, $from)
    {
        $this->fetchingManifest($assign, $from);
        return Excel::download(new DailyManifestExport($this->manifest, $assign), 'daily-report-' . $from . '.xlsx');
    }

    public function excelRefund($assign, $from)
    {
        $this->fetchingManifest($assign, $from);
        return Excel::download(new RefundExport($this->manifest, $assign), 'refund-report-' . $from . '.xlsx');
    }

    public function pdfManifest($destination, $date)
    {
        $data['date']        = Carbon::parse($date);
        $data['manifest']    = Manifest::where('created_at', 'like', $data['date']->toDateString().'%')
                                ->where('destination_id', $destination)
                                ->get();
        $data['destination'] = Destination::find($destination);
        $pdf = PDF::loadView('report.pdf.manifest', $data);
        return $pdf->stream('manifest.pdf');
    }

    private function fetchingManifest($assign, $from)
    {
        $from = Carbon::parse($from);
        if ($assign == 0) {
            $this->manifest = Manifest::where('created_at', 'like', $from->toDateString() . '%')
            ->get();
        } else {
            $this->manifest = Manifest::where('created_at', 'like', $from->toDateString() . '%')
                            ->where('assign_location_id', $assign)
                            ->get();
        }
    }
}
