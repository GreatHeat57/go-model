{{--
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.app')

@section('content')

<style type="text/css">
    .pb-150{
        padding-bottom: 150px;
    }
</style>

<div class="subcover colored-light-blue">
    @if($is_premium_country == 1)
    	<h1>{{ t('Your Contract') }}</h1>
	@else
		<h1>{{ t('Join for free') }}</h1>
	@endif
</div>
    
    <div class="container page-content pt-40 pb-150" id="contract-profile">
			<div class="row">
			        <div class="bg-white box-shadow full-width">
			            <div class="d-flex justify-content-center">
			                <div class="flex-grow-1 mw-720 py-20 px-30">
			                    <div class="text-center py-40 mx-auto mw-706">
			                        <div class="d-block mx-auto feedback-check bg-grey2 mb-40"></div>
			                        	{!! t('partner contract success')!!}
			                    </div>
			                </div>
			            </div>
			        </div>
		</div>
	</div>
@endsection
@section('page-script')
    <link href="{{ url(config('app.cloud_url').'/assets/css/wizard.css') }}" rel="stylesheet">
    <style>
    	.feedback-check { height: 100px; width: 100px; border-radius: 50%; background-image: url(/images/icons/ico-feedback.png); background-image: -webkit-image-set(url(/images/icons/ico-feedback.png) 1x, url(/images/icons/ico-feedback@2x.png) 2x, url(/images/icons/ico-feedback@3x.png) 3x);background-image: image-set(url(/images/icons/ico-feedback.png) 1x, url(/images/icons/ico-feedback@2x.png) 2x, url(/images/icons/ico-feedback@3x.png) 3x);background-position: center center;background-repeat: no-repeat;background-size: 31px;
		}
		.bg-grey2 { background-color: #f1f6fa;}

		.mr-auto, .mx-auto {margin-right: auto!important; }
		.ml-auto, .mx-auto {margin-left: auto!important;}
		.mb-40 {margin-bottom: 40px;}
		.bg-grey2 {background-color: #f1f6fa;}
		.title {font-family: "work_sansbold", Arial, Tahoma;font-size: 18px;}
		.py-40 {padding-top: 40px;padding-bottom: 40px;}

    </style>
@endsection