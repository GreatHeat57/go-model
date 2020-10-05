<?php /*

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
@extends('errors.layouts.master')

@section('title', t('Page not found', []))

@section('search')
	@parent
	@include('errors.layouts.inc.search')
@endsection

@section('content')
	@include('common.spacer')
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						<div class="error-page" style="margin: 100px 0;">
							<h2 class="headline text-center" style="font-size: 180px; float: none;"> 404</h2>
							<div class="text-center m-l-0" style="margin-top: 60px;">
								<h3 class="m-t-0"><i class="fa fa-warning"></i> :-( {{ t('Page not found') }} !</h3>
								<p>
									<?php
                                    $defaultErrorMessage = t('Meanwhile, you may :url return to homepage', ['url' => url('/')]);
									?>
									{!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage() : $defaultErrorMessage) : $defaultErrorMessage !!}
								</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- /.main-container -->
@endsection

*/ ?>

@extends('layouts.app')

@section('content')
<?php $defaultErrorMessage = t('Meanwhile, you may :url return to homepage', ['url' => url('/')]); ?>
<?php $image = url('images/error_images/').'/'.t('404_img_name'); ?>
	<div class="notfoundsection">
         <div class="notfoundsectionwrap">
            <div class="notfoundcontent">
               <div class="somethingwrongtext"><img src="{{ $image }}" alt="404 {{ t('something_went_wrong') }}">
               	<?php // <span>{{ t('something_went_wrong') }}</span> ?>
               </div>
               <div class="notfoundcontentwrap">
                  <h3 class="somethingwrongh3">{{ t('Page not found') }}</h3>
                  <p>{{ t('not_found_paragrah') }}</p>
                  <div class="btn"><a href="{{ lurl('/') }}" class="next section_1">{{ t('go_back') }}</a></div>
               </div>
            </div> 
        </div> 
    </div>

	<div class="block" style="background: #f1f6fa;">
        <h3 class=""></h3>
        <h3 class="playfair warning-font"> </h3>

        <div class="try-it mg-b-20">
        	<!-- <h4 class="warning-font">{!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage() : $defaultErrorMessage) : $defaultErrorMessage !!}</h4> -->
            <!-- <h2 class="mg-b-20">404</h2> -->
        </div>

        <!-- <div class="btn"> -->
            <!-- <a href="{{ lurl('/') }}">{{ t('Home') }}!</a> -->
          <!--   route('book_a_model') -->
        <!-- </div> -->
    </div>
@endsection
