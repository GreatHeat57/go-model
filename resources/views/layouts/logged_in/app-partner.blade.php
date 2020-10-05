<!DOCTYPE html>
<?php  
    $htmlLang = app()->getLocale();
    if(strtolower(config('app.locale')) == "de")
    {
        $htmlLang = strtolower(app()->getLocale()).'-'.strtoupper(app()->getLocale());
    }
?>
<html lang="{{ $htmlLang }}">
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
    <!-- End Google Tag Manager -->+
    */ ?>

    @include('layouts.logged_in.meta')

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <?php /* {{-- Html::style(asset('/css/custom_partner.css')) --}} */ ?>
    {{ Html::style(config('app.cloud_url').'/css/custom_partner.css') }}

    @include('layouts.logged_in.head')

    <script type="text/javascript">
        var textAddtoFav = '<?php echo t('Add to Favorite') ?>';
        var textRemoveFromFav = '<?php echo t('Remove from Favorite') ?>';
        // Tag manager code :
        // (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        //     new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        //     j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        //     'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        //     })(window,document,'script','dataLayer','GTM-T5RPTCX');

        //  var paq = paq || [];
        //   // tracker methods like "setCustomDimension" should be called before "trackPageView"
        //   _paq.push(["setCookieDomain", "*.go-models.com"]);
        //   _paq.push(['trackPageView']);
        //   _paq.push(['enableLinkTracking']);
        //   (function() {
        //     var u="//stats.go-models.com/";
        //     _paq.push(['setTrackerUrl', u+'piwik.php']);
        //     _paq.push(['setSiteId', '1']);
        //     var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        //     g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        //   })();
    </script>
    <?php /*
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5c8f7d4c1c07550011f24ee3&product=inline-share-buttons' async='async'></script>
    */ ?>
</head>
<body>
{!! config('constant.noscript_Google_Tag_Manager')!!} 
{!! config('constant.Cookie_noscript_Google_Tag_Manager') !!}   
<?php /*
    <!-- Google Tag Manager (noscript) -->
    <!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5RPTCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
    <!-- End Google Tag Manager (noscript) -->

    <!-- <button onclick="topFunction()" id="btnScrollTop" title="Scroll to top"><img src="{{ URL::to(config('app.cloud_url').'/images/icons/up-arrow-white.png') }}"/></button> -->
*/ ?>

@include('layouts.logged_in.header-partner')

<div class="px-13 px-sm-0 position-relative mt-70">
    @yield('content')
    {{--<a href="#" id="goUp" class="btn btn-white mini-all"></a>--}}
</div>

@include('childs.mobile-menu-partner')
@include('childs.mobile-menu-partner-right')
@include('layouts.logged_in.footer')

<script>
        
        var siteUrl = '<?php echo url('/'); ?>';

         /* update header flag and message,inviation count on cache page */
        var num_counter = "<?php echo config('app.num_counter'); ?>";
        var msg_label = "<?php echo t('Messages'); ?>";
        var intv_label = "<?php echo t('Invitations'); ?>";

        $("select").select2({
            minimumResultsForSearch: Infinity,
            width: '100%'
        });

        $('.multiple-select-hairColor').select2({
            dropdownAutoWidth: true,
            multiple: true,
            width: '100%',
            height: '30px',
            placeholder: "<?php echo t('Hair color'); ?>",
        });

        $('.multiple-select-eyeColor').select2({
            dropdownAutoWidth: true,
            multiple: true,
            width: '100%',
            height: '30px',
            placeholder: "<?php echo t('Eye color'); ?>",
        });

        $('.multiple-select-skinColor').select2({
            dropdownAutoWidth: true,
            multiple: true,
            width: '100%',
            height: '30px',
            placeholder: "<?php echo t('Skin color'); ?>",
        });

        $('.multiple-select-category').select2({
            dropdownAutoWidth: true,
            multiple: true,
            width: '100%',
            height: '30px',
            placeholder: "<?php echo t('All Categories'); ?>",
        });

        $(".country-auto-search").select2({
            minimumResultsForSearch: 5,
            width: '100%',
            templateResult: formatState,
            templateSelection: formatState
        });

        $(".city-auto-search").select2({
            minimumResultsForSearch: 5,
            width: '100%'
        });
        // time-zone list dropdown
        $(".timezone_list").select2({
            minimumResultsForSearch: 5,
            width: '100%'
        });

        $(".form-select2").select2({
            minimumResultsForSearch: 5,
            width: '100%'
        });
        
        function formatState (opt) {
             if (!opt.id) {
                return opt.text;
            } 

            var optimage = $(opt.element).attr('data-image'); 
            if(!optimage){
               return opt.text;
            } else {                    
                var $opt = $(
                   '<span><img class="country-flg-img" src="' + optimage + '" width="16" height="16" /> ' + opt.text + '</span>'
                );
                return $opt;
            }    
        };
        if ($('.phone-code-auto-search').length > 0) {
            $(".phone-code-auto-search").select2({
                minimumResultsForSearch: 5,
                width: '100%',
                templateResult: formatState,
                templateSelection: formatState
            });
        }


        $('.select2-search__field').css('width', '100%');

        $('.grid').masonry({
            itemSelector: '.grid-item',
        });

        $(".drag-n-drop").sortable({
            group: 'card-to-sort',
            cursor: 'move',
            axis: 'y'
        });

        $(".slider").slider({
            id: "slider12c",
            min: 0,
            max: 100,
            range: true,
            value: [0, 50]
        });

        // redirect to selected value url while change tab-menu 
        $('#tab-menu').on('change', function(){
            if( $(this).val() != undefined && $(this).val() != "" && $(this).val() != null ){
                window.location.href = $(this).val();
            }
        });
