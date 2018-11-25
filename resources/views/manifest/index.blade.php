@extends('backpack::layout')

@section('content')
    <div class="row">
        <form method="post" id="form">
            @csrf
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date" class="col-md-2 control-label">Date</label>
                                    <div class="col-md-10">
                                        <input name="date" type="date" class="form-control" id="date">
                                        <input name="assign_location_id" type="hidden" value="{{ Auth::user()->workTime->assignLocation->id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departure_time_id" class="col-md-4 control-label">Departure Time</label>
                                    <div class="col-md-8">
                                        <select name="departure_time_id" id="departure_time" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach ($det as $departure_time)
                                                <option value="{{ $departure_time->id }}">{{ $departure_time->formatTime() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="destination" class="col-md-4 control-label">Destination</label>
                                    <div class="col-md-8">
                                        <select name="destination_id" id="destination" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach ($des as $destination)
                                                <option value="{{ $destination->id }}">{{ $destination->to }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="active">
                                                    <th>No</th>
                                                    <th>Seat Number</th>
                                                    <th>No Transaction</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                <tr id="tr-placeholder"><td colspan="5" id="td-placeholder">No Data</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box box-success">
                                    <div class="box-body">
                                        <p class="lead">Total Passangers : <strong id="total_passengers">{{ 0 }}</strong></p>
                                        <hr>
                                        <p>Manifest Information</p>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="no_body" class="col-md-3 control-label">No Body</label>
                                                <div class="col-md-9">
                                                    <input required name="no_body" type="text" class="form-control" id="no_body" maxlength="8">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="driver" class="col-md-3 control-label">Driver</label>
                                                <div class="col-md-9">
                                                    <input required name="driver" type="text" class="form-control" id="driver" maxlength="30">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12" id="submit">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('after_scripts')
    <script>
        console.log('Sript active');
        let date = $('#date');
        let departure_time = $('#departure_time');
        let destination = $('#destination');
        let tr = $('#tr-placeholder');
        let td = $('#td-placeholder');
        let tbody = $('#tbody');
        let total = $('#total_passengers');
        let submit = $('#submit');
        let form = $('#form');

        date.on('change', function () {
            console.log('Date touched !!');
            fetchingManifest();
        });
        departure_time.on('change', function () {
            console.log('Departure Time touched !!');
            fetchingManifest();
        });
        destination.on('change', function () {
            console.log('Destination touched !!');
            fetchingManifest();
        });

        function fetchingManifest() {
            if (date.val() != "" && departure_time.val() != "" && destination.val() != "") {
                console.log('Fetching...');
                trPlaceholder('Fetching ...');
                tbody.html("");
                $.ajax({
                    url: "{{ url('/') }}" + '/api/manifest/' + date.val() + "/" + '{{ Auth::user()->workTime->assignLocation->id }}'+ "/" + destination.val() + "/" + departure_time.val(),
                    success: function (data) {
                        console.log("Successfully fetching manifest");
                        total.html(data.length);
                        let iter = 1;
                        trHide(true);
                        data.forEach(seat => {
                            appendTbody(iter, seat);
                            iter ++;
                        });
                    }
                });
                showSubmit(true);
                directForm();
            }

        }

        function trPlaceholder(message) {
            td.html(message);
        }

        function appendTbody(iter, data) {
            $.ajax({
                url: "{{ url('/') }}" + '/api/ticket/' + data.ticket.code,
                success: function (ticket) {
                    tbody.append("<tr><td>"+iter+"</td><td>"+data.seat_number+"</td><td>"+data.ticket.code+"</td><td>"+ticket.customer.name+"</td><td><a class='btn btn-danger btn-xs'>Ok</a></tr>");
                }
            });
        }

        function trHide(boolean) {
            if (true) {
                tr.remove();
            } else {
                tr.remove();
                tbody.append('<tr id="tr-placeholder"><td colspan="5" id="td-placeholder">No Data</td></tr>');
            }
        }

        function showSubmit(boolean){
            if (boolean) {
                submit.html("");
                submit.html('<input type="submit" value="Save" class="btn btn-success btn-block">');
            } else {
                submit.html("");
            }
        }

        function directForm() {
            form.attr('action', '{{ route("manifest.store") }}');
        }
    </script>
@stop