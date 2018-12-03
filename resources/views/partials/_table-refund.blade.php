<table class="table-hover table-bordered table-stripped table" id="EOD">
    <thead>
        <tr class="active">
            <th class="text-center">No</th>
            <th class="text-center">Departure Time</th>
            <th class="text-center">No Transaction</th>
            <th class="text-center">Time</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Qty</th>
            <th class="text-center" colspan="2">Amount</th>
            <th class="text-center">Fee Refund</th>
        </tr>
        <tr>
            <td colspan="6" rowspan="2"></td>
            <td class="text-center">Price</td>
            <td class="text-center">Refund</td>
        </tr>
    </thead>
    <tbody>
        @php
            $tickets = App\Ticket::eod(Auth::user()->id)->get();
            $pijet = 1;
            $cash = 0;
            $refund = 0;
        @endphp
        @foreach ($tickets as $ticket)
            @if ($ticket->seats(1)->count() != 0)
                <tr>
                    <td class="text-center">{{ $pijet ++ }}</td>
                    <td class="text-center">{{ $ticket->departureTime->boarding_time }}</td>
                    <td class="text-center">{{ $ticket->code }}</td>
                    <td class="text-center">{{ substr($ticket->created_at, 11, 5) }}</td>
                    <td class="text-center">{{ $ticket->customer->name }}</td>
                    <td class="text-center">{{ $ticket->seats(1)->count() }}</td>
                    <td class="text-center">{{ number_format($ticket->destination->price) }}</td>
                    <td class="text-center">{{ $ticket->refund == 0 ? 0 : number_format($ticket->refund())}}</td>
                    <td class="text-center">{{ number_format($ticket->refundFee()) }}</td>
                </tr>
                @php
                    $refund += $ticket->refundFee();
                @endphp
            @endif
        @endforeach
        <tr class="success">
            <td colspan="8" class="text-center">TOTAL</td>
            <td class="text-center">{{ "Rp . " . number_format($refund) }}</td>
        </tr>
    </tbody>
</table>