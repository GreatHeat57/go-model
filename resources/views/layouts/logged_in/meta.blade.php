@if (isset($dnsPrefetch) && count($dnsPrefetch) > 0)
	@foreach($dnsPrefetch as $dns)
		<link rel="dns-prefetch" href="{{ $dns }}">
	@endforeach
@endif

<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('common.meta-robots')
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-title" content="{{ config('settings.app.name') }}">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url(config('app.cloud_url').'/uploads/app/default/ico/apple-touch-icon-144-precomposed.png') . getPictureVersion() }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ url(config('app.cloud_url').'/uploads/app/default/ico/apple-touch-icon-114-precomposed.png') . getPictureVersion() }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ url(config('app.cloud_url').'/uploads/app/default/ico/apple-touch-icon-72-precomposed.png') . getPictureVersion() }}">
	<link rel="apple-touch-icon-precomposed" href="{{ url(config('app.cloud_url').'/uploads/app/default/ico/apple-touch-icon-57-precomposed.png') . getPictureVersion() }}">
	<link rel="shortcut icon" href="{{ url(config('app.cloud_url').'/uploads/'.config('settings.app.favicon')) . getPictureVersion() }}">
	
	<?php /*
		@if(isset($is_no_follow) && $is_no_follow == true)
			<meta name="robots" content="noindex, nofollow">
		@endif
	*/?>
	
	<title>{{ MetaTag::get('title') }}</title>
	{!! MetaTag::tag('description') !!}
	<?php /* {!! MetaTag::tag('keywords') !!} */ ?>

	<?php $href_lanf = config('constant.href_lang'); ?>
	@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
		<?php
			$alternetLocale = strtolower(strtolower($localeCode));
			if(strtolower($localeCode) == 'de')
			{
				$alternetLocale = strtolower(strtolower($localeCode)).'-'.strtoupper(strtolower($localeCode));
			} 

			$attr = [];
            
            if (isset($uriPathCatSlug)) {
                $attr['catSlug'] = $uriPathCatSlug;
                if (isset($uriPathSubCatSlug)) {
                    $attr['subCatSlug'] = $uriPathSubCatSlug;
                }
            }
			
			if (isset($uriPathPageSlug)) {
                $attr['slug'] = $uriPathPageSlug;
            }

            if(isset($uriPathPageId)){
                $attr['attrId'] = $uriPathPageId;
            }

            if (isset($uriCategoryId)){
                $attr['category_id'] = $uriCategoryId;
            }
            
            if (isset($uriPathToken)) {
                $attr['token'] = $uriPathToken;
            }
		?>

		@if(empty(\Request::get('d')))
		<link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL($localeCode , $url = null, $attr) }}" hreflang="{{ (isset($href_lanf[$properties['locale']]))? $href_lanf[$properties['locale']] : $alternetLocale }}"/>
		@endif
		<?php /*
		<link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" hreflang="{{ ($properties['locale'])? str_replace('_','-', $properties['locale']) : $alternetLocale }}"/> */ ?>
	@endforeach
	
	@if(!empty(\Request::get('d')))
		<!-- <link rel="canonical" href="{{ config('app.url') }}" /> -->
		<link rel="canonical" href="{{ LaravelLocalization::localizeURL(config('app.locale')) }}" />
	@else

		<?php
			
			$attr = [];
            
            if (isset($uriPathCatSlug)) {
                $attr['catSlug'] = $uriPathCatSlug;
                if (isset($uriPathSubCatSlug)) {
                    $attr['subCatSlug'] = $uriPathSubCatSlug;
                }
            }
			
			if (isset($uriPathPageSlug)) {
                $attr['slug'] = $uriPathPageSlug;
            }

            if(isset($uriPathPageId)){
                $attr['attrId'] = $uriPathPageId;
            }

            if (isset($uriCategoryId)){
                $attr['category_id'] = $uriCategoryId;
            }
            
            if (isset($uriPathToken)) {
                $attr['token'] = $uriPathToken;
            }
		?>

		<link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL(config('app.fallback_locale'), $url = null, $attr) }}" hreflang="x-default"/>
		<!-- <link rel="alternate" href="{{ config('app.url') }}" hreflang="x-default"/> -->
	@endif

	<?php /*
	 	<link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL(config('app.locale')) }}" hreflang="{{ strtolower(config('app.locale')) }}"/> 
	*/ ?>

	
	
	<?php /*{{-- SEO::getKeywords() --}} */ ?>

	@if (isset($post))
		@if (isVerifiedPost($post))
			@if (config('services.facebook.client_id'))
				<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
			@endif
			@if(isset($og))
			<?php 

			$hasLocale = $og->has('locale');
			if($hasLocale){
				$og_locale = $og->lastTag('locale')->value;

				if($og_locale !== ""){
					$og_locale = str_replace('_','-', $og_locale);
					$og->locale($og_locale);
				}
			} ?>
			{!! $og->renderTags() !!}
			@endif
			{!! MetaTag::twitterCard() !!}
		@endif
	@else
		@if (config('services.facebook.client_id'))
			<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
		@endif
		@if(isset($og))
		<?php 

		$hasLocale = $og->has('locale');
		if($hasLocale){
			$og_locale = $og->lastTag('locale')->value;

			if($og_locale !== ""){
				$og_locale = str_replace('_','-', $og_locale);
				$og->locale($og_locale);
			}
		} ?>
		{!! $og->renderTags() !!}
		{!! MetaTag::twitterCard() !!}
		@endif
	@endif
	@if(isset($og_seo_tags))
		@foreach($og_seo_tags as $key => $value)
			<meta property="<?=$key?>" content="<?=$value?>" />
		@endforeach
	@endif
	@if(isset($twitter_seo_tags))
		@foreach($twitter_seo_tags as $key => $value)
			<meta name="<?=$key?>" content="<?=$value?>" />
		@endforeach
	@endif
	
	@if (config('settings.seo.google_site_verification'))
		<meta name="google-site-verification" content="{{ config('settings.seo.google_site_verification') }}" />
	@endif
	@if (config('settings.seo.msvalidate'))
		<meta name="msvalidate.01" content="{{ config('settings.seo.msvalidate') }}" />
	@endif
	@if (config('settings.seo.alexa_verify_id'))
		<meta name="alexaVerifyID" content="{{ config('settings.seo.alexa_verify_id') }}" />
	@endif