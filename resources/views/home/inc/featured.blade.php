<?php
if (!isset($cacheExpiration)) {
	$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
}
?>
@if (isset($featured) and !empty($featured) and !empty($featured->posts))
	@include('home.inc.spacer')

			 	<div class="pb-20 pt-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('Similar Jobs') }}</h2>
                    <div class="divider"></div>
                </div>

				<div class="row">
	            	<?php
foreach ($featured->posts as $key => $post):
	if (!$countries->has($post->country_code)) {
		continue;
	}

	$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
	$postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
		$postType = \App\Models\PostType::transById($post->post_type_id);
		return $postType;
	});
	if (empty($postType)) {
		continue;
	}

	?>
		                <div class="col-md-6 col-xl-3 mb-30">
		                    <div class="img-holder position-relative">
		                        <a href="{{ lurl($post->uri) }}" >
	                            	<img class="img-responsive lazyload" data-src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ mb_ucfirst($post->title) }}" style="border: 1px solid #e7e7e7; margin-top: 2px;" width="100%" height="100%">
	                            </a>
							</div>
							<div class="box-shadow bg-white py-40 px-30">
								<span>{{ mb_ucfirst(str_limit($post->title, 70)) }}</span>
								<span class="price"> {{ $postType->name }} </span>
							</div>
		                </div>
			            <?php endforeach;?>
		        </div>
		        <div class="text-center mb-30 pt-30 position-relative">
		            <a href="{{ $featured->link }}"  class="btn btn-white refresh">
								{{ t('View more') }} <i class="icon-th-list"></i>
					</a>
		        </div>


@endif

@section('before_scripts')
	@parent
	<script>
		/* Carousel Parameters */
		var carouselItems = {{ (isset($featured) and isset($featured->posts)) ? collect($featured->posts)->count() : 0 }};
		var carouselAutoplay = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay'])) ? $featuredOptions['autoplay'] : 'false' }};
		var carouselAutoplayTimeout = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay_timeout'])) ? $featuredOptions['autoplay_timeout'] : 1500 }};
		var carouselLang = {
			'navText': {
				'prev': "{{ t('prev') }}",
				'next': "{{ t('next') }}"
			}
		};
	</script>
@endsection