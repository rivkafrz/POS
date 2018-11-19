@php
    $type = [
        'Unapproved' => 'danger',
        'Approved' => 'success'
    ]
@endphp
<span class="label label-{{ $type[$entry->approved] }}">{{ $entry->approved }}</span>