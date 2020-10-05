<?php
if (!isset($cats)) {
    $cats = collect([]);
}

$cats = $cats->groupBy('parent_id');
$subCats = $cats;
if ($cats->has(0)) {
	$cats = $cats->get(0);
}
if ($subCats->has(0)) {
	$subCats = $subCats->forget(0);
}
?>
<?php
	if (
		(isset($subCats) and !empty($subCats) and isset($cat) and !empty($cat) and $subCats->has($cat->tid)) ||
		(isset($cats) and !empty($cats))
	):
?>
@if (isset($subCats) and !empty($subCats) and isset($cat) and !empty($cat))

@else
	@if (isset($cats) and !empty($cats))
		<div class="container">
			<div class="category-links">
				<ul>
				@foreach ($cats as $iCategory)
					<li>
						<a href="{{ lurl('partner-list?c='.$iCategory->id) }}">
							{{ $iCategory->name }}
						</a>
					</li>
				@endforeach
				</ul>
			</div>
		</div>
	@endif
@endif
<?php endif; ?>