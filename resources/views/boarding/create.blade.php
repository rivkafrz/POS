@extends('backpack::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <form action="{{ route('boarding.store') }}" class="form-horizontal" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="date" class="col-md-2 control-label">Date</label>
                                    <div class="col-md-10">
                                        <input name="date" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date" class="col-md-3 control-label">Transaction</label>
                                    <div class="col-md-9">
                                        <input name="code" type="text" disabled="" class="form-control" id="transaction_code">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @include('boarding._location')
                            @include('boarding._seats')
                            @include('boarding._info-seat')
                            @include('boarding._customer')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_styles')
    <link rel="stylesheet" href="{{ url('css/custom.css') }}">
@endsection
@section('after_scripts')
    <script>
        console.log("Script enable");

        function selectSeat(seat_id) {
            console.log("Selected " + seat_id);
            var current = '#' + seat_id;
            if ($(current).hasClass('seat-occupied')) {
                alert('Cannot select occupied seat');
            } else {
                if ($(current).hasClass('seat-selected')) {
                    $(current).removeClass('seat-selected');
                } else {
                    $(current).addClass('seat-selected');
                }
            }
            $('#seats').append('<input type="hidden" name="selectedSeat[]" value="' + seat_id.substr(12) + '">');
            console.log($('#seats_commit').val());
        }

        function addBaggage() {
            $('#baggages').prepend('<input name="baggages[]" type="text" class="form-control">')
            console.log('Add Baggage');
        }

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

        function rebuildCodeTransaction() {
            var destination = $('#current_location').data('code');
            var to = $('#destination_to').find(':selected').data('code');
            var tickets = $('#tickets').val();
            var phone = $('#phone').val();
            $('#transaction_code').val(destination+to+phone+tickets);
        }

        function ajaxCallCustomer() {
            var phone = $('#phone').val();
            $.ajax({
                url: 'http://localhost:3000/api/tickets/' + phone,
                success: function (data) {
                    if (data.tickets < 1) {
                        $('#tickets').val(1);
                    } else {
                        $('#tickets').val(data.tickets);
                    }
                    rebuildCodeTransaction();
                }
            })
        }

        $('#destination_to').change(function(){ 
            var price = $(this).find(':selected').data('price');
            $('#price_val').val(priceFormat(price));
            $('#price').val(priceFormat(price));
            rebuildCodeTransaction();
        });
    </script>
@endsection