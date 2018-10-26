@extends('backpack::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <form action="" class="form-horizontal">
                            <div class="form-group row">
                                <label for="date" class="col-md-1 control-label">Date</label>
                                <div class="col-sm-3">
                                    <input name="date" type="date" class="form-control">
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
