<?php 
    if(request()->segment(1) == strtolower(config('app.locale')))
    {  
        $curentUrl = str_replace(config('app.locale').'/', '', Request::path());
    }else{
        $curentUrl = Request::path();
    }
?>

<?php if(isset($hide_header) && $hide_header == true): ?>
    
    <header class="no-padding">
        <div class="inner d-flex align-items-center px-0">
            <div class="d-flex flex-grow-1 align-items-center justify-content-between justify-content-md-start">
                <a href="{{lurl(config('app.locale'))}}">
                    <img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                             {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                             {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                         src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo2 mr-md-20"/>
                </a>
            </div>
        </div>
    </header>

<?php else: ?>

    <header class="no-padding">
        <div class="inner d-flex align-items-center px-0">
            <div class="d-flex flex-grow-1 align-items-center justify-content-between justify-content-md-start">
                <a href="{{lurl(config('app.locale'))}}">
                    <img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                             {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                             {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                         src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo2 mr-md-20"/>
                </a>
                <nav>
                    <ul>
                        
                        <li><a href="{{ lurl(trans('routes.go-premium')) }}" class="{{ $curentUrl == trans('routes.go-premium') ? 'active' : '' }}">{{t('go tour')}}</a></li>

                        <?php
                            
                            if($curentUrl == trans('routes.models-category') || $curentUrl == trans('routes.professionals')){
                                $active_category = 'active';
                            }else{
                                $active_category = '';
                            } 
                        ?>

                        <li><a href="{{ lurl(trans('routes.models-category')) }}" class="{{ $active_category }}">{{t('categories')}}</a></li>

                        <li dd="sd"><a href="{{ lurl(trans('routes.book-a-model')) }}" class="{{ $curentUrl == trans('routes.book-a-model') ? 'active' : '' }}">{{t('Book a model')}}</a></li>
                        
                        <?php /* 
                        @if (!auth()->check() )
                        <li><a class="profile-btn {{ $curentUrl == trans('routes.login') ? 'active' : '' }}" href="{{ lurl(trans('routes.login')) }}" title="{{t('Become a Model')}}">{{t('Become a Model')}}</a></li>
                        @endif
                        */ ?>

                        

                        <?php /*
                            
                            <li><a href="{{ lurl(trans('routes.login')) }}">{{t('post a job')}}</a></li> 
                        */?>

                        @if (auth()->check() && auth()->user()->user_type_id == 2)
                            <?php
                                $attr = [];
                                $attr['countryCode'] = config('country.icode');
                            ?>
                            <li><a href="{{ lurl(trans('routes.post-create', $attr), $attr) }}" class="{{ $curentUrl == trans('routes.post-create') ? 'active' : '' }}">{{t('post a job')}}</a></li>
                        @else
                            <li><a href="{{ lurl(trans('routes.post-a-job')) }}" class="{{ $curentUrl == trans('routes.post-a-job') ? 'active' : '' }}">{{t('post a job')}}</a></li>
                        @endif
                        <li><a class="magazin-btn {{ $curentUrl == trans('routes.magazine') ? 'active' : '' }}" href="{{ lurl(trans('routes.magazine')) }}" title="{{t('magazine')}}">{{ t('magazine') }}</a></li>
                        <li><a class="academy-btn {{ $curentUrl == trans('routes.academy') ? 'active' : '' }}" href="{{ lurl(trans('routes.academy')) }}" title="{{t('academy')}}">{{ t('academy') }}</a></li>
                    </ul>
                </nav>
            </div>
            <div class="d-flex flex-grow-1 align-items-center justify-content-end scroll">    
                <!-- country icon -->

                <span id="render-country"></span>
                <?php /*
                    @if (getSegment(1) != trans('routes.countries')  && !auth()->check())
                        <?php
                        $multiCountriesIsEnabled = false;
                        $multiCountriesLabel = '';
                        if (config('settings.geo_location.country_flag_activation')) {
                            if (!empty(config('country.code'))) {
                                $multiCountriesIsEnabled = true;
                                $multiCountriesLabel = 'title="' . t('Select a Country') . '"';
                            }
                        }
                        ?>
                        @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)

                            @if( config('country.icode') )
                                <a href="javascript:void(0);" class="mfp-country-select mr-20" title="{{ config('country.name') }}">
                                    <img class="flag-icon" src="{{ URL::to(config('app.cloud_url').'/images/flags/32/'.config('country.icode').'.png') }}" alt="{{ config('country.icode').'.png' }}" >
                                </a>
                            @else if (isset( auth()->user()->country_code))
                                <a href="javascript:void(0);" class="mfp-country-select mr-20">
                                    <img class="flag-icon" src="{{ URL::to(config('app.cloud_url').'/images/flags/32/'.strtolower(auth()->user()->country_code).'.png') }}" alt="{{ strtolower(auth()->user()->country_code).'.png' }}">
                                </a>
                            @endif

                        @endif
                    @endif */ ?>
                
                <div class="languages">
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

                                    if (isset($uriPathToken)) {
                                        $attr['token'] = $uriPathToken;
                                    }

                                    $link = lurl(null, $attr, $localeCode);
                                    $localeCode = strtolower($localeCode);

                                    $link = (isset($link) && !empty($link))? $link : url('/');
                                ?>
                                <li>
                                    <a href="{{ $link }}" tabindex="-1">{{ strtoupper($localeCode) }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="account">
                    <input type="hidden" id="app-env" value="{{config('app.env')}}"/>
                    <a href="{{ lurl(trans('routes.login')) }}" class="login">{{t('Log In')}}</a>
                    <a href="javascript:void(0);" id="mfp-register-form" class="register mfp-register-form" onclick="if(document.getElementById('app-env').value == 'live') { window.dataLayer.push({'event': 'signup-click'}); }" rel="nofollow">{{t('Signup')}}</a>
                </div>
                <div class="mobile-links">
                    <a href="#" class="mobile-menu" title="{{t('menu')}}">{{ t('menu') }}</a>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?>

