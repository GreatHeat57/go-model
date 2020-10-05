@extends('layouts.app')

@section('content')
        
        @if(Session::has('success'))
            @if (session('success') != '')
                @if (!(isset($paddingTopExists) and $paddingTopExists))
                    <div class="h-spacer"></div>
                @endif
                <?php $paddingTopExists = true;?>
                <div class="container no-padding no-margin">
                    <div class="row">
                        <div class="alert alert-success home-message position-absolute">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @if(Session::has('message'))
            @if(session('message') != '')
                @if (!(isset($paddingTopExists) and $paddingTopExists))
                    <div class="h-spacer"></div>
                @endif
                <?php $paddingTopExists = true;?>
                <div class="container no-padding no-margin">
                    <div class="row">
                        <div class="alert alert-danger home-message position-absolute">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif   
        @endif

        @if(Session::has('flash_notification'))
            @if(session('flash_notification') != '')
                @if (!(isset($paddingTopExists) and $paddingTopExists))
                    <div class="h-spacer"></div>
                @endif
                <?php $paddingTopExists = true;?>
                <div class="container no-padding no-margin">
                    <div class="row">
                        <div class="home-message position-absolute">
                            @include('flash::message')
                        </div>
                    </div>
                </div>
            @endif    
        @endif
       
    <div class="container px-0 pt-40 pb-60 position-absolute">
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
        </div>
    </div>

    <div class="cover">
        <?php /* <!-- <picture>
          <source srcset="{{ URL::to(config('app.cloud_url').'/images/covers/home.webp') }}">
          <img src="{{ URL::to(config('app.cloud_url').'/images/covers/home.jpg') }}" alt="Go-Models">
        </picture> --> */ ?>

        <picture class="banner-img">
            <source media="(max-width: 480px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/home/'.trans('frontPage.home-banner-img-jpg-480-320')) }}"  data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.home-banner-img-jpg')) }}">

            <source media="(max-width: 768px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/home/'.trans('frontPage.home-banner-img-jpg-768-595')) }}" data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.home-banner-img-jpg')) }}">

            <source media="(max-width: 1024px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/home/'.trans('frontPage.home-banner-img-jpg-1024-580')) }}" data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.home-banner-img-jpg')) }}">

            <source media="(max-width: 1200px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/home/'.trans('frontPage.home-banner-img-jpg-1200-580')) }}" data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.home-banner-img-jpg')) }}">

            <img src="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.home-banner-img-webp')) }}" class="" alt="{{ trans('metaTags.Go-Models') }}" onerror=this.src='{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.home-banner-img-jpg')) }}' />
        </picture>

        <div class="inner">
            <div class="text">
                <div class="holder">
                    <h1>{{ trans('frontPage.go_to_job') }}</h1>
                    <h3>{{ trans('frontPage.go_to_job_title') }}</h3>
                    <p>{{ trans('frontPage.go_to_job_description') }}</p>
                    <a href="#" class="watch home-video">{{ trans('frontPage.watch_intro') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <h2 class="mg-b-20">{{ trans('frontPage.step_title') }}</h2>
        <h3 class="playfair">{{ trans('frontPage.step_sub_title') }}</h3>

        <div class="cols-3 nested">
            <div class="col">
                <div class="reason">
                    <span>1</span>
                    <h4>{{ trans('frontPage.benefit_1_title') }}</h4>
                    <p>{{ trans('frontPage.benefit_1_description') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>2</span>
                    <h4>{{ trans('frontPage.benefit_2_title') }}</h4>
                    <p>{{ trans('frontPage.benefit_2_description') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>3</span>
                    <h4>{{ trans('frontPage.benefit_3_title') }}</h4>
                    <p>{{ trans('frontPage.benefit_3_description') }}</p>
                </div>
            </div>
        </div>

        <div class="btn pt-15">
            <?php $attr = ['countryCode' => config('country.icode')];?>
            @if (Auth::User() && Auth::User()->user_type_id == 2)
            <a href="{{ lurl(trans('routes.model-list')) }}" class="register">{{ trans('frontPage.btn_start') }}</a>
            @elseif (Auth::User() && Auth::User()->user_type_id == 3)
            <?php /* <a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}" class="register">{{ trans('frontPage.btn_start') }}</a> */ ?>


            {!! App\Helpers\CommonHelper::createLink('list_partner', trans('frontPage.btn_start'), lurl(trans('routes.partner-list', $attr), $attr), 
            'register', '','','') !!}

            @else
            <a href="javascript:void(0);" class="register mfp-register-form">{{ trans('frontPage.btn_start') }}</a>
            @endif
        </div>
    </div>


    <?php /* @include('childs.promo',['class' => 'colored-light-blue2']) */ ?>

        
    
    <!-- promo section starts -->
    <div class="block {{ isset($class) ? $class : '' }}" id="viewpoint">
        <div class="cols-2 no-mg-b">
            <div class="col">
                <div class="promo"> 
                    <img data-src="{{ URL::to(config('app.cloud_url').'/images/'.trans('frontPage.home-promo1-img-webp')) }}" class="lazyload" alt="{{ trans('frontPage.partner_step_title') }}" onerror=this.src='{{ URL::to(config('app.cloud_url').'/images/'.trans('frontPage.home-promo1-img-jpg')) }}' />
                    <div class="data">
                        <h2>{{ trans('frontPage.partner_step_title') }}</h2>
                        <ul>
                            <li>{{ trans('frontPage.partner_list_item1') }}</li>
                            <li>{{ trans('frontPage.partner_list_item2') }}</li>
                            <li>{{ trans('frontPage.partner_list_item3') }}</li>
                        </ul>
                        <div class="btn pt-15">
                            @if (Auth::User() && Auth::User()->user_type_id == 2)
                                <a href="{{ lurl(trans('routes.model-list')) }}" class="next">{{ trans('frontPage.partner_step_button_label') }}</a>
                            @elseif (Auth::User() && Auth::User()->user_type_id == 3)
                                <a href="javascript:void(0);" class="next disabled disabled_opacity">{{ trans('frontPage.partner_step_button_label') }}</a>
                            @else
                            <a href="{{ lurl(trans('routes.login')) }}" class="next">{{ trans('frontPage.partner_step_button_label') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="promo">
                    <img data-src="{{ URL::to(config('app.cloud_url').'/images/'.trans('frontPage.home-promo2-img-webp')) }}" class="lazyload" alt="{{ trans('frontPage.model_step_title') }}" onerror=this.src='{{ URL::to(config('app.cloud_url').'/images/'.trans('frontPage.home-promo2-img-jpg')) }}' />
                    <div class="data">
                        <h2>{{ trans('frontPage.model_step_title') }}</h2>
                        <ul>
                            <li>{{ trans('frontPage.model_list_item1') }}</li>
                            <li>{{ trans('frontPage.model_list_item2') }}</li>
                            <li>{{ trans('frontPage.model_list_item3') }}</li>
                        </ul>
                        <div class="btn pt-15">
                            @if (auth()->check())
                                <a href="javascript:void(0);" class="next disabled_opacity disabled">{{ trans('frontPage.model_step_button_label') }}</a>
                            @else
                            <a href="#" class="next mfp-register-form">{{ trans('frontPage.model_step_button_label') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span id="ajax-render"></span>


    <?php $category_title = t('Everyone can become a go model'); ?>
    <div class="block" id="loading_category_section" style="display: none;">
        <h2><?php echo $category_title; ?></h2>
        <div class="loading-process" style="position: relative;">Loading&#8230;</div>
    </div> 
    
    {{-- Html::script(config('app.cloud_url').'/js/bladeJs/home-blade.js') --}}
    {{-- Html::script(config('app.cloud_url').'/js/ajax_flash_message.js') --}}
    <script type="text/javascript">
       $(window).on('load', function() {
            var imageEle = $("img");
            $(imageEle).each(function() {
                if (typeof $(this).attr("alt") == typeof undefined || $(this).attr("alt") == "") {
                    var altText = "Go-Models";
                    if ($(this).attr("src") != undefined) {
                        var imagename = $(this).attr("src");
                        var last = imagename.substring(imagename.lastIndexOf("/") + 1, imagename.length);
                        altText = last.split(".")[0];
                        $(this).attr("alt", altText)
                    }
                }
            })
        });
        var getUrl = baseurl + "home-ajax-content";
        var is_reached = false;
        $(window).on("scroll", function() {
            setTimeout(function() {
                if ($(window).scrollTop() >= $("#viewpoint").offset().top + $("#viewpoint").outerHeight() - window.innerHeight * 3) {
                    if (!is_reached) {
                        $.ajax({
                            url: getUrl,
                            type: "get",
                            beforeSend: function() {
                                $("#loading_category_section").show()
                            },
                            complete: function() {
                                $("#loading_category_section").hide()
                            },
                            success: function(data) {
                                $("#ajax-render").html(data.html);

                                $(".mfp-register-form").unbind('click');
                                $(".mfp-register-form").click(function(e) { e.preventDefault(); signupFormPopup(); });
                                $(".block .testimonials").owlCarousel({
                                    slideSpeed: 300,
                                    paginationSpeed: 400,
                                    autoHeight: true,
                                    loop: true,
                                    autoplay: false,
                                    autoplayTimeout: 5e3,
                                    autoplayHoverPause: true,
                                    startPosition: 0,
                                    responsive: {
                                        0: {
                                            items: 1,
                                            nav: true,
                                            margin: 0,
                                            navigation: true
                                        },
                                        767: {
                                            items: 2,
                                            nav: true,
                                            margin: 0,
                                            navigation: true
                                        },
                                        1399: {
                                            items: 3,
                                            nav: true,
                                            margin: 0,
                                            navigation: true
                                        }
                                    }
                                });
                                $(".block .testimonials").on("resized.owl.carousel", function(event) {
                                    var $this = $(this);
                                    $this.find(".owl-height").css("height", $this.find(".owl-item.active").height())
                                });
                            },
                            error: function(err) {
                                console.log(err)
                            }
                        });
                        is_reached = true
                    }
                }
            }, 100)
        });

    </script>
@endsection
