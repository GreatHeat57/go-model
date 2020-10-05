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
@extends('layouts.master')

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (Session::has('flash_notification'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-layout"></i> {{ t('Social') }} </h2>
                        <button class="btn btn-default" onclick="loadpage()">{{ t('Refresh') }}</button>
						<div class="wall-outer" >
							<div id="social-stream" class="dc-wall col-4 dcwss modern light"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/inc/layout.css') }}" media="all" />
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/css/dcsns_wall.css') }}" media="all" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.plugins.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.site.js') }}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.wall.1.8.js')}}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.1.6.2.min.js')}}"></script>
	<script type="text/javascript">

        function loadpage()
        {
            location.reload(true);
        }
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
                url: "{{ url('account/social/facebook') }}",
                id: "152974331874420",
                intro: "Posted",
                comments: 3,
                image_width: 6,
                feed: "posts",
                out: "intro,thumb,title,text,user,share"
            },
            youtube: {
                id: "UCFb_MTs7jJBr5iOiri0oWQw",
                intro: "Uploaded",
                search: "Search",
                thumb: "medium",
                out: "intro,thumb,title,text,user,share",
                api_key: "AIzaSyCuoP7CP3GNEFA2NBlI32dCK1yBgd_aATA"
            },
            pinterest: {
                url: "{{ url('account/social/rss') }}",
                id: "go_models",
                intro: "Pinned",
                out: "intro,thumb,text,user,share"
            },
            instagram: {
                id: "!4582181010",
                intro: "Posted",
                search: "Search",
                out: "intro,thumb,text,user,share",
                accessToken: "4582181010.1677ed0.0bf900fe75164174acf65478c12a1c85",
                redirectUrl: "https://go-models.com",
                clientId: "0def877b5dc54bd0949aa9166595ef48"
            }
        },
        remove: "",
        max: "limit",
        days: 10,
        limit: 10,
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

});

// jQuery(document).ready(function(){
// 	var filters = {}, $container = jQuery('.wall-outer .stream');

// 	jQuery('.wall-outer .filter a').click(function(){

// 	    var $i = jQuery(this), isoFilters = [], prop, selector, $a = $i.parents('.dcsns-toolbar'), $b = $a.next(), $c = jQuery('.stream',$b);

// 	    jQuery('.filter a',$a).removeClass('iso-active');
// 	    $i.addClass('iso-active');
// 	    filters[ $i.data('group') ] = $i.data('filter');
// 	    for (prop in filters){
// 	        isoFilters.push(filters[ prop ])
// 	    }
// 	    selector = isoFilters.join('');
// 	    $c.isotope({filter: selector, sortBy : 'postDate'});

// 	    return false;
// 	});
// });

</script>
<style type="text/css">
	.stream li.dcsns-twitter .section-intro,.filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:#4ec2dc!important;}.stream li.dcsns-facebook .section-intro,.filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:#3b5998!important;}.stream li.dcsns-google .section-intro,.filter .f-google a:hover, .wall-outer .dcsns-toolbar .filter .f-google a.iso-active{background-color:#2d2d2d!important;}.stream li.dcsns-rss .section-intro,.filter .f-rss a:hover, .wall-outer .dcsns-toolbar .filter .f-rss a.iso-active{background-color:#FF9800!important;}.stream li.dcsns-flickr .section-intro,.filter .f-flickr a:hover, .wall-outer .dcsns-toolbar .filter .f-flickr a.iso-active{background-color:#f90784!important;}.stream li.dcsns-delicious .section-intro,.filter .f-delicious a:hover, .wall-outer .dcsns-toolbar .filter .f-delicious a.iso-active{background-color:#3271CB!important;}.stream li.dcsns-youtube .section-intro,.filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:#DF1F1C!important;}.stream li.dcsns-pinterest .section-intro,.filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:#CB2528!important;}.stream li.dcsns-lastfm .section-intro,.filter .f-lastfm a:hover, .wall-outer .dcsns-toolbar .filter .f-lastfm a.iso-active{background-color:#C90E12!important;}.stream li.dcsns-dribbble .section-intro,.filter .f-dribbble a:hover, .wall-outer .dcsns-toolbar .filter .f-dribbble a.iso-active{background-color:#F175A8!important;}.stream li.dcsns-vimeo .section-intro,.filter .f-vimeo a:hover, .wall-outer .dcsns-toolbar .filter .f-vimeo a.iso-active{background-color:#4EBAFF!important;}.stream li.dcsns-stumbleupon .section-intro,.filter .f-stumbleupon a:hover, .wall-outer .dcsns-toolbar .filter .f-stumbleupon a.iso-active{background-color:#EB4924!important;}.stream li.dcsns-deviantart .section-intro,.filter .f-deviantart a:hover, .wall-outer .dcsns-toolbar .filter .f-deviantart a.iso-active{background-color:#607365!important;}.stream li.dcsns-tumblr .section-intro,.filter .f-tumblr a:hover, .wall-outer .dcsns-toolbar .filter .f-tumblr a.iso-active{background-color:#385774!important;}.stream li.dcsns-instagram .section-intro,.filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:#413A33!important;}.wall-outer .dcsns-toolbar .filter li a {background:#777;}.dcwss.dc-wall .stream li {width: 226px!important; margin: 0px 15px 15px 0px!important;}</style>
</style>
@endsection

@section('after_scripts')

	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>

@endsection
