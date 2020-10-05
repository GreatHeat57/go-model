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
					@endif

					<div class="inner-box">
						<div class="row">
							<div class="col-md-5 col-xs-4 col-xxs-12">
								<h3 class="no-padding text-center-480 useradmin">
									<a href="">
										@if (!empty($user->profile->logo))
											<img class="userImg" src="{{ \Storage::url($user->profile->logo) }}" alt="{{ trans('metaTags.User') }}">&nbsp;
										@elseif (!empty($gravatar))
											<img class="userImg" src="{{ $gravatar }}" alt="{{ trans('metaTags.User') }}">&nbsp;
										@else
											<img class="userImg" src="{{ url('images/user.jpg') }}" alt="{{ trans('metaTags.User') }}">
										@endif
										{{ $user->name }}
									</a>
								</h3>
							</div>
							<div class="col-md-7 col-xs-8 col-xxs-12">
								<div class="header-data text-center-xs">
									@if (isset($user) and in_array($user->user_type_id, [1, 2]))
									<!-- Traffic data -->
									<div class="hdata">
										<div class="mcol-left">
											<!-- Icon with red background -->
											<i class="fa fa-eye ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of visitors -->
											<p>
												<a href="{{ lurl('account/my-posts') }}">
                                                    {{ $countPostsVisits->total_visits or 0 }}
												    <em>{{ trans_choice('global.count_visits', (isset($countPostsVisits) ? getPlural($countPostsVisits->total_visits) : getPlural(0))) }}</em>
                                                </a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>

									<!-- Ads data -->
									<div class="hdata">
										<div class="mcol-left">
											<!-- Icon with green background -->
											<i class="icon-th-thumb ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of ads -->
											<p>
												<a href="{{ lurl('account/my-posts') }}">
                                                    {{ $countPosts }}
												    <em>{{ trans_choice('global.count_posts', getPlural($countPosts)) }}</em>
                                                </a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
									@endif

                                    @if (isset($user) and in_array($user->user_type_id, [1, 3]))
									<!-- Favorites data -->
									<div class="hdata">
										<div class="mcol-left">
											<!-- Icon with blue background -->
											<i class="fa fa-user ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of favorites -->
											<p>
												<a href="{{ lurl('account/favourite') }}">
                                                    {{ $countFavoritePosts }}
												    <em>{{ trans_choice('global.count_favorites', getPlural($countFavoritePosts)) }} </em>
                                                </a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
                                    @endif
								</div>
							</div>
						</div>
					</div>

					<div class="inner-box">
						<div class="welcome-msg">
							<h3 class="page-sub-header2 clearfix no-padding">{{ t('Hello') }} {{ $user->name }} ! </h3>
							<span class="page-sub-header-sub small">
                                {{ t('You last logged in at') }}: {{ $user->last_login_at->formatLocalized(config('settings.app.default_datetime_format')) }}
                            </span>
							@if ($user->user_type_id == 3)
							<a href="{{ lurl('account/user/'.$user->id) }}"><button type="button" class="btn btn-primary">{{ t('Profile View') }}</button></a>
							@endif
						</div>
						<div class="panel-group" id="accordion">
							<!-- USER -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#userPanel" data-toggle="collapse" data-parent="#accordion"> {{ t('My details') }} </a></h4>
								</div>
								<div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'in' : '' }}" id="userPanel">
									<div class="panel-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="userPanel">

                                            @if (empty($user->user_type_id) or $user->user_type_id == 0)

                                                <!-- user_type -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('user_type')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-3 control-label">{{ t('You are a') }} <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <select name="user_type" id="userType" class="form-control selecter">
                                                            <option value="0"
																	@if (old('user_type')=='' or old('user_type')==0)
																		selected="selected"
																	@endif
															>
                                                                {{ t('Select') }}
                                                            </option>
                                                            @foreach ($userTypes as $type)
                                                                <option value="{{ $type->id }}"
																		@if (old('user_type', $user->user_type_id)==$type->id)
																			selected="selected"
																		@endif
																>
                                                                    {{ t($type->name) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            @else

												<!-- logo -->
												<div class="form-group">
													<label class="col-sm-3 control-label" for="profileLogo">{{ t('Profile Logo') }} <sup>*</sup></label>
													<div class="col-sm-9">
														<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
															<input id="profileLogo" name="profile[logo]" type="file" class="file">
														</div>
													</div>
												</div>

												<!-- cover picture -->
												<div class="form-group">
													<label class="col-sm-3 control-label" for="profileCover">{{ t('Cover Picture') }} <sup>*</sup></label>
													<div class="col-sm-9">
														<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
															<input id="profileCover" name="profile[cover]" type="file" class="file">
														</div>
													</div>
												</div>

                                                <!-- name -->
                                                <!-- <div class="form-group required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-3 control-label">{{ t('Name') }} <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <input name="name" type="text" class="form-control" placeholder="" value="{{ old('name', $user->name) }}">
                                                    </div>
                                                </div> -->

                                                <input name="country" type="hidden" value="{{ $user->country_code }}">

                                            @endif

											@if ($user->user_type_id == 2)

												<!-- company_name -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('company_name')) ? 'has-error' : ''; ?> for-employer">
													<label class="col-sm-3 control-label" for="company_name">{{ t('Company Name') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<input name="company_name" placeholder="{{ t('Company Name') }}" class="form-control input-md" type="text" value="{{ old('company_name', $user->profile->company_name) }}">
													</div>
												</div>

												<!-- Branch -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('category')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Branch') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="category" id="category" class="form-control" required>
															<option value="">{{ t('Select a branch') }}</option>
															@foreach ($branches as $key => $cat)
																<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}" {{ ($user->profile->category_id == $cat->tid) ? 'selected' : '' }}> {{ $cat->name }} </option>
															@endforeach
														</select>
													</div>
												</div>
											@endif

											@if ($user->user_type_id == 3)

												<!-- username -->

												<div class="form-group required <?php echo (isset($errors) and $errors->has('username')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label" for="email">{{ t('Username') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="icon-user"></i></span>
															<input id="username" name="username" type="text" class="form-control" placeholder="{{ t('Username') }}"
																   value="{{ old('username', $user->username) }}" readonly>
														</div>
													</div>
												</div>

												<!-- gocode -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('first_name')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-3 control-label">go-code <sup>*</sup></label>
                                                    <div class="col-sm-6">
                                                        <input name="first_name" type="text" class="form-control" placeholder="go-code" value="{{ old('name', $user->profile->go_code) }}" readonly>
                                                    </div>
												</div>

                                                <!-- firstname -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('first_name')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-3 control-label">{{ t('First name') }} <sup>*</sup></label>
                                                    <div class="col-sm-6">
                                                        <input name="first_name" type="text" class="form-control" placeholder="{{ t('First name') }}" value="{{ old('name', $user->profile->first_name) }}">
                                                    </div>
												</div>

												<!-- lastname -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('last_name')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-3 control-label">{{ t('Last name') }} <sup>*</sup></label>
                                                    <div class="col-sm-6">
                                                        <input name="last_name" type="text" class="form-control" placeholder="{{ t('Last name') }}" value="{{ old('name', $user->profile->last_name) }}">
                                                    </div>
                                                </div>

												<!-- birthday -->
												<div class="form-group">
													<label class="col-sm-3 control-label">{{ t('Birthday') }} </label>
													<div class="col-sm-9">
														<div id = "cs_birthday">
														</div>
													</div>
												</div>

												<!-- Parent fname -->
												<div class="form-group parent_details <?php echo (isset($errors) and $errors->has('fname_parent')) ? 'has-error' : ''; ?>" style = "display: none;">
													<label class="col-sm-3 control-label">{{ t('fname_parent') }} </label>
													<div class="col-sm-6">
														<input id="fname_parent" name="fname_parent" type="text" class="form-control" placeholder="{{ t('fname_parent') }}" value="{{ old('fname_parent', $user->profile->fname_parent) }}">
													</div>
												</div>

												<!-- Parent lname -->
												<div class="form-group parent_details <?php echo (isset($errors) and $errors->has('lname_parent')) ? 'has-error' : ''; ?>" style = "display: none;">
													<label class="col-sm-3 control-label">{{ t('lname_parent') }} </label>
													<div class="col-sm-6">
														<input id="lname_parent" name="lname_parent" type="text" class="form-control" placeholder="{{ t('lname_parent') }}" value="{{ old('lname_parent', $user->profile->lname_parent) }}">
													</div>
												</div>

												<!-- parent  category-->
												@php
													$parent = explode(',',$user->profile->parent_category);
												@endphp

												<div class="form-group required <?php echo (isset($errors) and $errors->has('parent')) ? 'has-error' : ''; ?>">
													<label class="col-md-3 control-label">{{ t('job category') }} <sup>*</sup></label>
													<div class="col-md-8">
														<select name="parent[]" id="parent" class="form-control selecter" multiple="multiple" required>
															<option value="0" data-type=""> {{ t('Select a category') }} </option>
															@foreach ($categories as $cat)
																<option  value='{{ $cat->tid }}' data-type='{{ $cat->type }}'
																	@if(in_array($cat->tid,$parent))
																		selected='selected'
																@endif
																> {{ $cat->name }}

															</option>
															@endforeach
														</select>
														<input type="hidden" name="parent_type" id="parent_type" value="{{ old('parent_type') }}">
													</div>
												</div>


												<!-- Category -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('category')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Category') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="category" id="category" class="form-control" required>
															<option value="">{{ t('Select a category') }}</option>
															@foreach ($modelCategories as $cat)
																<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"  {{ ($user->profile->category_id == $cat->tid) ? 'selected' : '' }}> {{ $cat->name }} </option>
															@endforeach
														</select>
													</div>
												</div>

											@endif

											<!-- allow_search -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('allow_search')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label">{{ t('Allow in search?') }} <sup>*</sup></label>
												<div class="col-md-9">
													<label class="radio-inline" for="allow_search">
														<input name="allow_search" value="1" type="radio" {{ (old('allow_search', $user->profile->allow_search)==1) ? 'checked="checked"' : '' }}>
														{{ t('Yes') }}
													</label>
													<label class="radio-inline" for="allow_search">
														<input name="allow_search" value="0" type="radio" {{ (old('allow_search', $user->profile->allow_search)==0) ? 'checked="checked"' : '' }}>
														{{ t('No') }}
													</label>
												</div>
											</div>

											<!-- description -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('description')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Description') }} </label>
												<div class="col-sm-9">
													<textarea id="pageContent" name="description" value="test">{{ $user->profile->description }}</textarea>
												</div>
											</div>

											@if ($user->user_type_id == 2)

												<h5>{{ t('TFP Information') }}</h5>

												<!-- tfp -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('tfp')) ? 'has-error' : ''; ?>">
                                                    <label class="col-md-3 control-label">{{ t('TFP') }} <sup>*</sup></label>
                                                    <div class="col-md-9">
														<label class="radio-inline" for="tfp">
															<input name="tfp" value="1" type="radio" {{ (old('tfp', $user->profile->tfp)==1) ? 'checked="checked"' : '' }}>
															{{ t('Yes') }}
														</label>
														<label class="radio-inline" for="tfp">
															<input name="tfp" value="0" type="radio" {{ (old('tfp', $user->profile->tfp)==0) ? 'checked="checked"' : '' }}>
															{{ t('No') }}
														</label>
                                                    </div>
                                                </div>

											@endif

											<h5>{{ t('Social Networks') }}</h5>

											<!-- facebook -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('facebook')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label" for="facebook">{{ t('Facebook') }} </label>
												<div class="col-sm-9">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-facebook"></i></span>
														<input id="facebook" name="facebook" type="text" class="form-control" placeholder="{{ t('Facebook') }}"
																value="{{ old('facebook', $user->profile->facebook) }}">
													</div>
												</div>
											</div>

											<!-- twitter -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('twitter')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label" for="twitter">{{ t('Twitter') }} </label>
												<div class="col-sm-9">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-twitter"></i></span>
														<input id="twitter" name="twitter" type="text" class="form-control" placeholder="{{ t('Twitter') }}"
																value="{{ old('twitter', $user->profile->twitter) }}">
													</div>
												</div>
											</div>

											<!-- googleplus -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('googleplus')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label" for="googleplus">{{ t('Google Plus') }} </label>
												<div class="col-sm-9">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-googleplus-rect"></i></span>
														<input id="googleplus" name="googleplus" type="text" class="form-control" placeholder="{{ t('Google Plus') }}"
																value="{{ old('googleplus', $user->profile->google_plus) }}">
													</div>
												</div>
											</div>

											<!-- linkedin -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('linkedin')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label" for="linkedin">{{ t('Linkedin') }} </label>
												<div class="col-sm-9">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-linkedin"></i></span>
														<input id="linkedin" name="linkedin" type="text" class="form-control" placeholder="{{ t('Linkedin') }}"
																value="{{ old('linkedin', $user->profile->linkedin) }}">
													</div>
												</div>
											</div>

											<!-- instagram -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('instagram')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label" for="instagram">{{ t('Instagram') }} </label>
												<div class="col-sm-9">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-instagram-filled"></i></span>
														<input id="instagram" name="instagram" type="text" class="form-control" placeholder="{{ t('Instagram') }}"
																value="{{ old('instagram', $user->profile->instagram) }}">
													</div>
												</div>
											</div>

											<h5>{{ t('Contact Information') }}</h5>

											<!-- phone -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
												<label for="phone" class="col-sm-3 control-label">{{ t('Phone') }} <sup>*</sup></label>
												<div class="col-sm-6">
													<div class="input-group">
														<span id="phoneCountry" class="input-group-addon">{!! getPhoneIcon(old('country', $user->country_code)) !!}</span>
														<input id="phone" name="phone" type="text" class="form-control"
																placeholder="" value="{{ phoneFormat(old('phone', $user->phone), old('country', $user->country_code)) }}">
													</div>
													<div class="checkbox">
														<label>
															<input name="phone_hidden" type="checkbox"
																	value="1" {{ (old('phone_hidden', $user->phone_hidden)=='1') ? 'checked="checked"' : '' }}>
															<small> {{ t('Hide the phone number on the published ads') }}</small>
														</label>
													</div>
												</div>
											</div>

											<!-- email -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Email') }} <sup>*</sup></label>
												<div class="col-sm-6">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-mail"></i></span>
														<input id="email" name="email" type="email" class="form-control" placeholder="{{ t('Email') }}" value="{{ old('email', $user->email) }}">
													</div>
												</div>
											</div>

											<!-- street -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('street')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Street') }} </label>
												<div class="col-sm-6">
													<input id="street" name="street" type="text" class="form-control" placeholder="{{ t('Street') }}" value="{{ old('street', $user->profile->street) }}">
												</div>
											</div>

											<!-- website -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('website')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Website') }} </label>
												<div class="col-sm-6">
													<input id="website" name="website" type="text" class="form-control" placeholder="{{ t('Website') }}" value="{{ old('website', $user->profile->website_url) }}">
												</div>
											</div>

											<!-- city -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('city')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('City') }} </label>
												<div class="col-sm-6">
													<input id="city" name="city" type="text" class="form-control" placeholder="{{ t('City') }}" value="{{ old('city', $user->profile->city) }}">
												</div>
											</div>

											<!-- country -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('country')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Country') }} </label>
												<div class="col-sm-6">
													<input id="country" name="country" type="text" class="form-control" placeholder="{{ t('Country') }}" value="{{ old('country', $user->country_code) }}">
												</div>
											</div>

											<!-- country -->
											<!-- <div class="form-group required <?php echo (isset($errors) and $errors->has('country')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="country">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-9">
													<select name="country" class="form-control">
														<option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}>
															{{ t('Select a country') }}
														</option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('asciiname') }}" {{ (old('country', $user->country_code)==$item->get('asciiname')) ? 'selected="selected"' : '' }}>
																{{ $item->get('name') }}
															</option>
														@endforeach
													</select>
												</div>
											</div> -->

											<!-- zip -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('zip')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Zip') }} </label>
												<div class="col-sm-6">
													<input id="zip" name="zip" type="text" class="form-control" placeholder="{{ t('Zip') }}" value="{{ old('zip', $user->profile->zip) }}">
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-offset-1 col-sm-10">
													<iframe id="googleMaps" src="" width="100%" height="250" frameborder="0" style="border:0; pointer-events:none; padding-top: 20px;"></iframe>
												</div>
											</div>

											@if ($user->user_type_id == 3)

												<h5>{{ t('Personal Information') }}</h5>
												<!-- Body Height -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('height')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Body height') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="height" id="height" class="form-control" required>
															<option value="">{{ t('Select height') }}</option>
															<?php