</script>

    @yield('after_styles')

    @yield('after_scripts')

    @yield('page-script')

{{ Html::script(config('app.cloud_url').'/js/bladeJs/header-count.js') }}

<script>
    $('body').on('change', 'form input.animlabel', function () {
        if ($(this).val().length > 0) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });

    $('body').on('click', '.dropdown-main', function (e) {
        $('.dropdown-content[data-content="' + $(this).data('content') + '"]').toggleClass('active');
        e.preventDefault();
    });

    $('body').on('click change', '.select2', function () {
        if ($(this).hasClass('select2-container--open')) {
            $(this).parent().css('box-shadow', '0 3px 14.4px 3.6px rgba(188, 188, 188, 0.34)');
        } else {
            $(this).parent().css('box-shadow', 'none');
        }
    });

    var viewportWidth = $(window).width();

    if (viewportWidth < 767) {

        $(".dropdown-main").addClass("mobile-menu-right");
    }else{

        $(".dropdown-main").removeClass("mobile-menu-right");
    }

    $(window).on("load, resize", function() {
        
        var viewportWidth = $(window).width();
        
        if (viewportWidth < 767) {

            $(".dropdown-main").addClass("mobile-menu-right");
        }else{

            $(".dropdown-main").removeClass("mobile-menu-right");
        }
    });

    $('body').on('click', '.mobile-menu-button', function (e) {
        
        $(".mobile-menu-right").removeClass('active');
        $(".wrapper-right").find('.mobile-menu').removeClass('active');
        $(".wrapper-right").hide();
        
        if($(".wrapper-left").find('.mobile-menu').hasClass('active')){

            $(".wrapper-left").find('.mobile-menu').removeClass('active');
            $(".wrapper-left").show();
            return false;
        }

        $(".wrapper-left").find('.mobile-menu').addClass('active');
        $(".wrapper-left").show();

        if ($(this).hasClass('active')) {
            $('body').css('overflow-y', 'hidden');
        } else {
            $('body').css('overflow-y', 'auto');
        }
        e.preventDefault();
    });

    $('body').on('click', '.mobile-menu-right', function (e) {
        
        $(".mobile-menu-button").removeClass('active');
        $(".wrapper-left").find('.mobile-menu').removeClass('active');
        $(".wrapper-left").hide();
        
        if($(".wrapper-right").find('.mobile-menu').hasClass('active')){

            $(".wrapper-right").find('.mobile-menu').removeClass('active');
            $(".wrapper-right").show();
            return false;
        }

        $(".wrapper-right").find('.mobile-menu').addClass('active');
        $(".wrapper-right").show();

        if ($(this).hasClass('active')) {
            $('body').css('overflow-y', 'hidden');
        } else {
            $('body').css('overflow-y', 'auto');
        }
        e.preventDefault();
    });
    
    $('body').on('click', '.custom-tabs ul li a', function () {
        $('.custom-tabs ul li a').removeClass('active');
        $(this).addClass('active');
    });

    $('body').on('click', 'a.filters', function () {
        $(this).toggleClass('active');
        $('.filter-area').stop().slideToggle();
        if(jQuery('a.search').hasClass('active')){
            jQuery('a.search').toggleClass('active');
            jQuery('.searchbar').stop().slideToggle();
        }
    });

    $('body').on('click', 'a.search', function () {
        $(this).toggleClass('active');
        $('.searchbar').stop().slideToggle();
         
        var num = $('#searchtext').val();        
        setTimeout(function() { $('#searchtext').focus().val('').val(num); }, 0000);
        
        if(jQuery('a.filters').hasClass('active')){
            jQuery('a.filters').toggleClass('active');
            jQuery('.filter-area').stop().slideToggle();
        }
    });
    
    jQuery.noConflict()(function($){

        var languageOpen = !1;
        $("body").on("click", ".languages .link", function(t) {
            languageOpen ? ($(this).parent().find("ul").slideUp("fast"), languageOpen = !1) : ($(this).parent().find("ul").slideDown("fast"), languageOpen = !0), t.preventDefault()
        });
    });
</script>
</body>
</html>