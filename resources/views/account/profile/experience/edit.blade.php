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
						<h2 class="title-2"><i class="icon-graduation-cap"></i> {{ t('Edit experiences in the model business') }} </h2>
					
						<div class="mb30" style="float: right; padding-right: 5px;">
							<a href="{{ lurl('account/profile') }}">{{ t('My profile') }}</a>
						</div>
						<div style="clear: both;"></div>
						
						<div class="panel-group" id="accordion">
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#experiencePannel" data-toggle="collapse" data-parent="#accordion"> {{ t('Experiences in the model business') }} </a></h4>
								</div>
								<div class="panel-collapse collapse in" id="experiencePannel">
									<div class="panel-body">
                                        <form name="details" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/profile/experience') }}" enctype="multipart/form-data">
                                            {!! csrf_field() !!}

                                            <!-- experience.title -->
                                            <div class="form-group required <?php echo (isset($errors) and $errors->has('experience.title')) ? 'has-error' : ''; ?>">
                                                <label class="col-sm-3 control-label">{{ t('Title') }}</label>
                                                <div class="col-sm-8">
                                                    <input name="title" type="text" class="form-control" placeholder="{{ t('Title') }}" value="{{ old('name', $experience['title']) }}" required>
                                                </div>
                                            </div>

                                            <!-- experience.start -->
                                            <div class="form-group">                                
                                                <label class="col-sm-3 control-label">{{ t('From') }} </label>
                                                <div class="col-sm-9">
                                                    <div id = "experience_from">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- experience.end -->
                                            <div class="form-group">                                
                                                <label class="col-sm-3 control-label">{{ t('To') }} </label>
                                                <div class="col-sm-9">
                                                    <div id = "experience_to">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">                                
                                                <label class="col-sm-3 control-label">{{ t('up to today') }} </label>
                                                <div class="col-sm-9">
                                                	<input type="checkbox" @if($experience['up_to_date']=='1') checked="checked" @endif name="up_to_date" value="date('Y/m/d')">
                                                </div>
                                            </div>

                                            <!-- experience.company -->
                                            <div class="form-group required <?php echo (isset($errors) and $errors->has('experience.company')) ? 'has-error' : ''; ?>">
                                                <label class="col-sm-3 control-label">{{ t('Company') }}</label>
                                                <div class="col-sm-8">
                                                    <input name="company" type="text" class="form-control" placeholder="{{ t('Company') }}" value="{{ old('name', $experience['company']) }}" required>
                                                </div>
                                            </div>

                                            <!-- experience.description -->
                                            <div class="form-group required <?php echo (isset($errors) and $errors->has('experience.description')) ? 'has-error' : ''; ?>">
                                                <label class="col-sm-3 control-label">{{ t('Description') }}</label>
                                                <div class="col-sm-8">
                                                    <textarea id="experience_description" name="description" value="test">{{ $experience['description'] }}</textarea>
                                                </div>
											</div>
											
											<input type="hidden" name="id" value="{{ $id }}">

                                            <!-- Button -->
                                            <div class="form-group">
                                                <div class="col-sm-offset-5 col-sm-7">
                                                    <button name="update" type="submit" class="btn btn-primary">{{ t('Update') }}</button>
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
	<link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/assets/plugins/simditor/styles/simditor.css') }}" />
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.custom_birthday {
			width: 28.3%;
			float: left;
			margin-right: 10px;
		}
		.simditor .simditor-body, .editor-style {
			min-height: 150px;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/module.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/uploader.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/simditor.js') }}"></script>
	<script type="text/javascript">
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
					textarea: $('#experience_description'),
					//placeholder: 'Describe what makes your ad unique...',
					toolbar: toolbar,
					pasteImage: false,
					defaultImage: '{{ url(config('app.cloud_url').'/assets/plugins/simditor/images/image.png') }}',
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
		jQuery("#experience_from").birthdayPicker({
            dateFormat: "littleEndian",
            sizeClass: "form-control custom_birthday",
            // callback: selected_date
        });
		jQuery("#experience_to").birthdayPicker({
            dateFormat: "littleEndian",
            sizeClass: "form-control custom_birthday",
            // callback: selected_date
        });

		function set_date_from($date){
			if ( $date != '' ) {
				var DOB = new Date($date);
				$('[name="experience_from_birth[year]"]').val(DOB.getFullYear());
				$('[name="experience_from_birth[month]"]').val(DOB.getMonth() + 1);
				$('[name="experience_from_birth[day]"]').val(DOB.getDate());
				$('[name="experience_from_birthDay"]').val($date);
				// selected_date($date);
			}
		}

		function set_date_to($date){
			if ( $date != '' ) {
				var DOB = new Date($date);
				$('[name="experience_to_birth[year]"]').val(DOB.getFullYear());
				$('[name="experience_to_birth[month]"]').val(DOB.getMonth() + 1);
				$('[name="experience_to_birth[day]"]').val(DOB.getDate());
				$('[name="experience_to_birthDay"]').val($date);
				// selected_date($date);
			}
		}

		// function selected_date($date) {
        //     var selected_date = $date;
        //     var DOB = new Date(selected_date);
        // }

		set_date_from('<?php echo $experience['from'] ?>');
		set_date_to('<?php echo $experience['to'] ?>');
	</script>
@endsection
