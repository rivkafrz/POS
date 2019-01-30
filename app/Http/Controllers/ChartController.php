<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\SummaryChart;
use Carbon\Carbon;
use App\Manifest;

class ChartController extends Controller
{
    protected $start;
    protected $end;
    protected $dataset;
    protected $range;

    public function summary($start, $end)
    {
        $this->start = Carbon::parse($start);
        $this->end = Carbon::parse($end);
        $this->constructLabel();
        $chart = new SummaryChart;
        $chart->labels($this->months);
        $chart->dataset('Total ', 'bar', $this->dataset);
        
        return view('charts.summary', compact('chart'));
    }

    public function constructLabel()
    {
        if ($this->end->format('Y') == $this->start->format('Y')) {
            $this->range = $this->end->format('n') - $this->start->format('n');
        } else {
            $this->range = (12 - $this->start->format('n')) + $this->end->format('n');
        }
        $this->months = [];
        $this->dataset = [];
        for ($i=0; $i <= $this->range; $i++) { 
            array_push($this->months, $this->start->format('F'));
            $current = Manifest::where('created_at', 'like', $this->start->format('Y-m-') . '%')->get();
            if ($current->count() != 0) {
                $total = 0;
                foreach ($current as $manifest) {
                    $total += $manifest->cash() + $manifest->nonCash() + $manifest->refundPrice();
                }
                $this->dataset = array_merge($this->dataset, [$total]);
            } else {
                $this->dataset = array_merge($this->dataset, [0]);
            }
            $this->start->addMonth();
        }
    }
}
