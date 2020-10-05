@extends( 'layouts.app' )

@section('content')
{{-- Html::style(config('app.cloud_url').'/css/app_user.css') --}}
{!! csrf_field() !!}
<input type="hidden" id="post_id" value="{{ $post->id }}">

<?php
// Phone
// $phone = TextToImage::make($post->phone, IMAGETYPE_PNG, ['backgroundColor' => 'rgba(0,0,0,0.0)', 'color' => '#FFFFFF']);
// $phoneLink = 'tel:' . $post->phone;
// $phoneLinkAttr = '';
// if (!auth()->check()) {
//  if (config('settings.single.guests_can_apply_jobs') != '1') {
//      $phone = t('Click to see');
//      $phoneLink = '#quickLogin';
//      $phoneLinkAttr = 'data-toggle="modal"';
//  }
// }

// Contact Recruiter URL
$applyJobURL = '#applyJob';
$applyLinkAttr = 'data-toggle="modal"';

if (!empty($post->application_url)) {
	$applyJobURL = $post->application_url;
	$applyLinkAttr = '';
}

if (!auth()->check()) {
	if (config('settings.single.guests_can_apply_jobs') != '1') {
		$applyJobURL = '#quickLogin';
		$applyLinkAttr = 'data-toggle="modal"';
	}
}
?>
    <?php if ($is_advertising) {?>
        @include('layouts.inc.advertising.top')
    <?php }?>

    <div class="container share-container pt-40 pb-60 px-0">
        <h1 class="text-center prata fs-28">{{ ucWords(t(':type Job', ['type' => $postType->name])) }}</h1>
        <div class="position-relative" wfd-id="33">
            <p class="text-center mb-30 w-lg-596 mx-lg-auto prata"><h1 class=" text-center prata fs-28 job-title">{{ mb_ucfirst($post->title) }}</h1></p>
            <!-- <div class="text-center mb-30 position-absolute-xl xl-to-right-0 xl-to-top-0" wfd-id="34">
               <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default arrow_left  mini-mobile">{{ t('Back to Results') }}</a>
            </div> -->
        </div>
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="box-shadow bg-white py-60 px-38 px-lg-0 w-xl-1220 mx-xl-auto">
            <div class="w-lg-750 w-xl-970 mx-auto">
                <span class="share-post-title">{{ t('Ads Details') }}</span>
                <div class="divider"></div>
                <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">
                    <div class="col-md-6">
                        
                        @if( isset($post->end_application) && $post->end_application != "")
                            <p>
                                <span class="share-post-bold d-inline-block mr-1">{{t('Application Deadline')}}:</span><span class="d-inline-block">{{ \App\Helpers\CommonHelper::getFormatedDate($post->end_application) }} </span>
                            </p>
                        @endif


                        @if (auth()->check())
                            
                            @if (auth()->user()->id == $post->user_id)
                                <p><a title="{{ t('applications') }}" href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">
                                    <span class="share-post-bold d-inline-block mr-1">{{ t('Application') }}:</span>
                                    <span class="d-inline-block">{{ $post->jobApplicationsCount->count() }}
                                    </span></a></p>
                            @else
                                <p><span class="share-post-bold d-inline-block mr-1">{{ t('Application') }}:</span>
                                    <span class="d-inline-block">{{ $post->jobApplicationsCount->count() }}
                                    </span></p>
                            @endif
                        @endif

                        <p>
                            <span class="share-post-bold d-inline-block mr-1">{{ t('Job Views') }}:</span>
                            <span class="d-inline-block">{{ $post->jobVisits->count() }} {{ trans_choice('global.count_views', getPlural($post->jobVisits->count())) }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">

                        <p>
                            <span class="share-post-bold d-inline-block mr-1">{{ t('Location') }}:</span><span class="d-inline-block">
                            <?php

                                $currency_symbol = isset($post->currency->html_entity)? $post->currency->html_entity : isset($post->currency->font_arial)? $post->currency->font_arial : config('currency.symbol');

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
                        </p>

                        <p><span class="share-post-bold d-inline-block mr-1">{{t('Posted On')}} </span><span class="d-inline-block">{{ \App\Helpers\CommonHelper::getFormatedDate($post->created_at) }} </span></p>
                    </div>
                </div>

                  <!-- Partner Categories -->

                @if (count($cat) > 0)
                    <div class="bb-light-lavender3 mb-40 pb-40">
                        <span class="share-post-title">{{ t('Category') }}</span>
                        <div class="divider"></div>
                        @foreach($cat as $cat)
                        <span class="tag mr-2 mb-2">{{ $cat->name }}</span>
                        @endforeach
                    </div>
                @endif
                <div class="text-center mb-30 pt-30 position-relative">
                    <div class="mb-40 details-desc" >
                        <a href='{{ lurl(trans('routes.login')) }}' class="link-message mb-40">    
                            {{ t('Please Login to view full job') }}
                        </a>
                    </div>
                </div>   
               <?php /*<!-- @include('home.inc.featured', ['firstSection' => false]) --> */ ?>
            </div>
        </div>

        
    </div>

    <style type="text/css">
        .details-desc p { text-align: justify; }
        .pointer-disable  { pointer-events: none; }
        .pointer-disable-hiden { pointer-events: none; }
        .label-color { /*color: #06c67b !important;*/ }
        .link-message { /*color: #06c67b !important;*/ text-decoration: underline !important;}
        .btn.applied {
            background-image: url(/images/icons/ico-feedback.png);
            background-image: -webkit-image-set(url(/images/icons/ico-feedback.png) 1x, url(/images/icons/ico-feedback@2x.png) 2x, url(/images/icons/ico-feedback@3x.png) 3x);
            background-image: image-set(url(/images/icons/ico-feedback.png) 1x, url(/images/icons/ico-feedback@2x.png) 2x, url(/images/icons/ico-feedback@3x.png) 3x);
        }
        .is_expired { box-shadow:none; -webkit-box-shadow: none;}
        .is_expired:hover { -webkit-box-shadow:none !important; box-shadow: none !important; }
        .is_expired:focus { -webkit-box-shadow:none !important; box-shadow: none !important; }
        .is_expired:active { -webkit-box-shadow:none !important; box-shadow: none !important; }
    </style>
    
    

@endsection

@section('page-script')
   <script>
        
    </script>


    @if (config('services.googlemaps.key'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script>
    @endif

    <script>
        $(document).ready(function () {
            @if (config('settings.single.show_post_on_googlemap'))
                /* Google Maps */
                getGoogleMaps(
                '{{ config('services.googlemaps.key') }}',
                '{{ (isset($post->city) and !empty($post->city)) ? addslashes($post->lon) . ',' . addslashes($post->lat) : config('country.name') }}',
                '{{ config('app.locale') }}'
                );
            @endif
        });


        function getGoogleMaps(t, e, i) {
            if (void 0 === e) var n = encodeURIComponent($("#address").text());
            else var n = encodeURIComponent(e);
            if (void 0 === i) var i = "en";
            var s = "https://www.google.com/maps/embed/v1/place?key=" + t + "&q=" + n + "&language=" + i + '&zoom=9';
            $("#googleMaps").attr("src", s)
        }

    </script>
@endsection
