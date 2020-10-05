@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')

@section('content')
<?php
use Illuminate\Support\Facades\Request;

// Keywords
$keywords = rawurldecode(Request::input('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : Request::input('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = Request::input('r');
} else {
	$qLocationId = Request::input('l');
	$qLocation = (Request::filled('r')) ? t('area:') . rawurldecode(Request::input('r')) : Request::input('location');
	$qAdmin = Request::input('r');
}
?>
    <div class="container px-0 pt-40 pb-20">
        <!-- <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="prata">{{t('find work')}}</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white filters mr-20 mini-under-desktop active">{{t('Filters')}}</a>
                <a href="#" class="btn btn-white search mini-under-desktop">{{t('Search')}}</a>
            </div>
        </div> -->
        <?php $attr = ['countryCode' => config('country.icode')];?>
        <div class="row justify-content-md-between searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-auto">
                <!-- <form id="seachform" name="seachform" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET"> -->
	        	{!! csrf_field() !!}
                <input name="q" class="keyword" type="text" placeholder="{{t('search job')}}" value="{{ $keywords }}">
                <!-- </form> -->
            </div>
        </div>
	       <!--  <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
	        	{!! csrf_field() !!} -->
	        	<!-- <div class="row bg-white box-shadow py-30 px-38 mb-40 mx-0">

	                <div class="col-md-6 px-xs-0 pr-md-0 mb-md-30">
	                	<select name="c" id="catSearch" class="form-control selecter">
							<option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
							@if (isset($cats) and $cats->count() > 0)
								@foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
									<option {{ ($qCategory==$itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
								@endforeach
							@endif
						</select>
	                </div>

	                <div class="col-md-6 px-xs-0 pr-md-0 mb-md-30">
	                	<input type="text" id="locSearch" name="location" class="locinput input-rel searchtag-input has-icon tooltipHere"
						   placeholder="{{ t('Where?') }}" value="{{ $qLocation }}" title="" data-placement="bottom"
						   data-toggle="tooltip" type="button"
						   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
						<input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
						<input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">
	                </div> -->

	                <!-- <div class="col-md-2 px-xs-0 pr-md-0 mb-md-30"> -->
	                	<!-- <button class="btn btn-block btn-primary float-right">
							<i class="fa fa-search"></i> <strong>{{ t('Search') }}</strong>
						</button> -->
	                <!-- </div> -->
	            <!-- </div> -->
			<!-- </form> -->
			<?php $options = [
	0 => t('Select'),
	1 => t('work search'),
	2 => t('my favorites'),
]
?>
<!-- {{ Form::select('tabs',$options,'',['class'=>'tabs d-md-none d-lg-none d-xl-none d-xs-block']) }} -->
	        <div class="custom-tabs mb-20 mb-xl-30">
	            <ul class="d-none d-md-block">
	                <li><a href="#" class="active" data-id="1">{{t('work search')}}</a></li>
	                <li><a href="{{ URL('account/favourite') }}" data-id="2">{{t('my favorites')}}</a></li>
	            </ul>
	        </div>

        <div class="row job-list">
        	<div class="row tab_content mb-40">
				<?php
				if (!isset($cacheExpiration)) {
					$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
				}
				?>

				@if (isset($paginator) and $paginator->getCollection()->count() > 0 and auth()->user()->user_type_id=='3')
					<?php

				// for model
				if (!isset($cats)) {
					$cats = collect([]);
				}

				$model_id = \Auth::user()->id;
				$modeldata = \App\Models\UserProfile::where('user_id', $model_id)->first();
				$gender = \Auth::user()->gender_id;
				// this is a job category
				$jobcategory = explode(',', $modeldata->parent_category);
				// This is a model profile category
				$modelcategory=$modeldata->category_id;

				foreach ($paginator->getCollection() as $key => $post):

					$count_match = DB::table('posts')->Where(
						[
							['id', $post->id],
							//['model_category_id', $modeldata->category_id],
							['ismodel','1'],
							['gender_type_id', $gender],
							['height_from', '<=', $modeldata->height_id],
							['height_to', '>=', $modeldata->height_id],
							['weight_from', '<=', $modeldata->weight_id],
							['weight_to', '>=', $modeldata->weight_id],
							['dressSize_from', '<=', $modeldata->size_id],
							['dressSize_to', '>=', $modeldata->size_id],
						]);
					$count = $count_match->whereIN('category_id', $jobcategory)->count();
				?>
					@if($count)
					<?php
								// 	if (!$countries->has($post->country_code)) {
								// 		continue;
								// 	}

								// Convert the created_at date to Carbon object
								$post->created_at = \Date::parse($post->created_at)->timezone(config('timezone.id'));
								$post->created_at = $post->created_at->ago();

								// Category
								$cacheId = 'category.' . $post->category_id . '.' . config('app.locale');
								$liveCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
									$liveCat = \App\Models\Category::find($post->category_id);
									return $liveCat;
								});

								// Check parent
								if (empty($liveCat->parent_id)) {
									$liveCatParentId = $liveCat->id;
								} else {
									$liveCatParentId = $liveCat->parent_id;
								}

								// Check translation
								if ($cats->has($liveCatParentId)) {
									$liveCatName = $cats->get($liveCatParentId)->name;
								} else {
									$liveCatName = $liveCat->name;
								}

								// Get the Post's Type
								$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
								$postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
									$postType = \App\Models\PostType::transById($post->post_type_id);
									return $postType;
								});
								if (empty($postType)) {
									continue;
								}

								// Get the Post's Salary Type
								$cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
								$salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
									$salaryType = \App\Models\SalaryType::transById($post->salary_type_id);
									return $salaryType;
								});
								if (empty($salaryType)) {
									continue;
								}

								if(isset($post->country_code)){
									$country = \App\Models\Country::find($post->country_code);
								}

								if (empty($country)) {
									continue;
								} else {
									// Get Post's City
									if ($country) {
										$country_name = $country->name;
									} else {
										$country_name = '-';
									}
								}

								// Get the Post's City
								$cacheId = config('country.code') . '.city.' . $post->city_id;
								$city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
									$city = \App\Models\City::find($post->city_id);
									return $city;
								});
								if (empty($city)) {
									continue;
								}
								?>
								<div class="col-md-6 mb-20">
								    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30 position-relative">
								        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
								            <span class="d-block">job # {{$post->id}} {{$post->category_id}}</span>
								            <span class="bullet rounded-circle bg-lavender d-block mx-2"></span>
								            <span class="d-block">{{$liveCatName }}</span>
								        </div>
								        <a href="{{ lurl($post->uri) }}"><span class="title">{{ mb_ucfirst(str_limit($post->title, config('constant.title_limit'))) }}</span></a>
								        <!-- <span>Jobart, Jobart</span> -->
								        <div class="divider"></div>
								        <div class="mb-30 job-desc-cls">{!! str_limit(strCleaner($post->description), config('constant.description_limit')) !!}</div>
								        <span class="info city mb-10">{{ $city->name }}, {{ $country_name }}</span>
								        <span class="info appointment mb-10">{{ $post->created_at }}</span>
										
											
								        <span class="mb-30">
			                                    <?php 
			                                        $salary_min = (isset($post->salary_min))? $post->salary_min : '';
			                                        $salary_max = (isset($post->salary_max))? $post->salary_max : '';
			                                    ?>

			                                    @if($salary_max !== '' || $salary_min !== '')
			                                        {{ \App\Helpers\Number::money($salary_min) }} - {{ \App\Helpers\Number::money($salary_max) }}

			                                        @if (!empty($salaryType))
														{{ $salaryType->name }}
													@endif
												

			                                    @endif
			                                </span>
								        <span class="info posted">{{$post->created_at}}</span>

										@if (auth()->check())
					                        @if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0)
					                           <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite active btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job"></a>
					                        @else
					                            <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job"></a>
					                        @endif
					                    @else
					                        <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job"></a>
					                    @endif
								    </div>
								</div>
						@endif						<!--/.job-item-->
									<?php
				endforeach;?>
				@elseif(isset($paginator) and $paginator->getCollection()->count() > 0 and auth()->user()->user_type_id=='2')	
					<?php

					// this is for partner
					if (!isset($cats)) {
						$cats = collect([]);
					}

					$model_id = \Auth::user()->id;
					$modeldata = \App\Models\UserProfile::where('user_id', $model_id)->first();
					$gender = \Auth::user()->gender_id;
					// this is a job category
					$jobcategory = explode(',', $modeldata->parent_category);
					// This is a model profile category
					$modelcategory=$modeldata->category_id;

					foreach ($paginator->getCollection() as $key => $post):
						$count = DB::table('posts')->Where(
						[
							['id', $post->id],
							//['model_category_id', $modeldata->category_id],
							['ismodel','0'],
						])->count();
					?>
						@if($count)
						<?php
									// 	if (!$countries->has($post->country_code)) {
									// 		continue;
									// 	}

									// Convert the created_at date to Carbon object
									$post->created_at = \Date::parse($post->created_at)->timezone(config('timezone.id'));
									$post->created_at = $post->created_at->ago();

									// Category
									$cacheId = 'category.' . $post->category_id . '.' . config('app.locale');
									$liveCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
										$liveCat = \App\Models\Category::find($post->category_id);
										return $liveCat;
									});

									// Check parent
									if (empty($liveCat->parent_id)) {
										$liveCatParentId = $liveCat->id;
									} else {
										$liveCatParentId = $liveCat->parent_id;
									}

									// Check translation
									if ($cats->has($liveCatParentId)) {
										$liveCatName = $cats->get($liveCatParentId)->name;
									} else {
										$liveCatName = $liveCat->name;
									}

									// Get the Post's Type
									$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
									$postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
										$postType = \App\Models\PostType::transById($post->post_type_id);
										return $postType;
									});
									if (empty($postType)) {
										continue;
									}

									// Get the Post's Salary Type
									$cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
									$salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
										$salaryType = \App\Models\SalaryType::transById($post->salary_type_id);
										return $salaryType;
									});
									if (empty($salaryType)) {
										continue;
									}

									if(isset($post->country_code)){
										$country = \App\Models\Country::find($post->country_code);
									}

									if (empty($country)) {
										continue;
									} else {
										// Get Post's City
										if ($country) {
											$country_name = $country->name;
										} else {
											$country_name = '-';
										}
									}


									// Get the Post's City
									$cacheId = config('country.code') . '.city.' . $post->city_id;
									$city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
										$city = \App\Models\City::find($post->city_id);
										return $city;
									});
									if (empty($city)) {
										continue;
									}
									?>
													<div class="col-md-6 mb-20">
													    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30 position-relative">
													        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
													            <span class="d-block">job # {{$post->id}} {{$post->category_id}}</span>
													            <span class="bullet rounded-circle bg-lavender d-block mx-2"></span>
													            <span class="d-block">{{$liveCatName }}</span>
													        </div>
													        <a href="{{ lurl($post->uri) }}"><span class="title">{{ mb_ucfirst(str_limit($post->title, config('constant.title_limit'))) }}</span></a>
													        <!-- <span>Jobart, Jobart</span> -->
													        <div class="divider"></div>
													        <div class="mb-30 job-desc-cls">{!! str_limit(strCleaner($post->description), config('constant.description_limit')) !!}</div>
													        <span class="info city mb-10">{{ $city->name }}, {{ $country_name }}</span>
													        <span class="info appointment mb-10">{{ $post->created_at }}</span>
															
																
													        <span class="mb-30">
								                                    <?php 
								                                        $salary_min = (isset($post->salary_min))? $post->salary_min : '';
								                                        $salary_max = (isset($post->salary_max))? $post->salary_max : '';
								                                    ?>

								                                    @if($salary_max !== '' || $salary_min !== '')
								                                        {{ \App\Helpers\Number::money($salary_min) }} - {{ \App\Helpers\Number::money($salary_max) }}

								                                        @if (!empty($salaryType))
																			{{ $salaryType->name }}
																		@endif
																	

								                                    @endif
								                                </span>
													        <span class="info posted">{{$post->created_at}}</span>

															@if (auth()->check())
										                        @if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0)
										                           <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite active btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job"></a>
										                        @else
										                            <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job"></a>
										                        @endif
										                    @else
										                        <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job"></a>
										                    @endif
													    </div>
													</div>
								@endif						<!--/.job-item-->
									<?php
								endforeach;?>
				@else
					<div class="text-center mb-30 position-relative">
						@if (\Illuminate\Support\Str::contains(\Route::currentRouteAction(), 'Search\CompanyController'))
							<p>{{ t('No jobs were found for this company') }}</p>
						@else
							<p>{{ t('No result, Refine your search using other criteria') }}</p>
						@endif
					</div>
				@endif
			</div>
 </div>
    </div>

    @if(auth()->user()->user_type_id=='3')
	    @if (!empty($paginator) && $count > 0)
		<div class="pagination-bar text-center">
			 <!-- @include('loadPagination', ['paginator' => $paginator]) -->
			 @include('customPagination', ['paginator' => $paginator])
		</div>
		@endif
	@endif

