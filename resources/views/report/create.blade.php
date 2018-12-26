@extends('backpack::layout')

@section('content')
    <div class="row">
        <form method="post" id="form">
            @csrf
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type" class="col-md-3 control-label">Type</label>
                                    <div class="col-md-9">
                                        <select name="type" id="type" class="form-control" onchange="typeOnChange()">
                                            <option value="">-- Select --</option>
                                            <option value="daily">Daily Report</option>
                                            <option value="manifest">Manifest Report</option>
                                            <option value="summary">Summary Report</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date" class="col-md-3 control-label">From</label>
                                    <div class="col-md-9">
                                        <input type="date" id="from" class="form-control" name="from" onchange="fromOnChange()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to" class="col-md-3 control-label">To</label>
                                    <div class="col-md-9">
                                        <input type="date" id="to" class="form-control" name="from" max="{{ now()->toDateString() }}" onchange="toOnChange()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="assign_location" class="col-md-4 control-label" id="assign_location_label">Assign Location</label>
                                    <div class="col-md-8">
                                        <select name="assign_location" id="assign_location" class="form-control" onchange="assignLocationOnChange()">
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12" id="chart">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Export</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr id="tplaceholder">
                                                <td colspan="3" class="text-center">No Data</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection
@push('js')
    @php
        use Carbon\Carbon;
    @endphp
    <script>
        console.log('Script Active');
        let type = $('#type');
        let from = $('#from');
        let to = $('#to');
        let tbody = $('#tbody');
        let tplaceholder = $('#tplaceholder');
        let assign_location = $('#assign_location');
        let assign_location_label = $('#assign_location_label');
        let chart = $('#chart');

        function typeOnChange() {
            console.log('Type touched');
            if (type.val() == 'manifest') {
                assign_location_label.html('Destination');
                assign_location.html('');
                assign_location.append(`
                    <option value="">-- Select --</option>
                    @foreach ($dt as $destination)
                        <option value="{{ $destination->id }}">{{ $destination->to }}</option>
                    @endforeach
                `);
            } else if(type.val() == 'daily') {
                assign_location_label.html('Assign Location');
                assign_location.html('');
                assign_location.append(`
                    <option value="">-- Select --</option>
                    <option value="0">All Counter</option>
                    @foreach ($al as $assign)
                        <option value="{{ $assign->id }}">{{ $assign->assign_location }}</option>
                    @endforeach
                `);
            } else if(type.val() == 'summary') {
                assign_location_label.html('Assign Location');
                assign_location.html('');
                assign_location.append(`
                    <option value="">-- Select --</option>
                    <option value="0">All Counter</option>
                `);
                swal({
                    title: 'Alert',
                    text: 'Summary Report will only take months from query',
                    type: 'info',
                    confirmButtonText: 'Oke'
                    });
            }

            runQuerry();
        }

        function fromOnChange() {
            console.log('From touched');
            runQuerry();
        }

        function toOnChange() {
            console.log('To touched');
            runQuerry();
        }

        function assignLocationOnChange() {
            console.log('AssignLocation touched');
            runQuerry();
        }

        function runQuerry() {
            if (paramsValid()) {
                $.ajax({
                    url: "{{ url('/') }}" + "/api/report/"
                        + type.val() + "/"
                        + from.val() + "/"
                        + to.val() + "/"
                        + assign_location.val() + "/",
                    success: function (data) {
                        console.log(data);
                        clearTable();
                        chart.html('');
                        data.forEach(el => {
                            appendTable(el);
                        });
                        if (type.val() == 'summary') {
                            chart.append('<iframe src="http://localhost:8000/app/chart/' + from.val() + '/' + to.val() + '" frameborder="0" class="col-md-12" height="450px"></iframe>');
                            chart.prepend('<p class="lead text-center"> INCOME</p>');
                        }
                    }

                });
            }
        }

        function paramsValid() {
            return (type.val() != "" && from.val() != "" && to.val() != "" && assign_location.val() != "");
        }

        function clearTable() {
            tplaceholder.remove();
            tbody.html("");
            return true;
        }

        function appendTable(el) {
            let btn = {
                "daily": 'btn-info',
                "manifest": 'btn-warning',
                "summary": 'btn-default',
                "refund": 'btn-danger',
            };
            tbody.append(`
            <tr>
                <td class="text-center">` + el + `</td>
               
                <td class="text-center"><a href="` + "{{ url('/') }}" + `/app/report/` + type.val() + `/` + assign_location.val() + "/" + el + `" class="btn btn-success"><span class="fa fa-file"></span></a></td>
            </tr>
            `);
        }
    </script>
@endpush
@section('after_styles')
    <link rel="stylesheet" href="{{ url('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>
@endsection