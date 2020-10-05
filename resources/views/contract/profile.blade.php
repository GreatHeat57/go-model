@extends('layouts.app')

@section('content')
	{{ Html::style(config('app.cloud_url').'/css/bladeCss/contractProfile-blade.css') }}
	{{ Html::style(config('app.cloud_url').'/css/bladeCss/table-blade.min.css') }}
	<div class="subcover colored-light-blue">
		@if($is_free_access_user == false)
        	<h1>{{ t('Your Contract') }}</h1>
    	@else
    		<h1>{{ t('Join for free') }}</h1>
    	@endif
    </div>

    <div class="container page-content pt-20" id="contract-profile">
        @include('contract.inc.notification')
    </div>
    
    <?php /* @include('contract.inc.wizard') */ ?>
    	@if($is_free_access_user == false)
	     	<div class="container page-content pt-20" id="contract-profile">
				<div class="row">
					<div class="container api-error-message" style="margin-bottom: -10px; margin-top: -10px; display: none;">
				        <div class="row">
				            <div class="col-lg-12">
				                <div class="alert alert-danger ">
				                	<?php echo t('some error occurred'); ?>
				        		</div>
				    		</div>
				        </div>
				    </div>
					 
	                <div class="bg-white box-shadow full-width p-2">
	                	<div class="col-md-12 col-xs-12 col-sm-12 float-left">
	                		<div class="inner-box category-content" style="padding-left: 50px;padding-right: 50px;">
	                			<div class="row">
	                				<div class="col-md-12" style="float:right;text-align:center;padding:20px;">
										<h5 class="user_name">
											@if($user->profile->first_name){{ $user->profile->first_name }}@endif
											@if($user->profile->last_name){{ $user->profile->last_name }}@endif
										</h5>
										<?php
											$location = '';
											/*
											// if (!empty($user->profile->city) && !empty($user->country_code) && !empty($user->profile->zip)) {
											// 	$location =  $user->profile->zip;
											// } 
											*/
										?>
										
											@if(!empty($user->profile->street))
												<h5><span class="user_street">{{ $user->profile->street }} </span></h5>
											@endif
											<h5>
												<span class="user_location">{{ $user->profile->zip }}</span>
												<span id='city_nm'> {{ $user->profile->city }}</span>
											</h5>
											<h5><span id='country_nm'>{{ $user->country_name }}</span></h5>
										@if(!empty($user->phone))<h5>Tel: {{ $user->phone_code }} {{ $user->phone }}</h5>@endif										
									</div>
								</div>
								<div class="row">
									<div class="col-md-12" style="float:right;text-align:center;padding:20px;">
										
										<div class="btn mb-30">
	                						<button id="{{ $user->id }}" class="green next mfp-profile" type="submit">{{ t('Update Profile')}}</button>
	            						</div>
	            						<div class="alert alert-danger print-error-msg" style="display:none"></div>
										<div class="alert alert-success print-success-msg" style="display:none"></div>
	            						<?php /*
										<button type="button" id="{{ $user->id }}" class="btn btn-success cursor-pointer mfp-profile ">{{ t('Update Profile')}}<i class="fa fa-edit"></i></button>
										*/ ?>
									</div>
								</div>
	                		</div>
	                	</div>
	                </div>
	            </div>
	        </div>
        @endif
        <div class="container page-content pt-20 pb-150" id="contract-profile">
			<div class="row">
            <div class="bg-white box-shadow full-width p-2">
                <div class="col-md-12 col-xs-12 col-sm-12 float-left">
					<div class="inner-box category-content">
						<?php /* <div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="float:left;">
									<img src="http://localhost/demo/model.jpg" alt="{{ $user->profile->first_name }} {{ $user->profile->last_name }}" width="100%">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5 class="user_name">
										@if($user->profile->first_name){{ $user->profile->first_name }}@endif
										@if($user->profile->last_name){{ $user->profile->last_name }}@endif
									</h5>

										@if(!empty($user->profile->street))
											<h5 class="user_street">{{ $user->profile->street }}</h5>
										@endif
										
										<?php
											$location = '';
											if (!empty($user->profile->city) && !empty($user->country_code) && !empty($user->profile->zip)) {
												$location =  $user->profile->zip;
											} 
										?>
										@if(!empty($location))
											<h5 class="user_location">{{ $location }}</h5>
										@endif
										
										<span id='city_nm'>{{ $user->profile->city }}</span> - <span id='country_nm'>{{ $user->country_name }}</span>

									@if(!empty($user->phone))<h5>TEL: {{ $user->phone }}</h5>@endif
									<button type="button" id="{{ $user->id }}" class="btn btn-success cursor-pointer mfp-profile ">{{ t('Update Profile')}}<i class="fa fa-edit"></i></button>			
								</div>
							</div>
						</div> */ ?>
						<div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<?php /* <center>
									<h5 class="user_name">
										@if($user->profile->first_name){{ $user->profile->first_name }}@endif
										@if($user->profile->last_name){{ $user->profile->last_name }}@endif
									</h5>

										@if(!empty($user->profile->street))
											<h5 class="user_street">{{ $user->profile->street }}</h5>
										@endif
										
										<?php
											$location = '';
											if (!empty($user->profile->city) && !empty($user->country_code) && !empty($user->profile->zip)) {
												$location =  $user->profile->zip;
											} 
										?>
										@if(!empty($location))
											<h5 class="user_location">{{ $location }}</h5>
										@endif
										
										<span id='city_nm'>{{ $user->profile->city }}</span> - <span id='country_nm'>{{ $user->country_name }}</span>

									@if(!empty($user->phone))<h5>TEL: {{ $user->phone }}</h5>@endif
									<button type="button" id="{{ $user->id }}" class="btn btn-success cursor-pointer mfp-profile ">{{ t('Update Profile')}}<i class="fa fa-edit"></i></button>
								</center>
								*/ ?>
								<?php /*
								<form action="{{ lurl('contract/profileUpdate') }}" name="settings" class="form-horizontal" role="form" method="POST" id="user-profile" >
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
										<div class="col-sm-7">
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

									<div class="row">
				                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('country') ? 'has-error' : ''}}">
				                                {{ Form::label(t('Select a country').' *', t('Select a country').' *', ['class' => 'control-label required  input-label position-relative']) }}

				                                <?php
													// get old country value
													$country_option = isset($user->country_code) ? $user->country_code : '0';
												?>

				                                <select id="country" name="country" class="form-control form-select2" required>
				                                    <option value="0" {{ (!old('country') or old('country')==0 or $country_option == 0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
				                                        @foreach ($countries as $item)
				                                            <option value="{{ $item->get('code') }}" @if($country_option == $item->get('code'))  selected="selected"  @endif >{{ $item->get('name') }}</option>
				                                        @endforeach
				                                </select>
				                                <input type="hidden" name="country_name" id='country_name'>
				                                 {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
				                            </div>
				                            
				                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('city') ? 'has-error' : ''}} ">
				                            	<!-- commented city code -->
				                                <?php
													// if (old('city') !== null) {
													// 	$city_option = old('city');
													// } else {
													// 	$city_option = isset($user->profile->city) ? $user->profile->city : '0';
													// }
												?>

				                                {{-- Form::label(t('Select a city'), t('Select a city'), ['class' => 'control-label  input-label required position-relative']) --}}

				                                <!-- <select name="city" id="city" class="form-control form-select2" required>
				                                    <option value="0" {{ (!old('city') or old('city')==0 or $city_option == 0) ? 'selected="selected"' : '' }}>

				                                    {{ t('Select a city') }}
				                                    </option>
				                                </select>
				                                <input type="hidden" name="city_name" id='city_name'> -->
				                                {{ Form::label(t('City').' *', t('City').' *', ['class' => 'control-label  input-label required position-relative']) }}
				                                <input id="city" name="city" type="text" class="form-control" placeholder="{{ t('City') }}" value="{{ old('city', $user->profile->city) }}" required>
				                                {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
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
									<div class="form-group required <?php echo (isset($errors) and $errors->has('gender')) ? 'has-error' : ''; ?> custom-radio">
										<label class="col-md-4 control-label">{{ t('Gender') }} <sup>*</sup></label>
										<div class="col-md-6">
											@if ($genders->count() > 0)
												@foreach ($genders as $gender)
										            <input name="gender" class="radio_field" id="gender_{{ $gender->tid }}" value="{{ $gender->tid }}" type="radio" {{ (old('gender', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }} required >
													<label class="radio-label" for="gender_{{ $gender->tid }}">{{ $gender->name }}</label>
												@endforeach
											@endif
										</div>
									</div>

									<!-- Button -->
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-6 btn">
											<button type="submit" class="green next btn btn-success btn-details-update">{{ t('Update') }}</button>
										</div>
									</div>

									<div style="margin-bottom: 30px;"></div>

								</form>
								*/
								?>
								<div class="col-md-12" style="float:left;padding-top:40px;padding-left:20px;">
									<p style="text-align:justify;">
										<?php
											$doc = new DOMDocument();
											if($is_free_access_user == true){
												$doc->loadHTML('<?xml encoding="UTF-8">' . t('free_country_contract_page_content'));	
											}else{
												$doc->loadHTML('<?xml encoding="UTF-8">' . t('contract_page_content'));
											}
											
											
											echo $doc->saveHTML();
										?>
									</p>
								</div>
							</div>
						</div>
						<form action="{{ lurl('contract') }}" name="proceed" class="form-horizontal" role="form" method="POST" id="order-submit">
						<div class="row" style="padding-top:40px;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="well" style="display: none;">
										<div class="form-group <?php echo (isset($errors) and $errors->has('package')) ? 'has-error' : ''; ?>"
												style="margin-bottom: 0;">
											<table id="packagesTable" class="table table-hover checkboxtable" style="margin-bottom: 0;">
												<thead>
													<tr>
														<td>{{ t('Package Name') }}</td>
														<td>{{ t('Price') }}</td>
														<td>{{ t('Tax percentage') }}</td>
														<td>{{ t('Duration') }}</td>
														<td>{{ t('Total') }}</td>
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
															$badge = ' <span class="label label-danger">' . t('Not available') . '</span>';
														} elseif ($currentPackagePrice == $package->price) {
															$badge = '';
														} else {
															
															/*
															// $badge = ' <span class="label label-success">' . t('Upgrade') . '</span>';
															*/
														}
														if ($currentPackageId == $package->id) {
															$badge = ' <span class="label label-default">' . t('Current') . '</span>';
															if ($currentPaymentActive == 0) {
																$badge .= ' <span class="label label-warning">' . t('Payment pending') . '</span>';
															}
														}
													?>
													<tr>
														<td>
															<div class="radio custom-radio">
																<input class="package-selection radio_field" type="radio" name="package"
																id="package_{{ $package->id }}"
																value="{{ $package->id }}"
																data-name="{{ $package->name }}"
																data-price="{{ $package->price }}"
																data-tax="{{ $package->tax ? $package->tax : '0.00' }}"
																data-currencysymbol="{{ $package->currency->symbol }}"
																data-currencyinleft="{{ $package->currency->in_left }}"
																data-duration_period="{{ t(strtolower($package->duration_period)) }}"
																data-duration = "{{ $package->duration }}"
																required checked
																{{ (old('package', $currentPackageId)==$package->id) ? ' checked' : (($package->price==0) ? ' checked' : '') }} {{ $packageStatus }}>
																<label class="radio-label" for="package_{{ $package->id }}">
																	<strong class="tooltipHere" data-placement="right" data-toggle="tooltip" title="{!! $package->description !!}">{!! $package->name . $badge !!} </strong>
																</label>
															</div>
															<div class="features" id="feature-{{ $package->id }}" style="display: none;">
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
															<p id="price-{{ $package->id }}">
																@if ($package->currency->in_left == 1)
																	<span class="price-currency">{{ $package->currency->symbol }}</span>
																@endif
																<span class="price-int">{{ $package->price }}</span>
																<input type="hidden" id="{{ $package->id }}-currency" value="{{ $package->currency_code }}">
																@if ($package->currency->in_left == 0)
																	<span class="price-currency">{{ $package->currency->symbol }}</span>
																@endif
															</p>
														</td>
														<td>
															<p id="tax-{{ $package->id }}">
																<span class="tax-int">{{ $package->tax ? $package->tax : '0.00' }}</span>
															</p>
														</td>
														<td>
															<p id="duration-{{ $package->id }}">
																<span class="duration-int">{{ $package->duration }} {{ t($package->duration_period) }}</span>
															</p>
														</td>
														<td>
															<p id="total-{{ $package->id }}">
																<?php $total_amount = round( $package->price + (($package->price * $package->tax)/ 100)); ?>
																@if ($package->currency->in_left == 1)
								                                    <span class="price-currency">{{ $package->currency->symbol }}</span>
								                                @endif
																<span class="duration-int">{{ $total_amount.'.00' }}</span>
																@if ($package->currency->in_left == 0)
								                                    <span class="price-currency">{{ $package->currency->symbol }}</span>
								                                @endif
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
								</div>
							</div>
							<div class="row" style="padding-top:40px;padding-left:20px;padding-right:20px;">
                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid #eee; border-right:none;padding:0px;">
									<div class="scroll-bar" style="height:700px;overflow-y: scroll;overflow-x:hidden;">
										<div style="padding:20px;">	

										<?php /*										
											<!-- <div class="header">
												@if (empty($page->picture))
													<h1 class="text-center title-1" style="color: {!! $page->name_color !!};"><strong>{{ $page->name }}</strong></h1>
													<hr class="center-block small text-hr" style="background-color: {!! $page->name_color !!};">
												@endif
											</div> -->

											<?php */ ?>

											<?php if(!empty($page)){ ?> 
											<div class="body">
												<div class="row">
													<div class="col-sm-12 page-content">
														<div class="logo" style="text-align: center;padding: 20px;">
															<img src="{{ URL::to(config('app.cloud_url').'/images/logo.png') }}">
														</div>
														<div style="text-align: center;"><h1>{{ t('User Agreement') }}</h1></div>
														<?php /*
														<!-- @if (empty($page->picture))
															<h3 style="text-align: center; color: {!! $page->title_color !!};">{{ $page->title }}</h3>
														@endif -->
														*/ ?>
														<div class="text-content text-left from-wysiwyg inner-page-content">
															{!! $page !!}
														</div>
													</div>
												</div>
											</div>

											<?php /*

											<!-- <h1 class="text-center title-1" style="color: {!! $page->name_color !!};"><strong>{{ $page->name }}</strong></h1>										 -->
											<!-- <hr class="center-block small text-hr" style="background-color: {!! $page->name_color !!};"> -->

											<?php */ ?>
 											<?php } ?>
											
										</div>
									</div>
								</div>
							</div>
							<?php /* if($is_user_premium_country_free_access == false){ */?>
							<div class="row" style="padding-top:40px;">
                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            		<?php $today_date = App\Helpers\CommonHelper::getFormatedDate(date('Y-m-d'), false); ?>
                            		@if($is_free_access_user == false)
								    	<div class="col-md-12 summary-content"> {!! t('summery', ['date' => $today_date])!!} </div>
									@else
										<div class="col-md-12 summary-content"> {!! t('summery for free', ['date' => $today_date])!!} </div>
									@endif
								</div>
							</div>
							<?php /* } */ ?>

							<div class="row" style="padding-top:40px;">
							  	
							  	<div class="col-md-6 offset-md-4">
							  		<div class="termbox mb-10 custom-checkbox">
							  			<input class="checkbox_field" name="term" id="term" value="1" type="checkbox" {{ (old('term')=='1') ? 'checked="checked"' : '' }}>
										<label class="checkbox-label checkbox-inline checkbox-label-term" for="term" style="margin-bottom:0px;">{!! t('I have read and agree to the Terms & Conditions', ['attributes' => 'href="#termPopup" data-toggle="modal"']) !!}</label>
									</div>
							  	</div>
							  	
							  	@if($user->receive_newsletter == 0)
							  		<!-- newslatter checkbox -->
								  	<div class="col-md-6 offset-md-4">
								  		<div class="termbox custom-checkbox">
									  		<input class="checkbox_field" name="receive_newsletter" id="receive_newsletter" value="1" type="checkbox" {{ (old('receive_newsletter')=='1') ? 'checked="checked"' : '' }}>
											<label class="checkbox-label checkbox-inline" for="receive_newsletter">{!! t('Job-Newsletters') !!}</label>
										</div>
								  	</div>
								  	<!-- END newslatter Checkbox -->
							  	@endif
							</div>

							

								<div class="row" style="padding-top:40px;">
	                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                            		<?php /*
										<div class="col-md-12 form-group required <?php echo (isset($errors) and $errors->has('term')) ? 'has-error' : ''; ?>"  style="padding-top:40px;">
											<div class="col-md-12">
												<div class="termbox mb10 custom-checkbox">
													<input class="checkbox_field" name="term" id="term" value="1" type="checkbox" {{ (old('term')=='1') ? 'checked="checked"' : '' }}>
													<label class="checkbox-label checkbox-inline checkbox-label-term" for="term" style="margin-bottom:0px;">
														{!! t('I have read and agree to the Terms & Conditions', ['attributes' => 'href="#termPopup" data-toggle="modal"']) !!}
													</label>
													<?php /*
													<!-- <label class="checkbox-label checkbox-inline" for="term">
														{!! t('I have read and agree to the <a :attributes>Terms & Conditions</a>', ['attributes' => 'href="#termPopup" data-toggle="modal"']) !!}
													</label>-->  ?>
												</div>
												<div style="clear:both"></div>
											</div>
										</div>
											
										@if($user->receive_newsletter == 0)
											<!-- newslatter checkbox -->
												<div class="col-md-12 form-group required <?php echo (isset($errors) and $errors->has('term')) ? 'has-error' : ''; ?>" >
													<div class="col-md-12">
														<div class="termbox mb10 custom-checkbox">
															<input class="checkbox_field" name="receive_newsletter" id="receive_newsletter" value="1" type="checkbox" {{ (old('receive_newsletter')=='1') ? 'checked="checked"' : '' }}>
															<label class="checkbox-label checkbox-inline" for="receive_newsletter">
																{!! t('Job-Newsletters') !!}
															</label>
														</div>
													</div>
												</div>
											<!-- END newslatter Checkbox -->
										@endif
										*/ ?>
										<input type="hidden" name="currency_code" value="{{ $package->currency_code }}">
											<!-- Button -->
											<center>
												<div class="form-group">
													<div class="col-sm-offset-5 col-sm-12">
														<div class="btn mb-30">
														 
														@if($is_user_premium_country_free_access == false)
															<button class="green next btn-order-submit" type="submit">{{ t('Order in Obligation') }}</button>
			                						 	@elseif($is_free_access_user == true)
			                						 		<button class="green next btn-order-submit" type="submit">{{ t('Order For Free') }}</button>
		                						 		@else
		                						 			<button class="green next btn-order-submit" type="submit">{{ t('Order For Free') }}</button>
			                						 	@endif
					            						</div>

					            						<?php /*
															<button type="submit" class="btn btn-success btn-order-submit cursor-pointer">{{ t('Order in Obligation') }}</button>
														*/ ?>
													</div>
												</div>
											</center>
										<div style="margin-bottom: 30px;"></div>
									</div>
								</div>
							</div>
						</form>
				</div>
	<?php /*
<!-- </div> reg-sidebar bg-white box-shadow full-width-->

                <!-- <div class="col-md-4 float-left">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box">
							 <i class=" icon-picture fa fa-4x icon-color-1"></i>
							<img src="{{asset('images/icons/profile.png')}}" width="50" height="50" />
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
				</div> -->
				*/ ?>
				<?php  /*
					@if(!empty($contract_content))
						{!! $contract_content->content !!}
					@endif
				*/ ?>
				</div>
			</div>
		</div>
	</div>
