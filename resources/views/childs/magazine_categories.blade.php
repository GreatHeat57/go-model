@if(count($blogCategory) > 0)
	<div class="categories">
		<ul>
			<?php 
				$selectedCategory = isset($category_slug) ? $category_slug : ''; 
				$allSelected = '';
				if(empty($selectedCategory)){
					$allSelected = 'active'; 
				}
			?>
			
			<li><a href="{{ lurl(trans('routes.magazine')) }}" class="{{ $allSelected }}">{{ t('All') }}</a></li>
			
			@foreach($blogCategory as $category)

				<?php $attr = ['countryCode' => config('country.icode'), 'slug' => $category->slug]; 
					$is_active = '';
					
					if($selectedCategory == $category->slug){
						$is_active = 'active';
					}
				?>

				<li><a href="{{ lurl(trans('routes.v-blog-category', $attr), $attr) }}" class="{{ $is_active }}">{{ $category->name }}</a></li>
			@endforeach
		</ul>
	</div>
@endif
