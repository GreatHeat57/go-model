<div class="container pt-40 px-0 w-xl-1220">
    <h1 class="text-center prata">{{ ucWords(t('model profile')) }}</h1>
    <div class="text-center mb-30 position-relative">
        <div class="divider mx-auto"></div>
        
        @if(Auth::user()->user_type_id !== '2')
            <?php /*<p>{{ t('Your profile, as the employers see') }}</p> */?>
            <p>&nbsp;</p>
        @else
            <p></p>
        @endif

        
        @if(Auth::user()->user_type_id !== config('constant.partner_type_id') && Auth::user()->id == $profile->user_id)
            <a href="{{ lurl(trans('routes.profile-edit')) }}" class="btn btn-default edit_grey mini-under-desktop position-absolute-md md-to-right-0 md-to-top-25">{{t('Edit')}}</a>
        @endif

    </div>
        @if(Auth::user()->user_type_id !== config('constant.partner_type_id') && (Auth::user()->id == $profile->user_id) && $profile->allow_search == 0)
            
            <?php $href = lurl(trans('routes.work-settings')); ?>
            <?php $label = t('click here'); ?>
            <?php $button = "<a href='$href' style='margin-right: 6px; margin-left: 6px; text-decoration: underline;  margin-top: 1px;'>$label</a>"; ?>

            <span class="text-center mt-20 mb-30 mx-lg-auto notes-zone dashboard-allow-search">{!! t("allow search false alert to model :button", ['button' => $button]) !!}</span>

        @endif
