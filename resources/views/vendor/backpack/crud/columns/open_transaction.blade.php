@php
    use App\Ticket;
    use Carbon\Carbon;
    
    $time = Carbon::parse($entry->created_at)->toDateString();
    $ticket = Ticket::where('created_at', 'like', $time.'%')->first();
@endphp
{{ substr($ticket->created_at, 11, 5) . " WIB" }}