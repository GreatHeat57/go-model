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
@extends('layouts.master')

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				@if (Session::has('flash_notification'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">

                    <div class="inner-box">
						<h2 class="title-2"><i class="icon-eye"></i> {{ t('Add talents') }} </h2>
					
						<div class="mb30" style="float: right; padding-right: 5px;">
							<a href="{{ lurl('account/profile') }}">{{ t('My profile') }}</a>
						</div>
						<div style="clear: both;"></div>
						
						<div class="panel-group" id="accordion">
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#educationPannel" data-toggle="collapse" data-parent="#accordion"> {{ t('Talents') }} </a></h4>
								</div>
								<div class="panel-collapse collapse in" id="educationPannel">
									<div class="panel-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/profile/talent') }}" enctype="multipart/form-data">
											{!! csrf_field() !!}
											<!-- talents.title -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('talents.title')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Heading of the ability') }}</label>
												<div class="col-sm-8">
													<input name="title" type="text" class="form-control" placeholder="{{ t('Heading of the ability') }}" value="{{ old('name', '') }}" required>
												</div>
											</div>

											<!-- talents.proportion -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('talents.proportion')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('proportion of') }}</label>
												<div class="col-sm-3">
													<input name="proportion" type="text" class="form-control" placeholder="{{ t('proportion of') }}" value="{{ old('name','') }}" required>
												</div>
											</div>

											<!-- Button -->
											<div class="form-group">
												<div class="col-sm-offset-5 col-sm-7">
													<button name="create" type="submit" class="btn btn-primary">{{ t('Submit') }}</button>
												</div>
											</div>
													
										</form>
									</div>
								</div>
							</div>
						
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_styles')
	<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	<link media="all" rel="stylesheet" type="text/css" href="{{ url('assets/plugins/simditor/styles/simditor.css') }}" />
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
@endsection
