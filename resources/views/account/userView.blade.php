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

	<div class="main-container bg">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 dtable-cell hw100">
					<h3 class="no-padding text-center-480 useradmin">
						<a href="">
							@if (!empty($profile->logo))
								<img class="logoImage" src="{{ \Storage::url($profile->logo) }}" alt="{{ trans('metaTags.User') }}">&nbsp;
							@elseif (!empty($gravatar))
								<img class="logoImage" src="{{ $gravatar }}" alt="{{ trans('metaTags.User') }}">&nbsp;
							@else
								<img class="logoImage" src="{{ url('images/user.jpg') }}" alt="{{ trans('metaTags.User') }}">
							@endif
						</a>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="nav-menu hw100">
		<div class="container">
			<div class="row">
			@if ($user_type_id == 3)
				<nav class="col-sm-12">
					<ul>
							<li><a href="#about">{{ t('About') }}</a></li>
						<?php if (isset($education) && sizeof($education) > 0): ?>
							<li><a href="#education">{{ t('Education') }}</a></li>
						<?php endif;?>
						<?php if (isset($experience) && sizeof($experience) > 0): ?>
							<li><a href="#experience">{{ t('Work Experience') }}</a></li>
						<?php endif;?>
						<?php if (isset($modelbooks) && sizeof($modelbooks) > 0): ?>
							<li><a href="#portfolio">{{ t('My model portfolio') }}</a></li>
						<?php endif;?>
						<?php if (isset($talent) && sizeof($talent) > 0): ?>
							<li><a href="#skills">{{ t('Professional skills') }}</a></li>
						<?php endif;?>
						<?php if (isset($awards) && sizeof($awards) > 0): ?>
							<li><a href="#awards">{{ t('Awards') }}</a></li>
						<?php endif;?>
					</ul>
				</nav>
			@endif
			</div>
		</div>
	</div>
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
			@if ($user_type_id == 3)
				<div class="col-sm-12 page-content">
					<div class="inner-box">
						<div id="about" class="paragraph">

							@if($invitation_accepted>0)
								<div class="row">
									<div class="col-md-8"></div>
									<div class="col-md-4">
										<a class="btn btn-primary btn-lg" href="{!! URL::to('account/personalchat',array($model_id)) !!}">{{ t('chat')}}
										</a>
									</div>
									
								</div>
							@endif
							<table class="table">
								<tbody>
									<tr>
										<td><i class="fa fa-eye"></i><div>{{ t('Eye color') }}<br>{{ $eye_color }}</div></td>
										<td><i class="fa fa-adjust"></i><div>{{ t('Skin color') }}<br>{{ $skin_color }}</div></td>
										<td><i class="fa fa-adjust"></i><div>{{ t('Hair color') }}<br>{{ $hair_color }}</div></td>
									</tr>
									<tr>
										<td><i class="fa fa-arrows-v"></i><div>{{ t('Height') }}<br>{{ $height }}</div></td>
										<td><i class="fa fa-dashboard"></i><div>{{ t('Weight') }}<br>{{ $weight }}</div></td>
										<td><i class="icon-t-shirt"></i><div>{{ t('Dress size') }}<br>{{ $dress_size }}</div></td>
									</tr>

									<tr>
										<td><i class="fa fa-strikethrough"></i><div>{{ t('Shoe size') }}<br>{{ $shoe_size }}</div></td>
										<td style="width: 33%"><i class="fa fa-arrows-v"></i><div>{{ t('Intrested job category') }}<br>
											@foreach ($categories as $cat)
												@if(in_array($cat->tid,$parent))
												<span class="badge"> {{ $cat->name }}</span>
												@endif

											@endforeach
										</div></td>
										<td><i class="icon-clock"></i><div>{{ t('Age') }}<br>

										@if($age_year< 1) {{$age_month}} @if($age_month==1)  {{ t('month')}} @else {{t('months')}} @endif
										@endif
										@if($age_year>0) {{ $age_year }} @if($age_year==1) {{t('year old')}} @else {{ t('years old')}} @endif @endif</div></td>
									</tr>

									<tr>
										@if(!empty($facebook))<td><a href="{{ $facebook}}" target="_blank"><i class="icon-facebook"></i></a></td>@endif
										@if(!empty($instagram))<td><a href="{{ $instagram}}" target="_blank"><i class="icon-instagram">I</i></a></td>@endif
										@if(!empty($linkedin))<td><a href="{{ $linkedin}}" target="_blank"><i class="icon-linkedin"></i></a></td>@endif
										@if(!empty($google_plus))<td><a href="{{ $google_plus}}" target="_blank"><i class="icon-google-plus">G</i></a></td>@endif
										@if(!empty($twitter))<td><a href="{{ $twitter}}" target="_blank"><i class="icon-twitter"></i></a></td>@endif
									</tr>

									<tr>
										@if(!empty($facebook))<td><a href="{{ $facebook}}" target="_blank"><i class="icon-facebook"></i></a></td>@endif
										@if(!empty($instagram))<td><a href="{{ $instagram}}" target="_blank"><i class="icon-instagram">I</i></a></td>@endif
										@if(!empty($linkedin))<td><a href="{{ $linkedin}}" target="_blank"><i class="icon-linkedin"></i></a></td>@endif
										@if(!empty($google_plus))<td><a href="{{ $google_plus}}" target="_blank"><i class="icon-google-plus">G</i></a></td>@endif
										@if(!empty($twitter))<td><a href="{{ $twitter}}" target="_blank"><i class="icon-twitter"></i></a></td>@endif
									</tr>

								</tbody>
							</table>

							<div class="description">
								<?php
