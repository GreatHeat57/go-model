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
				<?php /*
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
				*/ ?>
				<div class="w-xl-1220 mx-auto">
				    @include('childs.notification-message')
				</div>

				<div class="col-md-8 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-user-add"></i> {{ t('Create your account, Its free') }}</strong></h2>
						<div class="row">

							@if (config('settings.social_auth.social_login_activation'))
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mb30">
									<div class="row row-centered">
										<div class="col-lg-11 col-md-11 col-sm-12 col-xs-12 col-centered small-gutter">
											<div class="col-md-6 col-xs-12 mb5">
												<div class="col-xs-12 btn btn-lg btn-fb">
													<a class="btn-fb" id="fb_login"><i class="icon-facebook"></i> {!! t('Connect with Facebook') !!}</a>
												</div>
											</div>
											<div class="col-md-6 col-xs-12 mb5">
												<div class="col-xs-12 btn btn-lg btn-danger">
													<a class="btn-danger" id="google_login"><i class="icon-googleplus-rect"></i> {!! t('Connect with Google') !!}</a>
												</div>
											</div>
										</div>
									</div>

									<div class="row row-centered loginOr">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 col-centered mb5">
											<hr class="hrOr">
											<span class="spanOr rounded">{{ t('or') }}</span>
										</div>
									</div>
								</div>
							@endif

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<form id="signupForm" class="form-horizontal" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>
										<?php
/*
<!-- gender -->
<div class="form-group required <?php echo (isset($errors) and $errors->has('gender')) ? 'has-error' : ''; ?>">
<label class="col-md-3 control-label">{{ t('Gender') }} <sup>*</sup></label>
<div class="col-md-7">
<select name="gender" id="gender" class="form-control selecter">
<option value="0"
@if (old('gender')=='' or old('gender')==0)
selected="selected"
@endif
> {{ t('Select') }} </option>
@foreach ($genders as $gender)
<option value="{{ $gender->tid }}"
@if (old('gender')==$gender->tid)
selected="selected"
@endif
>
{{ $gender->name }}
</option>
@endforeach
</select>
</div>
</div>
 */
