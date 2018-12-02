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
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a href="#EODPane" data-toggle="tab" aria-expanded="true">Report</a></li>
                            <li><a href="#refund" data-toggle="tab" aria-expanded="true">Refund</a></li>
                        </ul>
                        <div id="tab-content" class="tab-content">
                            <div id="EODPane" class="tab-pane active">
                                @include('partials._table-eod')
                            </div>
                            <div id="refund" class="tab-pane fade">
                                @include('partials._table-refund')
                            </div>
                        </div>
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