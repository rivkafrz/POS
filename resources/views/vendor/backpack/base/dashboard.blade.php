@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                </div>

                <div class="box-body">{{ trans('backpack::base.logged_in') }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        @php
          $user = App\Models\User::find(Auth::user()->id);
        @endphp
        @if ($user->workTime != null)
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Current Settings</div>
                </div>
                <div class="box-body">
                  <p>Assign Location : <strong>{{ $user->workTime->assignLocation->assign_location }}</strong></p>
                  <p>Work Time : <strong>{{ $user->workTime->work_time }}</strong></p>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Settings</div>
                </div>
                <div class="box-body">
                  <form class="form" action="{{ route('settings.get-work-time') }}" method="post">
                    @csrf
                    <div class="form-group">
                      <label for="assign_location">Assign Location</label>
                      <select name="assign_location" class="form-control">
                        @if (app('request')->input('assign_location'))
                          @php
                            $current = App\Models\Assign_location::find(app('request')->input('assign_location'));
                          @endphp
                          <option value="{{ $current->id }}">{{ "-- $current->assign_location --" }}</option>
                        @endif
                        @foreach (App\AssignLocation::all() as $location)
                          <option value="{{ $location->id }}">{{ $location->assign_location }}</option>
                        @endforeach 
                      </select>
                    </div>

                    @if (app('request')->input('assign_location'))
                    <div class="form-group">
                      <input type="hidden" value="true" name="settings">
                      <label for="assign_location">Work Time</label>
                      <select name="work_time" class="form-control">
                        @foreach (App\Models\Assign_location::find(app('request')->input('assign_location'))->workTimes as $time)
                          <option value="{{ $time->id }}">{{ $time->work_time }}</option>
                        @endforeach 
                      </select>
                    </div>
                    @endif

                    <div class="form-group">
                      <input type="submit" value="Shift" class="btn btn-success">
                    </div>
                  </form>            
                </div>
            </div>
        </div>
    </div>
@endsection
