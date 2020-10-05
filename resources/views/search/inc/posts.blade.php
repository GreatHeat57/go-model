<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration', 3600);
}
?>

<?php 
    if(isset($favourites_tab) && $favourites_tab == 1){
        $favClass =  'active';
        $class = '';
        $segment = 'favourites';
    }else{
        $favClass =  '';
        $class = 'active'; 
        $segment = '';
    }
?>

<input type="hidden" id="pageNo" value="<?php echo isset($pageNo) ? $pageNo : 1 ?>"/>
<input type="hidden" id="is_last_page" value="<?php echo isset($is_last_page) ? $is_last_page : 0 ?>"/>

<div class="text-center no-result-found-div bg-white box-shadow position-relative mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30" style="display: none">
    <h5 class="prata">
        {{ t('No jobs found') }}
    </h5>
</div>

@if (isset($paginator) and !empty($paginator) and $paginator->getCollection()->count() > 0 )
    <div class="row mb-40 append-data">
        @foreach ($paginator->getCollection() as $key => $post)

        <?php
        	$city_name = '';
            if(isset($post->city) && !empty($post->city)){
                $city_name = explode(',', $post->city);
                $city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $post->city;
            }
                        
        	$city = $city_name;
        	$country = ($post->country_name) ? $post->country_name : '';
        	$show_city_country = '';
        	
        	if(!empty($city)){
        		$show_city_country = $city;
        	}
        	if(!empty($city) && !empty($country)){
        		$show_city_country .= ', ';
        	}

        	$show_city_country .= $country;

        	// $currency_symbol = isset($post->html_entity)? $post->html_entity : isset($post->font_arial)? $post->font_arial : config('currency.symbol');

        	if(isset($post->html_entity)){
                $currency_symbol = $post->html_entity;
            }else{
                if(isset($post->font_arial)){
                   $currency_symbol = $post->font_arial;
                }else{
                   $currency_symbol = config('currency.symbol');
                }
            }
		?>


        <div class="col-md-6 mb-20 all-post-div-count" id="modelDiv-{{ $post->id }}">

            <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30 position-relative">
            	 
            	 <a href="{{ lurl($post->uri) }}" title="{{ t('View detail') }}">
            	 	@if(isset($post->is_home_job) && $post->is_home_job == 1)
            	 		<span class="user-h to-left-30 to-top-0 home"></span>
            	 	@else
            	 		<span class="flag to-left-30 to-top-0 ongoing"></span>
            	 	@endif

            	 </a>

        		<div class="d-flex justify-content-center align-items-center mb-sm-30 border bg-lavender company-img-holder">
        			<a href="javascript:void(0);" style="cursor: default;">
	        			@if($post->company_logo !== "" && $post->company_logo !== null && Storage::exists($post->company_logo))

	        			 	<img src="{{ \Storage::url($post->company_logo) }}" alt="{{$post->company_name }}">
						@else
							<img srcset="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }},
                                {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@2x.png') }} 2x,
                                {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png@3x') }} 3x"
                                src="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.User') }}" class="from-img nopic"/>
						@endif
					</a>
               	</div>
				<br>

                <?php /* <a href="{{ lurl($post->uri) }}" title="{{ mb_ucfirst($post->title) }}">{{ mb_ucfirst($post->title) }}</a> */?>

                {!! App\Helpers\CommonHelper::createLink('view_jobs', mb_ucfirst($post->title), lurl($post->uri), '', '', mb_ucfirst($post->title),'', '<span class="title pr-1">','</span>') !!}

                @if( isset($post_type) && !empty($post_type) && isset($post_type[$post->post_type_id]) && !empty($post_type[$post->post_type_id]))
                	<span>{{ $post_type[$post->post_type_id] }}</span>
                @endif

                <div class="divider"></div>
                <p class="mb-30 overflow-wrap" style="text-align: justify;">{!! str_limit(strCleaner($post->description), config('constant.description_limit')) !!}</p>


                @if(isset($post->is_home_job) && $post->is_home_job == 1)
                    <span class="info home-job mb-10">{{ t('home_modeling_job') }}</span>
                @endif
                
                    <?php 
                        $salary_min = (isset($post->salary_min) && $post->salary_min > 0)? $post->salary_min : '';
                        $salary_max = (isset($post->salary_max) && $post->salary_max > 0)? $post->salary_max : '';
                    ?>

                    @if($salary_max !== '' || $salary_min !== '')
                        <span class="info currency mb-10"> 
                        	@if($salary_min != "")
                        	{{ \App\Helpers\Number::money($salary_min, $currency_symbol) }}
                        	
                        	@endif
                        	@if($salary_min != ""  && $salary_max != "")
                        	-
                        	@endif
                        	@if($salary_max != "")
                        	{{ \App\Helpers\Number::money($salary_max, $currency_symbol) }}
                        	@endif
                            @if($post->negotiable)
                                {{ t('Negotiable') }}
                            @endif 
                        </span>
                    @else
                        <!-- <span class="info mb-10">&nbsp;</span> -->
                    @endif

                    @if($salary_max == '' && $salary_min == '' && $post->negotiable)
                        <span class="info currency mb-10">{{ \App\Helpers\Number::money('') }} - {{ t('Negotiable') }}</span>
                    @endif
                <span class="info city mb-10">
                	{{ $show_city_country }}
	            </span>
                <span class="info appointment mb-10">{{ \App\Helpers\CommonHelper::getFormatedDate($post->end_application) }}</span>
                <span class="info posted">
                    <?php

                        date_default_timezone_set(config('timezone.id'));
                        $start  = date_create($post->created_at);
                        $end    = date_create();
                        
                        $diff   = date_diff( $start, $end );
                        
                        echo t('Posted On');
                        echo ' ';
                        if ($diff->y) {
                            echo  (($diff->y == 1) ? t(':value year ago', ['value' => $diff->y]): t(':value years ago', ['value' => $diff->y]));
                        }
                        else if ($diff->m) {
                            echo  (($diff->m == 1) ? t(':value month ago',['value' => $diff->m]): t(':value months ago',['value' => $diff->m]));
                        }
                        else if ($diff->d) {
                            echo  (($diff->d == 1) ? t(':value day ago',['value' => $diff->d]): t(':value days ago',['value' => $diff->d]));
                        }
                        else if ($diff->h) {
                            echo  (($diff->h == 1) ? t(':value hour ago',['value' => $diff->h]): t(':value hours ago',['value' => $diff->h]));
                        }
                        else if ($diff->i) {
                            echo  (($diff->i == 1) ? t(':value minute ago',['value' => $diff->i]): t(':value minutes ago',['value' => $diff->i]));
                        }
                        else if ($diff->s) {
                            echo  (($diff->s == 1) ? t(':value second ago',['value' => $diff->s]): t(':value seconds ago',['value' => $diff->s]));
                        }
                        // else {
                        //     echo t('never seen');
                        // }   
                    ?>
                </span>
                @if (auth()->check())
                    <?php if(in_array($post->id, $favourite_posts)){ ?>
                        <a href="javascript:void(0);" class="make-favorite fav-post active btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" id="saved-{{ $post->id}}" data-post-id="{{ $post->id }}" data-segment-id="{{ $segment }}" title="{{ t('Remove from Favorite') }}"></a>
                    <?php } else { ?>
                        <a href="javascript:void(0);" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" data-post-id="{{ $post->id }}" id="save-{{ $post->id }}" data-segment-id="{{ $segment }}" title="{{ t('Add to Favorite') }}"></a>
                    <?php } ?>
                @else
                    <a href="javascript:void(0);" id="save-{{ $post->id }}" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" data-post-id="{{ $post->id }}" data-segment-id="{{ $segment }}" title="{{ t('Add to Favorite') }}"></a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    @if( isset($paginator) and !empty($paginator) and $paginator->total() > 12 )
    	<div class="text-center more-post-div"><a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">{{ t('load more') }}</a></div>
    @endif
    
@else
    <div class="bg-white text-center box-shadow position-relative mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
        <h5 class="prata">
            {{ t('No records found') }}
        </h5>
    </div>
@endif





<?php /*
<div class="row tab_content mb-40">
<?php
if (!isset($cacheExpiration)) {
	$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
}
?>

@if (isset($paginator) and $paginator->getCollection()->count() > 0 and auth()->user()->user_type_id=='3')
	<?php
if (!isset($cats)) {
	$cats = collect([]);
}

$model_id = \Auth::user()->id;
$modeldata = \App\Models\UserProfile::where('user_id', $model_id)->first();

$gender = \Auth::user()->gender_id;
$parent_category = explode(',', $modeldata->parent_category);

foreach ($paginator->getCollection() as $key => $post):

	$count_match = DB::table('posts')->where(
		[
			['id', $post->id],
			['model_category_id', $modeldata->category_id],
			['ismodel', '1'],
			['gender_type_id', $gender],
			['height_from', '<=', $modeldata->height_id],
			['height_to', '>=', $modeldata->height_id],
			['weight_from', '<=', $modeldata->weight_id],
			['weight_to', '>=', $modeldata->weight_id],
			['dressSize_from', '<=', $modeldata->size_id],
			['dressSize_to', '>=', $modeldata->size_id],
		]
	)->orWhere(
		[
			['id', $post->id],
			['model_category_id', $modeldata->category_id],
			['ismodel', '1'],
			['gender_type_id', '2'],
			['height_from', '<=', $modeldata->height_id],
			['height_to', '>=', $modeldata->height_id],
			['weight_from', '<=', $modeldata->weight_id],
			['weight_to', '>=', $modeldata->weight_id],
			['dressSize_from', '<=', $modeldata->size_id],
			['dressSize_to', '>=', $modeldata->size_id],
		]);

	$count = $count_match->whereIN('category_id', $parent_category)->count();

	// if ($count > 0) {
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
					            <span class="d-block">job # {{$post->id}}</span>
					            <span class="bullet rounded-circle bg-lavender d-block mx-2"></span>
					            <span class="d-block">{{$liveCatName }}</span>
					        </div>
					        <a href="{{ lurl($post->uri) }}"><span class="title">{{ mb_ucfirst(str_limit($post->title, 70)) }}</span></a>
					        <!-- <span>Jobart, Jobart</span> -->
					        <div class="divider"></div>
					        <div class="mb-30 job-desc-cls">{!! str_limit(strCleaner($post->description), 180) !!}</div>
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
					<!--/.job-item-->
				<?php

	// }

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
<div class="text-cente pt-40 mb-30 position-relative">
    @include('customPagination')
</div>

@section('modal_location')
	@parent
	@include('layouts.inc.modal.send-by-email')
@endsection

@section('page-script')
	@parent
	<script>
 
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

		$(document).ready(function ()
		{
			 
			$('.email-job').click(function(){
				var postId = $(this).attr("data-id");
				$('input[type=hidden][name=post]').val(postId);
			});

			@if (isset($errors) and $errors->any())
				@if (old('sendByEmailForm')=='1')
					$('#sendByEmail').modal();
				@endif
			@endif

			
            $('.make-favorite').on('click',function(){

                var id = $(this).attr('id');
                var attr = $(this);
                var siteUrl =  window.location.origin;

                $.ajax({
                    method: "POST",
                    url: siteUrl + "/ajax/save/post",
                    data: {
                        postId: id,
                        _token: $("input[name=_token]").val()
                    }
                }).done(function(e) {
                    if(attr.hasClass( "active" )){
                        attr.removeClass('active');
                    }else{
                        attr.addClass('active');
                    }
                });
            });
        
		})
	</script>
@endsection

*/ ?>