</div>
<div class="py-40 px-20-under-desktop px-lg-38 px-xl-65 mx-m13 mx-sm-0 public-profile-top" @if(!empty($profile->cover) && Storage::exists($profile->cover)) style="background: url({{ \Storage::url($profile->cover) }}); background-position: center;background-repeat: no-repeat;background-size: cover;" @endif>
    <div class="wrapper-ppt"></div>
    <div class="d-md-flex justify-content-md-between justify-content-lg-center">
        <div class="mr-md-40 mb-lg-30 mb-xl-0">
            <!-- <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border mx-xs-auto bg-lavender msg-img-holder big"> -->

            <div class="d-flex justify-content-center align-items-center mb-sm-30  border mx-xs-auto bg-lavender msg-img-holder big">
                <!-- <img srcset="{{ URL::to('images/avatars/avatar-photo-upload.png') }},
                                     {{ URL::to('images/avatars/avatar-photo-upload@2x.png') }} 2x,
                                     {{ URL::to('images/avatars/avatar-photo-upload@3x.png') }} 3x"
                     src="{{ URL::to('images/avatars/avatar-photo-upload.png') }}" alt="Go Models" class="from-img full-width"/> -->
                            @if (!empty($profile->logo) && Storage::exists($profile->logo))
                                
                                <?php /*

                                <!-- <img class="logoImage from-img full-width" src="{{ \Storage::url($profile->logo) }}" alt="{{ trans('metaTags.User') }}"> -->

                                */?>

                                <img srcset="{{ \Storage::url($user->profile->logo) }},
                                            {{ \Storage::url($user->profile->logo) }} 2x,
                                            {{ \Storage::url($user->profile->logo) }} 3x"
                                            src="{{ \Storage::url($user->profile->logo) }}" alt="{{ trans('metaTags.User') }}" class="logoImage from-img full-width fit-contain"/>
                            @elseif (!empty($gravatar))
                                
                                <img class="logoImage from-img full-width fit-conver" src="{{ $gravatar }}" alt="{{ trans('metaTags.User') }}">
                            @else
                                
                                <img class="logoImage from-img full-width fit-conver" src="{{ url(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.User') }}">
                            @endif
            </div>
        </div>

        <?php $show_category = ''; $selected_cat = ''; ?>
           
            @if(count($modelCategories) > 0)
                @foreach ($modelCategories as $cat)
                    @if($cat->parent_id == $category)
                        <?php  $show_category = $cat->name; ?>
                    @endif
                @endforeach
            @endif
        
        <div class="d-lg-flex justify-content-lg-between flex-lg-grow-2">
            <div class="text-center text-md-left mr-lg-70 w-lg-460">
                <div class="modelcard-top text-uppercase mb-30 f-12">
                    <p>
                        {{!empty($profile->go_code)? $profile->go_code : ''}}
 
                        @if(!empty($show_category))
                            <span class="d-inline-block bullet rounded-circle bg-lavender mx-2"></span>
                            {{ rtrim($show_category, ", ") }}
                        @endif

                        @if(isset($user) && $user->gender_id == config('constant.gender_male'))
                        <span class="d-inline-block bullet rounded-circle bg-lavender mx-2"></span>
                        {{ t('Male') }}
                        @else
                        <span class="d-inline-block bullet rounded-circle bg-lavender mx-2"></span>
                        {{ t('Female') }}
                        @endif
                    </p>
                </div>

                <span class="title">{{ ucfirst($first_name) }}</span>
                <?php /* 
                @if(!empty($parent_name))
                <span>{{ ucfirst($parent_name) }}</span>
                @endif
                */ ?>
                
                <div class="modelcard-top">
                    <p>
                        <?php

                            $show_city_country = '';
                            
                            if(!empty($city)){
                               $show_city_country = $city;  
                            } 
                            if(!empty($city) && !empty($country)){
                                $show_city_country .= ', ';
                            }
                             
                            $show_city_country .= $country;
                        ?>
                        
                        {{ $show_city_country }}

                        <?php
                            $age = "";
                            
                            if( Auth::check() ){
                                $from = new \DateTime($profile->birth_day);
                                $to = new \DateTime('today');

                                if($from < $to) {
                                    if($from->diff($to)->y > 0 ){
                                        $y = $from->diff($to)->y;
                                        $age =  ($y)? ($y > 1 )? $y.' '.t('years') : $y.' '.t('year')  : '';
                                    }elseif($from->diff($to)->m > 0){
                                        $m = $from->diff($to)->m;
                                        $age =  ($m)? ($m > 1 )? $m.' '.t('months') : $m.' '.t('month') : '';
                                    }else{
                                        $d = $from->diff($to)->d;
                                        $age =  ($d)? ($d > 1 )? $d.' '.t('days') : $d.' '.t('day') : '' ;
                                    }
                                }else{
                                    $age = '0 '.t('year');
                                }
                            }
                        ?>
                        @if($age)
                            <span class="d-inline-block bullet rounded-circle bg-lavender mx-2"></span>
                            {{ $age }}
                        @endif

                    </p>
                </div>
                    <!-- <div class="divider mx-xs-auto"></div> -->
                    @if(!empty($work_settings))
                    <div class="modelcard-top">
                        <p>

                            <?php /*
                           @if(!empty($work_settings['hourly_rate']))
                                <?php echo ($in_left === '1')?  $currency_symbol : ''; ?>
                                {{ $work_settings['hourly_rate']}}
                                <?php echo ($in_left === '0')?  $currency_symbol : ''; 
                                ?>
                                {{ '/'.t('hour') }}
                           @endif 
                           
                           @if(!empty($work_settings['work_status']))

                             <!-- <span class="d-inline-block bullet rounded-circle bg-lavender mx-2"></span> -->


                             {{!empty($work_settings['work_status'] == 1) ? t('Available'): t('Not available') }}
                           @endif
                            
                            @if(isset($work_settings['job_distance_type']) && !empty($work_settings['job_distance_type']))

                                <!-- <span class="d-inline-block bullet rounded-circle bg-lavender mx-2"></span> -->
                                @if($work_settings['job_distance_type'] === 'km_radius')
                                    {{$work_settings['job_distance'].' KM'}}
                                @else
                                    {{ t($work_settings['job_distance_type']) }}
                                @endif

                           @endif
                           */ ?>
                        </p>
                    </div>
                    <?php /*
                    @if(isset($categories_list) && count($categories_list) > 0 )
                    <div class="modelcard-top text-uppercase mb-30 f-12">
                        <p>
                            <?php $iv = 0; foreach ($categories_list as $key => $value) {
                                if($iv != 0 ){
                                    echo '<span class="d-inline-block bullet rounded-circle bg-lavender mx-2"></span>'.$value;
                                }else{
                                    echo 'not'.$value;
                                }
                                $iv++;
                            } ?>
                        </p>
                    </div>
                    @endif */ ?>
                    <div class="divider mx-xs-auto"></div>
                @endif
                <?php /*
                <span class="mb-10">{{t('Hello')}}</span>
                <p class="mb-30 text-white">{!! str_limit(strCleaner($profile->description), config('constant.description_limit')) !!}</p> */?>
            </div>
            
            <div class="justify-content-sm-between justify-content-md-start d-lg-inline-block">
                @if(\Auth::user()->user_type_id == 2)
                    @if(isset($user->country->country_type) && $user->country->country_type == config('constant.country_premium') && ($user->user_register_type == config('constant.user_type_premium') || $user->user_register_type == config('constant.user_type_premium_send')) )

                        <div class="d-block d-lg-block text-center mb-20 mb-lg-20 mr-md-20 mr-lg-0">
                            <a href="#inviteJob" class="btn btn-white members invited_white w-160 bg-s-25 mfp-invite-model" data-toggle="modal" id="invite_button" >{{ t('Send Invitation')}}</a>
                        </div>
                    @endif    


                    <div class="d-block d-lg-block text-center mb-20 mb-lg-20 mr-md-20 mr-lg-0">

                        <a href="javascript:void(0);" value='{{$favorite}}' id="{{ $model_id }}" class="make-favorite-acount-user user-fav-button btn btn-white favorite w-160 @if($favorite == 1)active @endif">{{t('Favorite')}}</a>

                        <?php /* <a id='fav_button' value='{{$favorite}}' href="{!!URL::to('account/favorite',array($model_id))!!}" class="btn btn-white favorite w-160 @if($favorite == 0)active @endif">Favorite
                        </a> */ ?>
                    </div>
                   
                        
                   
                    @if(isset($direct_message_link) && $direct_message_link != "")
                        <div class="d-block d-lg-block text-center mb-20 mb-lg-20 mr-md-20 mr-lg-0">
                            <a href="{{ $direct_message_link }}" class="btn btn-white message w-160">{{ t('Message') }}</a>
                        </div>
                    @else
                        <div class="d-block d-lg-block text-center mb-20 mb-lg-20 mr-md-20 mr-lg-0">
                            <a data-toggle="modal" href="#directMessage" class="btn btn-white message w-160">{{ t('Message') }}</a>
                        </div>
                    @endif
                  

                @elseif($user->id == Auth::User()->id)
                    <div class="d-block d-lg-block text-center mb-20 mb-lg-20 mr-md-20 mr-lg-0">
                        <?php /*<a href="javascript:void(0);" class="btn btn-white members insight bg-s-25 pointer-event-none">&nbsp; {{$user->userVisits->count()}}&nbsp;{{ trans_choice('global.count_visits',$user->userVisits->count()) }}
                        </a>*/ ?>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@if(\Auth::user()->user_type_id == 2)
    @include('model.inc.invitation_jobs')
@endif