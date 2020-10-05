<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration', 3600);
}
?>

<?php 
    if(isset($favourites_tab) && $favourites_tab == true){
        $segment = 'favourites';
    }else{ 
        $segment = '';
    }
?>

@if (isset($paginator) and $paginator->getCollection()->count() > 0)

<input type="hidden" id="myurl" url="{{ url()->current() }}" />
<input type="hidden" id="pageNo" value="<?php echo isset($pageNo) ? $pageNo : 1 ?>"/>
<input type="hidden" id="is_last_page" value="<?php echo isset($is_last_page) ? $is_last_page : 0 ?>"/>
<input type="hidden" id="is_search" value="<?php echo isset($is_search) ? $is_search : 0 ?>"/>
<input type="hidden" id="is_filter" value="<?php echo isset($is_filter) ? $is_filter : 0 ?>"/>
<input type="hidden" id="is_category" value="<?php echo isset($is_category) ? $is_category : 0 ?>"/>

<div class="no-result-found-div bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30" style="display: none">
    <h5 class="prata">
       {{ t('No results found') }}
    </h5>
</div>

<div class="row tab_content mb-40 append-data">
	<?php
	foreach($paginator->getCollection() as $key => $user): ?>

			<?php 
				
				$logo = ($user->logo) ? $user->logo : '';

			    if($logo !== "" && Storage::exists($logo)){
			        $logo = \Storage::url($user->logo);
			    }else{
			        $logo = url(config('app.cloud_url').'/images/user.png');
			    }
			    $city = ($user->city) ? $user->city : '';
			    $country = ($user->country_name) ? $user->country_name : '';

			    $show_city_country = '';

			    if(!empty($city)){
                    $city_name = explode(',', $city);
                    $show_city_country = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $city;
                }

			    if(!empty($city) && !empty($country)){
			    	$show_city_country .= ', ';
			    }
			    $show_city_country .= $country;

				$city_name = '';

				if(isset($user->city)){
					$city_name = $user->city;
				}
			?>
			<?php $show_category = ''; ?>

			@if(count($modelCategories) > 0)
                @foreach ($modelCategories as $cat)
                    @if($cat->parent_id == $user->category_id)
                        <?php  $show_category = $cat->name; ?>
                    @endif
                @endforeach
            @endif

           	<div class="col-md-6 col-xl-3 all-post-div-count mb-20" id="modelDiv-{{ $user->user_id }}">
		    	<div class="img-holder d-flex align-items-center justify-content-center position-relative">
		    		<img src="{{ $logo }}" alt="{{ trans('metaTags.User') }}" />
		    		 <?php /* <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class="btn btn-white insight signed position-absolute to-right to-top-20 mini-all" title="{{ t('View profile') }}"></a> */ ?>
				</div>
		    	<div class="box-shadow bg-white pt-20 pr-20 pb-20 pl-30">
				        <div class="modelcard-top text-uppercase d-flex align-items-center mb-2">
				        	<span class="bullet rounded-circle bg-lavender d-block mr-2 mb-1"></span>
	                        <span class="d-block">{{$user->go_code}}</span>
						</div>
						<div class="modelcard-top text-uppercase d-flex align-items-center">
							@if(!empty($show_category))
	                       		<span class="bullet rounded-circle bg-lavender d-block mr-2"></span>
	                        	<span class="d-block">{{ rtrim($show_category, ", ") }}</span>
	                    	@endif
	                    </div>

			        	<?php $url = lurl(trans('routes.user').'/'.$user->username); ?>

			        <span class="title pt-20" title="{{ t('View profile') }}">
			        	<?php /* <a href="{{ $url }}">{{ $user->first_name }} </a> */ ?>
			        	{!! App\Helpers\CommonHelper::createLink('view_models', $user->first_name, $url, '', '', $user->first_name, '') !!}
			        </span>
			        <span> {{ $show_city_country }} </span>
			        <div class="divider"></div>
			        <?php /*
			        <p class="mb-70 overflow-wrap">{!! str_limit(strCleaner($user->description), config('constant.description_limit')) !!}</p> */ ?>
			        <div class="pl-2 row">
			        	<div class="col-6 text-left px-xs-0 px-md-0 px-md-0">
			        		<span class="posted font-weight-bold">
					        	<?php

								    date_default_timezone_set(config('timezone.id'));
								    $start  = date_create($user->last_login_at);
								    $end    = date_create();
								    
								    $diff   = date_diff( $start, $end );
							    	
							    	if ($diff->y) {
								        echo '<span class="lh-24">'. t('Last Active').': </span>'; 
								        echo '<span class="lh-24">'.  (($diff->y == 1) ? t(':value year ago', ['value' => $diff->y]): t(':value years ago', ['value' => $diff->y])). '</span>';
								    }
								    else if ($diff->m) {
								        echo '<span class="lh-24">'. t('Last Active').': </span>';
								        echo '<span class="lh-24">'.  (($diff->m == 1) ? t(':value month ago',['value' => $diff->m]): t(':value months ago',['value' => $diff->m])). '</span>';
								    }
								    else if ($diff->d) {
								        echo '<span class="lh-24">'. t('Last Active').': </span>';
								        echo '<span class="lh-24">'.  (($diff->d == 1) ? t(':value day ago',['value' => $diff->d]): t(':value days ago',['value' => $diff->d])) . '</span>';
								    }
								    else if ($diff->h) {
								        echo '<span class="lh-24">'. t('Last Active').': </span>';
								        echo '<span class="lh-24">'.  (($diff->h == 1) ? t(':value hour ago',['value' => $diff->h]): t(':value hours ago',['value' => $diff->h])) . '</span>';
								    }
								    else if ($diff->i) {
								        echo '<span class="lh-24">'. t('Last Active').': </span>';
								        echo '<span class="lh-24">'.  (($diff->i == 1) ? t(':value minute ago',['value' => $diff->i]): t(':value minutes ago',['value' => $diff->i])) . '</span>';
								    }
								    else if ($diff->s) {
								        echo '<span class="lh-24">'. t('Last Active').': </span>';
								        echo '<span class="lh-24">'.  (($diff->s == 1) ? t(':value second ago',['value' => $diff->s]): t(':value seconds ago',['value' => $diff->s])) . '</span>';
								    }  
								?>
					        </span>
			        	</div>
			        	<div class="col-6 text-right px-xs-0 pl-md-0">
				        	@if (auth()->check())
				                <?php if(in_array($user->user_id, $favorites_user_ids)){ ?>
				                   <a href="javascript:void(0);" id="{{ $user->user_id }}" data-is-fav="{{ $favourite }}" class="make-favorite-acount-user btn btn-white favorite active mini-all fav-post" data-segment-id="{{ $segment }}" title="{{ t('Remove from Favorite') }}"></a>
				                <?php } else { ?>
				                    <a href="javascript:void(0);" id="{{ $user->user_id }}" data-is-fav="{{ $favourite }}" class="make-favorite-acount-user btn btn-white favorite mini-all" title="{{ t('Add to Favorite') }}" data-segment-id="{{ $segment }}"></a>
				                <?php } ?>
				            @else
				                <a href="javascript:void(0);" id="{{ $user->user_id }}" data-is-fav="{{ $favourite }}" class="make-favorite-acount-user btn btn-white favorite  mini-all" title="{{ t('Add to Favorite') }}" data-segment-id="{{ $segment }}"></a>
				            @endif
			        		<a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class="btn btn-white insight signed mini-all" title="{{ t('View profile') }}"></a>
			        	</div>
				    </div>
				</div>
			</div>
	<?php endforeach; ?>
