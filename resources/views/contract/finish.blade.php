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
	@if($is_free_country_contract == false)
    	<h1>{{ t('Your Contract') }}</h1>
	@else
		<h1>{{ t('Join for free') }}</h1>
	@endif
</div>

<?php /* @include('contract.inc.wizard') */ ?>
    
    <div class="container page-content pt-40 pb-150" id="contract-profile">
			<div class="row">
	<!-- <div class="h-spacer"></div>
	<div class="main-container" style="padding-top: 0px !important;"> -->
		<!-- <div class="container">
			<div class="row"> -->

				<?php /*
				@if (Session::has('flash_notification'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				
				<div class="col-md-12 page-content">

					@if (Session::has('success'))
						<div class="inner-box category-content">
							<div class="row">
								<div class="col-lg-12">
									<div class="alert alert-success pgray  alert-lg" role="alert">
										<h2 class="no-margin no-padding">&#10004; {{ t('Congratulations!') }}</h2>
										<p>{{ session('message') }} <a href="{{ lurl('/') }}">{{ t('Homepage') }}</a></p>
									</div>
								</div>
							</div>
						</div>
					@endif

				</div> */ ?>

				<!-- <div class="d-flex align-items-center container px-0 mw-970 pt-20"> -->
			        <div class="bg-white box-shadow full-width">
			            <div class="d-flex justify-content-center">
			                <div class="flex-grow-1 mw-720 py-20 px-30">
			                    <div class="text-center py-40 mx-auto mw-706">
			                        <div class="d-block mx-auto feedback-check bg-grey2 mb-40"></div>

			                        @if(Session::has('offlinepaymentmsg') && Session::get('offlinepaymentmsg') == 'yes')
			                        	{!! t('offline payment success message')!!}
									@elseif(Session::has('delayedpaymentmsg') && Session::get('delayedpaymentmsg') == 'yes')
										{!! t('offline payment success message')!!}
									@elseif($is_free_country_contract == true)
										{!! t('free_country_contract_success_content :first_name :contact_url', ['first_name' => $first_name , 'contact_url' => lurl(trans('routes.contact'))]) !!}
									@else
			                        	{!! t('contract_success_payment')!!}
			                        @endif
									
									<?php /*
			                        <span class="title f20">Thank you for your application!</span>
			                        <div class="mx-auto divider"></div>
			                        <p>We will check your application and contact you within the next 48 hours!</p>
			                         
			                        <p class="m-0">When you registered, you provided the following address:<span class="d-block"><?php echo config('app.suppport_email'); ?></span></p>
			                        <?php */ ?>
			                    </div>
			                </div>
			            </div>
			        </div>
			    <!-- </div> -->
			<!-- </div>
		</div> -->
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
		h1{padding: 0 0 35px !important;}

    </style>
    <script type="text/javascript">
    	var username = "<?php echo $username; ?>";
    	var funnelPageName = 'contract_finish';
    </script>
    {{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
@endsection