@include('childs.bottom-bar')

@endsection
@section('page-script')
{{ Html::script(config('app.cloud_url').'/assets/plugins/autocomplete/jquery.mockjax.js') }}
{{ Html::script(config('app.cloud_url').'/assets/plugins/autocomplete/jquery.autocomplete.min.js') }}
{{ Html::script(config('app.cloud_url').'/assets/js/app/autocomplete.cities.js') }}
<script>
        /* Favorites Translation */
		var lang = {
			labelSavePostSave: "{!! t('Save Job') !!}",
			labelSavePostRemove: "{{ t('Saved Job') }}",
			loginToSavePost: "{!! t('Please log in to save the Ads') !!}",
			loginToSaveSearch: "{!! t('Please log in to save your search') !!}",
			confirmationSavePost: "{!! t('Post saved in favorites successfully !') !!}",
			confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully !') !!}",
			confirmationSaveSearch: "{!! t('Search saved successfully !') !!}",
			confirmationRemoveSaveSearch: "{!! t('Search deleted successfully !') !!}"
		};

		$(document).ready(function(){
			$("select[name='tabs']").on('change', function() {
                if($(this).val() == 1){
                  window.location='{{ lurl(trans('routes.v-search', $attr), $attr) }}';
                }
                if($(this).val() == 2){
                  window.location='{{ URL('account/favourite') }}';
                }
            });

			$('.keyword').on('keyup',function(){
	        	$.ajax({
					url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
					data:'q='+ $(this).val()+'&c='+ $('#catSearch').val()+'&location='+ $('#locSearch').val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
					type: 'get',
					success: function (data) {
						var $result = $(data).find('.job-list').html();
						$('.job-list').html($result);
						var $paginationlinks = $(data).find('.pagination-bar').html();
						$('.pagination-bar').html($paginationlinks);
					}
				});

	        });

	        $('#catSearch').on('change',function(){
	        	$.ajax({
					url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
					data:'q='+ $('.keyword').val()+'&c='+ $(this).val()+'&location='+ $('#locSearch').val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
					type: 'get',
					success: function (data) {
						var $result = $(data).find('.job-list').html();
						$('.job-list').html($result);
						var $paginationlinks = $(data).find('.pagination-bar').html();
						$('.pagination-bar').html($paginationlinks);
					}
				});
	        });

	        $('#locSearch').on('change',function(){
	        	$.ajax({
					url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
					data:'q='+ $('.keyword').val()+'&c='+ $('#catSearch').val()+'&location='+ $(this).val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
					type: 'get',
					success: function (data) {
						var $result = $(data).find('.job-list').html();
						$('.job-list').html($result);
						var $paginationlinks = $(data).find('.pagination-bar').html();
						$('.pagination-bar').html($paginationlinks);
					}
				});
	        });

	        $(document).on('click','.pagination li a',function(e){
                $.ajax({
                    url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
                    data:'q='+ $('.keyword').val()+'&c='+ $('#catSearch').val()+'&location='+ $(this).val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val()+'&page='+$(this).attr('data-page'),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.job-list').html();
                        $('.job-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });
            });

		});


</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
@endsection