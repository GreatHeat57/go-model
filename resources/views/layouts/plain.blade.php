<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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

    <!-- !! SEO::generate() !! -->
    */ ?>
    @include('layouts.head')
</head>
<body>
{!! config('constant.noscript_Google_Tag_Manager')!!}	
{!! config('constant.Cookie_noscript_Google_Tag_Manager') !!}
<?php /*
<!-- Google Tag Manager (noscript) -->
<!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5RPTCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
<!-- End Google Tag Manager (noscript) -->
*/ ?>
@include('layouts.header')

<div class="content">
    @yield('content')
</div>

@include('layouts.mobile_menu')
@include('layouts.footer_plain')
{{ Html::script(config('app.cloud_url').'/js/ui.min.js') }}

</body>
</html>