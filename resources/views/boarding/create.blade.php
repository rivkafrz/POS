@extends('backpack::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <form action="{{ route('boarding.store') }}" class="form-horizontal" method="POST" id="ticket_form">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="date" class="col-md-2 control-label">Date</label>
                                    <div class="col-md-10">
                                        <input name="date" type="date" class="form-control" id="date_input">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date" class="col-md-3 control-label">Transaction</label>
                                    <div class="col-md-9">
                                        <input type="text" disabled="" class="form-control" id="transaction_code">
                                        <input type="hidden" name="code" id="code">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @include('boarding._location')
                            @include('boarding._seats')
                            @include('boarding._info-seat')
                            @include('boarding._modal')
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
            var current = '#' + seat_id;
            if ($(current).hasClass('seat-occupied')) {
                alert('Cannot select occupied seat');
            } else {
                if ($(current).hasClass('seat-selected')) {
                    $(current).removeClass('seat-selected');
                    $(current).removeClass('seat-last');
                    $('#' + seat_id.substr(4)).remove();
                    console.log($('#seats_commit').val());
                    console.log("Un-Selected " + seat_id);

                    var init = parseInt($('#price_init').val());
                    $('#charge').val(parseInt($('#charge').val()) - init);
                    $('#charge_modal').val(parseInt($('#charge_modal').val()) - init);
                    $('#price').val(parseInt($('#price').val()) - init);
                    
                } else {
                    $(current).addClass('seat-selected');
                    $(current).removeClass('seat-last');
                    console.log("Selected " + seat_id);
                    $('#seats').append('<input type="hidden" name="selectedSeat[]" value="' + seat_id.substr(12) + '" id="' + seat_id.substr(4) + '">');
                    console.log($('#seats_commit').val());
                    if ($('#price_comparator').val() == 0) {
                        console.log($('#price_comparator').val(parseInt($('#price_comparator').val()) + 1));
                    } else {
                        var init = parseInt($('#price_init').val());
                        $('#charge').val(parseInt($('#charge').val()) + init);
                        $('#charge_modal').val(parseInt($('#charge_modal').val()) + init);
                        $('#price').val(parseInt($('#price').val()) + init);
                    }   
                }
            }
        }

        function addBaggage(value = null) {
            if (value == null) {
                $('#baggages').prepend('<input name="baggages[]" type="text" class="form-control">')
            } else {
                $('#baggages').prepend('<input name="baggages[]" type="text" class="form-control" value="' + value + '">')
            }
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
            $('#code').val(destination+to+phone+tickets);
        }

        function ajaxCallCustomer() {
            var phone = $('#phone').val();
            $.ajax({
                url: "{{ url('/') }}" + '/api/tickets/' + phone,
                success: function (data) {
                    console.log(data);
                    if (data.tickets == 0) {
                        $('#tickets').val(1);
                    } else {
                        $('#tickets').val(data.tickets + 1);
                    }
                    rebuildCodeTransaction();
                }
            });
            $.ajax({
                url: "{{ url('/') }}" + '/api/customer/' + phone,
                success: function (data) {
                    if (data.name != null) {
                        $('#name').val(data.name)
                    } else {
                        $('#name').val('')
                    }
                }
            })
        }

        $('#destination_to').change(function(){ 
            var price = $(this).find(':selected').data('price');
            $('#charge').val(0);
            $('#charge_modal').val(0);
            $('#price').val(0);
            $('#ticket_price').val(priceFormat(price));
            $('#price_init').val(price);
            rebuildCodeTransaction();
        });

        function findTicket() {
            var current = $('#find');
            $.ajax({
                url: "{{ url('/') }}" + "/api/ticket/" + current.val(),
                success: function (data) {
                    if (data.id == null) {
                        alert('Ticket not exist');
                    } else {
                        prependPatch(data);
                        showClearButton();
                        appendTabOneInfo(data);
                        checkForSeat();
                        appendTabTwoInfo(data);
                        appendThreeOneInfo(data);
                    }
                }
            });
        }

        function prependPatch(data) {
            $('#ticket_form').prepend('<input type="hidden" name="_method" value="PATCH">');
            $('#ticket_form').attr('action', "{{ url('/') }}" + '/app/boarding/' + data.id);
        }

        function showClearButton(){
            $('#find-input').append('<a onclick="location.reload()" class="btn btn-success btn-block" style="margin-top: 5px">Clear</a>');
        }

        function appendTabOneInfo(data){
            $('#destination_to').val(data.to.id);
            $('#price').val(data.to.price);
            $('#departure_time').val(data.departure_time.id);
            $('#submit').html('Change');
            $('#submit').removeClass('btn-success');
            $('#submit').addClass('btn-warning');
        }

        function appendTabTwoInfo(data){
            selectedCurrentSeat(data.seats);
        }

        function selectedCurrentSeat(data){
            checkForSeat();
            for (let i = 0; i < data.length; i++) {
                $('#seat-number-' + data[i].seat_number).addClass('seat-last');
            }
        }

        function selectedSeat(data){
            for (let i = 0; i < data.length; i++) {
                $('#seat-number-' + data[i].seat_number).addClass('seat-selected');
            }
        }

        function occupySeat(data){
            for (let i = 0; i < data.length; i++) {
                if ($('#seat-number-' + data[i].seat_number).hasClass('seat-last')) {
                    $('#seat-number-' + data[i].seat_number).removeClass('seat-occupied');
                } else {
                    $('#seat-number-' + data[i].seat_number).addClass('seat-occupied');
                }
            }
        }

        function appendThreeOneInfo(data){
            $('#phone').val(data.customer.phone);
            $('#name').val(data.customer.name);
            $('#baggages').html(null);
            for (let i = 0; i < data.baggages.length; i++) {
                $('#baggages').append(addBaggage(data.baggages[i].amount));
            }
            // TODO : Add fee belum
            $('#noted').html(data.note);
            $('#date_input').val(data.created_at.substr(0, 10));
            $('#transaction_code').val(data.code);
        }

        function checkForSeat(){
            $.ajax({
                url: "{{ url('/') }}" 
                    + '/api/seats/' 
                    + $('#destination_to').val() + '/'
                    + $('#departure_time').val() + '/',
                success: function (data) {
                    console.log(data);
                    occupySeat(data);
                }
            })
        }

        function showPaymentForm(payment_type){
            console.log(payment_type);

            if (payment_type == 1) {
                $('#payment').html(null);
                $('#payment').html(`@include('boarding._cash')`);
            } else {
                $('#payment').html(null);
                $('#payment').html(`@include('boarding._no_cash')`);
            }
        }

        function selectBank(){
            console.log($('#bank_not_exist').is(':checked'))
            if ($('#bank_not_exist').is(':checked')) {
                $('#card_bank').remove();
                $('#select_bank').prepend(`@include('boarding._input_bank')`);
            } else {
                $('#card_bank').remove();
                $('#select_bank').prepend(`@include('boarding._select_bank')`);
            }
        }
        
    </script>
@endsection