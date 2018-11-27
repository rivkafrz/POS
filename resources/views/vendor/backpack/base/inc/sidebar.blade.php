@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        @include('backpack::inc.sidebar_user_panel')

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          @if (Auth::user()->hasRole('admin'))
            <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
            <li><a href="{{ backpack_url ('user') }}"><i class="fa fa-users"></i> <span>{{ trans('Manage Account') }}</span></a></li>


            <li class="treeview">
            <a href="#"><i class="fa-fa-archieve"></i>Master Data<i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ backpack_url('employee') }}"><i class="fa fa-address-book"></i> <span>{{ trans('Employee') }}</span></a></li>
                <li><a href="{{ backpack_url('departure_time') }}"><i class="fa fa-bus"></i> <span>{{ trans('Departure Time') }}</span></a></li>
                <li><a href="{{ backpack_url('destination') }}"><i class="fa fa-clipboard"></i> <span>{{ trans('Destination') }}</span></a></li>
                <li><a href="{{ backpack_url('work_time') }}"><i class="fa fa-clock-o"></i> <span>{{ trans('Work Time') }}</span></a></li>
                <li><a href="{{ backpack_url('assign_location') }}"><i class="fa fa-location-arrow"></i> <span>{{ trans('Assign Location') }}</span></a></li>
              </ul>
            </li>
             
          @endif
          @if (Auth::user()->hasRole('ticketing'))
          <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
          @if (!is_null(Auth::user()->eods()->where('created_at', 'like', now()->toDateString() . '%')->first()))
            <li><a type="button" data-toggle="modal" data-target="#modalEOD"><i class="fa fa-ticket"></i> <span>{{ trans('Order') }}</span></a></li>
            @else
            <li><a href="{{ route('boarding.create') }}"><i class="fa fa-ticket"></i> <span>{{ trans('Order') }}</span></a></li>
          @endif
            <li><a type="button" data-toggle="modal" data-target="#modalEOD"><i class="fa fa-archive"></i> <span>{{ trans('EOD') }}</span></a></li>
            <li><a href="{{ backpack_url('ticket') }}"><i class="fa fa-search"></i> <span>{{ trans('Search') }}</span></a></li>
          @endif

          @if (Auth::user()->hasRole('leader'))
          <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
            <li><a href="{{ route('manifest.index') }}"><i class="fa fa-book"></i> <span>{{ trans('Manifest') }}</span></a></li>
            <li><a href="{{ backpack_url('history-manifest') }}"><i class="fa fa-history"></i> <span>{{ trans('History Manifest') }}</span></a></li>
            <li><a href="{{ backpack_url('ticket') }}"><i class="fa fa-search"></i> <span>{{ trans('Search') }}</span></a></li>
          @endif
          @if (Auth::user()->hasRole('admin') or Auth::user()->hasRole('ticketing'))
            <li><a href="{{ backpack_url('eod') }}"><i class="fa fa-bell"></i> <span>{{ Auth::user()->hasRole('admin') ? 'Approve EOD'  : 'History My EOD'}}</span></a></li>
          @endif
          @if (Auth::user()->hasRole('admin'))
            <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-clipboard"></i> <span>{{ trans('Report ') }}</span></a></li>
            
          @endif  

          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
@if (Auth::check())
  @if (Auth::user()->hasRole('ticketing'))
    @include('partials._modal-eod')
  @endif
@endif
@push('js')
    @if (Auth::check())
    @if (Auth::user()->hasRole('ticketing'))
      <script>
          if ({{ Auth::user()->eods()->where('created_at', 'like', now()->toDateString() . '%')->get()->count() }} == 0) {
              $('#logout')
              .attr('href', "")
              .on('click', function () {
                swal({
                  type: 'error',
                  tittle: 'eror',
                  name: 'You have unsubmitted EOD today'
                })
              
              });
          } else {
            $('#logout')
              .attr('href', "{{ route('logout') }}");
          }
      </script>
    @endif
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>
@endpush