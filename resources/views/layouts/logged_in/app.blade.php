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

<div class="px-13 px-sm-0">
    @yield('content')
</div>

@include('layouts.footer')

<script>
    $('body').on('change', 'form input.animlabel', function () {
        if ($(this).val().length > 0) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });

    $('body').on('click change', '.select2', function () {
        if ($(this).hasClass('select2-container--open')) {
            $(this).parent().css('box-shadow', '0 3px 14.4px 3.6px rgba(188, 188, 188, 0.34)');
        } else {
            $(this).parent().css('box-shadow', 'none');
        }
    });


    $(document).ready(function () {
        $("select").select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
</body>
</html>