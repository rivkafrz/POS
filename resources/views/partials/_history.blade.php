<div class="col-md-6">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <p class="lead">Today's recent login</p>
                </div>
            </div>
        </div>
        @php
            use App\Role;
            use App\Seat;
            use App\Ticket;

            $ticketing = Role::find(3)->users;
            $leader = Role::find(2)->users;
            $admin = Role::find(1)->users;
            $admin_login = 0;
            $ticketing_login = 0;
            $leader_login = 0;
            foreach ($ticketing as $user) {
                $ticketing_login += $user->authentications()->where('login_at', 'like', now()->toDateString().'%')->count();
            }
            foreach ($admin as $user) {
                $admin_login += $user->authentications()->where('login_at', 'like', now()->toDateString().'%')->count();
            }
            foreach ($leader as $user) {
                $leader_login += $user->authentications()->where('login_at', 'like', now()->toDateString().'%')->count();
            }
            $passengers = Seat::where('created_at', 'like', now()->toDateString().'%')->where('refund', 0)->count();
            $refund = Seat::where('created_at', 'like', now()->toDateString().'%')->where('refund', 1)->count();
            $income = Ticket::where('created_at', 'like', now()->toDateString().'%')->sum('amount');
        @endphp
        <div class="col-md-4">
            @include('partials._card', [
                'color'    => 'info',
                'icon'  => 'user',
                'title' => 'Admin',
                'count' => $admin_login
            ])
        </div>
        <div class="col-md-4">
            @include('partials._card', [
                'color'    => 'info',
                'icon'  => 'user',
                'title' => 'Ticketing',
                'count' => $ticketing_login
            ])
        </div>
        <div class="col-md-4">
            @include('partials._card', [
                'color'    => 'info',
                'icon'  => 'user',
                'title' => 'Leader',
                'count' => $leader_login
            ])
        </div>
        <div class="col-md-4">
            @include('partials._card', [
                'color'    => 'info',
                'icon'  => 'users',
                'title' => 'Passengers',
                'count' => $passengers
            ])
        </div>
        <div class="col-md-4">
            @include('partials._card', [
                'color'    => 'info',
                'icon'  => 'ticket',
                'title' => 'Income',
                'count' => number_format($income)
            ])
        </div>
        <div class="col-md-4">
            @include('partials._card', [
                'color'    => 'info',
                'icon'  => 'money',
                'title' => 'Refund',
                'count' => $refund
            ])
        </div>
    </div>
</div>