@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content')
    <div class="container pt-40 pb-60 px-0" id="social_container">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="text-center prata">{{ t('Now on Gomodels') }}</h1>
                <div class="divider mx-auto"></div>
                <!-- <span>Look around what lorem ipsum dolor sit amet</span> -->
            </div>
        </div>

        <!-- + -->
        <div class="row grid mb-40" id='socialstream-section'>
            <div class="col-md-12 col-xl-12 position-relative">
                <div class="wall-outer">
                    <div id="social-stream" class="dc-wall col-lg-12 dcwss modern light table-responsive"></div>
                </div>
            </div>
        </div>
        <!-- <div class="text-center"><a href="#" class="btn btn-white refresh">More posts</a></div> -->
    </div>


    @include('childs.bottom-bar')


@endsection

@section('page-script')
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/inc/layout.css') }}" media="all" />
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/css/dcsns_wall.css') }}" media="all" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.plugins.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.site.js') }}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.wall.1.8.js')}}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.1.6.2.min.js')}}"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var config = {
        feeds: {
            twitter: {
                url: "{{ url('twitter.php') }}",
                id: "go_models",
                intro: "Tweeted",
                search: "Tweeted",
                images: "thumb",
                thumb: true,
                retweets: false,
                replies: false,
                out: "intro,text,share"
            },
            facebook: {
                url: "{{ lurl('account/social/facebook') }}",
                id: "{{ config('app.facebook_page_id') }}",
                intro: "Posted",
                comments: 3,
                image_width: 6,
                feed: "feed",
                out: "intro,thumb,title,text,user,share"
            },
            /*youtube: {
                id: "UCFb_MTs7jJBr5iOiri0oWQw",
                intro: "Uploaded",
                search: "Search",
                thumb: "medium",
                out: "intro,thumb,title,text,user,share",
                api_key: "AIzaSyCuoP7CP3GNEFA2NBlI32dCK1yBgd_aATA"
            },*/
            pinterest: {
                url: "{{ url('account/social/rss') }}",
                id: "go_models",
                intro: "Pinned",
                out: "intro,thumb,text,user,share"
            },
            instagram: {
                id: "{{ config('app.instagram_id') }}",
                intro: "Posted",
                search: "Search",
                out: "intro,thumb,text,user,share",
                accessToken: "{{ config('app.instagram_access_token') }}",
                redirectUrl: "{{ config('app.instagram_redirect_url') }}",
                clientId: "{{ config('app.instagram_client_id') }}"
            }
        },
        remove: "",
        max: "limit",
        days: 10,
        limit: 50,
        center: true,
        speed: 600,
        style: {
            layout: "modern",
            colour: "light"
        },
        rotate: {
            delay: 0,
            direction: "up"
        },
        wall: true,
        container: "dcwss",
        cstream: "stream",
        content: "dcwss-content",
        imagePath: "{{ url(config('app.cloud_url').'/images/dcwss-dark/') }}",
        iconPath: "{{ url(config('app.cloud_url').'/images/dcwss-dark/') }}"
    };
    //$("#social-stream").dcSocialStream(config);
    if (!jQuery().dcSocialStream) {
        $.getScript("{{ url(config('app.cloud_url').'/js/jquery.social.stream.wall.1.8.js') }}", function() {});
        $.getScript("{{ url(config('app.cloud_url').'/js/jquery.social.stream.1.6.2.min.js') }}", function() {
            $("#social-stream").dcSocialStream(config);
        });
    } else {
        $("#social-stream").dcSocialStream(config);
    }


    $('#dcsns-filter li a.link-all').html('All');
    // $('#dcsns-filter .f-facebook a').html('Facebook');
    // $('#dcsns-filter .f-twitter a').html('Twitter');
    // $('#dcsns-filter .f-youtube a').html('Youtube');
    // $('#dcsns-filter .f-pinterest a').html('Pinterest');
    // $('#dcsns-filter .f-instagram a').html('Instagram');
    // $('#dcsns-filter').addClass('d-none d-md-flex justify-content-center');
});
</script>
<style type="text/css">
    .stream li.dcsns-twitter .section-intro,.filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:#4ec2dc!important;}.stream li.dcsns-facebook .section-intro,.filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:#3b5998!important;}.stream li.dcsns-google .section-intro,.filter .f-google a:hover, .wall-outer .dcsns-toolbar .filter .f-google a.iso-active{background-color:#2d2d2d!important;}.stream li.dcsns-rss .section-intro,.filter .f-rss a:hover, .wall-outer .dcsns-toolbar .filter .f-rss a.iso-active{background-color:#FF9800!important;}.stream li.dcsns-flickr .section-intro,.filter .f-flickr a:hover, .wall-outer .dcsns-toolbar .filter .f-flickr a.iso-active{background-color:#f90784!important;}.stream li.dcsns-delicious .section-intro,.filter .f-delicious a:hover, .wall-outer .dcsns-toolbar .filter .f-delicious a.iso-active{background-color:#3271CB!important;}.stream li.dcsns-youtube .section-intro,.filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:#DF1F1C!important;}.stream li.dcsns-pinterest .section-intro,.filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:#CB2528!important;}.stream li.dcsns-lastfm .section-intro,.filter .f-lastfm a:hover, .wall-outer .dcsns-toolbar .filter .f-lastfm a.iso-active{background-color:#C90E12!important;}.stream li.dcsns-dribbble .section-intro,.filter .f-dribbble a:hover, .wall-outer .dcsns-toolbar .filter .f-dribbble a.iso-active{background-color:#F175A8!important;}.stream li.dcsns-vimeo .section-intro,.filter .f-vimeo a:hover, .wall-outer .dcsns-toolbar .filter .f-vimeo a.iso-active{background-color:#4EBAFF!important;}.stream li.dcsns-stumbleupon .section-intro,.filter .f-stumbleupon a:hover, .wall-outer .dcsns-toolbar .filter .f-stumbleupon a.iso-active{background-color:#EB4924!important;}.stream li.dcsns-deviantart .section-intro,.filter .f-deviantart a:hover, .wall-outer .dcsns-toolbar .filter .f-deviantart a.iso-active{background-color:#607365!important;}.stream li.dcsns-tumblr .section-intro,.filter .f-tumblr a:hover, .wall-outer .dcsns-toolbar .filter .f-tumblr a.iso-active{background-color:#385774!important;}.stream li.dcsns-instagram .section-intro,.filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:#413A33!important;}.dcwss.dc-wall .stream li {width: 425px!important; margin: 0px 15px 15px 0px!important;}.wall-outer #dcsns-filter.dc-center{padding-left: 0% !important;margin-left: 0px !important;padding-right: 0%;}.stream li.dcsns-facebook .section-intro, .filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:transparent !important; }.stream li.dcsns-twitter .section-intro, .filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:transparent !important;}.stream li.dcsns-youtube .section-intro, .filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:transparent !important;}.stream li.dcsns-pinterest .section-intro, .filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:transparent !important;}.stream li.dcsns-instagram .section-intro, .filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:transparent !important;}.wall-outer .dcsns-toolbar .filter li a{padding: 10px 16px;}#socialstream-section{height:auto !important;}.wall-outer{max-height: 1000px;}
        .wall-outer .dcsns-toolbar .filter li{ padding-top: 3px; }

        .wall-outer .dcsns-toolbar .filter li a{padding: 10px 27px; }
        span.socicon.socicon-facebook { color: #3b5998; } span.socicon.socicon-twitter{ color: #55acee;  } span.socicon.socicon-youtube { color: #cd201f; } span.socicon.socicon-pinterest{ color: #bd081c; } span.socicon.socicon-instagram { color: #3f729b;  }

        @media (min-width: 768px) and (max-width: 1024px) {
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 9px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: auto; padding: 10px 36px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important; margin-left: -73px !important; }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 100px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; padding-top: 3px;}
        }

        /*Portrait*/ 
        @media only screen and (min-width: 1024px) and (orientation: portrait) { 
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 0px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: 100%; padding: 10px 20px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important;margin-left: -73px !important }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 0px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; padding-top: 3px;}
        }
        
        @media (min-width: 320px) and (max-width: 480px) {
            .dcwss.dc-wall .stream li {
                width: auto; margin: 0px 15px 15px 0px!important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 18px; }
            .dcwss.dc-wall.modern.light .stream li { max-width: 100%;  }
            ul.stream{  width: auto !important; }
        }
        @media (max-width: 320px){
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 15px; }
            ul.stream{  width: auto !important; }
        }
        /* center text for social link */
        .dcsns-toolbar {
            display: flex !important;
            justify-content: center !important;
        }
        #dcsns-filter {
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
        }
        /*@media (min-width: 375px) and (max-width: 424px) {
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 21px; }
        }
        @media (min-width: 425px) and (max-width: 767px) {
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 23px; }
        }
*/
</style>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>

<script>
    $(window).on('load', function() {
        var height =  ($('.wall-outer').height() + 200);
        $("#social_container").css('height',height);
    });
</script>
@endsection