?>

										<!-- name -->
										<!-- <div class="form-group required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label">{{ t('Name') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input name="name" placeholder="{{ t('Name') }}" class="form-control input-md" type="text" value="{{ old('name') }}">
											</div>
										</div> -->

										<!-- first_name -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('first_name')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label">{{ t('First Name') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input name="first_name" placeholder="{{ t('First Name') }}" class="form-control input-md" type="text" value="{{ old('first_name') }}">
											</div>
										</div>

										<!-- last_name -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('last_name')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label">{{ t('Last Name') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input name="last_name" placeholder="{{ t('Last Name') }}" class="form-control input-md" type="text" value="{{ old('last_name') }}">
											</div>
										</div>

										<!-- user_type -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('user_type')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label">{{ t('You are a') }} <sup>*</sup></label>
											<div class="col-md-6">
												@foreach ($userTypes as $type)
													@if ($type->id != 4)
														<label class="radio-inline" for="user_type-{{ $type->id }}">
															<input type="radio" name="user_type" id="userType-{{ $type->id }}" class="user-type"
																value="{{ $type->id }}" {{ (old('user_type', \Illuminate\Support\Facades\Request::input('type'))==$type->id) ? 'checked="checked"' : '' }}>
															{{ t('' . $type->name) }}
														</label>
													@endif
												@endforeach
											</div>
										</div>

										<!-- company_name -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('company_name')) ? 'has-error' : ''; ?> for-employer" style="display: <?php echo (old('user_type', \Illuminate\Support\Facades\Request::input('type')) == 3) ? 'none' : 'block'; ?>">
											<label class="col-md-4 control-label" for="company_name">{{ t('Company Name') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input name="company_name" placeholder="{{ t('Company Name') }}" class="form-control input-md" type="text" value="{{ old('company_name') }}">
											</div>
										</div>

										<!-- website -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('website')) ? 'has-error' : ''; ?> for-employer" style="display: <?php echo (old('user_type', \Illuminate\Support\Facades\Request::input('type')) == 3) ? 'none' : 'block'; ?>">
											<label class="col-md-4 control-label" for="website">{{ t('Website') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input name="website" placeholder="{{ t('Website') }}" class="form-control input-md" type="text" value="{{ old('website') }}">
											</div>
										</div>

										<!-- country -->
										@if (empty(config('country.code')))
											<div class="form-group required <?php echo (isset($errors) and $errors->has('country')) ? 'has-error' : ''; ?>">
												<label class="col-md-4 control-label" for="country">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-6">
													<select id="country" name="country" class="form-control sselecter">
														<option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}>{{ t('Select') }}</option>
														@foreach ($countries as $code => $item)
															<option value="{{ $code }}" {{ (old('country', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$code) ? 'selected="selected"' : '' }}>
																{{ $item->get('name') }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="country" name="country" type="hidden" value="{{ config('country.code') }}">
										@endif

										@if (isEnabledField('phone'))
										<!-- phone -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label">{{ t('Phone') }}
												@if (!isEnabledField('email'))
													<sup>*</sup>
												@endif
											</label>
											<div class="col-md-6">
												<div class="input-group">
													<span id="phoneCountry" class="input-group-addon">{!! getPhoneIcon(old('country', config('country.code'))) !!}</span>
													<input name="phone" placeholder="{{ t('Phone Number') }}"
														   class="form-control input-md" type="text" value="{{ phoneFormat(old('phone'), old('country', config('country.code'))) }}">
												</div>
											</div>
										</div>
										@endif

										@if (isEnabledField('email'))
										<!-- email -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label" for="email">{{ t('Email') }}
												@if (!isEnabledField('phone'))
													<sup>*</sup>
												@endif
											</label>
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-mail"></i></span>
													<input id="email" name="email" type="email" class="form-control" placeholder="{{ t('Email') }}" value="{{ old('email') }}">
												</div>
											</div>
										</div>
										@endif

										@if (isEnabledField('username'))
										<!-- username -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('username')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label" for="email">{{ t('Username') }}</label>
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-user"></i></span>
													<input id="username" name="username" type="text" class="form-control" placeholder="{{ t('Username') }}" value="{{ old('username') }}">
												</div>
											</div>
										</div>
										@endif

										<!-- password -->
										<!-- <div class="form-group required <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
											<label class="col-md-4 control-label" for="password">{{ t('Password') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input id="password" name="password" type="password" class="form-control" placeholder="{{ t('Password') }}">
												<br>
												<input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="{{ t('Password Confirmation') }}">
												<p class="help-block">{{ t('At least 5 characters') }}</p>
											</div>
										</div> -->

										@if (config('larapen.core.register.showCompanyFields'))
										<div id="companyBloc">
											<div class="content-subheading">
												<i class="icon-town-hall fa"></i>
												<strong>{{ t('Company Information') }}</strong>
											</div>

											@include('account.company._form', ['originForm' => 'user'])
										</div>
										@endif

										@if (config('larapen.core.register.showResumeFields'))
										<div id="resumeBloc">
											<div class="content-subheading">
												<i class="icon-attach fa"></i>
												<strong>{{ t('Resume') }}</strong>
											</div>

											@include('account.resume._form', ['originForm' => 'user'])
										</div>
										@endif

										@if (config('settings.security.recaptcha_activation'))
											<!-- g-recaptcha-response -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
												<label class="col-md-4 control-label" for="g-recaptcha-response"></label>
												<div class="col-md-6">
													{!! Captcha::display($attributes = [], $options = ['lang' => config('lang.locale')]) !!}
												</div>
											</div>
										@endif

										<!-- term -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('term')) ? 'has-error' : ''; ?>"
											 style="margin-top: -10px;">
											<label class="col-md-4 control-label"></label>
											<div class="col-md-6">
												<div class="termbox mb10">
													<label class="checkbox-inline" for="term">
														<input name="term" id="term" value="1" type="checkbox" {{ (old('term')=='1') ? 'checked="checked"' : '' }}>
														<span class="for-model" style="display: none">{!! t('I have read and agree to the <a :attributes>Terms & Conditions</a>', ['attributes' => 'href="#termModel" data-toggle="modal"']) !!}</span>
														<span class="for-employer">{!! t('I have read and agree to the <a :attributes>Terms & Conditions</a>', ['attributes' => 'href="#termPartner" data-toggle="modal"']) !!}</span>
														<!-- {!! t('I have read and agree to the <a :attributes>Terms & Conditions</a>', ['attributes' => getUrlPageByType('terms')]) !!} -->
													</label>
												</div>
												<div style="clear:both"></div>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group">
											<label class="col-md-4 control-label"></label>
											<div class="col-md-8">
												<button id="signupBtn" class="btn btn-success btn-lg"> {{ t('Register') }} </button>
											</div>
										</div>

										<div style="margin-bottom: 30px;"></div>

									</fieldset>
								</form>
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

@include('layouts.inc.modal.model.term')
@include('layouts.inc.modal.partner.term')

@section('after_styles')
	<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		@media screen and (min-width: 768px){
			#termModel .modal-sm, #termPartner .modal-sm {
				width: 60%;
			}
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif

	<script>
		var userType = '<?php echo old('user_type', \Illuminate\Support\Facades\Request::input('type')); ?>';

		$(document).ready(function ()
		{
			/* Set user type */
			setUserType(userType);
			if (userType == 2) {
				$('.for-employer').show();
				$('.for-model').hide();
			}
			if (userType == 3) {
				$('.for-employer').hide();
				$('.for-model').show();
			}

			$('.user-type').click(function () {
				userType = $(this).val();

				if (userType == 2) {
					$('.for-employer').show();
					$('.for-model').hide();
				}
				if (userType == 3) {
					$('.for-employer').hide();
					$('.for-model').show();
				}
				setUserType(userType);
			});

			/* Submit Form */
			$("#signupBtn").click(function () {
				$("#signupForm").submit();
				return false;
			});

			$("#fb_login").click(function () {
				if ($("#term")[0].checked) {
					window.location = "{{ lurl('auth/facebook') }}";
				} else {
					alert("{{ t('The terms must be accepted')}}");
				}
			});

			$("#google_login").click(function () {
				if ($("#term")[0].checked) {
					window.location = "{{ lurl('auth/google') }}";
				} else {
					alert("{{ t('The terms must be accepted')}}");
				}
			});
		});
	</script>
@endsection
