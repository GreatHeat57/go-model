<aside class="pb-25 blog-right-section">
    @isset($allCategories)
        @if (count($allCategories) > 0)
            <div class="blog-tag">
                <h4 class="no-padding-top">{{ t('Magazine Categories') }}</h4>
                <div class="rows">
                    <div class="row tagcloud">
                        @foreach ($allCategories as $category)
                            <?php $cat_attr = ['countryCode' => config('country.icode'), 'slug' =>  $category->slug]; ?>

                                <a href="{{ lurl(trans('routes.v-blog-category', $cat_attr), $cat_attr) }}">{!! $category->name !!}</a>
                                <?php /*
                                    <!-- <li><a href="{{ lurl(trans('routes.v-blog-category', $cat_attr), $cat_attr) }}">{!! $category->name !!}</a></li> -->
                                */ ?>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endisset
    @isset($allTags)
        @if (count($allTags) > 0)
            <div class="blog-tag">
                <h4 class="no-padding-top">{{ t('Blog Tags') }}</h4>
                <div class="rows">
                    <div class="row tagcloud">
                    @foreach ($allTags as $blogTag)
                        <?php $p_attr = ['countryCode' => config('country.icode'), 'slug' =>  $blogTag->slug]; ?>
                    
                        <a href="{{ lurl(trans('routes.v-magazine-tag', $p_attr), $p_attr) }}">{!! $blogTag->tag !!}</a>
                    @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endisset
    @isset($popularBlogs)
        @if (count($popularBlogs) > 0)
            <div class="most-popular">
                <h4>Most popular</h4>
                <div class="rows">
                    @foreach ($popularBlogs as $popularBlog)
                        <?php  
                            
                            $atl = "";

                            $popularBlogs_image = ($popularBlog->picture) ? $popularBlog->picture : '';
                            $popular_cropped_image ="";
                            if($popularBlogs_image != "")
                            {
                                $image_details= pathinfo(public_path('uploads').'/'.$popularBlogs_image);
                                

                                if(isset($image_details['filename']) && !empty($image_details['filename'])){
                                    $atl = $image_details['filename'];
                                }

                                $popular_cropped_image = str_replace('uploads/','',substr($image_details['dirname'] , strpos($image_details['dirname'], 'uploads/')))."/".$image_details['filename'].'-'.config('app.blog_right_image').'.'.$image_details['extension'];
                            }
                        ?>
                        <?php $p_attr = ['countryCode' => config('country.icode'), 'slug' =>  $popularBlog->slug]; ?>
                        <div class="row">
                            <a href="{{ lurl(trans('routes.v-magazine', $p_attr), $p_attr) }}">
                                
                                <?php /*
                                    @if($popularBlogs_image !== "" && file_exists(public_path('uploads').'/'.$popularBlogs_image))
                                        <img src="{{ \Storage::url($popularBlog->picture) }}" alt="{{ trans('metaTags.img_modeling_agency') }}" class="thumb">
                                    @else
                                        <img src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="" class="thumb" >
                                    @endif
                                */ ?>

                                @if($popular_cropped_image !== "" && file_exists(public_path('uploads').'/'.$popular_cropped_image))

                                    <img data-src="{{ url(config('app.cloud_url'). '/uploads/'.$popular_cropped_image) }}" alt="{{ ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$popularBlog->name)) }}" class="thumb lazyload">

                                @elseif($popularBlogs_image !== "" && file_exists(public_path('uploads').'/'.$popularBlogs_image))
                                    <img data-src="{{ url(config('app.cloud_url'). '/uploads/'.$popularBlog->picture) }}" alt="{{ ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$popularBlog->name)) }}" class="thumb lazyload">                           
                                @else
                                    <img data-src="{{ URL::to(config('app.cloud_url') . '/images/icons/blog_listing_small_default.jpg') }}" alt="{{ ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$popularBlog->name)) }}" class="thumb lazyload" >
                                @endif
                            </a>
                            <h5 class="magazine_most_popular"><a href="{{ lurl(trans('routes.v-magazine', $p_attr), $p_attr) }}">{!! $popularBlog->name !!}</a></h5>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endisset 
    <?php /*  
       <!--  <div class="follow-us">
            <h4>Follow us</h4>
            <ul>
                <li><a target="_blank" href="{{ config('app.go_model_facebook') }}" class="facebook">Facebook</a></li>
                <li><a target="_blank" href="{{ config('app.go_model_instagram') }}" class="instagram">Instagram</a></li>
                <li><a target="_blank" href="{{ config('app.go_model_twiiter') }}" class="twitter">Twitter</a></li>
                <li><a target="_blank" href="{{ config('app.go_model_youtube') }}" class="youtube">Youtube</a></li>
            </ul>
        </div> -->

        <!-- <div class="items dc-wall blog-social">
            <div class="item">
                <h4>Instagram</h4>
                <div class="img">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/aside_instagram.jpg') }}" alt="Instagram" />
                </div>
                <p><span>Cathy, 21</span> #gomodels #modelling</p>
            </div>

            <div class="item">
                <h4>Youtube</h4>
                <div class="img">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/aside_youtube.jpg') }}" alt="Youtube" />
                </div>
                <p>Watch our behind the scenes video</p>
            </div>

            <div class="item">
                <h4>Pinterest</h4>
                <div class="img">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/aside_pinterest.jpg') }}" alt="Pinterest" />
                </div>
                <p>Pinterest fashion inspiration with go models</p>
            </div>

            <div class="item">
                <h4>Twitter</h4>
                <div class="img">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/aside_twitter.jpg') }}" alt="Twitter" />
                </div>
                <p>Twitter laoreet nunc semper ornare. </p>
            </div>
        </div> -->
    */ ?>
