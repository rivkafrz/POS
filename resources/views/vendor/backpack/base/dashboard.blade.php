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
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-body">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi vero nostrum ex optio. Voluptatem amet quaerat, quod explicabo repellendus at quisquam sed inventore. Velit adipisci, saepe sunt ipsum odit ab?</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Current Settings</div>
                </div>
                <div class="box-body">
                  @include('partials.setting')
                </div>
        </div>
    </div>
@endsection