@endsection

<?php /* @include('layouts.inc.modal.term') */?>



@section('page-script')
    <link href="{{ url(config('app.cloud_url').'/assets/css/wizard.css') }}" rel="stylesheet">
    @include('layouts.inc.tools.wysiwyg.css')
	<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif

    <script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript" defer></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js" defer></script>

	<!-- Place Auto Complete start -->
	{{ Html::script(config('app.cloud_url').'/assets/js/place-autocomplete.js') }}
	<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googlemaps.key')}}&libraries=places"></script>
	<!-- Place Auto Complete End -->
    <script type="text/javascript">
    	var userId = '<?php echo $user->id; ?>';
		var username = '<?php echo $user->username; ?>';
		var funnelPageName = "contract_data";
		var error = '<?php echo t('Something went wrong Please try again'); ?>';
		var receive_newsletter = 0;
		var contract_date_update_route =  '<?php echo route('contract-date-update'); ?>';
		var validCityNameError = '<?php echo t('Please enter valid city name'); ?>';
		var SomethingWentWrongError = '{{ t("Something went wrong Please try again") }}';
		var vat = '<?php echo t('Vat'); ?>';
		var requiredMsg = '{{ t("required_field") }}';
		var is_user_premium_country_free_access = '{{ $is_user_premium_country_free_access }}';
		var is_free_access_user = '{{ $is_free_access_user }}';
		var contract_for_free_model_route =  '<?php echo route('contract-for-free-model'); ?>';
		var baseurl = "{{ lurl('/') }}/";
	</script>
    {{ Html::script(config('app.cloud_url').'/js/bladeJs/contractProfile-blade.js') }}
    {{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
@endsection
