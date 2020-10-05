<?php
    // Search parameters
    $queryString = (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');

    // Get the Default Language
    $cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.other.cache_expiration', 3600);
    /*
    // $defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
    // 	$defaultLang = \App\Models\Language::where('default', 1)->first();
    // 	return $defaultLang;
    // });
    */

    // Check if the Multi-Countries selection is enabled
    $multiCountriesIsEnabled = false;
    $multiCountriesLabel = '';
    if (config('settings.geo_location.country_flag_activation')) {
    	if (!empty(config('country.code'))) {
            if(isset($countries) && !empty($countries) && $countries->count() > 1) {
    			$multiCountriesIsEnabled = true;
    			$multiCountriesLabel = 'title="' . t('Select a country') . '"';
    		}
    	}
    }



    // Logo Label
    $logoLabel = '';
    if (getSegment(1) != trans('routes.countries')) {
    	$logoLabel = config('settings.app.name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
    }
?>
<div id="mobile-menu">
    <div class="scroll">
        <!-- country icon -->
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
                <div class="bg-menu mobile-menu-div">
                   @if(config('country.icode'))
                        <a href="javascript:void(0);" class="mfp-country-select">
                            <img class="flag-icon" src="{{ URL::to(config('app.cloud_url').'/images/flags/32/'.config('country.icode').'.png') }}" alt="{{ config('country.icode').'.png' }}"><span class="mobile-span px-20">{{ config('country.name') }}</span>
                        </a>
                    @else if (isset( auth()->user()->country_code))
                        <a href="javascript:void(0);" class="mfp-country-select">
                            <img class="flag-icon" src="{{ URL::to(config('app.cloud_url').'/images/flags/32/'.strtolower(auth()->user()->country_code).'.png') }}" alt="{{ strtolower(auth()->user()->country_code).'.png' }}"><span class="mobile-span px-20">{{ config('country.name') }}</span>
                        </a>
                    @endif
                </div>
            @endif
        @endif
        <div class="mobile-menu-div pb-0">
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

                                $link = lurl(null, $attr, $localeCode);
                                $localeCode = strtolower($localeCode);
                            ?>
                            <li>
                                <a href="{{ $link }}" tabindex="-1">{{ strtoupper($localeCode) }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mobile-menu-div-hr">
            <hr size="1px" color="" class="mobile-hr" noshade />
        </div>

        <div class="buttons">
            <div class="btn">
                <a href="{{ lurl(trans('routes.login')) }}">{{t('Log In')}}</a>
            </div>
            @if (!Auth::user())
                <div class="btn">
                    <a href="#" id="mfp-register-form" class="green mfp-register-form mb-0" onclick="if(document.getElementById('app-env').value == 'live') { window.dataLayer.push({'event': 'signup-click'}); }">{{t('Signup')}}</a>
                </div>
            @endif
        </div>

        <div class="mobile-menu-div-hr">
            <hr size="1px" color="" class="mobile-hr" noshade />
        </div>

        <div class="bg-menu mobile-menu-div mb-10">
            <a href="{{ lurl(trans('routes.models-category')) }}"><span class="mobile-span px-20">{{t('Model Categories')}}</span></a>
        </div>
        @if(isset($modelCategories) && $modelCategories->count() > 0)
            @foreach($modelCategories as $modelCategory)
                <div class="mobile-menu-div">
                    <a href="{{ lurl(trans('routes.'.$modelCategory->page_route)) }}">
                        <span class="mobile-span px-20">{{ $modelCategory->name }}</span>
                    </a>
                    
                </div>
            @endforeach
        @endif

        <div class="bg-menu mobile-menu-div mt-10 mb-10">
            <a href="{{lurl(config('app.locale'))}}"><span class="mobile-span px-20">go-models</span></a>
        </div>

        <div class="mobile-menu-div">
            <a href="{{ lurl(trans('routes.go-premium')) }}"><span class="mobile-span px-20">{{t('go tour')}}</span></a>
        </div>

        <div class="mobile-menu-div">
            <a href="{{ lurl(trans('routes.book-a-model')) }}"><span class="mobile-span px-20">{{t('Book a model')}}</span></a>
        </div>
        
        <div class="mobile-menu-div">
            <a href="{{ lurl(trans('routes.post-a-job')) }}"><span class="mobile-span px-20">{{t('post a job')}}</span></a>
        </div>

        <div class="mobile-menu-div">
            <a href="{{ lurl(trans('routes.magazine')) }}"><span class="mobile-span px-20">{{ t('magazine') }}</span></a>
        </div>

        <div class="mobile-menu-div">
            <a href="{{ lurl(trans('routes.about-us')) }}"><span class="mobile-span px-20">{{ ucfirst(t('about us'))}}</span></a>
        </div>

        <div class="bg-menu mobile-menu-div mt-10">
            <a href="{{ lurl(trans('routes.professionals')) }}"><span class="mobile-span px-20">{{t('For Clients')}}</span></a>
        </div>

        <div class="mobile-menu-div-hr">
            <hr size="1px" color="" class="mobile-hr" noshade />
        </div>
        
        <div class="mobile-menu-div pt-0">
            <span class="mobile-span px-20 font-bold">{{t('lbl_help_contact')}}:</span>
        </div>

        <div class="mobile-menu-div">
            <a href="{{ lurl(trans('routes.faq')) }}"><span class="mobile-span px-20">{{t('lbl_faq')}}</span></a>
        </div>

        <div class="mobile-menu-div">
            <a href="{{ lurl(trans('routes.feedback')) }}"><span class="mobile-span px-20">{{ t('lbl_feedback') }}</span></a>
        </div>
        
        <div class="mobile-menu-div pb-0">
            <div class="btn">
                <a href="{{ lurl(trans('routes.contact')) }}">{{ t('lbl_contact_us') }}</a>
            </div>
        </div>

        <div class="mobile-menu-div-hr mobile-pb-60">
            <hr size="1px" color="" class="mobile-hr" noshade />
        </div>

        <?php /*
        <ul>
            <li>
                <a href="#" class="dd"><span>Go-models</span></a>
                <ul>
                    <li><a href="{{ lurl(trans('routes.go-premium')) }}">{{t('go tour')}}</a></li>
                    <li><a href="{{ lurl(trans('routes.models-category')) }}">{{t('categories')}}</a></li>
                    <li><a href="{{ lurl(trans('routes.book-a-model')) }}">{{t('Book a model')}}</a></li>
                     
                    
                    <li><a href="{{ lurl(trans('routes.post-a-job')) }}">{{t('post a job')}}</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="dd"><span>{{ t('lbl_company') }}</span></a>
                <ul>
                    <li><a href="{{ lurl(trans('routes.about-us')) }}">{{t('about us')}}</a></li>
                    <li><a href="{{ lurl(trans('routes.magazine')) }}">{{t('magazine')}}</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="dd"><span>{{ t('lbl_help_contact') }}</span></a>
                <ul>
                    <li><a href="{{ lurl(trans('routes.faq')) }}">{{t('lbl_faq')}}</a></li>
                    <li><a href="{{ lurl(trans('routes.contact')) }}">{{t('lbl_contact')}}</a></li>
                </ul>
            </li>
        </ul>

        <div class="support">
            <h5>{{t('lbl_customer_support')}}</h5>
            <p>{{ t('lbl_email_support') }}</p>
            <div class="btn">
                <a href="{{ lurl(trans('routes.contact')) }}">{{ t('lbl_contact_us') }}</a>
            </div>
        </div>
        */ ?>
    </div>
</div>