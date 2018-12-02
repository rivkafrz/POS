<table class="table-hover table-bordered table-stripped table" id="EOD">
    <thead>
        <tr class="active">
            <th class="text-center">No</th>
            <th class="text-center">Departure Time</th>
            <th class="text-center">No Transaction</th>
            <th class="text-center">Time</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Qty</th>
            <th class="text-center">No Card</th>
            <th class="text-center">Bank</th>
            <th class="text-center" colspan="2">Amount</th>
        </tr>
        <tr>
            <td colspan="8" rowspan="2"></td>
            <td class="text-center">Non Cash</td>
            <td class="text-center">Cash</td>
        </tr>
    </thead>
    <tbody>
        @php
            $tickets = App\Ticket::eod(Auth::user()->id)->get();
            $pijet = 1;
            $cash = 0;
            $nonCash = 0;
        @endphp
        @foreach ($tickets as $ticket)
            <tr>
                <td class="text-center">{{ $pijet ++ }}</td>
                <td class="text-center">{{ $ticket->departureTime->boarding_time }}</td>
                <td class="text-center">{{ $ticket->code }}</td>
                <td class="text-center">{{ substr($ticket->created_at, 11, 5) }}</td>
                <td class="text-center">{{ $ticket->customer->name }}</td>
                <td class="text-center">{{ $ticket->seats->count() }}</td>
                <td class="text-center">{{ !is_null($ticket->nonCash) ? $ticket->nonCash->no_card : null }}</td>
                <td class="text-center">{{ !is_null($ticket->nonCash) ? $ticket->nonCash->bank->name : null }}</td>
                <td class="text-center">{{ isset($ticket->nonCash) ? $ticket->amount : null }}</td>
                <td class="text-center">{{ isset($ticket->cash) ? $ticket->amount : null }}</td>
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
        @endforeach
        <tr class="warning">
            <td colspan="8" class="text-center">SUB TOTAL</td>
            <td class="text-center">{{ number_format($nonCash) }}</td>
            <td class="text-center">{{ number_format($cash) }}</td>
        </tr>
        <tr class="success">
            <td colspan="8" class="text-center">TOTAL</td>
            <td colspan="2" class="text-center">{{ "Rp . " . number_format($cash + $nonCash) }}</td>
        </tr>
    </tbody>
</table>