$doc = new DOMDocument();
if ($profile->description) {
	$doc->loadHTML($profile->description);
	echo $doc->saveHTML();
}
?>
							</div>

						</div>

						<?php if (isset($education) && sizeof($education) > 0): ?>
							<div id="education" class="paragraph">
								<h2><i class="icon-graduation-cap"></i> {{ t('EDUCATION') }} </h2>
								<ul class="education">
									<?php
foreach ($education as $key => $edu):
?>


										<li><p><b>{{$edu['title']}}</b> {{date("Y", strtotime($edu['from']))}} -
											@if(!isset($edu['up_to_date']) || $edu['up_to_date']=='1')
											{{ t('presence')}}
											@else
												{{date("Y", strtotime($edu['to']))}}
											@endif
											<br> {{$edu['institute']}}</p></li>
									<?php endforeach;?>
								</ul>
							</div>
						<?php endif;?>

						<?php if (isset($experience) && sizeof($experience) > 0): ?>
							<div id="experience" class="paragraph">
								<h2><i class="icon-briefcase"></i> {{ t('WORK EXPERIENCE') }} </h2>
								<ul class="experience">
									<?php
foreach ($experience as $key => $edu):
?>

										<li><p><b>{{$edu['title']}}</b> {{date("Y", strtotime($edu['from']))}} - @if(!isset($edu['up_to_date']) || $edu['up_to_date']=='1')
										 {{ t('presence')}}
										@else
										 {{date("Y", strtotime($edu['to']))}}
										@endif
										<br> {{$edu['company']}}</p></li>
									<?php endforeach;?>
								</ul>
							</div>
						<?php endif;?>

						<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-2">
								<label>{{ t('Invite for Post')}}</label>
								<input type="hidden" name="modelid" value='{{$user_id}}' id='model_id'>
								<select class="form-control" name='job' id='job' >
									<option value="">{{ t('Invite for Job')}}</option>
									@foreach($postlist as $getpostlist)
									<option value="{{$getpostlist->id}}">{{$getpostlist->title}}</option>
									@endforeach
								</select><br>
								<button class="btn btn-primary" id='invite_button' onclick ="invitemodel()">{{ t('Send Invitation')}}</button>
							</div>
							<div class="col-md-2">
								<br><a id='fav_button' value='{{ $favorite}}' href="{!!URL::to('account/favorite',array($model_id))!!}" class="btn btn-primary">
									@if($favorite<1) <i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title='{{t ("Add to Favorite")}}'></i>
									@else  <i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title='{{t ("Remove from Favorite")}}'></i>
									@endif
								</a>
							</div>
						</div>
						<?php if (isset($modelbooks) && sizeof($modelbooks) > 0): ?>
							<div id="portfolio" class="paragraph">
								<h2><i class="icon-picture"></i> {{ t('MY MODEL PORTFOLIO') }} </h2>
								<div class="download">
									<a class="btn btn-primary" href="">{{ t('Model Folder')}}</a>
									<a class="btn btn-primary" href="{{ lurl('account/sedcards/downloadsdcard') }}">{{ t('Sedcard')}}</a>
								</div>
								<?php
