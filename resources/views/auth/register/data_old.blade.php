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
								<form name="asd" class="form-horizontal" role="form" method="POST" action="{{ url()->current() }}">
									{!! csrf_field() !!}
									<input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">

									@if ($user->user_type_id == 3)
									<!-- birthday -->
									<div class="form-group required">                                
										<label class="col-sm-4 control-label">{{ t('Birthday') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<div id = "cs_birthday">
											</div>
										</div>
									</div>

									<!-- Parent fname -->
									<div class="form-group required parent_details <?php echo (isset($errors) and $errors->has('fname_parent')) ? 'has-error' : ''; ?>" style = "display: none;">
										<label class="col-sm-4 control-label">{{ t('fname_parent') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="fname_parent" name="fname_parent" type="text" class="form-control" placeholder="{{ t('fname_parent') }}" value="{{ old('fname_parent', $user->profile->fname_parent) }}" >
										</div>
									</div>

									<!-- Parent lname -->
									<div class="form-group required parent_details <?php echo (isset($errors) and $errors->has('lname_parent')) ? 'has-error' : ''; ?>" style = "display: none;">
										<label class="col-sm-4 control-label">{{ t('lname_parent') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="lname_parent" name="lname_parent" type="text" class="form-control" placeholder="{{ t('lname_parent') }}" value="{{ old('lname_parent', $user->profile->lname_parent) }}" >
										</div>
									</div>
									
									<!-- Category -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('category')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Category') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="category" id="category" class="form-control" required>
												<option value="">{{ t('Select a category') }}</option>
												@foreach ($modelCategories as $cat)
													<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"  {{ ($user->profile->category_id == $cat->tid) ? 'selected' : '' }}> {{ $cat->name }} </option>
												@endforeach
											</select>
										</div>
									</div>

									<!-- email -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Email') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="email" name="email" type="text" class="form-control" placeholder="{{ t('Email') }}" value="{{ old('email', $user->email) }}" readonly="">
										</div>
									</div>
									@endif

									@if ($user->user_type_id == 2)
									<!-- Branch -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('category')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Branch') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="category" id="category" class="form-control" required>
												<option value="">{{ t('Select a branch') }}</option>
												@foreach ($branches as $key=>$cat)
													<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}" {{ ($user->profile->category_id == $key) ? 'selected' : '' }}> {{ $cat->name }} </option>
												@endforeach
											</select>
										</div>
									</div>
									@endif

									<!-- phone -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
										<label for="phone" class="col-sm-4 control-label">{{ t('Phone') }}<sup>*</sup></label>
										<div class="col-sm-6">
											<div class="btn-group">
												<div id="input-phone" class="input-phone search-field"></div>
											</div>
										</div>
									</div>

									<!-- street -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('street')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Street') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="street" name="street" type="text" class="form-control" placeholder="{{ t('Street') }}" value="{{ old('street', $user->profile->street) }}" required>
										</div>
									</div>

									<!-- city -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('city')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('City') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="city" name="city" type="text" class="form-control" placeholder="{{ t('City') }}" value="{{ old('city', $user->profile->city) }}" required>
										</div>
									</div>

									<!-- country -->
									<!-- <div class="form-group required <?php echo (isset($errors) and $errors->has('country')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Country') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="country" name="country" type="text" class="form-control" placeholder="{{ t('Country') }}" value="{{ old('country', $user->country->asciiname) }}" readonly="">
										</div>
									</div> -->
									 <div class="form-group required <?php echo (isset($errors) and $errors->has('country')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Country') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select id="country" name="country" class="form-control sselecter" required>
														<option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{ (old('country', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$user->country->code) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
														@endforeach
											</select>
										</div>
									</div> 

									<!-- zip -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('zip')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Zip') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="zip" name="zip" type="text" class="form-control" placeholder="{{ t('Zip') }}" value="{{ old('zip', $user->profile->zip) }}" required>
										</div>
									</div>

									@if ($user->user_type_id == 3)
									<!-- Body Height -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('height')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Body height') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="height" id="height" class="form-control" required>
												<option value="">{{ t('Select height') }}</option>
												<?php
													foreach($properties['height'] as $key=>$cat){
														?>
														<option value="<?= $key ?>"  {{ ($user->profile->height_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<!-- Body Weight -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('weight')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Body weight') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="weight" id="weight" class="form-control" required>
												<option value="">{{ t('Select weight') }}</option>
												<?php
													foreach($properties['mass'] as $key=>$cat){
														?>
														<option value="<?= $key ?>"  {{ ($user->profile->weight_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<!-- Dress size -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('dressSize')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Dress size') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="dressSize" id="dressSize" class="form-control" required>
												<option value="">{{ t('Select dress size') }}</option>
												<?php
													foreach($properties['dress_size'] as $key=>$cat){
														?>
														<option value="<?= $key ?>"  {{ ($user->profile->size_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<!-- Eye color -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('eyeColor')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Eye color') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="eyeColor" id="eyeColor" class="form-control" required>
												<option value="">{{ t('Select eye color') }}</option>
												<?php
													foreach($properties['eye_color'] as $key=>$cat){
														?>
														<option value="<?= $key ?>"  {{ ($user->profile->eye_color_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<!-- Hair color -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('hairColor')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Hair color') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="hairColor" id="hairColor" class="form-control" required>
												<option value="">{{ t('Select hair color') }}</option>
												<?php
													foreach($properties['hair_color'] as $key=>$cat){
														?>
														<option value="<?= $key ?>"  {{ ($user->profile->hair_color_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<!-- Shoe size -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('shoeSize')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Shoe size') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="shoeSize" id="shoeSize" class="form-control" required>
												<option value="">{{ t('Select shoe size') }}</option>
												<?php
													foreach($properties['shoe_size'] as $key=>$cat){
														?>
														<option value="<?= $key ?>"  {{ ($user->profile->shoes_size_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<!-- Skin color -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('skinColor')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Skin color') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<select name="skinColor" id="skinColor" class="form-control" required>
												<option value="">{{ t('Select skin color') }}</option>
												<?php
													foreach($properties['skin_color'] as $key=>$cat){
														?>
														<option value="<?= $key ?>"  {{ ($user->profile->skin_color_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
									@endif

									<!-- gender -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('gender')) ? 'has-error' : ''; ?>">
										<label class="col-md-4 control-label">{{ t('Gender') }} <sup>*</sup></label>
										<div class="col-md-6">
											@if ($genders->count() > 0)
												@foreach ($genders as $gender)
													<label class="radio-inline" for="gender">
														<input name="gender" id="gender-{{ $gender->tid }}" value="{{ $gender->tid }}"
																type="radio" {{ (old('gender', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }} required>
														{{ t($gender->name) }}
													</label>
												@endforeach
											@endif
										</div>
									</div>
									
									<!-- Button -->
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-6">
											<button type="submit" class="btn btn-success">{{ t('Submit') }}</button>
										</div>
									</div>

									<div style="margin-bottom: 30px;"></div>

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



@section('after_styles')
	<link rel="stylesheet" href="{{ url('assets/css/intlInputPhone.css') }}">
	<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.custom_birthday {
			width: 30%;
			float: left;
			margin-right: 10px;
		}
		#input-phone button {
			line-height: 30.7px;
		}
		.btn-success {
			padding: 8px 12px;
			background-color: #2ecc71;
			border-color: #2ecc71;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif

	@if(Lang::locale()=='de')
	<script src="{{ url('assets/plugins/jquery-birthday-picker/jquery-birthday-picker-de.min.js') }}" type="text/javascript"></script>
	@else
	<script src="{{ url('assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
	
	@endif
	
	<script src="{{ url('assets/js/initPhone.js') }}"></script>
	<script src="{{ url('assets/js/intlInputPhone.js') }}"></script>
	
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
			jQuery(".input-phone").intlInputPhone();

			var userType = {{ $user->user_type_id }};
			if (userType == 2) {
				$('.for-employer').show();
				$('.for-model').hide();
			}
			if (userType == 3) {
				$('.for-employer').hide();		
				$('.for-model').show();		
			}
		});
	</script>

	<script>
		jQuery("#cs_birthday").birthdayPicker({
            dateFormat: "littleEndian",
            sizeClass: "form-control custom_birthday",
            callback: selected_date
        });

        function selected_date($date) {
            var selected_date = $date;
            var DOB = new Date(selected_date);
            var today = new Date();
            var age = today.getTime() - DOB.getTime();

            age = Math.floor(age / (1000 * 60 * 60 * 24 * 365.25));

            if (age < 18) {
                jQuery(".parent_details").css("display", "block");
            } else {
                jQuery(".parent_details").css("display", "none");
            }
        }

		function set_date($date){
			if ( $date != '' ) {
				var DOB = new Date($date);
				$('select.birthYear').val(DOB.getFullYear());
				$('select.birthMonth').val(DOB.getMonth() + 1);
				$('select.birthDate').val(DOB.getDate());

				$('[name="cs_birthday_birthDay"]').val($date);
				selected_date($date);
			}
		}

		set_date('<?php echo $user->profile->birth_day ?>');
	</script>
@endsection
