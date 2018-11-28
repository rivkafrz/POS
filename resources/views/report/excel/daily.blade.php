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
            <td>Work Time</td>
            <td>Leader</td>
            <td>Ticketing</td>
        </tr>
        @foreach ($manifest as $man)
            @foreach ($man->ticketings() as $t)
                <tr>
                    <td>{{ $man->workTime()->work_time }}</td>
                    <td>{{ $man->user->employee->employee_name }}</td>
                    <td>{{ $t->employee_name }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>

    <table>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Departure Time</th>
            <th rowspan="2">No Body</th>
            <th rowspan="2">Driver</th>
            <th rowspan="2">Total Passenger</th>
            <th colspan="2">Payment Method</th>
        </tr>
        <tr>
            <th>Non Cash</th>
            <th>Cash</th>
        </tr>
        @php
            $pijet = 1;
            $income = 0;
        @endphp
        @foreach ($manifest as $m)
        <tr>
            <td>{{ $pijet }}</td>
            <td>{{ $m->departureTime->boarding_time }}</td>
            <td>{{ $m->no_body }}</td>
            <td>{{ $m->driver }}</td>
            <td>{{ $m->passenger(1) }}</td>
            <td>{{ number_format($m->nonCash()) }}</td>
            <td>{{ number_format($m->cash()) }}</td>
        </tr>
        @php
            $income += $m->nonCash();
            $income += $m->cash();
        @endphp
        @endforeach
        <tr>
            <td rowspan="2" colspan="4">Total</td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td>The Amount of Income Terminal 1</td>
        </tr>
        <tr>
            <td>Rp. {{ number_format($income) }}</td>
        </tr>
    </table>
</body>
</html>