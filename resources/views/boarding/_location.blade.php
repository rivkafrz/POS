<div class="col-md-2">
    <div class="form-group row">
        <label for="find" class="col-md-6">Find Transaction</label>
        <div class="col-sm-12" id="find-input">
            <input name="find" type="text" class="form-control" onchange="findTicket()" id="find">
        </div>
    </div>
    <hr>
    <p><strong>Destination</strong></p>
    <div class="form-group row">
        @if (Auth::user()->workTime == null)
            <div class="alert alert-danger col-sm-10 col-md-offset-1">
                <p>Please set on Dashboard</p>
            </div>
        @else
        <label for="from" class="col-md-6">From</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" value="{{ Auth::user()->workTime->assignLocation->assign_location }}" disabled="">
                <input type="hidden" name="assignLocation" value="{{ Auth::user()->workTime->assignLocation->code_location }}" id="current_location" data-code="{{ Auth::user()->workTime->assignLocation->code_location }}">
            </div>
        @endif
    </div>
    <div class="form-group row">
        <label for="to" class="col-md-6">To</label>
        <div class="col-sm-12">
            @if ($destinations->count() !== 0)
                <select name="destination" class="form-control" id="destination_to">
                  <option value="0">{{ "-- Destination --" }}</option>
                    @foreach ($destinations as $destination)
                      <option value="{{ $destination->id }}" data-code="{{ $destination->code }}" data-price={{ $destination->price }}>{{ $destination->to }}</option>
                    @endforeach
                </select>
                @else
                <div class="alert alert-danger">
                    Destination Empty
                </div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="price" class="col-md-6">Price</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" disabled="" id="price">
            <input name="price" type="hidden" class="form-control" id="price_val">
            <input type="hidden" class="form-control" id="price_init">
        </div>
    </div>
    <div class="form-group row">
        <label for="departure_time" class="col-md-6">Departure Time</label>
        <div class="col-sm-12">
            @if ($departures->count() !== 0)
                <select name="departureTime" class="form-control" id="departure_time" onchange="checkForSeat()">
                  <option value="0">{{ "-- Boarding --" }}</option>
                    @foreach ($departures as $departure)
                      <option value="{{ $departure->id }}" data-boarding-time={{ $departure->boarding_time }}>{{ substr($departure->boarding_time, -8, 5) }}</option>
                    @endforeach
                </select>
                @else
                <div class="alert alert-danger">
                    Destination Empty
                </div>
            @endif
        </div>
    </div>
</div>

@section('before_styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection