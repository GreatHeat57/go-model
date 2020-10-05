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
				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">
					
					<?php /*
					@include('flash::message')
					
					@if (isset($errors) and $errors->any())
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif */ ?>

					<div class="w-xl-1220 mx-auto">
					    @include('childs.notification-message')
					</div>
					
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-attach"></i> {{ t('Add a new model book') }} </h2>
					
						<div class="mb30" style="float: right; padding-right: 5px;">
							<a href="{{ lurl('account/model-book') }}">{{ t('My model books') }}</a>
						</div>
						<div style="clear: both;"></div>
						
						<div class="panel-group" id="accordion">
							
							<!-- MODEL BOOK -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#modelbookPanel" data-toggle="collapse" data-parent="#accordion"> {{ t('Model Book') }} </a></h4>
								</div>
								<div class="panel-collapse collapse in" id="modelbookPanel">
									<div class="panel-body">
										<form name="modelbook" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/model-book') }}" enctype="multipart/form-data">
											{!! csrf_field() !!}
											<input name="panel" type="hidden" value="modelbookPanel">
											
											@include('account.modelbook._form')
											
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9"></div>
											</div>
											
											<!-- Button -->
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary">{{ t('Submit') }}</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						
						</div>
						<!--/.row-box End-->
					
					</div>
				</div>
				<!--/.page-content-->
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection

@section('after_styles')
	<link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif	
@endsection