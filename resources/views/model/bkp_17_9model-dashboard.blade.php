@extends('layouts.logged_in.app-model')
@section('content')
    <div class="container px-0 pt-40 pb-60 mb-20">
        <div class="text-center mb-30">
            <h1 class="prata">{{ ucWords(t('Welcome back')) }}</h1>
            <div class="divider mx-auto"></div>
        </div>
       
        @if(auth()->user()->profile->allow_search != 1)
            <?php $href = lurl(trans('routes.work-settings')); ?>
            <?php $label = t('click here'); ?>
            <?php $button = "<a href='$href' style='margin-right: 6px; margin-left: 6px; text-decoration: underline;  margin-top: 1px;'>$label</a>"; ?>

            <span class="text-center mb-30 mx-lg-auto notes-zone dashboard-allow-search">{!! t("allow search false alert to model :button", ['button' => $button]) !!}</span>
        @endif
        
        <div class="mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="row">
            <div class="col-lg-6 pb-40">
                <div class="mb-30 text-center">
                    <h2 class="position-relative prata d-inline-block">{{t('invitations')}}
                        @if( isset($invitations) && count($invitations) > 0 )
                            <?php if( $invitations_count > config('app.num_counter') ){ ?>
                                <span class="msg-num dashboard">{{ config('app.num_counter').'+' }}</span>
                            <?php } else { ?>
                                <span class="msg-num dashboard">{{ $invitations_count }}</span>
                            <?php } ?>
                        @endif
                    </h2>
                    <div class="divider mx-auto"></div>
                </div>
@if(!empty($invitations) && count($invitations) > 0)
    @foreach($invitations as $invitation)
        <?php

        $fromUser = $invitation->from_user;
        
        $fromUserProfilePic = URL::to(config('app.cloud_url').'/images/user.png');
        
        if(isset($fromUser->profile->logo) && Storage::exists($fromUser->profile->logo)){
            $fromUserProfilePic = \Storage::url($fromUser->profile->logo);
        }
        
        if(isset($invitation->post) && isset($invitation->post->uri) && isset($invitation->post->title)){$job_url = lurl($invitation->post->uri);
            $job_title = $invitation->post->title;
        }else{
            $job_url = "";
            $job_title = "";
        }

        $tag = "ongoing";
        if($invitation->invitation_status != ""){
            switch ($invitation->invitation_status) {
                case '0': $tag = "ongoing";  break;
                case '1': $tag = "applied";  break;
                case '2': $tag = "rejected";  break;
                default: $tag = "ongoing"; break;
            }
        }

?>
        <div class="row mx-0 bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-40 pl-30 mb-20">
            <a href="{{url($job_url)}}" class=""><span class="flag to-left-30 to-top-0 {{ $tag }}"></span></a>
            <div class="col-md-6 pt-40 pb-20 px-0 bordered">
                <a href="{{ $job_url }}"><span class="title">{{ mb_ucfirst(str_limit($job_title, config('constant.title_limit'))) }}</span></a>
                <div class="divider"></div>
                <span class="mb-20 overflow-hide">{!! str_limit(strCleaner($invitation->post->description), config('constant.description_limit')) !!}</span>
                <span class="posted">{{ \App\Helpers\CommonHelper::getFormatedDate($invitation->created_at) }}</span> 
            </div>
            <div class="col-md-6 px-0 pt-40 pl-md-4">
                <span class="dark-grey2 posted mb-10">{{ t('From') }}</span>
                <?php $url = lurl(trans('routes.user').'/'. $fromUser->username); ?>
                <a href="{{ $url }} ">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            <img srcset="{{  $fromUserProfilePic }},
                                 {{ $fromUserProfilePic }} 2x,
                                 {{ $fromUserProfilePic }} 3x"
                                 src="{{ $fromUserProfilePic }}" alt="{{ t('user') }}"
                                 class="from-img full-width dashboard-logo-img fit-conver"/>
                        </div>
                        <span class="title">{{ $invitation->from_name }} </span>
                    </div>
                </a>
                <div class="col-md-8 pt-40 pb-20 px-0 ">
                    <span class="title d-flex justify-content-start align-items-center">
                        <a href="{{url('/account/invtresp/1/'.$invitation->id)}}" class="btn-invitation btn-applied mr-20" title="{{ t('Accept') }}"></a>&nbsp;
                        <a href="{{url('/account/invtresp/2/'.$invitation->id)}}" class="btn-invitation btn-rejected" title="{{ t('Reject') }}"></a>
                    </span>
                    <span class="mt-20 mb-20">{{ t('Partner has sent invitation') }}</span>
                </div>
            </div>
        </div>
    @endforeach
    <?php // $notification_url = trans('routes.v-notifications', ['status' => 'all']);?>
    <div class="text-center"><a href="{{ lurl(trans('routes.notifications', ['countryCode' => config('country.icode')])) }}" class="btn btn-white no-bg">{{t('all invitations')}}</a></div>
