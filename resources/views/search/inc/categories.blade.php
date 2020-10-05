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
	@if ($subCats->has($cat->tid))
			<div class="text-center bb-light-lavender3 mb-40 pb-40" >
				@foreach ($subCats->get($cat->tid) as $iSubCat)
					<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug, 'subCatSlug' => $iSubCat->slug]; ?>
						<a href="{{ lurl(trans('routes.v-search-subCat', $attr), $attr) }}">
							<span class="tag mr-2 mb-2">
								{{ $iSubCat->name }}
							</span>
						</a>
				@endforeach
			</div>
	@endif
@else
	@if (isset($cats) and !empty($cats))
			<div class="text-center bb-light-lavender3 mb-40 pb-40" >
				@foreach ($cats as $iCategory)
					<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $iCategory->slug]; ?>
					<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
						<span class="tag mr-2 mb-2">
							{{ $iCategory->name }}
						</span>
					</a>
				@endforeach
			</div>
	@endif
@endif
<?php endif; ?>