@if ($entry->approved == 'Approved')
<form action="{{ route('eod.pdf') }}" method="POST">
    @csrf
    <input type="hidden" name="eod_id" value="{{ $entry->id }}">
    <input type="submit" value="pdf" class="btn btn-xs btn-info">
</form>
@endif