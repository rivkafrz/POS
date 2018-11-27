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
                                        <input type="date" id="to" class="form-control" name="from">
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
                                            <tr class="tplaceholder">
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
    <script>
        console.log('Script Active');
        let type = $('#type');
        let from = $('#from');
        let to = $('#to');
        let tbody = $('#tbody');
        let tplaceholder = $('#tplaceholder');
        let assign_location = $('#assign_location');
    </script>
@endpush