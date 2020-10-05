{{--
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
<?php
	$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
	$detectAdsBlockerPlugin = load_installed_plugin('detectadsblocker');
?>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
<head>
	{!! config('constant.Google_Tag_Manager')!!}
	{!! config('constant.Cookie_Google_Tag_Manager')!!}    	
	<?php /*
	<!-- Google Tag Manager -->
	<!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-T5RPTCX');</script> -->
	<!-- End Google Tag Manager -->
 */ ?>
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
	<title>{{ MetaTag::get('title') }}</title>
	{!! MetaTag::tag('description') !!}{!! MetaTag::tag('keywords') !!}
	<link rel="canonical" href="{{ $fullUrl }}"/>
	{{-- @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
		@if (strtolower($localeCode) != strtolower(config('app.locale')))
			<link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" hreflang="{{ strtolower($localeCode) }}"/>
		@endif
	@endforeach --}}
	<link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL(config('app.locale')) }}" hreflang="{{ strtolower(config('app.locale')) }}"/>
	@if (isset($dnsPrefetch) && count($dnsPrefetch) > 0)
		@foreach($dnsPrefetch as $dns)
			<link rel="dns-prefetch" href="{{ $dns }}">
		@endforeach
	@endif
	
	<!-- dynamic meta keyword for every page -->
	{!! SEO::getKeywords() !!}
	<!-- dynamic meta keyword for every page -->

	@if (isset($post))
		@if (isVerifiedPost($post))
			@if (config('services.facebook.client_id'))
				<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
			@endif
			@if(isset($og))
			{!! $og->renderTags() !!}
			@endif
			{!! MetaTag::twitterCard() !!}
		@endif
	@else
		@if (config('services.facebook.client_id'))
			<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
		@endif
		@if(isset($og))
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
	
	@yield('before_styles')
	
	@if (config('lang.direction') == 'rtl')
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="{{ url(mix('css/app.rtl.css')) }}" rel="stylesheet">
	@else
		<link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
	@endif
	@if (isset($detectAdsBlockerPlugin) and !empty($detectAdsBlockerPlugin))
		<link href="{{ url('assets/detectadsblocker/css/style.css') . getPictureVersion() }}" rel="stylesheet">
	@endif
	@include('layouts.inc.tools.style')
	<link href="{{ url('css/custom.min.css') . getPictureVersion() }}" rel="stylesheet">
	
	@yield('after_styles')
	
	@if (isset($installedPlugins) and count($installedPlugins) > 0)
		@foreach($installedPlugins as $pluginName)
			@yield($pluginName . '_styles')
		@endforeach
	@endif
	
	@if (config('settings.style.custom_css'))
		{!! printCss(config('settings.style.custom_css')) . "\n" !!}
	@endif
	
	@if (config('settings.other.js_code'))
		{!! printJs(config('settings.other.js_code')) . "\n" !!}
	@endif

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script>
		paceOptions = {
			elements: true
		};
	</script>

	<!-- defined register popup url to convert based on local and get it pupop form action-->
	<script type="text/javascript">
	  var registerurl = "{{ lurl(trans('routes.register-from')) }}/";
	</script>
	
	<script src="{{ url('assets/js/pace.min.js') }}"></script>
	<link href="{{ url('assets/css/main.css') . getPictureVersion() }}" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="{{ url('assets/js/croppic.js') }}"></script>
	<script src="{{ url('assets/js/main.js') }}"></script>
	<link href="{{ url('assets/css/croppic.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script src="{{ url('assets/js/custom.js') }}"></script>
	  <script>
	  $( function() {
	    $( "#datepicker" ).datepicker();
	  } );
	  </script>

	  <script type="text/javascript">
		  var baseurl = "{{ url('/') }}/";
		</script>
