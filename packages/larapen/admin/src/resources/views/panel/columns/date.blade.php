{{-- localized date using jenssegers/date --}}
<td data-order="{{ $entry->{$column['name']} }}">
	<?php
	$dateColumnValue = \Date::parse($entry->{$column['name']})->timezone(config('app.timezone'));
	if (\Illuminate\Support\Str::contains(config('larapen.admin.default_date_format'), '%')) {
		$dateColumnValue = $dateColumnValue->formatLocalized(config('larapen.admin.default_date_format'));
	} else {
		$dateColumnValue = $dateColumnValue->format(config('larapen.admin.default_date_format'));
	}
	?>
	{{ $dateColumnValue }}
</td>