</div>
	@if( isset($paginator) and $paginator->total() > 12 )

		<div class="text-center more-post-div more-posts" id="more-posts" ></div>
		<?php /*
		<!-- <div class="text-center more-post-div"><a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">{{ t('load more') }}</a></div>  --> */ ?>
	@endif
<?php /*
<div class="text-cente mb-30 position-relative">
    @include('customPagination')
    <div class="text-center"><a href="#" class="btn btn-white refresh more-posts">More posts</a></div>
</div>
*/ ?>
@else
	<div class="bg-white text-center box-shadow position-relative mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
	    <h5 class="prata">
	       {{ t('No results found') }}
	    </h5>
	</div>
@endif

@section('modal_location')
	@parent
	@include('layouts.inc.modal.send-by-email')
@endsection

@section('after_scripts')
	@parent
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

		$.fn.isInViewport = function() {
			
			var elementTop = $(this).offset().top;
		    var elementBottom = elementTop + $(this).outerHeight();

		    var viewportTop = $(window).scrollTop();
		    var viewportBottom = viewportTop + $(window).height();

		    return elementBottom > viewportTop && elementTop < viewportBottom;
		}

		var isAjaxCall = false;

		$(window).on('resize scroll', function() {

			if($('#more-posts').length == 0){

				return false;
			}

			if ($('#more-posts').isInViewport() && !isAjaxCall) {

		    	isAjaxCall = true;
				
				// do something
				var is_search = $("#is_search").val();
				var is_filter = $("#is_filter").val();
				var postData = '';

				if(is_search == 1){
					postData = $("#model-search-form").serialize();
				}
				if(is_filter == 1){
					postData = $("#model-filter-form").serialize();
				}

				if($("#is_last_page").val() == 1){
					$('.more-post-div').hide();
					return false;
				}

				/* Get Post ID */
				$('.email-job').click(function(){
					var postId = $(this).attr("data-id");
					$('input[type=hidden][name=post]').val(postId);
				});

				@if (isset($errors) and $errors->any())
					@if (old('sendByEmailForm')=='1')
						$('#sendByEmail').modal();
					@endif
				@endif
				
				var is_fav_page = '<?php echo $segment; ?>';
				var numItems = $('.all-post-div-count').length;
                
                if(is_fav_page == 'favourites'){
					numItems = $('.fav-post').length;
                }

                var is_favorites = '<?php echo $favourite;  ?>';
				var is_category = $("#is_category").val();
				var url = $("#myurl").attr("url");
			 	var pageNo = $("#pageNo").val(); 
				var formData = 'page=' + pageNo +'&show_record=' + numItems;
				var type = 'get';

				if(postData != ''){
					formData = postData + "&page=" + pageNo +'&show_record=' + numItems;
					type = 'post';
				}

				if(is_category != 0){
					type = 'get';
					formData = 'page=' + pageNo + '&c=' + is_category +'&show_record=' + numItems;
				}
				
				var data = formData;
				
				$.ajax({
					
	                url: url,
	                type : type,
	                dataType :'json',
	                beforeSend: function(){
	                	$(".loading-process").show();
            		},
			        complete: function(){
			            $(".loading-process").hide();
			        },
	                data : data,
	                success : function(res){
						
						var append = $(res.html).filter(".append-data").html();

						$("#pageNo").val(res.pageNo);
						
						if(res.is_last_page == 1){
							$("#is_last_page").val(res.is_last_page);
							$('.more-post-div').hide();
						}

						$('.append-data').append(append);

						$('.make-favorite-acount-user').unbind("click");
						
						/* Save the Acount User */
					    $('.make-favorite-acount-user').bind("click", function(){
					        saveAcountUser(this);
					    });

					    if(res.is_last_page == 1){
					    	isAjaxCall = true;
					    }else{
					    	isAjaxCall = false;
					    }
					}
            	});
			}
		});
	</script>
@endsection
