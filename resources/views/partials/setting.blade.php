@if (Auth::user()->workTime === null)
  <div class="alert alert-danger">
    <p>Your settings is unset, please set bellow !</p>
  </div>
@else
  <div class="well">
    <dl>
      <dt>Location : </dt>
      <dd>{{ Auth::user()->workTime->assignLocation->assign_location }}</dd>
      <dt>Work Time : </dt>
      <dd>{{ Auth::user()->workTime->work_time }}</dd>
    </dl>
  </div>
@endif
<form class="form" action="{{ route('settings.get-work-time') }}" method="post">
  @csrf
  <div class="form-group">
    <label for="assign_location">Assign Location</label>
    @if (!app('request')->input('assign_location'))
      <select name="assign_location" class="form-control">
        @foreach (App\AssignLocation::all() as $location)
          <option value="{{ $location->id }}">{{ ucwords($location->assign_location) }}</option>
        @endforeach 
      </select>
      @else
      @php
        $current = App\Models\Assign_location::find(app('request')->input('assign_location'));
      @endphp
      <input type="hidden" value="{{ $current->id }}" name="assign_location">
      <input type="text" disabled="" value="{{ ucwords($current->assign_location) }}" class="form-control">
    @endif
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
    <div class="row">
      <div class="col-md-6">
        <input type="submit" value="{{ app('request')->input('assign_location') ? "Set" : "Fetch" }}" class="btn btn-success btn-block">
      </div>
      @if (app('request')->input('assign_location'))
        <div class="col-md-6">
          <a class="btn btn-default btn-block" href="{{ route('backpack.dashboard') }}">Clear</a>
        </div>
      @endif
    </div>
  </div>
</form>