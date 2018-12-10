<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manifest Report</title>
</head>
<style>
    body{
        font-size: 12px;
    }

    td.center {
        text-align: center;
    }
    .justify{
        font-style: inherit justify;
    }
    .page-break {
        page-break-after: always;
    }
    table.outline-table {
		border: 1px solid;
		border-spacing: 0;
        margin-top: 30px;
	}
	tr.border-bottom td, td.border-bottom {
		border-bottom: 1px solid;
	}
	tr.border-top td, td.border-top {
		border-top: 1px solid;
	}
	tr.border-right td, td.border-right {
		border-right: 1px solid;
	}
	tr.border-right td:last-child {
		border-right: 0px;
	}
	tr.center td, td.center {
		text-align: center;
	}
	td.pad-left {
		padding-left: 5px;
	}
	tr.right-center td, td.right-center {
		text-align: right;
		padding-right: 50px;
	}
	tr.right td, td.right {
		text-align: right;
	}
	.grey {
		background:grey;
	}
</style>
<body>
    <table width="100%">
        <tr>
            <td class="center"><h1>Manifest Report</h1></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td width="15%">Date</td>
            <td>: {{ $date->toDateString() }}</td>
        </tr>
        <tr>
            <td width="15%">Destination</td>
            <td>: {{ $destination->to }}</td>
        </tr>
    </table>

    <table width="50%" class="outline-table">
        <tr class="center">
            <td class="border-right"><strong>Work Time</strong></td>
            <td><strong>Leader</strong></td>
        </tr>
        @foreach ($manifest as $man)
            <tr class="center border-top">
                <td class="border-right">{{ $man->work_time->work_time }}</td>
                <td>{{ $man->user->employee->employee_name }}</td>
            </tr>
        @endforeach
    </table>

    <table width="100%" class="outline-table">
        <tr class="center border-bottom">
            <td rowspan="2" class="border-right"><strong>No</strong></td>
            <td rowspan="2" class="border-right"><strong>Departure Time</strong></td>
            <td rowspan="2" class="border-right"><strong>No Body</strong></td>
            <td rowspan="2" class="border-right"><strong>Driver</strong></td>
            <td colspan="{{ count($manifest->groupBy('assign_location_id')) * 2 }}" class="border-right"><strong>Passenger</strong></td>
            <td rowspan="2"><strong>Total</strong></td>
        </tr>
        @php
            $assigns = App\AssignLocation::all();            
        @endphp
        <tr class="center border-bottom">
            @foreach ($assigns as $as)
                <td class="border-right" colspan="2">{{ $as->assign_location }}</td>
            @endforeach
        </tr>
        @php
            $iter = 1;
            $cell_passenger = 0;
            $total_passenger = 0;
            $cell = [];
        @endphp
        @foreach ($manifest as $m)
            <tr class="center border-bottom">
                <td class="border-right">{{ $iter }}</td>
                <td class="border-right">{{ $m->departureTime->boarding_time }}</td>
                <td class="border-right">{{ $m->no_body }}</td>
                <td class="border-right">{{ $m->driver }}</td>
                @foreach ($assigns as $assign)
                    @php
                        $current_manifest = App\Manifest::where('created_at', 'like', $date->toDateString() . '%')
                                ->where('departure_time_id', $m->departureTime->id)
                                ->where('destination_id', $m->destination->id)
                                ->where('assign_location_id', $assign->id)
                                ->first();
                        $cell_passenger += ($current_manifest->passenger(1) + $current_manifest->passenger(0));
                        array_push($cell, ['in' => $current_manifest->passenger(1), 'out' => $current_manifest->passenger(0)]);
                    @endphp
                    <td class="border-right">{{ $current_manifest->passenger(1) }}</td>
                    <td class="border-right">{{ $current_manifest->passenger(0) }}</td>
                @endforeach
                <td>{{ $cell_passenger }}</td>
                @php
                    $total_passenger += $cell_passenger;
                    $cell_passenger = 0;
                @endphp
            </tr>
        @endforeach

        <tr class="center">
            <td colspan="4" class="border-right">Total</td>
            @foreach ($cell as $c)
                <td class="border-right">{{ $c['in'] }}</td>
                <td class="border-right">{{ $c['out'] }}</td>
            @endforeach
            <td>{{ $total_passenger }}</td>
        </tr>
    </table>

</body>
</html>