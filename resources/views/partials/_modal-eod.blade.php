<div id="modalEOD" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">End of Day</h4>
            </div>
            @if (!is_null(Auth::user()->eods()->where('created_at', 'like', now()->toDateString() . '%')->first()))
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="lead">EOD successfully created</p>
                        <small>You can only create single EOD per day</small>
                        <hr>
                    </div>
                    <div class="col-md-4">
                        <dl class="dl-horizontal">
                            <dt>Open Transaction :</dt>
                            @php
                                $time   = now()->toDateString();
                                $ticket = App\Ticket::where('created_at', 'like', $time . '%')->first();
                            @endphp
                            <dd>{{ !is_null($ticket) ? date('G:i:s A', strtotime($ticket->created_at)) : null }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <dl class="dl-horizontal">
                            <dt>Close Transaction :</dt>
                            @php
                                $time   = now()->toDateString();
                                $ticket = App\Ticket::where('created_at', 'like', $time . '%')->orderBy('created_at', 'desc')->first();
                            @endphp
                            <dd>{{ !is_null($ticket) ? date('G:i:s A', strtotime($ticket->created_at)) : null }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            @else
                @if (is_null(Auth::user()->tickets()->where('created_at', 'like', now()->toDateString() . '%')->first()))
                    <div class="modal-body">
                        <p class="lead text-center">No Transaction open</p>
                    </div>
                    @else
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Assign Location :</dt>
                                    <dd>{{ !is_null(Auth::user()->workTime) ? Auth::user()->workTime->assignLocation->assign_location : 'Unassigned' }}</dd>
                                    <dt>Work Time :</dt>
                                    <dd>{{ !is_null(Auth::user()->workTime) ? Auth::user()->workTime->work_time : 'Unassigned' }}</dd>
                                    <dt>Ticketing :</dt>
                                    <dd>{{ Auth::user()->employee->employee_name }}</dd>
                                </dl>
                            </div>

                            <div class="col-md-4 col-md-offset-3">
                                <dl class="dl-horizontal">
                                    <dt><i class="fa fa-calendar"></i> :</dt>
                                    <dd>{{ date('d/m/Y',  strtotime(now()->toDateString())) }}</dd>
                                    <dt>Open Transaction :</dt>
                                    @php
                                        $time   = now()->toDateString();
                                        $ticket = App\Ticket::where('created_at', 'like', $time . '%')->first();
                                    @endphp
                                    <dd>{{ !is_null($ticket) ? date('G:i:s A', strtotime($ticket->created_at)) : null }}</dd>
                                </dl>
                            </div>
                        </div>
                        <hr>
                        <table class="table-hover table-bordered table-stripped table">
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
                                        <td class="text-center">{{ substr($ticket->departureTime->boarding_time, 11, 5) }}</td>
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
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('eod.submit') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Submit EOD</button>
                            <a type="button" class="btn btn-info" data-dismiss="modal">Cancel</a>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>