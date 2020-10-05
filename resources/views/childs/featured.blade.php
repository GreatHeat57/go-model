<?php
	if (!isset($cacheExpiration)) {
		$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
	}
?>

@if (isset($paginator) and $paginator->getCollection()->count() > 0)

<div class="block colored-gray {{ isset($class) ? $class : '' }}">
    <h2>{{ trans('frontPage.feature_model_title') }}</h2>
    <div class="featured-models owl-carousel">
		<?php
			if (!isset($cats)) {
				$cats = collect([]);
			}
			foreach ($paginator->getCollection() as $key => $user): ?>
				<div class="item">
		            <div class="holder">
		                <div>
		                    @if (!empty($user->logo))
		                        <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}"><img src="{{ \Storage::url($user->logo) }}" alt="{{ trans('metaTags.User') }}" class="featureModelImage" ></a>&nbsp;
		                    @elseif (!empty($gravatar))
		                        <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}"><img src="{{ $gravatar }}" alt="{{ trans('metaTags.User') }}"></a>&nbsp;
		                    @else
		                        <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}"><img src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="{{ trans('metaTags.User') }}" class="featured-models-image"></a>&nbsp;
		                    @endif

		                    <?php
								$age = '';
								if(isset($user->birth_day) && !empty($user->birth_day)){
									$from = new DateTime($user->birth_day);
									$to = new DateTime('today');

									if($from->diff($to)->y > 0 ){
										$y = $from->diff($to)->y;
										$age =  ($y)? ($y > 1 )? $y.' '.t('years') : $y.' '.t('year')  : '';
									}elseif($from->diff($to)->m > 0){
										$m = $from->diff($to)->m;
										$age =  ($m)? ($m > 1 )? $m.' '.t('months') : $m.' '.t('month') : '';
									}else{
										$d = $from->diff($to)->d;
										$age =  ($d)? ($d > 1 )? $d.' '.t('days') : $d.' '.t('day') : '' ;
									}
									// $age = $from->diff($to)->y;
								}
								
							?>
		                    <span class="featureImage featureImagePadding">
								<a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class="featureImageFont">
								@if(isset($user->full_name) && !empty($user->full_name))
									{{ ucfirst($user->full_name) }}
								@endif
								</a>
							</span>
							<span class="featureImagePadding">
								@if(!empty($age))
									{{ $age }}
								@endif
							</span>
		                </div>
		            </div>
		        </div>
				<?php
			endforeach;
		?>
	</div>
</div>
@endif