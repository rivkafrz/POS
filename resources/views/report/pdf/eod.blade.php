<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EOD</title>
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
            <td class="center"><h1>End of Day</h1></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td>Assign Location</td>
            <td>: {{ $eod->assignLocation->assign_location }}</td>
            <td width="50%"></td>
            <td>Date</td>
            <td>: {{ date('d/m/Y', strtotime($eod->created_at)) }}</td>
        </tr>
        <tr>
            <td>Work Time</td>
            <td>: {{ $eod->workTime->work_time }}</td>
            <td width="50%"></td>
            <td>Open Transaction</td>
            <td>: {{ $eod->openTransaction() }}</td>
        </tr>
        <tr>
            <td>Ticketing</td>
            <td colspan="4">: {{ $eod->user->employee->employee_name }}</td>
        </tr>
    </table>

    <table width="100%" class="outline-table">
        <tr class="border-bottom center border-right">
            <td rowspan="2">No</td>
            <td rowspan="2">Departure Time</td>
            <td rowspan="2">No Transaction</td>
            <td rowspan="2">Time</td>
            <td rowspan="2">Customer</td>
            <td rowspan="2">Qty</td>
            <td rowspan="2">No Card</td>
            <td rowspan="2">Bank</td>
            <td class="center" colspan="2">Amount</td>
        </tr>
        <tr class="border-bottom">
            <td class="center border-right">Non Cash</td>
            <td class="center   ">Cash</td>
        </tr>
        @php
            $pijet = 1;
            $nonCash = 0;
            $cash = 0;
            $refund = 0;
        @endphp
        @foreach ($eod->tickets() as $ticket)
            @if ( $ticket->seats->count() != 0)
                <tr class="center border-right">
                    <td>{{ $pijet ++ }}</td>
                    <td>{{ $ticket->departureTime->boarding_time }}</td>
                    <td>{{ $ticket->code }}</td>
                    <td>{{ substr($ticket->created_at, 11, 5) }}</td>
                    <td>{{ $ticket->customer->name }}</td>
                    <td>{{ $ticket->seats->count() }}</td>
                    <td>{{ !is_null($ticket->nonCash) ? $ticket->nonCash->no_card : null }}</td>
                    <td>{{ !is_null($ticket->nonCash) ? $ticket->nonCash->bank->name : null }}</td>
                    <td>{{ isset($ticket->nonCash) ? number_format($ticket->amount) : null }}</td>
                    <td>{{ isset($ticket->cash) ? number_format($ticket->amount) : null }}</td>
                </tr>
                @if (is_null($ticket->cash))
                    @php
                        $nonCash += $ticket->amount;
                    @endphp
                    @else
                    @php
                        $cash += $ticket->amount;
                    @endphp
                @endif
                @php
                    $refund += $ticket->refund();
                @endphp
                @else
                @php
                    $refund += $ticket->refund();
                @endphp
            @endif
        @endforeach
        <tr class="center border-right border-top">
            <td colspan="8" class="text-center">SUB TOTAL</td>
            <td class="text-center">{{ number_format($nonCash) }}</td>
            <td class="text-center">{{ number_format($cash) }}</td>
        </tr>
        <tr class="center border-right border-top">
            <td colspan="8" class="text-center">REFUND INCOME</td>
            <td colspan="2" class="text-center">{{ 'Rp. ' . number_format($refund) }}</td>
        </tr>
        <tr class="center border-right border-top">
            <td colspan="8" class="text-center">TOTAL + REFUND</td>
            <td colspan="2" class="text-center">{{ "Rp . " . number_format($cash + $nonCash + $refund) }}</td>
        </tr>
    </table>
</body>
</html>