foreach ($properties['height'] as $key => $cat) {
	?>
																	<option value="<?=$key?>"  {{ ($user->profile->height_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Body Weight -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('weight')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Body weight') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="weight" id="weight" class="form-control" required>
															<option value="">{{ t('Select weight') }}</option>
															<?php
foreach ($properties['weight'] as $key => $cat) {
	?>
																	<option value="<?=$key?>"  {{ ($user->profile->weight_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Body chest -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('chest')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Chest') }} </label>
													<div class="col-sm-6">
														<select name="chest" id="chest" class="form-control" >
															<option value="">{{ t('Select chest') }}</option>
															<?php
for ($i = 65; $i < 150; $i++) {
	?>
																	<option value="<?=$i?>"  {{ ($user->profile->chest_id == $i) ? 'selected' : '' }} ><?=$i?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Body waist -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('waist')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Waist') }}</label>
													<div class="col-sm-6">
														<select name="waist" id="waist" class="form-control" >
															<option value="">{{ t('Select waist') }}</option>
															<?php
for ($i = 50; $i < 150; $i++) {
	?>
																	<option value="<?=$i?>"  {{ ($user->profile->waist_id == $i) ? 'selected' : '' }} ><?=$i?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Body hips -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('hips')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Hips') }} </label>
													<div class="col-sm-6">
														<select name="hips" id="hips" class="form-control">
															<option value="">{{ t('Select hips') }}</option>
															<?php
for ($i = 60; $i < 150; $i++) {
	?>
																	<option value="<?=$i?>"  {{ ($user->profile->hips_id == $i) ? 'selected' : '' }} ><?=$i?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Dress size -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('dressSize')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Dress size') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="dressSize" id="dressSize" class="form-control" required>
															<option value="">{{ t('Select dress size') }}</option>
															<?php
foreach ($properties['dress_size'] as $key => $cat) {
	?>
																	<option value="<?=$key?>"  {{ ($user->profile->size_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Eye color -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('eyeColor')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Eye color') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="eyeColor" id="eyeColor" class="form-control" required>
															<option value="">{{ t('Select eye color') }}</option>
															<?php
foreach ($properties['eye_color'] as $key => $cat) {
	?>
																	<option value="<?=$key?>"  {{ ($user->profile->eye_color_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Hair color -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('hairColor')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Hair color') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="hairColor" id="hairColor" class="form-control" required>
															<option value="">{{ t('Select hair color') }}</option>
															<?php
foreach ($properties['hair_color'] as $key => $cat) {
	?>
																	<option value="<?=$key?>"  {{ ($user->profile->hair_color_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Shoe size -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('shoeSize')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Shoe size') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="shoeSize" id="shoeSize" class="form-control" required>
															<option value="">{{ t('Select shoe size') }}</option>
															<?php
foreach ($properties['shoe_size'] as $key => $cat) {
	?>
																	<option value="<?=$key?>"  {{ ($user->profile->shoes_size_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- Skin color -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('skinColor')) ? 'has-error' : ''; ?>">
													<label class="col-sm-3 control-label">{{ t('Skin color') }} <sup>*</sup></label>
													<div class="col-sm-6">
														<select name="skinColor" id="skinColor" class="form-control" required>
															<option value="">{{ t('Select skin color') }}</option>
															<?php
foreach ($properties['skin_color'] as $key => $cat) {
	?>
																	<option value="<?=$key?>"  {{ ($user->profile->skin_color_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
																	<?php
}
?>
														</select>
													</div>
												</div>

												<!-- gender -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('gender')) ? 'has-error' : ''; ?>">
                                                    <label class="col-md-3 control-label">{{ t('Gender') }} <sup>*</sup></label>
                                                    <div class="col-md-9">
                                                        @if ($genders->count() > 0)
                                                            @foreach ($genders as $gender)
                                                                <label class="radio-inline" for="gender">
                                                                    <input name="gender" id="gender-{{ $gender->tid }}" value="{{ $gender->tid }}"
                                                                           type="radio" {{ (old('gender', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }}>
																	{{ t($gender->name) }}
                                                                </label>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

												<!-- piercing -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('piercing')) ? 'has-error' : ''; ?>">
                                                    <label class="col-md-3 control-label">{{ t('Piercing') }} <sup>*</sup></label>
                                                    <div class="col-md-9">
														<label class="radio-inline" for="piercing">
															<input name="piercing" value="1" type="radio" {{ (old('piercing', $user->profile->piercing)==1) ? 'checked="checked"' : '' }}>
															{{ t('Yes') }}
														</label>
														<label class="radio-inline" for="piercing">
															<input name="piercing" value="0" type="radio" {{ (old('piercing', $user->profile->piercing)==0) ? 'checked="checked"' : '' }}>
															{{ t('No') }}
														</label>
                                                    </div>
                                                </div>

												<!-- tattoo -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('tattoo')) ? 'has-error' : ''; ?>">
                                                    <label class="col-md-3 control-label">{{ t('Tattoo') }} <sup>*</sup></label>
                                                    <div class="col-md-9">
														<label class="radio-inline" for="tattoo">
															<input name="tattoo" value="1" type="radio" {{ (old('tattoo', $user->profile->tattoo)==1) ? 'checked="checked"' : '' }}>
															{{ t('Yes') }}
														</label>
														<label class="radio-inline" for="tattoo">
															<input name="tattoo" value="0" type="radio" {{ (old('tattoo', $user->profile->tattoo)==0) ? 'checked="checked"' : '' }}>
															{{ t('No') }}
														</label>
                                                    </div>
                                                </div>
											@endif

											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9"></div>
											</div>

											<!-- Button -->
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>

							<!-- SETTINGS -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#settingsPanel" data-toggle="collapse" data-parent="#accordion"> {{ t('Settings') }} </a></h4>
								</div>
								<div class="panel-collapse collapse {{ (old('panel')=='settingsPanel') ? 'in' : '' }}" id="settingsPanel">
									<div class="panel-body">
										<form name="settings" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/settings') }}">
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="settingsPanel">

											<!-- disable_comments -->
											<div class="form-group">
												<div class="col-sm-12">
													<div class="checkbox">
														<label>
															<input id="disable_comments" name="disable_comments" value="1"
																   type="checkbox" {{ ($user->disable_comments==1) ? 'checked' : '' }}>
															{{ t('Disable comments on my ads') }}
														</label>
													</div>
												</div>
											</div>

											<!-- password -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('New Password') }}</label>
												<div class="col-sm-9">
													<input id="password" name="password" type="password" class="form-control" placeholder="{{ t('Password') }}">
												</div>
											</div>

											<!-- password_confirmation -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Confirm Password') }}</label>
												<div class="col-sm-9">
													<input id="password_confirmation" name="password_confirmation" type="password"
														   class="form-control" placeholder="{{ t('Confirm Password') }}">
												</div>
											</div>

											<!-- Button -->
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
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
	<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	<link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/assets/plugins/simditor/styles/simditor.css') }}" />
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
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
		.simditor .simditor-body, .editor-style {
			min-height: 200px;
		}
		.welcome-msg a {
			float: right;
			margin-top: -10px;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/module.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/uploader.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/simditor.js') }}"></script>
	<script>
		(function() {
			$(function() {
				var $preview, editor, mobileToolbar, toolbar, allowedTags;
				Simditor.locale = 'en-US';
				toolbar = ['bold','italic','underline','fontScale','|','ol','ul','blockquote','table','link'];
				mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
				if (mobilecheck()) {
					toolbar = mobileToolbar;
				}
				allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','hr','table'];
				editor = new Simditor({
					textarea: $('#pageContent'),
					//placeholder: 'Describe what makes your ad unique...',
					toolbar: toolbar,
					pasteImage: false,
					defaultImage: "{{ url(config('app.cloud_url').'/assets/plugins/simditor/images/image.png') }}",
					upload: false,
					allowedTags: allowedTags
				});
				$preview = $('#preview');
				if ($preview.length > 0) {
					return editor.on('valuechanged', function(e) {
						return $preview.html(editor.getValue());
					});
				}
			});
		}).call(this);
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

		/* Initialize with defaults (logo) */
		function initFile()
		{
			$('#profileLogo').fileinput({
				language: '{{ config('app.locale') }}',
				@if (config('lang.direction') == 'rtl')
					rtl: true,
				@endif
				showPreview: true,
				allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
				showUpload: false,
				showRemove: false,
				maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
				@if (isset($user->profile) and !empty($user->profile->logo))
				initialPreview: [
					'{{ \Storage::url($user->profile->logo) }}'
				],
				initialPreviewAsData: true,
				initialPreviewFileType: 'image',
				/* Initial preview configuration */
				initialPreviewConfig: [
					{
						width: '120px'
					}
				],
				initialPreviewShowDelete: false
				@endif
				});

				$('#profileCover').fileinput({
				language: '{{ config('app.locale') }}',
				@if (config('lang.direction') == 'rtl')
					rtl: true,
				@endif
				showPreview: true,
				allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
				showUpload: false,
				showRemove: false,
				maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
				@if (isset($user->profile) and !empty($user->profile->cover))
				initialPreview: [
					'{{ \Storage::url($user->profile->cover) }}'
				],
				initialPreviewAsData: true,
				initialPreviewFileType: 'image',
				/* Initial preview configuration */
				initialPreviewConfig: [
					{
						width: '120px'
					}
				],
				initialPreviewShowDelete: false
				@endif
				});
		}

		initFile();
	</script>

	@if (config('services.googlemaps.key'))
	<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function () {
			getGoogleMaps(
				'<?php echo config('services.googlemaps.key'); ?>',
				'<?php echo $user->profile->street . ',' . $user->profile->city . ',' . $user->country_code ?>',
				'<?php echo config('app.locale'); ?>'
			);
		})
	</script>
	@endif
@endsection
