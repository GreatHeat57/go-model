@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30">
            <h1 class="prata">{{ ucWords(t('Welcome back')) }}</h1>
            <div class="divider mx-auto"></div>
        </div>
        
        @if(auth()->user()->profile->allow_search != 1)
            <?php $href = lurl(trans('routes.partner-profile-edit')); ?>
            <?php $label = t('click here'); ?>
            <?php $button = "<a href='$href' style='margin-right: 6px; margin-left: 6px; text-decoration: underline;  margin-top: 1px;'>$label</a>"; ?>

            <span class="text-center mt-20 mb-30 mx-lg-auto notes-zone dashboard-allow-search">{!! t("allow search false alert to client :button", ['button' => $button]) !!}</span>
        @endif

        <div class="mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="row">
            <!-- appliers -->
          
                <div class="col-lg-6 pb-40">
                    <div class="mb-30 text-center">
                        <h2 class="position-relative prata d-inline-block">{{ t('My ads') }}
                            @if(isset($countMyPosts) && $countMyPosts > 0)

                                <?php if( $countMyPosts > config('app.num_counter') ){ ?>
                                    <span class="msg-num dashboard">{{ config('app.num_counter').'+' }}</span>
                                <?php } else { ?>
                                    <span class="msg-num dashboard">{{ $countMyPosts }}</span>
                                <?php } ?>
                            @endif
                        </h2>
                        <div class="divider mx-auto"></div>
                    </div>
                      @if(!empty( $posts ) && count($posts) > 0 )
                        @foreach($posts as $k => $post)
                        <?php 

                            $applicationsCount = $post->jobApplications->count();
                            
                            $postUrl = lurl($post->uri);
                            
                            if (in_array($pagePath, ['pending-approval', 'archived'])) {
                                $postUrl = $postUrl . '?preview=1';
                            }

                            $iconPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';
                        ?>
                        <div class="row mx-0 bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-40 pl-30 mb-20">
                            <a href="{{ $post->uri }}" title="{{ t('View detail') }}"><span class="flag to-left-30 to-top-0 ongoing"></span></a>
                            <div class="col-md-6 pt-40 pb-20 px-0 bordered">
                                <span class="title" title="{{ mb_ucfirst($post->title) }}"><a href="{{ $postUrl }}"><span class="{{ $post->title }}">{{ mb_ucfirst(str_limit($post->title, config('constant.title_limit'))) }}</a></span>
                                <span class="overflow-hide">{{ str_limit( strip_tags($post->description), config('constant.title_limit') ) }}</span>
                                <div class="divider"></div>
                                <span class="posted">Date: {{ \App\Helpers\CommonHelper::getFormatedDate($post->end_application) }}</span>
                            </div>
                            <div class="col-md-6 px-0 pt-40 pl-md-4">
                                <!-- <span class="dark-grey2 posted mb-10">From</span> -->
                                <div class="d-flex justify-content-start align-items-center">
                                    <?php $applications = (!empty($post->postConversation) && count($post->postConversation) > 0)? count($post->postConversation) : '0'; ?>

                                    <div class="d-flex justify-content-start align-items-center">
                                        <a title="{{ t('applications') }}" href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">
                                            <span class="d-xl-inline-block rounded-circle card-appointment-number bold mr-10 bg-lavender">{{ $applicationsCount }}</span></a>
                                        <span class="title">
                                            <a title="{{ t('applications') }}" href="{{lurl('account/my-posts/'.$post->id.'/applications')}}"> {{ t('applications') }}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endforeach
                        
                    @else
                        <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30">
                            <h5 class="prata">{{ t('No records found') }}</h5>
                        </div>
                    @endif
                    @if(!empty( $posts ) && count($posts) > 0 )
                    <div class="text-center"><a href="{{ lurl('account/my-posts') }}" class="btn btn-white no-bg">{{ t('All My ads') }}</a></div>
                    @endif
                   
                </div>

                <div class="col-lg-6 pb-40">
                    
                    <div class="mb-30 text-center">
                        <h2 class="position-relative prata d-inline-block">{{t('Messages')}}
                            @if(isset($unreadMessages) && $unreadMessages > 0)
                                <?php if( $unreadMessages > config('app.num_counter') ){ ?>
                                    <span class="msg-num dashboard">{{ config('app.num_counter').'+' }}</span>
                                <?php } else { ?>
                                    <span class="msg-num dashboard">{{ $unreadMessages }}</span>
                                <?php } ?>
                            @endif
                        </h2>
                        <div class="divider mx-auto"></div>
                    </div>
                    
                    <?php
                    if (isset($conversations) && count($conversations) > 0) {

                        foreach ($conversations as $key => $conversation) {  
                            
                            // $unreadCount = count($conversation->convunreadmessages); 
                            // $lastConversation = $conversation->convmessages->first();
                            // $userName = $userProfile = $username = '';

                            //     if($lastConversation->from_user_id == auth()->user()->id){
                            //         $userProfile = $lastConversation->to_user->profile;
                            //         $full_name = $lastConversation->to_user->profile->full_name;
                            //         $userName = $lastConversation->to_user->username;
                            //     }else{
                            //         $userProfile = $lastConversation->from_user->profile;
                            //         $full_name = $lastConversation->from_user->profile->full_name;
                            //         $userName = $lastConversation->from_user->username;
                            //     }

                            //     $created_at =  $conversation->created_at;

                            //     if(isset($conversation->convmessages) && count($conversation->convmessages) > 0 ){
                            //         if(isset($conversation->convmessages[0]->created_at) && !empty($conversation->convmessages[0]->created_at)){
                            //             $created_at =  $conversation->convmessages[0]->created_at;
                            //         }
                            //     }

                            $unreadCount = (isset($conversation->msgcount)? $conversation->msgcount : 0 ); 
                            $created_at =  ($conversation->created_at)? $conversation->created_at : '';

                            $unreadClass = '';
                            $unreadClassRound = 'bg-green';

                            if($conversation->user_is_read != "" && $conversation->user_is_read == 0){
                                $unreadClass = 'unreaded';
                                $unreadClassRound = 'bg-red';
                            }

                            ?>
                         
                            <div class="row mx-0 bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20">
                <div class="mr-md-40 mb-lg-30 mb-xl-0">
                    <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <?php $userUrl = lurl(trans('routes.user').'/'.(($conversation->username)? $conversation->username : '')); ?>
                        @if(isset($conversation->logo) && Storage::exists($conversation->logo))
                            <a href="{{ $userUrl }}"><img src="{{ \Storage::url($conversation->logo) }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img full-width" /></a>
                        @else
                            <!-- <a href="{{  $userUrl }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a> -->
                             <a href="{{  $userUrl }}"><img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                             src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width fit-conver"/></a>
                        @endif
                    </div>
                </div>
                <div>
                    
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">{{t('Conversation')}}</span>
                    </div>
                    
                    <a href="{{ lurl('account/conversations/' . $conversation->parent_id . '/messages') }}" title="{{ (isset($conversation->title))? ucfirst($conversation->title) : '' }}"><span class="title">{{ (isset($conversation->title))? ucfirst(str_limit($conversation->title, config('constant.title_limit')))  : '' }}</span></a>
                    
                    <div class="modelcard-top">
                        <a href="{{ $userUrl }}">
                        <span class="d-inline-block">{{ str_limit($conversation->full_name, config('constant.title_limit')) }}</span></a>
                    </div>
                    
                    <div class="divider"></div>

                    <a href="{{ lurl('account/conversations/' . $conversation->parent_id . '/messages') }}"><p>{!! str_limit($conversation->message, config('constant.title_limit')) !!}</p></a>
                    
                    <div class="d-flex justify-content-start align-items-center">
                        <a title="{{ t('Messages') }}" href="{{ lurl('account/conversations/' . $conversation->parent_id . '/messages') }}"><span class="d-xl-inline-block rounded-circle bg-green card-appointment-number bold mr-10">{{ $unreadCount }}</span></a>
                        <span class="bold">{{ \App\Helpers\CommonHelper::getFormatedDate($created_at) }}</span>
                    </div>
                </div>
            </div>
                            <?php 
                        } ?>
                        <div class="text-center"><a href="{{ route('messages') }}" class="btn btn-white no-bg">{{t('all messages')}}</a></div>
                        <?php
                    }  else{ ?>
                         <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30">
                            <h5 class="prata">{{ t('No records found') }}</h5>
                        </div>
                   <?php  } 
                    ?>
                </div>
            
          

            <!-- find model -->
            <div class="col-lg-6 pb-40 pb-lg-0">
                <div class="mb-30 text-center">
                    <h2 class="position-relative prata d-inline-block">{{ t('New models near you') }}<!-- <span class="msg-num dashboard">23</span> --></h2>
                    <div class="divider mx-auto"></div>
                   <!--  <div class="position-absolute-md md-to-left-0 md-to-top-0">
                        <a href="javascript:void(0);" class="btn btn-white filters mr-20 mini-all"></a>
                    </div> -->
                </div>

                <?php /*
                {{ Form::open(array('url' => lurl('model-list'), 'method' => 'get', 'files' => true)) }}
                    @include('childs.model-search-filter')
                {{ Form::close() }} */ ?>

                <div class="row tab_content mb-40">
                    @if(!empty( $models ) && count($models) > 0 )
                        @foreach($models as $k => $model)
                        
                        <?php

                            $city = ($model->city) ? $model->city : '';
                            $country = ($model->country_name) ? $model->country_name : '';
                            $show_city_country = '';

                            if(!empty($city)){
                                $show_city_country = $city;
                            }
                            if(!empty($city) && !empty($country)){
                                $show_city_country .= ', ';
                            }
                            
                            $show_city_country .= $country;

                            // $profile = \App\Models\UserProfile::where('user_id', $model->id)->get();
                            // $profile = $profile[0] ? $profile[0] : array();
                            /* ** profile data is already present in model object. so no need to fetch seperately ** */
                            $profile = $model;
                            $logo = ($profile->logo) ? $profile->logo : '';
                        ?>
                            <div class="col-md-6 col-lg-12 col-xl-6 mb-30">
                                <div class="img-holder d-flex align-items-center justify-content-center position-relative" style="display: -webkit-box !important;">
                                    
                                    @if($logo !== "" && Storage::exists($logo))
                                        <img src="{{ \Storage::url($profile->logo) }}"  alt="{{ trans('metaTags.User') }}">&nbsp;
                                    @else
                                        <img  src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.User') }}">
                                    @endif
                                    <?php // $url = lurl(trans('routes.user').'/'.$user->username); ?>
                                    <a href="{{ lurl(trans('routes.user').'/'.$model->username) }}" class="btn btn-white insight signed position-absolute to-right to-top-20 mini-all" title="{{ t('View profile') }}"></a>
                                </div>
                                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                                        <span class="d-block">{{!empty($model->go_code)? $model->go_code: ''}}</span>
                                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                                        <span class="d-block">{{t('model')}}</span>
                                    </div>
                                    <span class="title" title="{{ t('View profile') }}"><a href="{{ lurl(trans('routes.user').'/'.$model->username) }}">{{ $model->full_name }}</a></span>
                                    <span>{{ $show_city_country }}</span>
                                    <div class="divider"></div>
                                    <p class="mb-70 overflow-hide">{{ str_limit(strip_tags($profile->description), 120) }}</p>
                                    <span class="info posted mb-30">
                                        <?php
                                        date_default_timezone_set(config('timezone.id'));
                                        $start  = date_create($model->last_login_at);
                                        $end    = date_create();
                                        
                                        $diff   = date_diff( $start, $end );
                                        
                                        echo t('Last Activity');
                                        echo ': ';
                                        if ($diff->y) {
                                            echo  $diff->y . ' ' . (($diff->y == 1) ? t('year ago'): t('years ago'));
                                        }
                                        else if ($diff->m) {
                                            echo  $diff->m . ' ' . (($diff->m == 1) ? t('month ago'): t('months ago'));
                                        }
                                        else if ($diff->d) {
                                            echo  $diff->d . ' ' . (($diff->d == 1) ? t('day ago'): t('days ago'));
                                        }
                                        else if ($diff->h) {
                                            echo  $diff->h . ' ' . (($diff->h == 1) ? t('hour ago'): t('hours ago'));
                                        }
                                        else if ($diff->i) {
                                            echo  $diff->i . ' ' . (($diff->i == 1) ? t('minute ago'): t('minutes ago'));
                                        }
                                        else if ($diff->s) {
                                            echo  $diff->s . ' ' . (($diff->s == 1) ? t('second ago'): t('seconds ago'));
                                        }
                                        else {
                                            echo t('never seen');
                                        }   
                                    ?>
                                    </span>
                                    <!-- <div class="d-flex justify-content-end">
                                        <div class="position-relative">
                                            <a href="#" class="btn btn-success more mr-20 mini-all dropdown-main"  data-content="more-dropdown-1"></a>
                                            <div class="bg-white box-shadow py-10 px-30 dropdown-content" data-content="more-dropdown-1">
                                                <a href="#" class="d-block f-15 pb-10 mb-10 bb-grey2">View profile</a>
                                                <a href="#" class="d-block f-15 pb-10 mb-10 bb-grey2">Sedcard download</a>
                                                <a href="#" class="d-block f-15 pb-10 mb-10 bb-grey2">Portfolio download</a>
                                                <a href="#" class="d-block f-15 pb-10 mb-10 bb-grey2">Invite to job</a>
                                                <a href="#" class="d-block f-15">Add to favorites</a>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-white favorite active mini-all"></a>
                                    </div> -->
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30">
                            <h5 class="prata">{{ t('No records found') }}</h5>
                        </div>
                    @endif
                </div>
                @if(!empty( $models ) && count($models) > 0 )
                    <div class="text-center"><a href="{{ lurl(trans('routes.model-list')) }}" class="btn btn-white no-bg">{{ t('Find model') }}</a>
                @endif
                </div>
            </div>

            <!-- now on gomodels -->
            <div class="col-lg-6 pb-40 pb-lg-0"  style="position: relative;">
                <div class="text-center">
                    <h2 class="position-relative prata d-inline-block">{{ t('Now on Gomodels') }}</h2>
                    <div class="divider mx-auto"></div>
                </div>
                <div class="row grid mb-40" id="socialstream-section">
                    <div class="col-md-12 col-xl-12 col-sm-12 position-relative">
                        <div class="wall-outer mb-40">
                            <div id="social-stream" class="dc-wall col-lg-12 dcwss modern light"></div>
                        </div>
                        <!-- <div class="text-center full-width"><a href="{{ route('social') }}" class="btn btn-white no-bg">{{ t('more post')}}</a></div> -->
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('childs.bottom-bar')
@endsection


