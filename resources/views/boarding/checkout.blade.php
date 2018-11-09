@extends('backpack::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p class="lead">Boarding Information</p>
                            <form action="" class="form-horizontal">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 control-label">Date</label>
                                    <div class="col-sm-8">
                                        <input name="date" type="text" class="form-control" value="{{ substr(now(), 0 , 10) }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="departure_time" class="col-sm-4 control-label">Departure Time</label>
                                    <div class="col-sm-8">
                                        <input name="departure_time" type="text" class="form-control">
                                    </div>
                                </div>
                                <strong>Destination</strong>
                                <hr>
                                <div class="form-group row">
                                    <label for="destination_form" class="col-sm-4 control-label">From</label>
                                    <div class="col-sm-8">
                                        <input name="destination_form" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="to" class="col-sm-4 control-label">To </label>
                                    <div class="col-sm-8">
                                        <input name="to" type="text" class="form-control">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 control-label">Name </label>
                                    <div class="col-sm-8">
                                        <input name="name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-4 control-label">Phone </label>
                                    <div class="col-sm-8">
                                        <input name="phone" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="baggage" class="col-sm-4 control-label">Baggage </label>
                                    <div class="col-sm-8">
                                        <input name="baggage" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="person" class="col-sm-4 control-label">Person </label>
                                    <div class="col-sm-8">
                                        <input name="person" type="text" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
