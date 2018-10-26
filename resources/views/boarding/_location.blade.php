<div class="col-md-2">
    <div class="form-group row">
        <label for="find" class="col-md-6">Find Transaction</label>
        <div class="col-sm-12">
            <input name="find" type="text" class="form-control">
        </div>
    </div>
    <hr>
    <p><strong>Destination</strong></p>
    <div class="form-group row">
        <label for="from" class="col-md-6">From</label>
        @if (Auth::user()->workTime == null)
            <div class="alert alert-danger">
                <p>Please set on Dashboard</p>
            </div>
        @else
            <div class="col-sm-12">
                <input type="text" class="form-control" value="{{ Auth::user()->workTime->assignLocation->assign_location }}" disabled="">
                <input type="hidden" name="from" value="{{ Auth::user()->workTime->assignLocation->assign_location }}">
            </div>
        @endif
    </div>
    <div class="form-group row">
        <label for="to" class="col-md-6">To</label>
        <div class="col-sm-12">
            @if ($destinations->count() !== 0)
                <select name="to" class="form-control" id="destination_to">
                  <option value="0">{{ "-- Destination --" }}</option>
                    @foreach ($destinations as $destination)
                      <option value="{{ $destination->id }}" data-price={{ $destination->price }}>{{ $destination->to }}</option>
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
            <input name="price" type="text" class="form-control" disabled="" id="price_val">
        </div>
    </div>
    <div class="form-group row">
        <label for="departure_time" class="col-md-6">Departure Time</label>
        <div class="col-sm-12">
            @if ($departures->count() !== 0)
                <select name="to" class="form-control" id="destination_to">
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
@section('after_scripts')
    <script class="text/javascript">
        console.log("Script enable");

        function priceFormat(price)
        {
            price += '';
            x = price.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        $('#destination_to').change(function(){ 
            var price = $(this).find(':selected').data('price');
            $('#price_val').val(priceFormat(price));
        });
    </script>
@endsection