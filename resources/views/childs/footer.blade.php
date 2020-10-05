<?php

/*
// $multiCountriesIsEnabled = false;
// $multiCountriesLabel = '';
// if (config('settings.geo_location.country_flag_activation')) {
//     if (!empty(config('country.code'))) {
//         // if (\App\Models\Country::where('active', 1)->count() > 1) {
//             $multiCountriesIsEnabled = true;
//             $multiCountriesLabel = 'title="' . t('Select a Country') . '"';
//         // }
//     }
// }
*/

?>

<div class="links">
    <div class="inner">
        <div class="col">
            <h6>Go-Models</h6>
            <ul>
                <li>
                    <a href="{{ lurl(trans('routes.book-a-model')) }}">{{ t('lbl_book_a_model') }}</a>
                </li>
                <li><a href="{{ lurl(trans('routes.go-premium')) }}">{{ t('go tour') }}</a></li>
                <li><a href="{{ lurl(trans('routes.models-category')) }}" class="dd">{{ t('lbl_model_categories') }}</a></li>
                @if (auth()->check() && auth()->user()->user_type_id == 2)
                    <?php
                        $attr = [];
                        $attr['countryCode'] = config('country.icode');
                    ?>
                    <li><a href="{{ lurl(trans('routes.post-create', $attr), $attr) }}">{{ t('lbl_job_post') }}</a></li>
                @else
                    <li><a href="{{ lurl(trans('routes.post-a-job')) }}">{{ t('lbl_job_post') }}</a></li>
                @endif
            </ul>
        </div>

        <div class="col">
            <h6>{{ t('lbl_company') }}</h6>
            <ul>
                <li><a href="{{ lurl(trans('routes.about-us')) }}">{{ t('lbl_about_us') }}</a></li>
                <li><a href="{{ lurl(trans('routes.magazine')) }}">{{ t('lbl_magazine') }}</a></li>
            </ul>
        </div>

        <div class="col">
            <h6>{{ t('lbl_help_contact') }}</h6>
            <ul>
                <?php /*
                <li><a href="{{ lurl(trans('routes.pricing')) }}">{{ t('lbl_packages') }}</a></li>
                */ ?>
                <li><a href="{{ lurl(trans('routes.faq')) }}">{{ t('lbl_faq') }}</a></li>
                <li><a href="{{ lurl(trans('routes.contact')) }}">{{ t('lbl_contact') }}</a></li>
                <li><a href="{{ lurl(trans('routes.feedback')) }}">{{ t('lbl_feedback') }}</a></li>
                <?php /*
                <li><a href="{{ lurl(trans('routes.ourVision')) }}">{{ t('lbl_vision') }}</a></li>
                <li><a href="{{ lurl(trans('routes.videos')) }}">{{ t('lbl_videos') }}</a></li>
                <li><a href="{{ lurl(trans('routes.benefits')) }}">{{ t('lbl_benefits') }}</a></li> */ ?>
            </ul>
        </div>

        <div class="col">
            <h6>{{ t('lbl_customer_care') }}</h6>
            <ul>
                <li><a href="{{ lurl(trans('routes.contact')) }}">{{ t('lbl_email_support') }}</a></li>
            </ul>
            <a href="{{ lurl(trans('routes.contact')) }}" class="get-help">{{ t('lbl_contact_us') }}</a>
        </div>
    </div>
</div>

<div class="about">
    <div class="inner">
        <img data-src="{{ URL::to(config('app.cloud_url').'/images/logo_footer.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo lazyload" />

        @if(isset($footer_text) && !empty($footer_text))
            <p>{!! $footer_text !!}</p>
        @else
            <p>{{ trans('frontPage.footer_about_text') }}</p>
        @endif

        <div class="warranty">
            <img class="lazyload" data-src="{{ URL::to(config('app.cloud_url').'/images/warranty1.png') }}" alt="100% secure" />
            <img class="lazyload" data-src="{{ URL::to(config('app.cloud_url').'/images/warranty2.png') }}" alt="SSL secure" />
            <img class="lazyload" data-src="{{ URL::to(config('app.cloud_url').'/images/warranty3.png') }}" alt="Privacy" />
        </div>
    </div>
</div>

<div class="copyright py-20">
    <div class="inner">
        <p>
            {!! t('copyright', ['year' => date('Y')]) !!}<br />
           
            @if (isset($pages) and $pages->count() > 0)
            
            <?php $i = 0;?>
                
                @foreach($pages as $page)
                    @if($page->type !== 'single')                    
                        <?php

                            $linkTarget = '';

                            if ($page->target_blank == 1) {
                            	$linkTarget = 'target="_blank"';
                            }

                            if ($page->slug == 'faq') {
                            	$link = lurl('/faq');
                            } else {
                            	$link = $page->external_link;
                            }

                            $i = $i + 1;
                        ?>

                        @if (!empty($link))
                            <a href="{!! $link !!}" {!! $linkTarget !!}>{{ $page->name }}</a> -
                        @else
                            <?php $attr = ['slug' => $page->slug];?>
                            <a href="{{ lurl(trans('routes.v-page', $attr), $attr) }}" {!! $linkTarget !!}>{{ $page->name }}</a>@if($i != $pages->count()) - @endif
                        @endif
                    @endif
                @endforeach
            @endif
            -
            <a href="{{ lurl(trans('routes.terms-conditions-model')) }}">{{ t('Terms of Use for Models') }}</a> - 
            <a href="{{ lurl(trans('routes.terms-conditions-client')) }}">{{ t('Terms of Use for Clients') }}</a>
        </p>
        <?php /*
            <p>
                @if (getSegment(1) != trans('routes.countries'))
                    @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)

                        @if( config('country.icode') )
                            <a href="javascript:void(0);" class="mfp-country-select">
                                <img class="flag-icon" src="{{ url('images/flags/32/'.config('country.icode').'.png') }}">
                            </a>
                        @else if (isset( auth()->user()->country_code))
                            <a href="javascript:void(0);" class="mfp-country-select">
                                <img class="flag-icon" src="{{ url('images/flags/32/'.strtolower(auth()->user()->country_code).'.png') }}">
                            </a>
                        @endif
                    @endif
                @endif
            </p> 
        */ ?>
    </div>
</div>

<?php /*
 <!-- Normal cookie consent footer -->
 <div class="col-12 px-20 py-20 text-center">
    @include('cookieConsent::index')
 </div>
*/ ?> 

 <!-- jovan cookie consent code -->
 @include('common.cookie-consent')
 
<!-- Country selection popup in footer -->
{{-- @include('layouts.inc.modal.mfp-change-country') --}}
{{-- Html::script(config('app.cloud_url').'/js/country_popup.js') --}}
<script>
    $(document).ready(function() {
        $('.mfp-country-select').click(function(e) {
            e.preventDefault();
            
            $('.mfp-country-select').magnificPopup({
                items: {
                    src: "#mfp-country",
                    type: "inline"
                },
                closeOnBgClick: false,
                closeBtnInside: true,
            }).magnificPopup('open');
        });
    });
</script>
<!-- Country selection popup in footer end -->

