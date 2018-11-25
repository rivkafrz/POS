@foreach ($entry->seats as $seat)
    @php
        $style = [
            'label-danger',
            'label-success'
        ]
    @endphp
    <span class="label {{ $style[$seat->checked] }}">{{ $seat->seat_number }}</span>
@endforeach
