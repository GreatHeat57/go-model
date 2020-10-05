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
	@include('contract.inc.wizard')
@endsection

@section('content')
	<div class="h-spacer"></div>
	<div class="main-container">
		<div class="container">
			<div class="row">

                @include('contract.inc.notification')

                <div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> {{ t('Profile Data') }}</strong></h2>
						<div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<center>
									<h5>{{ $user->profile->first_name }} {{ $user->profile->last_name }}</h5>
									<h5>{{ $user->profile->street }}</h5>
									<h5>{{ $user->profile->city }}, {{ $user->country_code }} - {{ $user->profile->zip }}</h5>
									<h5>TEL: {{ $user->phone }}</h5>
									<button type="button" id="update-btn" class="btn btn-primary">{{ t('Update Data ')}}<i class="fa fa-edit"></i></button>
								</center>
								<br>
								<form action="{{ lurl('contract/profileUpdate') }}" name="settings" class="form-horizontal" role="form" method="POST" id="user-profile" style="display: none;">
									{!! csrf_field() !!}
									<input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">

                                    <!-- email -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Email') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="email" name="email" type="text" class="form-control" placeholder="{{ t('Email') }}" value="{{ old('email', $user->email) }}" readonly="">
										</div>
									</div>

									<!-- First Name -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('first_name')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('First name') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="first_name" name="first_name" type="text" class="form-control" placeholder="{{ t('First name') }}" value="{{ old('first_name', $user->profile->first_name) }}" required>
										</div>
									</div>

									<!-- Last Name -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('last_name')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Last name') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="last_name" name="last_name" type="text" class="form-control" placeholder="{{ t('Last name') }}" value="{{ old('last_name', $user->profile->last_name) }}" required>
										</div>
									</div>

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
									<div class="form-group required <?php echo (isset($errors) and $errors->has('country')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Country') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="country" name="country" type="text" class="form-control" placeholder="{{ t('Country') }}" value="{{ old('country', $user->country->asciiname) }}" readonly="">
										</div>
									</div>

									<!-- zip -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('zip')) ? 'has-error' : ''; ?>">
										<label class="col-sm-4 control-label">{{ t('Zip') }} <sup>*</sup></label>
										<div class="col-sm-6">
											<input id="zip" name="zip" type="text" class="form-control" placeholder="{{ t('Zip') }}" value="{{ old('zip', $user->profile->zip) }}" required>
										</div>
									</div>

									<!-- gender -->
									<div class="form-group required <?php echo (isset($errors) and $errors->has('gender')) ? 'has-error' : ''; ?>">
										<label class="col-md-4 control-label">{{ t('Gender') }} <sup>*</sup></label>
										<div class="col-md-6">
											@if ($genders->count() > 0)
												@foreach ($genders as $gender)
													<label class="radio-inline" for="gender">
														<input name="gender" id="gender-{{ $gender->tid }}" value="{{ $gender->tid }}"
																type="radio" {{ (old('gender', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }} required>
														{{ $gender->name }}
													</label>
												@endforeach
											@endif
										</div>
									</div>
									
									<!-- Button -->
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-6">
											<button type="submit" class="btn btn-success">{{ t('Update') }}</button>
										</div>
									</div>

									<div style="margin-bottom: 30px;"></div>

								</form>

								<p>
								<?php
									$doc = new DOMDocument();
									$doc->loadHTML('<?xml encoding="UTF-8">' . t('contract_page_content'));
									echo $doc->saveHTML();
								?>
								</p>
								<br>

								<form action="{{ lurl('contract/create') }}" name="proceed" class="form-horizontal" role="form" method="POST">
									
									<div class="well">
										<div class="form-group <?php echo (isset($errors) and $errors->has('package')) ? 'has-error' : ''; ?>"
												style="margin-bottom: 0;">
											<table id="packagesTable" class="table table-hover checkboxtable" style="margin-bottom: 0;">
												<thead>
													<tr>
														<td>{{ t('Package Name') }}</td>
														<td>{{ t('Price') }}</td>
														<td>{{ t('Tax') }}</td>
														<td>{{ t('Duration') }}</td>
													</tr>
												</thead>
												<?php
													// Get Current Payment data
													$currentPaymentMethodId = 0;
													$currentPaymentActive = 1;
													if (isset($currentPayment) and !empty($currentPayment)) {
														$currentPaymentMethodId = $currentPayment->payment_method_id;
														if ($currentPayment->active == 0) {
															$currentPaymentActive = 0;
														}
													}
												?>
												@foreach ($packages as $package)
													<?php
													$currentPackageId = 0;
													$currentPackagePrice = 0;
													$packageStatus = '';
													$badge = '';
													if (isset($currentPaymentPackage) and !empty($currentPaymentPackage)) {
														$currentPackageId = $currentPaymentPackage->tid;
														$currentPackagePrice = $currentPaymentPackage->price;
													}
													// Prevent Package's Downgrading
													if ($currentPackagePrice > $package->price) {
														$packageStatus = ' disabled';
														$badge = ' <span class="label label-danger">'. t('Not available') . '</span>';
													} elseif ($currentPackagePrice == $package->price) {
														$badge = '';
													} else {
														$badge = ' <span class="label label-success">'. t('Upgrade') . '</span>';
													}
													if ($currentPackageId == $package->tid)
													{
														$badge = ' <span class="label label-default">'. t('Current') . '</span>';
														if ($currentPaymentActive == 0) {
															$badge .= ' <span class="label label-warning">'. t('Payment pending') . '</span>';
														}
													}
													?>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input class="package-selection" type="radio" name="package"
																			id="package-{{ $package->tid }}"
																			value="{{ $package->tid }}"
																			data-name="{{ $package->name }}"
																			data-currencysymbol="{{ $package->currency->symbol }}"
																			data-currencyinleft="{{ $package->currency->in_left }}"
																			required
																			{{ (old('package', $currentPackageId)==$package->tid) ? ' checked' : (($package->price==0) ? ' checked' : '') }} {{ $packageStatus }}>
																	<strong class="tooltipHere" title="" data-placement="right" data-toggle="tooltip" data-original-title="{!! $package->description !!}">{!! $package->name . $badge !!} </strong>
																</label>
															</div>
															<div class="features" id="feature-{{ $package->tid }}" style="display: none;">
																<?php
																	$doc = new DOMDocument();
																	if ($package->features) {
																		$doc->loadHTML('<?xml encoding="UTF-8">' . $package->features);
																		echo $doc->saveHTML();
																	}
																?>
															</div>
														</td>
														<td>
															<p id="price-{{ $package->tid }}">
																@if ($package->currency->in_left == 1)
																	<span class="price-currency">{{ $package->currency->symbol }}</span>
																@endif
																<span class="price-int">{{ $package->price }}</span>
																<input type="hidden" id="{{ $package->tid }}-currency" value="{{ $package->currency_code }}">
																@if ($package->currency->in_left == 0)
																	<span class="price-currency">{{ $package->currency->symbol }}</span>
																@endif
															</p>
														</td>
														<td>
															<p id="tax-{{ $package->tid }}">
																<span class="tax-int">{{ $package->tax ? $package->tax : '0.00' }}</span>
															</p>                                                                    
														</td>
														<td>
															<p id="duration-{{ $package->tid }}">
																<span class="duration-int">{{ $package->duration }} {{ t('days') }}</span>
															</p>                                                                    
														</td>
													</tr>
												@endforeach									
											</table>
										</div>
									</div>
									<input name="code" type="hidden" value="{{ $code }}">
									<input name="id" type="hidden" value="{{ $id }}">
									<input name="subid" type="hidden" value="{{ $subid }}">
									<!-- term -->
									<div class="scroll-bar" style="height:180px;overflow-y: scroll;">
										<div class="header">
											@if (empty($page->picture))
												<h1 class="text-center title-1" style="color: {!! $page->name_color !!};"><strong>{{ $page->name }}</strong></h1>
												<hr class="center-block small text-hr" style="background-color: {!! $page->name_color !!};">
											@endif
										</div>
										<div class="body">
											<div class="row">
												<div class="col-sm-12 page-content">
													@if (empty($page->picture))
														<h3 style="text-align: center; color: {!! $page->title_color !!};">{{ $page->title }}</h3>
													@endif
													<div class="text-content text-left from-wysiwyg">
														{!! $page->content !!}
													</div>
												</div>
											</div>
										</div>
										
									</div>
									<div class="row">

										<div class="col-md-12"> {!! t('summery')!!} </div>
										
									</div>
									<div class="form-group required <?php echo (isset($errors) and $errors->has('term')) ? 'has-error' : ''; ?>" style="margin-top: -10px;">

										<label class="col-md-4 control-label"></label>
										<div class="col-md-6">
											<div class="termbox mb10">
												<label class="checkbox-inline" for="term">
													<input name="term" id="term" value="1" type="checkbox" {{ (old('term')=='1') ? 'checked="checked"' : '' }} required>
													{!! t('I have read and agree to the <a :attributes>Terms & Conditions</a>', ['attributes' => 'href="#termPopup" data-toggle="modal"']) !!}
												</label>
											</div>
											<div style="clear:both"></div>
										</div>
									</div>

									<!-- Button -->
									<div class="form-group">
										<div class="col-sm-offset-5 col-sm-6">
											<button type="submit" class="btn btn-success">{{ t('Order in Obligation') }}</button>
										</div>
									</div>

									<div style="margin-bottom: 30px;"></div>
								</form>
							</div>
                        </div>
                    </div>
                </div>
				
                <div class="col-md-3 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>{{ t('Profile Data') }}</strong></h3>
							<p>
								{{ t('Do you have a post to be filled within your company? Find the right candidate in a few clicks at :app_name', ['app_name' => config('app.name')]) }}
							</p>
						</div>

						<div class="panel sidebar-panel">
							<div class="panel-heading uppercase">
								<small><strong>{{ t('How to find quickly a candidate?') }}</strong></small>
							</div>
							<div class="panel-content">
								<div class="panel-body text-left">
									<ul class="list-check">
										<li> {{ t('Use a brief title and description of the ad') }} </li>
										<li> {{ t('Make sure you post in the correct category') }}</li>
										<li> {{ t('Add a logo to your ad') }}</li>
										<li> {{ t('Put a min and max salary') }}</li>
										<li> {{ t('Check the ad before publish') }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@include('layouts.inc.modal.term')

@section('after_styles')
    @include('layouts.inc.tools.wysiwyg.css')
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
		@media screen and (min-width: 768px){
			#termPopup .modal-sm {
				width: 60%;
			}
		}
		#packagesTable > tbody > tr:nth-child(1) > td:nth-child(2), #packagesTable > tbody > tr:nth-child(1) > td:nth-child(3), #packagesTable > tbody > tr:nth-child(1) > td:nth-child(4) {
			width: 15%;
		}
		.features{
			padding: 10px 40px;
		}
		.features ul{
			list-style-type: square;
		}
		#packagesTable{
			font-size: 13px;
		}
		.well{
			width: 96%;
			margin-left: 2%;
		}
	</style>
@endsection

@section('after_scripts')

	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	
    <script src="{{ url('assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
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

		$('#update-btn').click(function() {
			$('#user-profile').slideToggle();
		});

		$('.package-selection').click(function () {
			selectedPackage = $(this).val();
			$('#feature-' + selectedPackage).slideToggle();
		});
	</script>
@endsection
