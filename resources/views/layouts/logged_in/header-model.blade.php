    <?php $attr = ['countryCode' => config('country.icode')];?>

<?php 
    if(request()->segment(1) == strtolower(config('app.locale')))
    {  
        $curentUrl = str_replace(config('app.locale').'/', '', Request::path());
    }else{
        $curentUrl = Request::path();
    }
?>
{{ Html::style(config('app.cloud_url').'/css/login_menu.css') }}
<header class="bg-white box-shadow no-padding" id="loggedin-header">
    <div class="container login-container d-flex align-items-center px-0">
        <div class="d-flex flex-grow-1 align-items-center justify-content-between justify-content-md-start">
            <a href="{{ lurl('/') }}" class="mobile-menu-button d-md-none"></a>
            <a href="{{ lurl('/') }}">
                <img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                         {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                         {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                             src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo2 mr-md-20"/>
            </a>
            <nav class="d-none d-md-block">
                
                <ul class="m-0 d-flex align-items-center">

                    <li>
                        <a href="{{ lurl(trans('routes.model-dashboard', $attr), $attr) }}" class="dashboard-btn {{ $curentUrl == trans('routes.model-dashboard') ? 'active' : '' }}" title="{{t('Dashboard')}}">{{t('Dashboard')}}</a>
                    </li>
                    <li>
                        <a href="{{ lurl(trans('routes.social', $attr), $attr) }}" class="social-btn {{ $curentUrl == trans('routes.social') ? 'active' : '' }}" title="{{t('Social')}}">{{t('Social')}}</a>
                    </li>
                    
                    <?php /*
                    @if (!auth()->check() )
                    <li>
                        <a href="{{ lurl(trans('routes.user')) }}" class="profile-btn {{ $curentUrl == trans('routes.user') ? 'active' : '' }}" title="{{t('Become a Model')}}">{{t('Become a Model')}}</a>
                    </li>
                    @endif
                    */ ?>


                    <?php  
                        if($curentUrl == trans('routes.search') || $curentUrl == trans('routes.search').'/'.t('favourites')){
                            $active_jobs = 'active';
                        }else{
                            $active_jobs = '';
                        } 
                    ?>

                    <li>
                        <?php /*
                        @if( App\Helpers\CommonHelper::checkUserType(config('constant.country_free')) )
                            <a href="#freejobs" data-toggle="modal" class="{{ $active_jobs }}">{{ t('Jobs') }}</a>
                        @else
                            <a href="{{ lurl(trans('routes.search', $attr), $attr) }}" class="{{ $active_jobs }}">{{ t('Jobs') }}</a>
                        @endif
                        */?>
                        
                        {!! App\Helpers\CommonHelper::createLink('list_jobs', t('Jobs'), lurl(trans('routes.search', $attr), $attr), $active_jobs, '','','') !!}
                    </li>

                    <?php  
                        if($curentUrl == trans('routes.partner-list') || $curentUrl == trans('routes.partner-list-favourites')){
                            $active_partner = 'active';
                        }else{
                            $active_partner = '';
                        }
                    ?>
                    <?php /* ?>
                    <li>
                        <a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}" class="{{ $active_partner }}">{{ t('Partners List') }}</a>
                    </li>
                    <?php */ ?>

                    <li>
                        <a class="magazin-btn {{ $curentUrl == trans('routes.magazine') ? 'active' : '' }}" href="{{ lurl(trans('routes.magazine')) }}" title="{{t('magazine')}}">{{ t('magazine') }}</a>
                    </li>
                    <li>
                        <a class="academy-btn {{ $curentUrl == trans('routes.model-academy') ? 'active' : '' }}" href="{{ lurl(trans('routes.model-academy')) }}" title="{{t('academy')}}">{{ t('academy') }}</a>
                    </li>

                    <?php /*
                    <div class="d-none d-md-inline-block d-lg-none position-relative dropdown-main px-30" data-content="menu-dropdown">
                        
                        <li>
                            <a href="#" class="btn btn-white more_white mini-all h-40"></a>
                        </li>
                        
                        <div class="bg-white box-shadow py-10 px-30 dropdown-content" data-content="menu-dropdown">

                            <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="f-15 pb-10 mb-10 bb-grey2">{{t('chat')}}
                                @if(isset($unreadMessages) && $unreadMessages > 0)
                                    <span class="msg-num">
                                        {{ $unreadMessages }}
                                    </span>
                                @endif
                            </a>

                            <a href="{{ lurl(trans('routes.notifications', $attr), $attr) }}" class="f-15">{{t('news')}}
                                @if(isset($totalInvitations) && $totalInvitations > 0)
                                    <span class="msg-num">
                                        {{ $totalInvitations }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <?php */ ?>
                </ul>
            </nav>
        </div>
        <div class="d-flex flex-grow-1 align-items-center justify-content-end scroll">
            <div class="position-relative languages">
                <a href="#" class="link">{{ strtoupper(config('app.locale')) }}</a>
                <ul>
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if (strtolower($localeCode) != strtolower(config('app.locale')))
                            <?php
                                // Controller Parameters
                                $attr = [];
                                $attr['countryCode'] = config('country.icode');

                                if (isset($uriPathCatSlug)) {
                                	$attr['catSlug'] = $uriPathCatSlug;
                                	if (isset($uriPathSubCatSlug)) {
                                		$attr['subCatSlug'] = $uriPathSubCatSlug;
                                	}
                                }

                                if (isset($uriPathCityName) && isset($uriPathCityId)) {
                                	$attr['city'] = $uriPathCityName;
                                	$attr['id'] = $uriPathCityId;
                                }

                                if (isset($uriPathPageSlug)) {
                                	$attr['slug'] = $uriPathPageSlug;
                                }

                                if(isset($uriPathPageId)){
                                    $attr['attrId'] = $uriPathPageId;
                                }

                                if (isset($uriCategoryId)){
                                    $attr['category_id'] = $uriCategoryId;
                                }

                                if (isset($notifications_slug)){
                                    $attr['slug'] = strtolower(Lang::get('global.'.$notifications_slug, [] , strtolower($localeCode)));
                                }
                                             
                                // Default
                                $link = LaravelLocalization::getLocalizedURL($localeCode, null, $attr);

                                // $link = lurl(null, $attr, $localeCode);
                                $localeCode = strtolower($localeCode);
                            ?>
                            <li>
                                <a href="{{ $link }}" tabindex="-1" rel="alternate" hreflang="{{ ($properties['locale'])? str_replace('_','-', $properties['locale']) : $localeCode }}">
                                    {{ strtoupper($localeCode) }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>



            
            @if(!Gate::check('show_premium_button', \Auth::user()))
                <?php $msgcls =  ($curentUrl == trans('routes.messages'))? 'd-none d-lg-inline-block message-btn active message-lbl' : 'd-none d-lg-inline-block message-btn message-lbl'; ?>
                <?php $titleMsg = t('Messages');
                    // if(isset($unreadMessages) && $unreadMessages > 0){
                    //     if( $unreadMessages > config('app.num_counter') ){ 
                    //         $titleMsg = t('Messages').' '."<span class='msg-num'>".config('app.num_counter').'+'."</span>";
                    //     } else { 
                    //         $titleMsg = t('Messages').' '."<span class='msg-num'>$unreadMessages</span>";
                    //     }
                    // }
                ?>
                    
                {!! App\Helpers\CommonHelper::createLink('list_messages', $titleMsg, lurl(trans('routes.messages', $attr), $attr), $msgcls, '', t('Messages'), '') !!}

                <?php /*           
                <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="d-none d-lg-inline-block message-btn {{ $curentUrl == trans('routes.messages') ? 'active' : '' }}" title="{{t('Messages')}}">{{t('Messages')}}
                    @if(isset($unreadMessages) && $unreadMessages > 0)
                        <?php if( $unreadMessages > config('app.num_counter') ){ ?>
                            <span class="msg-num">{{ config('app.num_counter').'+' }}</span>
                        <?php } else { ?>
                            <span class="msg-num">{{ $unreadMessages }}</span>
                        <?php } ?>
                    @endif
                </a>
                */ ?>

     
                <?php  
                    if($curentUrl == trans('routes.notifications') || $curentUrl == trans('routes.notifications').'/'.strtolower(t('Invited')) || $curentUrl == trans('routes.notifications').'/'.strtolower(t('Accepted')) || $curentUrl == trans('routes.notifications').'/'.strtolower(t('Rejected'))){
                        $active_notifications = 'active';
                    }else{
                        $active_notifications = '';
                    } 
                ?>

                <?php $intvcls =  ($curentUrl == trans('routes.notifications'))? 'd-none d-lg-inline-block notif-btn notifications active inviation-lbl' : 'd-none d-lg-inline-block notif-btn notifications inviation-lbl'; ?>
                <?php $titleInvt = t('Invitations');
                    // if(isset($totalInvitations) && $totalInvitations > 0){
                    //     if( $totalInvitations > config('app.num_counter') ){ 
                    //         $titleInvt = t('Invitations').' '."<span class='msg-num num-invited'>".config('app.num_counter').'+'."</span>";
                    //     } else { 
                    //         $titleInvt = t('Invitations').' '."<span class='msg-num num-invited'>$totalInvitations</span>";
                    //     }
                    // }
                ?>
                
                {!! App\Helpers\CommonHelper::createLink('list_invitations', $titleInvt, lurl(trans('routes.notifications', $attr), $attr), $intvcls, '', t('Invitations'), '') !!}
            @else
                <a data-toggle="modal" data-target="#go-premium" class="go-pre-btn mini-mobile position-relative mr-20 star-bk go-premium-button go-header" title="{{t('premium_btn')}}"> {{t('premium_btn')}} </a>
            @endif

            <?php /*

            @if( App\Helpers\CommonHelper::checkUserType(config('constant.country_free')) )
                    <a href="#freejobs" data-toggle="modal" class="d-none d-lg-inline-block notif-btn notifications {{ $active_notifications }}" title="{{t('Invitations')}}">{{t('Invitations')}}</a>
            @else
                <a href="{{ lurl(trans('routes.notifications', $attr), $attr) }}" class="d-none d-lg-inline-block notif-btn notifications {{ $active_notifications }}" title="{{t('Invitations')}}">
                    {{t('Invitations')}}
                    @if(isset($totalInvitations) && $totalInvitations > 0)
                        
                        <?php if( $totalInvitations > config('app.num_counter') ){ ?>
                            <span class="msg-num num-invited">{{ config('app.num_counter').'+' }}</span>
                        <?php } else { ?>
                            <span class="msg-num num-invited">{{ $totalInvitations }}</span>
                        <?php } ?>
                    @endif
                </a>
            @endif

            */?>

            <div class="position-relative">
                <?php
                    if (!empty(\Auth::user()->profile->logo)) {

                        // $profile_logo = \App\Helpers\CommonHelper::getThumbImage(\Auth::user()->id, \Auth::user()->profile->logo, config('constant.LOGO_THUMB'));

                    	$profile_logo = \Storage::url(\Auth::user()->profile->logo);

                    } elseif (isset($gravatar) && !empty($gravatar)) {
                    	$profile_logo = $gravatar;
                    } else {
                    	$profile_logo = url(config('app.cloud_url').'/images/user.png');
                    }
                ?>

                <a href="#" class="mr-lg-10 d-inline-block dropdown-main mobile-menu-right" data-content="profile-dropdown">
                    <img srcset="{{ $profile_logo }},
                                 {{ $profile_logo }} 2x,
                                 {{ $profile_logo }} 3x"
                                 src="{{ $profile_logo }}" alt="{{ trans('metaTags.Go-Models') }}" class="avatar rounded-circle fit-conver"/>
                </a>

                <a href="#" class="d-none d-xl-inline-block dropdown-main" data-content="profile-dropdown">{{t('My account')}}</a>
                
                <div class="bg-white box-shadow pt-15 pb-30 px-30 dropdown-content mobil header-menu-div" data-content="profile-dropdown">
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li>
                            <a href="{{ lurl(trans('routes.user')) }}">{{ t('My profile') }}</a>
                        </li>
                    </ul>
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                       
                       <?php /* <!-- <li><a href="{{ lurl(trans('routes.profile-edit', $attr), $attr) }}">{{t('Edit model profile')}}</a></li> --> */ ?>
                        
                        <li>
                            <a href="{{ lurl(trans('routes.model-sedcard-edit', $attr), $attr) }}">{{t('My Sedcard')}}</a>
                        </li>
                        
                        <li>
                            <a href="{{ lurl(trans('routes.model-portfolio-edit', $attr), $attr) }}">{{t('My Model Book')}}</a>
                        </li>
                    </ul>
                    
                    <?php /*  <a href="{{ lurl(trans('routes.system-settings', $attr), $attr) }}" class="f-15 pb-10 mb-10 bb-grey2">{{t('System settings')}}</a> */ ?>
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        
                        <li>
                            <a href="{{ lurl(trans('routes.my-data', $attr), $attr) }}">{{t('My Data')}}</a>
                        </li>
                        <li>
                            <a href="{{ lurl(trans('routes.work-settings', $attr), $attr) }}">{{t('Work Settings')}}</a>
                        </li>
                    </ul>
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li>
                            <?php /* <a href="{{ lurl(trans('routes.job-applied', $attr), $attr) }}">{{ t('Jobs Applied') }}</a> */ ?>
                            {!! App\Helpers\CommonHelper::createLink('applied_jobs', t('Jobs Applied'), lurl(trans('routes.job-applied', $attr), $attr), '', '','','') !!}
                        </li>
                        <li>
                            <?php /*<a href="{{ lurl(trans('routes.search').'/favourites') }}">{{ t('Favorite jobs') }}</a> */?>
                            {!! App\Helpers\CommonHelper::createLink('list_jobs', t('Favorite jobs'), lurl(trans('routes.search').'/favourites'), '', '','','') !!}
                        </li>
                        <li>
                            <?php /* <a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}" >{{ t('Partners List') }}</a> */ ?>
                            {!! App\Helpers\CommonHelper::createLink('list_partner', t('Partners List'), lurl(trans('routes.partner-list', $attr), $attr), '', '','','') !!}                          
                        </li>

                        <li>
                            <?php /* <a href="{{ lurl(trans('routes.partner-list-favourites')) }}">{{ t('Favorite partner') }}</a> */ ?>
                            {!! App\Helpers\CommonHelper::createLink('list_partner', t('Favorite partner'), lurl(trans('routes.partner-list-favourites')), '', '','','') !!}  
                        </li>
                    </ul>
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        
                        <li>
                            <a href="{{ lurl(trans('routes.change-password', $attr), $attr) }}">{{t('Change Password')}}</a>
                        </li>
                    </ul>
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li>
                            <a href="{{ lurl(trans('routes.logout')) }}">{{ ucWords(t('Log out')) }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