@section('after_scripts')
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
                url: "{{ url('account/social/facebook') }}",
                id: "{{ config('app.facebook_page_id') }}",
                intro: "Posted",
                comments: 3,
                image_width: 6,
                feed: "feed",
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
        days: 2,
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

    $(window).on("load", function() {
    
        // var result = $(".wall-outer").height();
        $('.wall-outer').append('<div class="text-center full-width" id="more-social-post" style="padding-bottom: 100px;"><a href="<?php echo route('social') ?>" class="btn btn-white no-bg"><?php echo  t('more post'); ?></a></div>');
    });

});
</script>
<style type="text/css">
    .stream li.dcsns-twitter .section-intro,.filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:#4ec2dc!important;}.stream li.dcsns-facebook .section-intro,.filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:#3b5998!important;}.stream li.dcsns-google .section-intro,.filter .f-google a:hover, .wall-outer .dcsns-toolbar .filter .f-google a.iso-active{background-color:#2d2d2d!important;}.stream li.dcsns-rss .section-intro,.filter .f-rss a:hover, .wall-outer .dcsns-toolbar .filter .f-rss a.iso-active{background-color:#FF9800!important;}.stream li.dcsns-flickr .section-intro,.filter .f-flickr a:hover, .wall-outer .dcsns-toolbar .filter .f-flickr a.iso-active{background-color:#f90784!important;}.stream li.dcsns-delicious .section-intro,.filter .f-delicious a:hover, .wall-outer .dcsns-toolbar .filter .f-delicious a.iso-active{background-color:#3271CB!important;}.stream li.dcsns-youtube .section-intro,.filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:#DF1F1C!important;}.stream li.dcsns-pinterest .section-intro,.filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:#CB2528!important;}.stream li.dcsns-lastfm .section-intro,.filter .f-lastfm a:hover, .wall-outer .dcsns-toolbar .filter .f-lastfm a.iso-active{background-color:#C90E12!important;}.stream li.dcsns-dribbble .section-intro,.filter .f-dribbble a:hover, .wall-outer .dcsns-toolbar .filter .f-dribbble a.iso-active{background-color:#F175A8!important;}.stream li.dcsns-vimeo .section-intro,.filter .f-vimeo a:hover, .wall-outer .dcsns-toolbar .filter .f-vimeo a.iso-active{background-color:#4EBAFF!important;}.stream li.dcsns-stumbleupon .section-intro,.filter .f-stumbleupon a:hover, .wall-outer .dcsns-toolbar .filter .f-stumbleupon a.iso-active{background-color:#EB4924!important;}.stream li.dcsns-deviantart .section-intro,.filter .f-deviantart a:hover, .wall-outer .dcsns-toolbar .filter .f-deviantart a.iso-active{background-color:#607365!important;}.stream li.dcsns-tumblr .section-intro,.filter .f-tumblr a:hover, .wall-outer .dcsns-toolbar .filter .f-tumblr a.iso-active{background-color:#385774!important;}.stream li.dcsns-instagram .section-intro,.filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:#413A33!important;}.dcwss.dc-wall .stream li {width: 425px!important; margin: 0px 15px 15px 0px!important;}.wall-outer #dcsns-filter.dc-center{padding-left: 0% !important;margin-left: 0px !important;padding-right: 0%;}.stream li.dcsns-facebook .section-intro, .filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:transparent !important; }.stream li.dcsns-twitter .section-intro, .filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:transparent !important;}.stream li.dcsns-youtube .section-intro, .filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:transparent !important;}.stream li.dcsns-pinterest .section-intro, .filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:transparent !important;}.stream li.dcsns-instagram .section-intro, .filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:transparent !important;}.wall-outer .dcsns-toolbar .filter li a{padding: 10px 16px;}#socialstream-section{height:auto !important;}.wall-outer{max-height: 1000px;}

        .wall-outer .dcsns-toolbar .filter li a{padding: 10px 27px; }
        span.socicon.socicon-facebook { color: #3b5998; } span.socicon.socicon-twitter{ color: #55acee;  } span.socicon.socicon-youtube { color: #cd201f; } span.socicon.socicon-pinterest{ color: #bd081c; } span.socicon.socicon-instagram { color: #3f729b;  }

        @media (min-width: 768px) and (max-width: 1024px) {
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 0px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: auto; padding: 10px 36px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important;  }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 100px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; }
        }

        /*Portrait*/ 
        @media only screen and (min-width: 1024px) and (orientation: portrait) { 
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 0px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: 100%; padding: 10px 20px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important;  }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 0px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; }
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
@endsection