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
	@include('post.inc.wizard')
@endsection

<?php
// Category
if ($post->category) {
    if ($post->category->parent_id == 0) {
        $postCatParentId = $post->category->id;
    } else {
        $postCatParentId = $post->category->parent_id;
    }
} else {
    $postCatParentId = 0;
}
?>
@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				@include('post.inc.notification')

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2">
							<strong> <i class="icon-docs"></i> {{ t('Update My Ad') }}</strong> -
							<a href="{{ lurl($post->uri) }}" class="tooltipHere" title="" data-placement="top"
							   data-toggle="tooltip"
							   data-original-title="{!! $post->title !!}">
								{!! str_limit($post->title, 45) !!}
							</a>
						</h2>
						<div class="row">
							<div class="col-sm-12">
								<form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<input name="_method" type="hidden" value="PUT">
									<input type="hidden" name="post_id" value="{{ $post->id }}">
									<fieldset>
										<!-- COMPANY -->
										<div class="content-subheading" style="margin-top: 0;">
											<i class="icon-town-hall fa"></i>
											<strong>{{ t('Company Information') }}</strong>
										</div>
										
										<!-- company_id -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('category_id')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Select a Company') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="companyId" name="company_id" class="form-control selecter">
													<option value="0" data-logo=""
															@if (old('company_id', 0)==0)
																selected="selected"
															@endif
													>
														[+] {{ t('New Company') }}
													</option>
													@if (isset($companies) and $companies->count() > 0)
														@foreach ($companies as $item)
															<option value="{{ $item->id }}" data-logo="{{ resize($item->logo, 'small') }}"
																	@if (old('company_id', (isset($postCompany) ? $postCompany->id : 0))==$item->id)
																		selected="selected"
																	@endif
															>
																{{ $item->name }}
															</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
										
										<!-- logo -->
										<div id="logoField" class="form-group">
											<label class="col-md-3 control-label">&nbsp;</label>
											<div class="col-md-8">
												<div class="mb10">
													<div id="logoFieldValue"></div>
												</div>
												<p class="help-block">
													<a id="companyFormLink" href="{{ lurl('account/companies/0/edit') }}" class="btn btn-default">
														<i class="fa fa-pencil-square-o"></i>
														{{ t('Edit the Company') }}
													</a>
												</p>
											</div>
										</div>
									
										@include('account.company._form', ['originForm' => 'post'])
										
									
										<!-- POST -->
										<div class="content-subheading">
											<i class="icon-town-hall fa"></i>
											<strong>{{ t('Job\'s Details') }}</strong>
										</div>
										
										<!-- parent -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('parent')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="parent" id="parent" class="form-control selecter">
													<option value="0" data-type=""
															@if (old('parent', $postCatParentId)=='' or old('parent', $postCatParentId)==0)
																selected="selected"
															@endif
													>
														{{ t('Select a category') }}
													</option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if (old('parent', $postCatParentId)==$cat->tid)
																	selected="selected"
																@endif
														>
															{{ $cat->name }}
														</option>
													@endforeach
												</select>
												<input type="hidden" name="parent_type" id="parent_type" value="{{ old('parent_type') }}">
											</div>
										</div>
										
										<!-- category -->
										<div id="subCatBloc" class="form-group required <?php echo (isset($errors) and $errors->has('category')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Sub-Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="category" id="category" class="form-control selecter">
													<option value="0"
															@if (old('category', $post->category_id)=='' or old('category', $post->category_id)==0)
																selected="selected"
															@endif
													>
														{{ t('Select a sub-category') }}
													</option>
												</select>
											</div>
										</div>

										@if ($post->ismodel)
											<!-- modelCategory -->
											<div class="form-group for-model required <?php echo (isset($errors) and $errors->has('modelCategory')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label">{{ t('Model Category') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select name="modelCategory" id="modelCategory" class="form-control selecter">
														<option value="0" data-type=""
																@if (old('modelCategory')=='' or old('modelCategory')==0)
																	selected="selected"
																@endif
														> {{ t('Select a category') }} </option>
														@foreach ($modelCategories as $cat)
															<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																	@if ($post->model_category_id == $cat->tid)
																		selected="selected"
																	@endif
															> {{ $cat->name }} </option>
														@endforeach
													</select>
													<input type="hidden" name="modelCategory_type" id="modelCategory_type" value="{{ old('modelCategory_type') }}">
												</div>
											</div>
										@endif

										@if (!$post->ismodel)
											<!-- branch -->
											<div class="form-group for-partner required <?php echo (isset($errors) and $errors->has('branch')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label">{{ t('Partner Category') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select name="branch" id="branch" class="form-control selecter">
														<option value="0" data-type=""
																@if (old('branch')=='' or old('branch')==0)
																	selected="selected"
																@endif
														> {{ t('Select a category') }} </option>
														@foreach ($branches as $cat)
															<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																	@if ($post->partner_category_id==$cat->tid)
																		selected="selected"
																	@endif
															> {{ $cat->name }} </option>
														@endforeach
													</select>
													<input type="hidden" name="branch_type" id="branch_type" value="{{ old('branch_type') }}">
												</div>
											</div>
										@endif

										<!-- title -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('title')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Title') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="{{ t('Job\'s Title') }}" class="form-control input-md"
													   type="text" value="{{ old('title', $post->title) }}">
												<span class="help-block">{{ t('A great title needs at least 60 characters') }} </span>
											</div>
										</div>

										<!-- description -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('description')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="description">{{ t('Description') }} <sup>*</sup></label>
                                            <div class="col-md-11" style="position: relative; float: right; padding-top: 10px;">
                                                <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
												<textarea class="form-control {{ $ckeditorClass }}" id="description" name="description" rows="10" required="">{{ old('description', $post->description) }}</textarea>
												<p class="help-block">{{ t('Describe what makes your ad unique') }}</p>
											</div>
										</div>

										<!-- post_type -->
										<div id="postTypeBloc" class="form-group required <?php echo (isset($errors) and $errors->has('post_type')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Job Type') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="post_type" id="post_type" class="form-control selecter">
													@foreach ($postTypes as $postType)
														<option value="{{ $postType->tid }}"
																@if (old('post_type', $post->post_type_id)==$postType->tid)
																	selected="selected"
																@endif
														>
															{{ $postType->name }}
														</option>
													@endforeach
												</select>
											</div>
										</div>

										<!-- salary_min & salary_max -->
										<div id="salaryBloc" class="form-group <?php echo (isset($errors) and $errors->has('salary_max')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="salary_max">{{ t('Salary') }}</label>
											<div class="col-md-4">
												<div class="input-group">
													@if (config('currency')['in_left'] == 1)
														<span class="input-group-addon">{{ config('currency')['symbol'] }}</span>
													@endif
													<input id="salary_min" name="salary_min" class="form-control" placeholder="{{ t('Salary (min)') }}" type="text" value="{{ old('salary_min', $post->salary_min) }}">
													<input id="salary_max" name="salary_max" class="form-control" placeholder="{{ t('Salary (max)') }}" type="text" value="{{ old('salary_max', $post->salary_max) }}">
													@if (config('currency')['in_left'] == 0)
														<span class="input-group-addon">{{ config('currency')['symbol'] }}</span>
													@endif
												</div>
											</div>

											<!-- salary_type -->
											<div class="col-md-4">
												<select name="salary_type" id="salary_type" class="form-control selecter">
													@foreach ($salaryTypes as $salaryType)
														<option value="{{ $salaryType->tid }}"
																@if (old('salary_type', $post->salary_type_id)==$salaryType->tid)
																	selected="selected"
																@endif
														>
															{{ 'per'.' '.$salaryType->name }}
														</option>
													@endforeach
												</select>
												<div class="checkbox">
													<label>
														<input id="negotiable" name="negotiable" type="checkbox"
															   value="1" {{ (old('negotiable', $post->negotiable)=='1') ? 'checked="checked"' : '' }}>
														{{ t('Negotiable') }}
													</label>
												</div>
											</div>
										</div>

										<!-- start_date -->
										<div class="form-group <?php echo (isset($errors) and $errors->has('start_date')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="start_date">{{ t('Start Date') }} </label>
											<div class="col-md-8">
												<input id="start_date" name="start_date" placeholder="{{ t('Start Date') }}" class="form-control input-md"
													   type="date" value="{{ old('start_date', $post->start_date) }}">
											</div>
										</div>

										<!-- end_date -->
										<div class="form-group <?php echo (isset($errors) and $errors->has('end_date')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="end_date">{{ t('End Date') }} </label>
											<div class="col-md-8">
												<input id="end_date" name="end_date" class="form-control input-md"
													   type="date" value="{{ old('end_date', $post->end_date) }}">
											</div>
										</div>

										<!-- experience_type -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('experience_type')) ? 'has-error' : ''; ?>">
											<label class="col-sm-3 control-label">{{ t('Required experience') }} <sup>*</sup></label>
											<div class="col-sm-8">
												<select name="experience_type" id="experienceType" class="form-control selecter">
													<option value="0"
															@if (old('experience_type')=='' or old('experience_type')==0)
																selected="selected"
															@endif
													>
														{{ t('Select') }}
													</option>
													@foreach ($experienceTypes as $type)
														<option value="{{ $type->id }}"  {{ ($type->id == $post->experience_type_id) ? 'selected' : '' }} >
															{{ t($type->name) }}
														</option>
													@endforeach
												</select>
											</div>
										</div>

										<!-- gender_type -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('gender_type')) ? 'has-error' : ''; ?>">
											<label class="col-sm-3 control-label">{{ t('Gender') }} <sup>*</sup></label>
											<div class="col-sm-8">
												<select name="gender_type" id="userType" class="form-control selecter">
													<option value="0"
															@if (old('gender_type')=='' or old('gender_type')==0)
																selected="selected"
															@endif
													>
														{{ t('Select') }}
													</option>
													<option value="0"  {{ ( '0' == $post->gender_type_id) ? 'selected' : '' }} >{{ t("Male") }} </option>
													<option value="1"  {{ ( '1' == $post->gender_type_id) ? 'selected' : '' }} >{{ t("Female") }} </option>
													<option value="2"  {{ ( '2' == $post->gender_type_id) ? 'selected' : '' }} >{{ t("Both") }} </option>
												</select>
											</div>
										</div>

										<!-- tfp -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('tfp')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('TFP') }} <sup>*</sup></label>
											<div class="col-md-9">
												<label class="radio-inline" for="tfp">
													<input name="tfp" value="1"  type="radio" {{ ( '1' == $post->tfp) ? 'checked' : '' }}>
													{{ t('Yes') }}
												</label>
												<label class="radio-inline" for="tfp">
													<input name="tfp" value="0" type="radio" {{ ( '0' == $post->tfp) ? 'checked' : '' }}>
													{{ t('No') }}
												</label>
											</div>
										</div>

										@if ($post->ismodel)
											<!-- Body Height -->
											<div class="form-group for-model required <?php echo (isset($errors) and $errors->has('height')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Body height') }} <sup>*</sup></label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="height_from" id="height_from" class="form-control selecter" required>
														<?php
															foreach($properties['height'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->height_from == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="height_to" id="height_to" class="form-control selecter" required>
														<?php
															foreach($properties['height'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->height_to == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Body Weight -->
											<div class="form-group for-model required <?php echo (isset($errors) and $errors->has('weight')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Body weight') }} <sup>*</sup></label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="weight_from" id="weight_from" class="form-control selecter" required>
														<?php
															foreach($properties['mass'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->weight_from == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="weight_to" id="weight_to" class="form-control selecter" required>
														<?php
															foreach($properties['mass'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->weight_to == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Age -->
											<div class="form-group for-model required <?php echo (isset($errors) and $errors->has('age')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Age') }} <sup>*</sup></label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="age_from" id="age_from" class="form-control selecter" required>
														<?php
															for ($i=0; $i < 101; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->age_from == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="age_to" id="age_to" class="form-control selecter" required>
														<?php
															for ($i=0; $i < 101; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->age_to == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Dress size -->
											<div class="form-group for-model required <?php echo (isset($errors) and $errors->has('dressSize')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Dress size') }} <sup>*</sup></label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="dressSize_from" id="dressSize_from" class="form-control selecter" required>
														<?php
															foreach($properties['dress_size'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->dressSize_from == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="dressSize_to" id="dressSize_to" class="form-control selecter" required>
														<?php
															foreach($properties['dress_size'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->dressSize_to == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Chest -->
											<div class="form-group for-model <?php echo (isset($errors) and $errors->has('chest')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Chest') }}</label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="chest_from" id="chest_from" class="form-control selecter">
														<option></option>
														<?php
															for ($i=65; $i < 150; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->chest_from == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="chest_to" id="chest_to" class="form-control selecter">
														<option></option>
														<?php
															for ($i=65; $i < 150; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->chest_to == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Waist -->
											<div class="form-group for-model <?php echo (isset($errors) and $errors->has('waist')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Waist') }}</label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="waist_from" id="waist_from" class="form-control selecter">
														<option></option>
														<?php
															for ($i=65; $i < 150; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->waist_from == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="waist_to" id="waist_to" class="form-control selecter">
														<option></option>
														<?php
															for ($i=65; $i < 150; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->waist_to == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Hips -->
											<div class="form-group for-model <?php echo (isset($errors) and $errors->has('hips')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Hips') }}</label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="hips_from" id="hips_from" class="form-control selecter">
														<option></option>
														<?php
															for ($i=65; $i < 150; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->hips_from == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="hips_to" id="hips_to" class="form-control selecter">
														<option></option>
														<?php
															for ($i=65; $i < 150; $i++) { 
																?>
																<option value="<?= $i ?>" {{ ( $post->hips_to == $i ) ? 'selected' : '' }}><?= $i ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Shoe size -->
											<div class="form-group for-model <?php echo (isset($errors) and $errors->has('shoeSize')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Shoe size') }}</label>
												<label class="col-sm-1 control-label">{{ t('from') }}</label>
												<div class="col-sm-3">
													<select name="shoeSize_from" id="shoeSize_from" class="form-control selecter">
														<option></option>
														<?php
															foreach($properties['shoe_size'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->shoeSize_from == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<label class="col-sm-1 control-label">{{ t('to') }}</label>
												<div class="col-sm-3">
													<select name="shoeSize_to" id="shoeSize_to" class="form-control selecter">
														<option></option>
														<?php
															foreach($properties['shoe_size'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->shoeSize_to == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Eye color -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('eyeColor')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Eye color') }}</label>
												<div class="col-sm-8">
													<select name="eyeColor" id="eyeColor" class="form-control">
														<option value="">{{ t('Select eye color') }}</option>
														<?php
															foreach($properties['eye_color'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->eyeColor == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Hair color -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('hairColor')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Hair color') }}</label>
												<div class="col-sm-8">
													<select name="hairColor" id="hairColor" class="form-control">
														<option value="">{{ t('Select hair color') }}</option>
														<?php
															foreach($properties['hair_color'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->hairColor == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>

											<!-- Skin color -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('skinColor')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Skin color') }}</label>
												<div class="col-sm-8">
													<select name="skinColor" id="skinColor" class="form-control">
														<option value="">{{ t('Select skin color') }}</option>
														<?php
															foreach($properties['skin_color'] as $key=>$cat){
																?>
																<option value="<?= $key ?>" {{ ( $post->skinColor == $key ) ? 'selected' : '' }}><?= $cat ?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>
										@endif

										<!-- contact_name -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('contact_name')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="contact_name">{{ t('Contact Name') }} <sup>*</sup></label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-user"></i></span>
													<input id="contact_name" name="contact_name" placeholder="{{ t('Contact Name') }}"
													   class="form-control input-md" type="text"
													   value="{{ old('contact_name', $post->contact_name) }}">
												</div>
											</div>
										</div>

										<!-- email -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="email"> {{ t('Contact Email') }} <sup>*</sup></label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-mail"></i></span>
													<input id="email" name="email" class="form-control"
														   placeholder="{{ t('Email') }}" type="text"
														   value="{{ old('email', $post->email) }}">
												</div>
											</div>
										</div>

										<!-- phone -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="phone">{{ t('Phone Number') }}</label>
											<div class="col-md-8">
												<div class="input-group">
													<span id="phoneCountry" class="input-group-addon">{!! getPhoneIcon($post->country_code) !!}</span>
													<input id="phone" name="phone"
														   placeholder="{{ t('Phone Number') }}" class="form-control input-md"
														   type="text" value="{{ phoneFormat(old('phone', $post->phone), $post->country_code) }}">
												</div>
												<div class="checkbox">
													<label>
														<input id="phone_hidden" name="phone_hidden" type="checkbox"
															   value="1" {{ (old('phone_hidden', $post->phone_hidden)=='1') ? 'checked="checked"' : '' }}>
														<small> {{ t('Hide the phone number on this ads') }}</small>
													</label>
												</div>
											</div>
										</div>
										
										<!-- country -->
										<input id="country" name="country" type="hidden" value="{{ config('country.code') }}">
									
										@if (config('country.admin_field_active') == 1 and in_array(config('country.admin_type'), ['1', '2']))
										<!-- admin_code -->
										<div id="locationBox" class="form-group required <?php echo (isset($errors) and $errors->has('admin_code')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="admin_code">{{ t('Location') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="adminCode" name="admin_code" class="form-control sselecter">
													<option value="0" {{ (!old('admin_code') or old('admin_code')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select your Location') }}
													</option>
												</select>
											</div>
										</div>
										@endif
									
										<!-- city -->
										<div id="cityBox" class="form-group required <?php echo (isset($errors) and $errors->has('city')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="city">{{ t('City') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="city" name="city" class="form-control sselecter">
													<option value="0" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select a city') }}
													</option>
												</select>
											</div>
										</div>
										
										<!-- application_url -->
										<div class="form-group <?php echo (isset($errors) and $errors->has('application_url')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Application URL') }}</label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-reply"></i></span>
													<input id="application_url" name="application_url"
														   placeholder="{{ t('Application URL') }}" class="form-control input-md" type="text"
														   value="{{ old('application_url', $post->application_url) }}">
												</div>
												<span class="help-block">{{ t('Candidates will follow this URL address to apply for the job') }}</span>
											</div>
										</div>

										<!-- end_application -->
										<div class="form-group <?php echo (isset($errors) and $errors->has('end_application')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="end_application">{{ t('Application Deadline') }} </label>
											<div class="col-md-8">
												<input id="end_application" name="end_application" class="form-control input-md"
													   type="date" value="{{ old('end_application', $post->end_application) }}">
											</div>
										</div>
										
										<!-- tags -->
										<div class="form-group <?php echo (isset($errors) and $errors->has('tags')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Tags') }}</label>
											<div class="col-md-8">
												<input id="tags" name="tags" placeholder="{{ t('Tags') }}" class="form-control input-md" type="text" value="{{ old('tags', $post->tags) }}">
												<span class="help-block">{{ t('Enter the tags separated by commas') }}</span>
											</div>
										</div>

										<!-- Button -->
										<div class="form-group">
											<div class="col-md-12" style="text-align: center;">
												<a href="{{ lurl($post->uri) }}" class="btn btn-default btn-lg"> {{ t('Back') }}</a>
												<button id="nextStepBtn" class="btn btn-success btn-lg submitPostForm"> {{ t('Update') }} </button>
											</div>
										</div>

										<div style="margin-bottom: 30px;"></div>

									</fieldset>
								</form>

							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar">
					<div class="reg-sidebar-inner text-center">

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
	</style>
@endsection

@section('after_scripts')
    @include('layouts.inc.tools.wysiwyg.js')
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
	@if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
	@endif

	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	
	<script>
		/* Translation */
		var lang = {
			'select': {
				'category': "{{ t('Select a category') }}",
				'subCategory': "{{ t('Select a sub-category') }}",
				'country': "{{ t('Select a country') }}",
				'admin': "{{ t('Select a location') }}",
				'city': "{{ t('Select a city') }}"
			},
			'price': "{{ t('Price') }}",
			'salary': "{{ t('Salary') }}",
            'nextStepBtnLabel': {
                'next': "{{ t('Next') }}",
                'submit': "{{ t('Update') }}"
            }
		};
		
		var stepParam = 0;
		
		/* Company */
		var postCompanyId = {{ old('company_id', (isset($postCompany) ? $postCompany->id : 0)) }};
		getCompany(postCompanyId);
		
		/* Categories */
        var category = {{ old('parent', (int)$postCatParentId) }};
        var categoryType = '{{ old('parent_type') }}';
        if (categoryType == '') {
            var selectedCat = $('select[name=parent]').find('option:selected');
            categoryType = selectedCat.data('type');
        }
        var subCategory = {{ old('category', (int)$post->category_id) }};
		
		/* Locations */
        var countryCode = '{{ old('country', $post->country_code) }}';
        var adminType = '{{ config('country.admin_type', 0) }}';
        var selectedAdminCode = '{{ old('admin_code', ((isset($admin) and !empty($admin)) ? $admin->code : 0)) }}';
        var cityId = '{{ old('city', (isset($post) ? $post->city_id : 0)) }}';
		
		/* Packages */
        var packageIsEnabled = false;
		@if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
            packageIsEnabled = true;
		@endif
	</script>
	<script>
		$(document).ready(function() {
			/* Company */
			$('#companyId').bind('click, change', function() {
				postCompanyId = $(this).val();
				getCompany(postCompanyId);
			});
			
			$('#tags').tagit({
				fieldName: 'tags',
				placeholderText: '{{ t('add a tag') }}',
				caseSensitive: true,
				allowDuplicates: false,
				allowSpaces: false,
				tagLimit: {{ (int)config('settings.single.tags_limit', 15) }},
				singleFieldDelimiter: ','
			});
		});
	</script>
	<script src="{{ url('assets/js/app/d.select.category.js') . vTime() }}"></script>
	<script src="{{ url('assets/js/app/d.select.location.js') . vTime() }}"></script>
@endsection