</aside>
@section('page-script')
<?php /*
<!-- <link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/inc/layout.css') }}" media="all" />
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
                url: "{{ url('account/social/facebook') }}",
                id: "{{ config('app.facebook_page_id') }}",
                intro: "Posted",
                comments: 3,
                image_width: 6,
                feed: "feed",
                out: "thumb,title"
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
                out: "thumb,text,user"
            },
            instagram: {
                id: "!4582181010",
                intro: "Posted",
                search: "Search",
                out: "thumb,text,user",
                accessToken: "4582181010.1677ed0.0bf900fe75164174acf65478c12a1c85",
                redirectUrl: "https://go-models.com",
                clientId: "0def877b5dc54bd0949aa9166595ef48"
            }
        },
        remove: "",
        max: "limit",
        days: 10,
        limit: 1,
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
            $(".items").dcSocialStream(config);
        });
    } else {
        $(".items").dcSocialStream(config);
    }


    // $('#dcsns-filter .f-facebook a').html('Facebook');
    // $('#dcsns-filter .f-twitter a').html('Twitter');
    // $('#dcsns-filter .f-youtube a').html('Youtube');
    // $('#dcsns-filter .f-pinterest a').html('Pinterest');
    // $('#dcsns-filter .f-instagram a').html('Instagram');
    // $('#dcsns-filter').addClass('d-none d-md-flex justify-content-center');
});
</script>
<style type="text/css">
    .stream li.dcsns-twitter .section-intro,.filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:#4ec2dc!important;}.stream li.dcsns-facebook .section-intro,.filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:#3b5998!important;}.stream li.dcsns-google .section-intro,.filter .f-google a:hover, .wall-outer .dcsns-toolbar .filter .f-google a.iso-active{background-color:#2d2d2d!important;}.stream li.dcsns-rss .section-intro,.filter .f-rss a:hover, .wall-outer .dcsns-toolbar .filter .f-rss a.iso-active{background-color:#FF9800!important;}.stream li.dcsns-flickr .section-intro,.filter .f-flickr a:hover, .wall-outer .dcsns-toolbar .filter .f-flickr a.iso-active{background-color:#f90784!important;}.stream li.dcsns-delicious .section-intro,.filter .f-delicious a:hover, .wall-outer .dcsns-toolbar .filter .f-delicious a.iso-active{background-color:#3271CB!important;}.stream li.dcsns-youtube .section-intro,.filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:#DF1F1C!important;}.stream li.dcsns-pinterest .section-intro,.filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:#CB2528!important;}.stream li.dcsns-lastfm .section-intro,.filter .f-lastfm a:hover, .wall-outer .dcsns-toolbar .filter .f-lastfm a.iso-active{background-color:#C90E12!important;}.stream li.dcsns-dribbble .section-intro,.filter .f-dribbble a:hover, .wall-outer .dcsns-toolbar .filter .f-dribbble a.iso-active{background-color:#F175A8!important;}.stream li.dcsns-vimeo .section-intro,.filter .f-vimeo a:hover, .wall-outer .dcsns-toolbar .filter .f-vimeo a.iso-active{background-color:#4EBAFF!important;}.stream li.dcsns-stumbleupon .section-intro,.filter .f-stumbleupon a:hover, .wall-outer .dcsns-toolbar .filter .f-stumbleupon a.iso-active{background-color:#EB4924!important;}.stream li.dcsns-deviantart .section-intro,.filter .f-deviantart a:hover, .wall-outer .dcsns-toolbar .filter .f-deviantart a.iso-active{background-color:#607365!important;}.stream li.dcsns-tumblr .section-intro,.filter .f-tumblr a:hover, .wall-outer .dcsns-toolbar .filter .f-tumblr a.iso-active{background-color:#385774!important;}.stream li.dcsns-instagram .section-intro,.filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:#413A33!important;}.dcwss.dc-wall .stream li {width: 425px ; margin: 0px 15px 15px 0px!important;}.wall-outer #dcsns-filter.dc-center{padding-left: 0% !important;margin-left: 0px !important;padding-right: 0%;}.stream li.dcsns-facebook .section-intro, .filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:transparent !important; }.stream li.dcsns-twitter .section-intro, .filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:transparent !important;}.stream li.dcsns-youtube .section-intro, .filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:transparent !important;}.stream li.dcsns-pinterest .section-intro, .filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:transparent !important;}.stream li.dcsns-instagram .section-intro, .filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:transparent !important;}

        .wall-outer .dcsns-toolbar .filter li a{padding: 10px 72px; } span.socicon.socicon-facebook { color: #3b5998; } span.socicon.socicon-twitter{ color: #55acee;  } span.socicon.socicon-youtube { color: #cd201f; } span.socicon.socicon-pinterest{ color: #bd081c; } span.socicon.socicon-instagram { color: #3f729b;  }

        @media (min-width: 768px) and (max-width: 1024px) {
            .dcwss.dc-wall .stream li { 
               width: 500px; margin: 0px 15px 15px 0px !important; 
            } 
            .wall-outer .dcsns-toolbar .filter li a{ width: auto; padding: 10px 36px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important;  }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 100px; }
            /*.wall-outer .dcsns-toolbar .filter li{ padding: 14px; }
        }
        @media (min-width: 320px) and (max-width: 480px) { 
            .dcwss.dc-wall .stream li { 
                width: auto; margin: 0px 15px 15px 0px!important; 
            } 
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 18px; }
            .dcwss.dc-wall.modern.light .stream li { max-width: 100%;  }
        }
        @media(max-width: 320px){
            .wall-outer .dcsns-toolbar .filter li a{
                padding: 10px 15px;
            }
        }

        @media(max-width:768px){
          /*.wall-outer #dcsns-filter.dc-center {
            padding-left: 0% !important;
            padding-right: 0% !important;
            height: auto !important;
          }
          .wall-outer .dcsns-toolbar .filter li a{
            line-height: 22px !important;
            margin:3px;
            padding:10px 9px !important;
          }
          .wall-outer .dcsns-toolbar .filter .link-all{
            padding: 11px 7px 4px 7px !important;
          }
           .wall-outer .dcsns-toolbar #dcsns-filter li a.iso-active:after{
            display: block;
            content: " ";
            width: 100%;
            height: 4px;
            background: #b8c7f1;
           }*/

           /*.dcwss.dc-wall{
            overflow: hidden;
           }
        }
</style> -->
*/ ?>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
@endsection