@else
  <!--  <div class="row mx-0 bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-40 pl-30 mb-20">
    <h5 class="prata">{{-- t('No invitation found') --}}</h5>
   </div> -->

    <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30" wfd-id="130">
        <h5 class="prata">{{ t('No invitation found') }}</h5>
    </div>
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

            // if($lastConversation->from_user_id == auth()->user()->id){
            //     $userProfile = $lastConversation->to_user->profile;
            //     $full_name = $lastConversation->to_user->profile->full_name;
            //     $userName = $lastConversation->to_user->username;
            // }else{
            //     $userProfile = $lastConversation->from_user->profile;
            //     $full_name = $lastConversation->from_user->profile->full_name;
            //     $userName = $lastConversation->from_user->username;
            // }

            // $created_at =  $conversation->created_at;

            // if(isset($conversation->convmessages) && count($conversation->convmessages) > 0 ){
            //     if(isset($conversation->convmessages[0]->created_at) && !empty($conversation->convmessages[0]->created_at)){
            //         $created_at =  $conversation->convmessages[0]->created_at;
            //     }
            // }

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
                        <?php $userUrl = lurl(trans('routes.user').'/'.(($conversation->username)? $conversation->username : ''));
                         ?>
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
        <div class="bg-white text-center box-shadow position-relative  pt-40 pr-20 pb-20 pl-30 mb-30" wfd-id="130">
            <h5 class="prata">{{ t('No message found') }}</h5>
        </div>
   <?php  } 
    ?>
    