foreach ($modelbooks as $key => $model):
?>
									<div class="column">
										<a href="{{ \Storage::url($model->filename) }}" data-toggle="lightbox" data-gallery="example-gallery">
											<img src="{{ \Storage::url($model->filename) }}">
										</a>
									</div>
								<?php endforeach;?>
							</div>
						<?php endif;?>

						<?php if (isset($talent) && sizeof($talent) > 0): ?>
							<div id="skills" class="paragraph">
								<h2><i class="fa fa-area-chart"></i> {{ t('PROFESSIONAL SKILLS') }} </h2>
								<?php
foreach ($talent as $key => $tal):
?>
								<div class="skills">
									<h5>{{$tal['title']}}</h5>
									<div class="progress">
										<div class="progress-bar" role="progressbar" style="width: {{$tal['proportion']}}%">
										</div>
									</div>
								</div>
								<?php endforeach;?>
							</div>
						<?php endif;?>

						<?php if (isset($awards) && sizeof($awards) > 0): ?>
							<div id="awards" class="paragraph">
								<h2><i class="icon-trophy"></i> {{ t('AWARDS') }} </h2>
								<ul class="awards">
									<?php
foreach ($awards as $key => $edu):
?>
										<li><p><b>{{$edu['title']}}</b> {{date("Y", strtotime($edu['date']))}} </p></li>
									<?php endforeach;?>
								</ul>
							</div>
						<?php endif;?>
					</div>
				</div>
			@endif
			@if ($user_type_id == 2)
				<div class="col-sm-8 page-content">
					<div class="inner-box">
						<br><br>
						<div class="description">
							<?php
$doc = new DOMDocument();
if ($profile->description) {
	$doc->loadHTML($profile->description);
	echo $doc->saveHTML();
}
?>
						</div>
						<div id="portfolio" class="paragraph">
							<h2><i class="icon-picture"></i> {{ t('MY MODEL PORTFOLIO') }} </h2>
							<?php
