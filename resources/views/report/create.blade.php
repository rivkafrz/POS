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
                                        <select name="type" id="type" class="form-control">
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
                                        <input type="date" id="from" class="form-control" name="from">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to" class="col-md-3 control-label">To</label>
                                    <div class="col-md-9">
                                        <input type="date" id="to" class="form-control" name="from" max="{{ now()->toDateString() }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="assign_location" class="col-md-3 control-label">Assign Location</label>
                                    <div class="col-md-9">
                                        <select name="assign_location" id="assign_location" class="form-control">
                                            <option value="">-- Select --</option>
                                            <option value="0">All Counter</option>
                                            @foreach ($al as $assign)
                                                <option value="{{ $assign->id }}">{{ $assign->assign_location }}</option>
                                            @endforeach
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
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th class="text-center">Date</th>
                                                <th class="text-center">View</th>
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

        type.on('change', function () {
            console.log('Type touched');
            runQuerry();
        });

        from.on('change', function () {
            console.log('From touched');
            runQuerry();
        });

        to.on('change', function () {
            console.log('To touched');
            runQuerry();
        });

        assign_location.on('change', function () {
            console.log('AssignLocation touched');
            runQuerry();
        }); 

        function runQuerry() {
            if (paramsValid()) {
                $.ajax({
                    url: "{{ url('/') }}" + "/api/report/"
                        + type.val() + "/"
                        + from.val() + "/"
                        + to.val() + "/"
                        + assign_location.val() + "/",
                    success: function (data) {
                        clearTable();
                        data.forEach(el => {
                            appendTable(el);
                        });
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
                <td class="text-center"><a href="` + "{{ url('/') }}" + `/app/report/` + type.val() + `/` + assign_location.val() + "/" + el + `" class="btn ` + btn[type.val()] + `"><span class="fa fa-eye"></span></a></td>
                <td class="text-center"><a href="` + "{{ url('/') }}" + `/app/report/` + type.val() + `/` + assign_location.val() + "/" + el + `" class="btn btn-success"><span class="fa fa-file"></span></a></td>
            </tr>
            `);
        }
    </script>
@endpush