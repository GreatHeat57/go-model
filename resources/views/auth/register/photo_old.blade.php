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

@section('wizard')
	@include('auth.register.inc.wizard')
@endsection

@section('content')
	<div class="h-spacer"></div>
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (isset($errors) and $errors->any())
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (Session::has('flash_notification'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-md-8 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-user-add"></i> {{ t('Create your account, Its free') }}</strong></h2>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<h5>{{ t('Photo upload') }}</h5>
								<div style="margin-bottom: 20px;"></div>
								<form name="photo" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">
									
									<!-- logo -->
									<div class="form-group">
										<div class="col-sm-1"></div>
										<div class="col-sm-10">
											<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
												<input name="profile[logo]" type="file" class="file" required>
											</div>
											<div style="margin-bottom: 15px;"></div>
										</div>
										<div class="col-sm-1"></div>
									</div>

									

									<a id="add_line">+ {{ t('Add new picture') }}</a>									
									
									<!-- Button -->
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="submit" class="btn btn-success">{{ t('Upload') }}</button>
										</div>
									</div>
								</form>

								<div style="margin-bottom: 30px;"></div>
									
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>{{ t('Post a Job') }}</strong></h3>
							<p>
								{{ t('Do you have a post to be filled within your company? Find the right candidate in a few clicks at :app_name',
								['app_name' => config('app.name')]) }}
							</p>
						</div>
						<div class="promo-text-box"><i class="icon-pencil-circled fa fa-4x icon-color-2"></i>
							<h3><strong>{{ t('Create and Manage Jobs') }}</strong></h3>
							<p>{{ t('Become a best company, Create and Manage your jobs, Repost your old jobs, etc') }}</p>
						</div>
						<div class="promo-text-box"><i class="icon-heart-2 fa fa-4x icon-color-3"></i>
							<h3><strong>{{ t('Create your Favorite jobs list') }}</strong></h3>
							<p>{{ t('Create your Favorite jobs list, and save your searchs, Don\'t forget any opportunity!') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_styles')
	<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	
	<script>
		var userType = '<?php echo old('user_type', \Illuminate\Support\Facades\Request::input('type')); ?>';

		$(document).ready(function ()
		{
			/* Set user type */
			setUserType(userType);
			$('.user-type').click(function () {
				userType = $(this).val();
				setUserType(userType);
			});

			/* Submit Form */
			$("#signupBtn").click(function () {
				$("#signupForm").submit();
				return false;
			});
		});
	</script>

	<script>
		/* Initialize with defaults (logo) */
		function initFile()
		{
			$('.file').fileinput({
				language: '{{ config('app.locale') }}',
				@if (config('lang.direction') == 'rtl')
					rtl: true,
				@endif
				showPreview: true,
				allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
				showUpload: false,
				showRemove: false,
				maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
			});
		}
		
		initFile();
		
		var num = 0;
		$('#add_line').click(function(){
			var len = $('.photo-form').length;
			num++;
			if (len < 5) {
				var element = `<div class="form-group">
								<div class="col-sm-1"></div>
								<div class="col-sm-10">
									<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
										<input name="modelbook[filename]" type="file" class="file" required>
									</div>
									<div style="margin-bottom: 15px;"></div>
								</div>
								<div class="col-sm-1">
									<a onclick="close_line(this)">X</a>
								</div>										
							</div>`;
				$( element ).insertBefore( "#add_line" );
				initFile();
			}
			if (len == 4) {
				$('#add_line').hide();
			}
			
		});
		function close_line(el)
		{
			var photo = el.parentNode.parentNode;
			photo.parentNode.removeChild(photo);
			$('#add_line').show();
		}
	</script>
@endsection
