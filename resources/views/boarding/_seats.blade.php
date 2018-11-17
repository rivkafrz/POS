<div class="col-md-4">
    <input type="hidden" name="seat_limit" id="seat_limit" value="40">
    <input type="hidden" name="seat_selected" id="seat_selected" value="0">
    <div id="seats">
    </div>
    <p class="lead">Select Seat</p>
    @if ($errors->has('selectedSeat'))
        <div class="alert alert-danger">
            <p>At least one seat selected</p>
        </div>
    @endif
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