</div>
<div class="col-lg-6 pb-40 pb-lg-0">
    <div class="mb-30 text-center">
        <h2 class="position-relative prata d-inline-block">{{t('Latest jobs near you')}}
            @if (isset($latest_jobs['paginator']) and $latest_jobs['paginator']->getCollection()->count() > 0)
                <span class="msg-num dashboard">{{ $latest_jobs['paginator']->total() }}</span>
            @endif
        </h2>
        <div class="divider mx-auto"></div>
    </div>
    @if (isset($latest_jobs['paginator']) and $latest_jobs['paginator']->getCollection()->count() > 0)
        <?php 

        foreach ($latest_jobs['paginator']->getCollection() as $key => $post) { ?>
           <div class="bg-white box-shadow pt-40 pr-20 pb-20 pl-30 mb-20 position-relative">
                
                <a href="{{ lurl($post->uri) }}" title="{{ t('View detail') }}"><span class="flag to-left to-top-0 ongoing"></span></a>

                <div class="d-flex justify-content-center align-items-center mb-sm-30 border bg-lavender company-img-holder">
                    <a href="javascript:void(0);" style="cursor: default;">
                        @if($post->company_logo !== "" && $post->company_logo !== null && Storage::exists($post->company_logo))

                            <img src="{{ \Storage::url($post->company_logo) }}" alt="{{$post->company_name }}">
                        @else
                            <img srcset="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }},
                                {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@2x.png') }} 2x,
                                {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png@3x') }} 3x"
                                src="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.User') }}" class="from-img nopic"/>
                        @endif
                    </a>
                </div>


                <br/>
                <div class="position-relative">
                    <a href="{{ lurl($post->uri) }}" title="{{ mb_ucfirst($post->title) }}"><span class="title">{{ mb_ucfirst(str_limit($post->title, config('constant.title_limit'))) }}</span></a>

                    @if( isset($post_type) && !empty($post_type) && isset($post_type[$post->post_type_id]) && !empty($post_type[$post->post_type_id]))
                        <span>{{ $post_type[$post->post_type_id] }}</span>
                    @endif
                    
                    <!-- <span>Jobart, Jobart</span> -->
                    <div class="divider"></div>
                    <p class="mb-20 overflow-hide">{!! str_limit(strCleaner($post->description), config('constant.description_limit')) !!}</p>
                    
                    <?php

                        $currency_symbol = isset($post->html_entity)? $post->html_entity : isset($post->font_arial)? $post->font_arial : config('currency.symbol');

                        $salary_min = (isset($post->salary_min))? $post->salary_min : '';
                        $salary_max = (isset($post->salary_max))? $post->salary_max : '';
                    ?>

                    @if($salary_max !== '' || $salary_min !== '')
                        <span class="info currency mb-10"> {{ \App\Helpers\Number::money($salary_min, $currency_symbol) }} - {{ \App\Helpers\Number::money($salary_max, $currency_symbol) }}

                            @if($post->negotiable)
                                {{ t('Negotiable') }}
                            @endif 
                        </span>
                    @else
                        <span>&nbsp;</span>
                    @endif

                    @if($salary_max == '' && $salary_min == '' && $post->negotiable)
                        <span class="info currency mb-10">{{ \App\Helpers\Number::money('') }} - {{ t('Negotiable') }}</span>
                    @endif

                    <span class="info city mb-10">

                        <?php 
                            $city = ($post->city) ? $post->city : '';
                            $country = ($post->country_name) ? $post->country_name : '';
                            $show_city_country = '';

                            if(!empty($city)){
                                $show_city_country = $city;
                            }
                            if(!empty($city) && !empty($country)){
                                $show_city_country .= ', ';
                            }
                            echo $show_city_country .= $country;
                        ?>
                    </span>
                    <span class="info appointment mb-10">{{ \App\Helpers\CommonHelper::getFormatedDate($post->end_application) }}</span>
                    <span class="info posted">
                        <?php
                        date_default_timezone_set(config('timezone.id'));
                        $start  = date_create($post->created_at);
                        $end    = date_create();
                        
                        $diff   = date_diff( $start, $end );
                        
                        echo t('Posted On');
                        echo ' ';
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
                    @if (auth()->check())
                        <?php if(in_array($post->id, $favourite_posts)){ ?>
                            <a href="javascript:void(0);" class="make-favorite active btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" id="saved-{{ $post->id}}" data-post-id="{{ $post->id }}" data-segment-id="" title="{{ t('Remove from Favorite') }}"></a>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" data-post-id="{{ $post->id }}" id="save-{{ $post->id }}" data-segment-id="" title="{{ t('Add to Favorite') }}"></a>
                        <?php } ?>
                    @else
                        <a href="javascript:void(0);" id="save-{{ $post->id }}" class="make-favorite btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" data-post-id="{{ $post->id }}" data-segment-id="" title="{{ t('Add to Favorite') }}"></a>
                    @endif    
                </div>
            </div>
            <?php
        } ?>
    @else
        <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30" wfd-id="130">
            <h5 class="prata">{{ t('No jobs found') }}</h5>
        </div>
    @endif
            @if (isset($latest_jobs['paginator']) and $latest_jobs['paginator']->getCollection()->count() > 0)
                <?php $attr = ['countryCode' => config('country.icode')];?>
                <div class="text-center"><a href="{{ lurl(trans('routes.search', $attr), $attr) }}" class="btn btn-white no-bg">{{ t('Browse Jobs') }}</a>
                </div>
            @endif
            </div>
            <div class="col-lg-6 pb-40 pb-lg-0" style="position: relative; height: 1100px !important;">
                <div class="text-center">
                    <h2 class="position-relative prata d-inline-block">{{t('Now on Gomodels')}}</h2>
                    <div class="divider mx-auto"></div>
                </div>
                <div class="row grid mb-40" id="socialstream-section">
                    <div class="col-md-12 col-xl-12 position-relative">
                        <div class="wall-outer mb-20">
                            <div id="social-stream" class="dc-wall col-lg-12 dcwss modern light"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('childs.bottom-bar')
@endsection
@section('page-script')
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
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
});

$(window).on("load", function() {
    
    // var result = $(".wall-outer").height();
    $('.wall-outer').append('<div class="text-center full-width" id="more-social-post" style="padding-bottom: 100px;"><a href="<?php echo route('social') ?>" class="btn btn-white no-bg"><?php echo  t('more post'); ?></a></div>');
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