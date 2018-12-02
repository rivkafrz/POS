<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Refund Report</title>
</head>
<body>
    <table>
        <tr>
            <td colspan="8"><strong>Refund Report</strong></td>
        </tr>
    </table>

    <table>
        <tr>
            <td>Date </td>
            <td>: {{ date('d/m/Y', strtotime(now())) }}</td>
        </tr>
        <tr>
            <td>Assign Location</td>
            <td>: {{ isset($assign->assign_location) ? $assign->assign_location : $assign }}</td>
        </tr>
        
    </table>

    <table>
        <tr>
            <td>Assign Location</td>
            <td>Work Time</td>
            <td>Leader</td>
            <td>Ticketing</td>
        </tr>
        @php
            use App\AssignLocation;
            use App\Manifest;
            use Carbon\Carbon;

            $assigns = AssignLocation::all();
            $metadata = [];
        @endphp
        @foreach ($manifest as $man)
            @foreach ($man->ticketings() as $t)
                @if (!in_array($t->id, $metadata))
                    <tr>
                        <td>{{ $man->workTime()->workTime->assignLocation->assign_location }}</td>
                        <td>{{ $man->workTime()->workTime->work_time }}</td>
                        <td>{{ $man->user->employee->employee_name }}</td>
                        <td>{{ $t->employee_name }}</td>
                    </tr>
                @endif
                @php
                    !in_array($t->id, $metadata) ? array_push($metadata, $t->id) : null;
                @endphp
            @endforeach
        @endforeach
    </table>

    <table>
        <tr>
            <th rowspan="2">No</th>
            <th colspan="{{ $assigns->count() }}">Assign Location</th>
            <th rowspan="2">Departure Time</th>
            <th rowspan="2">Refund Fee</th>
        </tr>
        <tr>
            @foreach ($assigns as $assign)
                <th>{{ $assign->assign_location }}</th>
            @endforeach
        </tr>
        @php
            $pijet = 1;
            $refund = 0;
            $stack = [];
        @endphp
        @foreach ($manifest as $m)
            @php
                $current_total_refund_price = 0;
                $current_cash = 0;
                $current_noncash = 0;
                $needle = $m->departureTime->id . "-" . $m->destination->id;
            @endphp
            @if (!in_array($needle, $stack))
                <tr>
                    <td>{{ $pijet }}</td>
                    @foreach ($assigns as $assign)
                        @php
                            $current_manifest = Manifest::where('created_at', 'like', Carbon::parse($m->created_at)->toDateString() . '%')
                                    ->where('departure_time_id', $m->departureTime->id)
                                    ->where('destination_id', $m->destination->id)
                                    ->where('assign_location_id', $assign->id)
                                    ->first();
                            $total = $current_manifest->refundSeat()->count();
                            $current_refund = $current_manifest->refundPrice();
                        @endphp
                        <td>{{ $total }}</td>
                        @php
                            $current_total_refund_price += $current_refund;
                        @endphp
                    @endforeach
                    <td>{{ $m->departureTime->boarding_time }}</td>
                    <td>{{ number_format($current_total_refund_price) }}</td>
                </tr>
            @endif
        @php
            $refund += $current_total_refund_price;
            $pijet++;
            !in_array($needle, $stack) ? array_push($stack, $needle) : null;
        @endphp
        @endforeach
        <tr>
            <td rowspan="2" colspan="5">Total</td>
            <td>Total Refund Fee</td>
        </tr>
        <tr>
            <td>Rp. {{ number_format($refund) }}</td>
        </tr>
    </table>
</body>
</html>