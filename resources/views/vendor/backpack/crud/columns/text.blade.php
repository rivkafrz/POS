{{-- regular object attribute --}}
<td>{{ (array_key_exists('prefix', $column) ? $column['prefix'] : '').str_limit(strip_tags($entry->{$column['name']}), array_key_exists('limit', $column) ? $column['limit'] : 80, "[...]").(array_key_exists('suffix', $column) ? $column['suffix'] : '') }}</td>
