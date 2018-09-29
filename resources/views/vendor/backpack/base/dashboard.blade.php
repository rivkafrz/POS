@extends('backpack::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
              <div class="box-body">
                <p class="lead">Welcome {{ Auth::user()->employee->employee_name }}</p>
                <p>You are logged in with <strong>{{ Auth::user()->email }}</strong></p>
              </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Current Settings</div>
                </div>
                <div class="box-body">
                  @include('partials.setting')
                </div>
            </div>
        </div>
    </div>
@endsection
