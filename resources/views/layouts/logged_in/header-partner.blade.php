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
                        <a href="{{ lurl(trans('routes.partner-dashboard', $attr), $attr) }}" class="dashboard-btn {{ $curentUrl == Lang::get('routes.partner-dashboard', [], config('app.locale')) ? 'active' : '' }}" title="{{ t('Dashboard') }}">{{ t('Dashboard') }}</a>
                    </li>

                    <li>
                        <a href="{{ lurl(trans('routes.social', $attr), $attr) }}" class="social-btn {{ $curentUrl == Lang::get('routes.social', [], config('app.locale')) ? 'active' : '' }}" title="{{ t('Social') }}">{{ t('Social') }}</a>
                    </li>
                    
                    <?php
                        
                        if($curentUrl == trans('routes.model-list') || $curentUrl == trans('routes.model-list').'/'.t('favourites')){
                            $active_modellist = 'active';
                        }else{
                            $active_modellist = '';
                        }
                    ?>

                    @if(Gate::check('list_models', $user))
                    <li>
                        <a href="{{ lurl(trans('routes.model-list', $attr), $attr) }}" class="find-model-btn {{ $active_modellist }}" title="{{ t('Find model') }}">{{ t('Find model') }}</a>
                    </li>
                    @endif

                    
                    <?php  
                        if($curentUrl == trans('routes.search') || $curentUrl == trans('routes.search').'/'.t('favourites')){
                            $active_jobs = 'active';
                        }else{
                            $active_jobs = '';
                        } 
                    ?>

                    <li>
                        <a href="{{ lurl(trans('routes.search', $attr), $attr) }}" class="{{ $active_jobs }}">{{ t('Jobs') }}</a>
                    </li>




                    <?php  
                        if($curentUrl == trans('routes.magazine')){
                            $active_magazine = 'active';
                        }else{
                            $active_magazine = '';
                        } 
                    ?>

                    <li>
                        <a class="magazin-btn {{ $active_magazine }}" href="{{ lurl(trans('routes.magazine')) }}" title="{{t('magazine')}}">{{t('magazine')}}</a>
                    </li>
                    <li>
                        <a class="academy-btn {{ $curentUrl == trans('routes.academy') ? 'active' : '' }}" href="{{ lurl(trans('routes.academy')) }}" title="{{t('academy')}}">{{ t('academy') }}</a>
                    </li>

                    <?php /*

                    <li class="d-none d-xl-inline-block">
                        <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="mr-0 message-btn">{{ t('chat') }} 
                            @if(isset($unreadMessages) && $unreadMessages > 0)
                                <span class="msg-num">{{ isset($unreadMessages) ? $unreadMessages : 0 }}</span>
                            @endif
                        </a>
                    </li>

                    
                    <div class="d-none d-md-inline-block d-lg-none position-relative dropdown-main" data-content="menu-dropdown">
                        <li>
                            <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="f-15 pb-10 mb-10 bb-grey2">{{ t('chat') }}
                                 @if(isset($unreadMessages) && $unreadMessages > 0)
                                    <span class="msg-num">{{ isset($unreadMessages) ? $unreadMessages : 0 }}</span>
                                @endif
                            </a>
                        </li>
                        <?php /*
                        <div class="bg-white box-shadow py-10 px-30 dropdown-content" data-content="menu-dropdown">

                            <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="f-15 pb-10 mb-10 bb-grey2">{{ t('chat') }}
                                 @if(isset($unreadMessages) && $unreadMessages > 0)
                                    <span class="msg-num">{{ isset($unreadMessages) ? $unreadMessages : 0 }}</span>
                                @endif
                            </a>
                        </div> 
                        <?php  
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

                                if (isset($uriId)){
                                    $attr['id'] = $uriId;
                                }

                                if (isset($notifications_slug)){
                                $attr['slug'] = strtolower(Lang::get('global.'.$notifications_slug, [] , strtolower($localeCode)));
                                }

                                // Default
                                $link = LaravelLocalization::getLocalizedURL($localeCode, null, $attr);
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

            <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="d-none d-lg-inline-block message-btn message-lbl {{ $curentUrl == Lang::get('routes.messages', [], config('app.locale')) ? 'active' : ''  }}" title="{{ t('Messages') }}">{{ t('Messages') }}
                <?php /* @if(isset($unreadMessages) && $unreadMessages > 0)
                    <?php if( $unreadMessages > config('app.num_counter') ){ ?>
                        <span class="msg-num">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num">{{ $unreadMessages }}</span>
                    <?php } ?>
                @endif */ ?>
            </a>

            <?php  
                if($curentUrl == trans('routes.notifications') || $curentUrl == trans('routes.notifications').'/'.strtolower(t('Invited')) || $curentUrl == trans('routes.notifications').'/'.strtolower(t('Accepted')) || $curentUrl == trans('routes.notifications').'/'.strtolower(t('Rejected'))){
                    $active_notifications = 'active';
                }else{
                    $active_notifications = '';
                } 
            ?>
            
            <a href="{{ lurl(trans('routes.notifications', $attr), $attr) }}" class="d-none d-lg-inline-block notif-btn notifications inviation-lbl {{ $active_notifications }}" title="{{ t('Invitations') }}">
                {{t('Invitations')}}
                <?php /* @if(isset($totalInvitations) && $totalInvitations > 0)
                    
                    <?php if( $totalInvitations > config('app.num_counter') ){ ?>
                        <span class="msg-num num-invited">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num num-invited">{{ $totalInvitations }}</span>
                    <?php } ?>
                @endif */ ?>
            </a>
            
            <a href="{{ lurl(trans('routes.post-create', $attr), $attr) }}" class="d-none d-sm-inline-block btn btn-success h-40 add_new mini-all mr-20" title="{{ t('Post your Job') }}" ></a>

            <div class="position-relative">
                <a href="#" class="mr-lg-10 d-inline-block dropdown-main mobile-menu-right" data-content="profile-dropdown">
                    <?php
                        $logo = (Auth::user()->profile->logo) ? Auth::user()->profile->logo : '';
                        /*
                        // $logo = \App\Helpers\CommonHelper::getThumbImage(Auth::user()->id, Auth::user()->profile->logo, config('constant.LOGO_THUMB')); */
                    ?>

                        @if($logo !== "" && Storage::exists($logo))
                            <img src="{{ \Storage::url(Auth::user()->profile->logo) }}" alt="{{ trans('metaTags.Go-Models') }}" class="avatar rounded-circle fit-conver">
                            <?php /*
                            @elseif (!empty($gravatar))
                            <img alt="Go Models" class="avatar rounded-circle fit-conver" src="{{ $gravatar }}"> */ ?>
                        @else
                            <img alt="{{ trans('metaTags.Go-Models') }}" class="avatar rounded-circle fit-conver" src="{{ url(config('app.cloud_url').'/images/user.png') }}" >
                        @endif
                </a>

                <a href="#" class="d-none d-xl-inline-block dropdown-main" data-content="profile-dropdown">{{ t('My account') }}</a>

                <div class="bg-white box-shadow pt-15 pb-30 px-30 dropdown-content mobil header-menu-div" data-content="profile-dropdown">
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li>
                            <a href="{{ lurl(trans('routes.user')) }}">{{ t('My profile') }}</a>
                        </li>
                    </ul>

                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <?php /* <!-- <li><a href="{{ lurl(trans('routes.partner-profile-edit', $attr), $attr) }}">{{ t('Edit business profile') }}</a></li> --> */?>
                        
                        <li>
                            <a href="{{ lurl(trans('routes.account-album', $attr), $attr) }}">{{ ucWords(t('My albums')) }}</a>
                        </li>
                    </ul>
                    <?php /*
                    <!-- <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li><a href="#">System settings</a></li>
                        <li><a href="#">Work settings</a></li>
                    </ul> -->
                    */ ?>
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li>
                            <a href="{{ lurl(trans('routes.account-companies', $attr), $attr) }}">{{ ucWords(t('My companies')) }}</a>
                        </li>
                    </ul>
                    <?php /*
                    <!-- <a href="#" class="f-15 pb-10 mb-10 bb-grey2">System settings</a>
                    <a href="#" class="f-15 pb-10 mb-10 bb-grey2">Work settings</a> -->

                    <!-- <a href="{{ lurl('account/transactions') }}" class="f-15 pb-10 mb-10 bb-grey2">{{ t('My Transactions')}}</a>
                    <a href="#" class="f-15 pb-10 mb-10 bb-grey2">{{ t('My subscription') }}</a> -->
                    */ ?>

                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <?php /*
                        <!--  <li><a href="#">Transactions</a></li>
                        <li><a href="#">My subscription</a></li>
                        <li><a href="#">My data</a></li> --> */ ?>
                        <li>
                            <a href="{{ lurl('account/my-posts') }}">{{ ucWords(t('My ads')) }}</a>
                        </li>
                        <?php /*
                        <!-- <li><a href="{{ lurl('account/pending-approval') }}">{{ t('Pending approval') }} </a></li> --> */ ?>
                        <li>
                            <a href="{{ lurl('account/archived') }}">{{ ucWords(t('Archived ads')) }}</a>
                        </li>
                        <li>
                            <a href="{{ lurl(trans('routes.job-applied', $attr), $attr) }}">{{ t('Jobs Applied') }}</a>
                        </li>
                    </ul>
                    
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        
                        <li>
                            <a href="{{ lurl(trans('routes.search').'/favourites') }}">{{ t('Favorite jobs') }}</a>
                        </li>

                        @if(Gate::check('list_models', $user))
                        <li>
                            <a href="{{ lurl(trans('routes.model-list').'/favourites') }}">{{ t('Favorite models') }}</a>
                        </li>
                        @endif
                    </ul>
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li>
                            <a href="{{ lurl(trans('routes.change-password', $attr), $attr) }}">{{ t('Change Password') }}</a>
                        </li>
                    </ul>
                    <ul class="f-15 pb-10 mb-10 bb-grey2">
                        <li>
                            <a href="{{ lurl(trans('routes.logout', $attr), $attr) }}">{{ ucWords(t('Log out')) }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