foreach ($album as $model):
?>
								<div class="column">
									<a href="{{ \Storage::url('/album/'.$model->filename) }}" data-toggle="lightbox" data-gallery="example-gallery">
										<img src="{{ \Storage::url('/album/'.$model->filename) }}">
									</a>
								</div>
							<?php endforeach;?>
						</div>
					</div>
				</div>
				<div class="col-sm-4 page-content">


					<div class="inner-box">
						<br>
						<h2 class="modal-title"><i class=" icon-mail-2"></i> {{ t('Contact Employer') }} </h2>
						<br>
						@if($active==1)
							<form role="form" method="POST" action="{{ lurl('account/' . $partner->id . '/contact') }}" enctype="multipart/form-data">
								{!! csrf_field() !!}
								@if (isset($errors) and $errors->any() and old('messageForm')=='1')
									<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<ul class="list list-check">
											@foreach($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif

								<!-- phone -->
								<div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
									<label for="phone" class="control-label">{{ t('Phone Number') }}
										@if (!isEnabledField('email'))
											<sup>*</sup>
										@endif
									</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="icon-phone-1"></i></span>
										<input id="phone" name="phone" type="text"
											placeholder="{{ t('Phone Number') }}"
											maxlength="60" class="form-control" value="{{ old('phone', (auth()->check()) ? auth()->user()->phone : '') }}">
									</div>
								</div>

								<!-- message -->
								<div class="form-group required <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">
									<label for="message" class="control-label">{{ t('Message') }} <span class="text-count">(500 max)</span> <sup>*</sup></label>
									<textarea id="message" name="message" class="form-control required" placeholder="{{ t('Your message here') }}" rows="5">{{ old('message') }}</textarea>
								</div>

								<a id="add_line">+ {{ t('Add new picture') }}</a>

								<br><br>
								<button type="submit" class="btn btn-success pull-right">{{ t('Send message') }}</button>
							</form>
						@else


						<div class="alert alert-danger">
						  <strong>{{ t('warning') }}</strong>  {{ t('this_partner_profile_is_not_fully_activated_yet') }}
						</div>
						@endif

						<div style="padding-bottom: 50px;"></div>
						<div class="form-group">
							<iframe id="googleMaps" src="" width="100%" height="250" frameborder="0" style="border:0; pointer-events:none; padding-top: 20px;"></iframe>
						</div>
					</div>

				</div>
			@endif
			</div>
		</div>
	</div>
@endsection

@section('after_styles')
	<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<link rel="stylesheet" href="{{ url('assets/css/ekko-lightbox.css') }}">
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.download {
			padding: 0px 40px 5px 40px;
			overflow: hidden;
		}
		.download a {
			float: right;
			margin-right: 10px;
		}
		.bg {
			background: #666;
			display: flex;
			align-items: center;
			padding: 0px;
			background: url("{{\Storage::url($profile->cover)}}") no-repeat center center fixed;
			background-size: cover;
		}
		.logoImage {
			width: 100px;
			height: 100px;
			border-radius: 50px;
		}
		.nav-menu {
			height: 49px;
			background: #333;
			display: flex;
			align-items: center;
			color: #fff;
		}
		.nav-menu a {
			font-size: 14px;
			color: #fff;
		}
		nav ul {
			display: flex;
		}
		nav ul li {
			padding-right: 15px;
		}
		.paragraph {
			padding: 20px;
			overflow: hidden;
		}
		#about td {
			border: none;
			align-items: center;
		}
		#about td i {
			font-size: 20px;
			color: #969696;
			float: left;
			margin-top: 8px;
			width: 25px;
		}
		#about td .icon-t-shirt {
			font-size: 16px;
		}
		#about td .fa-arrows-v {
			padding-left: 5px;
		}
		#about td div {
			padding-left: 10px;
			float: left;
		}
		.description {
			padding-left: 20px;
		}
		.education, .experience, .awards {
			padding-left: 40px;
		}
		.education li, .experience li, .awards li {
			list-style-type: circle;
		}
		.column {
			padding: 10px;
			float: left;
		}
		.column img {
			height: 160px;
		}
		.progress {
			height: 11px;
		}
		.progress-bar {
			background-color: #666;
			border-radius: 0px 25px 25px 0px;
		}
		.skills {
			padding-left: 35px;
			padding-right: 35px;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	<script src="{{ url('assets/js/ekko-lightbox.js') }}"></script>
	<script>
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox();
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
				showPreview: false,
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
				var element = `<div class="form-group photo-form">
									<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
										<input name="special[filename` + len + `]" type="file" class="file" required>
									</div>
									<div style="margin-bottom: 15px;"></div>
								</div>`;
				$( element ).insertBefore( "#add_line" );
				initFile();
			}
			if (len == 4) {
				$('#add_line').hide();
			}
		});
	</script>
	@if (config('services.googlemaps.key') && $user_type_id == 2)
	<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function () {
			getGoogleMaps(
				'<?php echo config('services.googlemaps.key'); ?>',
				'<?php echo $partner->profile->street . ',' . $partner->profile->city . ',' . $partner->profile->country ?>',
				'<?php echo config('app.locale'); ?>'
			);
		})
	</script>
	@endif
@endsection
