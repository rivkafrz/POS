@foreach ($entry->baggages as $baggage)
    <span class="label label-info">{{ $baggage->amount }}</span>
@endforeach
