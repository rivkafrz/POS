<div class="col-md-4">
    <p class="lead">Select Seat</p>
    @php
        $sub = 1;
        $arrange;
    @endphp
    @for ($i = 1; $i <= 40; $i++)
        @php
            switch ($sub) {
                case 1:
                    $arrange = 3;
                    break;
                case 2:
                    $arrange = 1;
                    break;
                case 3:
                    $arrange = -1;
                    break;
                case 4:
                    $arrange = -3;
                    break;
                default:
                    $arrange = 0;
                    break;
            }
        @endphp
        <div class="{{ ($i % 4 == 0) ? 'row' : '' }}">
            @if ($i == 37)
                <div class="col-md-2 seat-divider"></div>
            @endif
            @php
                $id = $i + $arrange;
            @endphp
            <div 
                class="col-md-2 seat {{ $i < 37 ? '' : 'smoke-area' }}"
                onclick='selectSeat("{{ 'seat-number-' . $id }}")'
                id="{{ 'seat-number-' . $id }}"
                >
                {{ $id }}
            </div>
            @if ($i <= 36)
                @if ($i % 2 == 0)
                    <div class="col-md-2 seat-divider"></div>
                @endif
            @endif
            @php
                if ($sub % 4 == 0) {
                    $sub = 1;
                } else {
                    $sub += 1;
                }
            @endphp
        </div>
    @endfor 
</div>
@section('after_scripts')
    <script>
        function selectSeat(seat_id) {
            console.log("Selected " + seat_id);
            var current = '#' + seat_id;
            if ($(current).hasClass('seat-occupied')) {
                alert('Cannot select occupied seat');
            } else {
                if ($(current).hasClass('seat-selected')) {
                    $(current).removeClass('seat-selected');
                } else {
                    $(current).addClass('seat-selected');
                }
            }
        }
    </script>
@endsection