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
             <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-clipboard"></i> <span>{{ trans('Order') }}</span></a></li>
             <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-archive"></i> <span>{{ trans('EOD') }}</span></a></li>
             <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-book"></i> <span>{{ trans('Manifest') }}</span></a></li>
            <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-bell"></i> <span>{{ trans('Approve EOD') }}</span></a></li>
             <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-clipboard"></i> <span>{{ trans('Report ') }}</span></a></li>
             <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-bar-chart"></i> <span>{{ trans('View Board ') }}</span></a></li>

          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
