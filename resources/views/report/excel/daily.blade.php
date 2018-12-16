<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Report</title>
</head>
<body>
    <table>
        <tr>
            <td colspan="8"><strong>Daily Report</strong></td>
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
            <th rowspan="2">No Body</th>
            <th rowspan="2">Driver</th>
            <th rowspan="2">Total Customer</th>
            <th colspan="{{ $assigns->count() }}">Refund</th>
            <th rowspan="2">Total Refund</th>
            <th colspan="3">Payment Method</th>
        </tr>
        <tr>
            @foreach ($assigns as $assign)
                <th>{{ $assign->assign_location }}</th>
            @endforeach
            @foreach ($assigns as $as)
                <th>{{ $as->assign_location }}</th>
            @endforeach
            <th>Non Cash</th>
            <th>Cash</th>
            <th>Refund</th>
        </tr>
        @php
            $pijet = 1;
            $income = 0;
            $income_cash = 0;
            $income_nocash = 0;
            $refund_fee = 0;
            $stack = [];
        @endphp
        @foreach ($manifest as $m)
            @php
                $current_total_passenger = 0;
                $current_cash = 0;
                $current_noncash = 0;
                $current_refund = 0;
                $needle = $m->departureTime->id . "-" . $m->destination->id;
                $seat_refunded = 0;
                $total_seat_refunded = 0;
            @endphp
            @if (!in_array($needle, $stack))
                <tr>
                    <td>{{ $pijet }}</td>
                    @php
                        $pijet++;
                    @endphp
                    @foreach ($assigns as $assign)
                        @php
                            $current_manifest = Manifest::where('created_at', 'like', Carbon::parse($m->created_at)->toDateString() . '%')
                                    ->where('departure_time_id', $m->departureTime->id)
                                    ->where('destination_id', $m->destination->id)
                                    ->where('assign_location_id', $assign->id)
                                    ->first();
                            if (!is_null($current_manifest)) {
                                $total = $current_manifest->passenger(1) + $current_manifest->passenger(0);
                                $seat_refunded = $current_manifest->refundSeat();
                            }
                        @endphp
                        <td>{{ $total }}</td>
                        @php
                            $current_total_passenger += $total;
                            if (!is_null($current_manifest)) {
                                $current_cash += $current_manifest->cash(); 
                                $current_noncash += $current_manifest->nonCash(); 
                                $current_refund += $current_manifest->refundPrice(); 
                            }
                        @endphp
                    @endforeach
                    <td>{{ $m->departureTime->boarding_time }}</td>
                    <td>{{ $m->no_body }}</td>
                    <td>{{ $m->driver }}</td>
                    <td>{{ $current_total_passenger }}</td>
                    @foreach ($assigns as $assign)
                        @php
                            $current_manifest = Manifest::where('created_at', 'like', Carbon::parse($m->created_at)->toDateString() . '%')
                                    ->where('departure_time_id', $m->departureTime->id)
                                    ->where('destination_id', $m->destination->id)
                                    ->where('assign_location_id', $assign->id)
                                    ->first();
                            if (!is_null($current_manifest)) {
                                $seat_refunded = $current_manifest->refundSeat()->count();
                            }
                        @endphp
                        <td>{{ $seat_refunded == 0 ? '-' : $seat_refunded }}</td>
                        @php
                            $total_seat_refunded += $seat_refunded;
                        @endphp
                    @endforeach
                    <td>{{ $total_seat_refunded }}</td>
                    <td>{{ number_format($current_noncash) }}</td>
                    <td>{{ number_format($current_cash) }}</td>
                    <td>{{ number_format($current_refund) }}</td>
                </tr>
            @endif
        @php
            $income += $m->nonCash();
            $income_nocash += $m->nonCash();
            $income += $m->cash();
            $income_cash += $m->cash();
            $refund_fee += $current_refund;
            !in_array($needle, $stack) ? array_push($stack, $needle) : null;
        @endphp
        @endforeach
        <tr>
            <td rowspan="2" colspan="{{ ($assigns->count() * 2) + 6 }}">Total</td>
            <td rowspan="2">{{ number_format($income_nocash) }}</td>
            <td rowspan="2">{{ number_format($income_cash) }}</td>
            <td rowspan="2">{{ number_format($refund_fee) }}</td>
            <td>The Amount of Income</td>
        </tr>
        <tr>
            <td>Rp. {{ number_format($income + $refund_fee) }}</td>
        </tr>
    </table>
</body>
</html>