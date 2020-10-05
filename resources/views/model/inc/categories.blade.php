<?php
if (!isset($cats)) {
	$cats = collect([]);
}
/*
// $cats = $cats->groupBy('parent_id');
// $subCats = $cats;
// if ($cats->has(0)) {
// 	$cats = $cats->get(0);
// }
// if ($subCats->has(0)) {
// 	$subCats = $subCats->forget(0);
// }
*/
?>
@if(isset($cats) && count($cats) > 0)

	<?php 
		$attr = ['countryCode' => config('country.icode'), 'slug' => t('favourites')];

		$categoryUrl = lurl(trans('routes.model-list'));
		if(isset($favourite)){
		    if($favourite == 1){
		       $categoryUrl = lurl(trans('routes.v-model-list', $attr), $attr);
		    }
		}
	?>

	<div class="bb-light-lavender3 mb-40 pb-40 model-category-container text-center" >
		
		<a href="{{ $categoryUrl }}"><span class="tag mr-2 mb-2">{{ t('Show All') }}</span></a>
		@foreach ($cats as $iCategory)
			<a href="{{ $categoryUrl.'?c='.$iCategory->parent_id }}"><span class="tag mr-2 mb-2">{{ $iCategory->name }}</span></a>
		@endforeach
	</div>
@endif

<?php /*

if (
	(isset($subCats) and !empty($subCats) and isset($cat) and !empty($cat) and $subCats->has($cat->tid)) ||
	(isset($cats) and !empty($cats))
):
?>
@if (isset($subCats) and !empty($subCats) and isset($cat) and !empty($cat))

@else
	@if (isset($cats) and !empty($cats))
		<div class="bb-light-lavender3 mb-40 pb-40 model-category-container" >
			@foreach ($cats as $iCategory)
				<a href="{{ trans('routes.model-list').'?c='.$iCategory->id }}"><span class="tag mr-2 mb-2">{{ $iCategory->name }}</span></a>
			@endforeach
		</div>
	@endif
@endif
<?php endif; */ ?>