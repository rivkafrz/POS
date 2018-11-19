@if ($entry->approved != 'Approved')
    <form action="{{ route('eod.approve') }}" method="POST">
        @csrf
        <input type="hidden" name="eod_id" value="{{ $entry->id }}">
        <input type="submit" value="Approved EOD" name="submit" class="btn btn-success btn-xs">
    </form>
@endif