</head>
<body class="{{ config('app.skin') }}">
{!! config('constant.noscript_Google_Tag_Manager')!!}	
{!! config('constant.Cookie_noscript_Google_Tag_Manager') !!}
<?php /*
<!-- Google Tag Manager (noscript) -->
<!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5RPTCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
<!-- End Google Tag Manager (noscript) -->
*/ ?>
<div id="wrapper">

	@section('header')
		@include('layouts.inc.header')
	@show

	@section('search')
	@show
		
	@section('wizard')
	@show

	@if (isset($siteCountryInfo))
		<div class="h-spacer"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{!! $siteCountryInfo !!}
					</div>
				</div>
			</div>
		</div>
	@endif

	@yield('content')

	@section('info')
	@show
	
	@section('footer')
		@include('layouts.inc.footer')
	@show

</div>

@section('modal_location')
@show
@section('modal_abuse')
@show
@section('modal_message')
@show

@includeWhen(!auth()->check(), 'layouts.inc.modal.login')
@include('layouts.inc.modal.change-country')

@if (isset($detectAdsBlockerPlugin) and !empty($detectAdsBlockerPlugin))
	@if (view()->exists('detectadsblocker::modal'))
		@include('detectadsblocker::modal')
	@endif
@endif

<script>
	{{-- Init. Root Vars --}}
	var siteUrl = '<?php echo url('/'); ?>';
	var languageCode = '<?php echo config('app.locale'); ?>';
	var countryCode = '<?php echo config('country.code', 0); ?>';
	
	{{-- Init. Translation Vars --}}
	var langLayout = {
		'hideMaxListItems': {
			'moreText': "{{ t('View More') }}",
			'lessText': "{{ t('View Less') }}"
		},
		'select2': {
			errorLoading: function(){
				return "{!! t('The results could not be loaded') !!}"
			},
			inputTooLong: function(e){
				var t = e.input.length - e.maximum, n = {!! t('Please delete #t character') !!};
				return t != 1 && (n += 's'),n
			},
			inputTooShort: function(e){
				var t = e.minimum - e.input.length, n = {!! t('Please enter #t or more characters') !!};
				return n
			},
			loadingMore: function(){
				return "{!! t('Loading more results') !!}"
			},
			maximumSelected: function(e){
				var t = {!! t('You can only select #max item') !!};
				return e.maximum != 1 && (t += 's'),t
			},
			noResults: function(){
				return "{!! t('No results found') !!}"
			},
			searching: function(){
				return "{!! t('Searching') !!}"
			}
		}
	};
</script>

@yield('before_scripts')

<script src="{{ url('/js/app.min.js') }}"></script>
@if (file_exists(public_path() . '/assets/plugins/select2/js/i18n/'.config('app.locale').'.js'))
	<!-- <script src="{{ url('assets/plugins/select2/js/i18n/'.config('app.locale').'.js') }}"></script> -->
@endif
@if (isset($detectAdsBlockerPlugin) and !empty($detectAdsBlockerPlugin))
	<script src="{{ url('assets/detectadsblocker/js/script.js') . getPictureVersion() }}"></script>
@endif
<script>
	$(document).ready(function () {
		{{-- Select Boxes --}}
		$('.selecter').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity,
			width: '100%'
		});
		
		{{-- Searchable Select Boxes --}}
		$('.sselecter').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			width: '100%'
		});
		
		{{-- Social Share --}}
		$('.share').ShareLink({
			title: '{{ addslashes(MetaTag::get('title')) }}',
			text: '{!! addslashes(MetaTag::get('title')) !!}',
			url: '{!! $fullUrl !!}',
			width: 640,
			height: 480
		});
		
		{{-- Modal Login --}}
		@if (isset($errors) and $errors->any())
			@if ($errors->any() and old('quickLoginForm')=='1')
				$('#quickLogin').modal();
			@endif
		@endif
	});
</script>

<!-- for extra js on pages-->
@yield('extrajs')
<!-- for extra js on pages-->

@yield('after_scripts')

@if (isset($installedPlugins) and count($installedPlugins) > 0)
	@foreach($installedPlugins as $pluginName)
		@yield($pluginName . '_scripts')
	@endforeach
@endif

@if (config('settings.footer.tracking_code'))
	{!! printJs(config('settings.footer.tracking_code')) . "\n" !!}
@endif
</body>
</html>