@extends('layouts.logged_in.app-model')

@section('content')
	<div class="container pt-40 pb-60 px-0 w-xl-1220">
		<div class="row">
			<div class="col-sm-12 page-content mb-30 model-back-book">
        		<h1 class="text-center prata">{{ t('Edit the model book') }}</h1>
        		<div class="position-relative">
            		<div class="divider mx-auto"></div>
            		<div class="text-center mb-30 position-absolute-xl xl-to-right-0 xl-to-top-0">
                        <a class="btn btn-white mini-mobile arrow_left" href="{{ lurl(trans('routes.model-portfolio-edit')) }}">
                          {{ t('Back to Modelbook') }}
                        </a>
                    </div>
           		</div>
           	</div>
        </div>
		@include('childs.notification-message')

        {{ Form::open(array('url' => lurl('account/model-book/'.$modelbook->id.'/update'), 'method' => 'post', 'files' => true, 'id' => 'modelImage')) }}
	        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto" id="profile-image-div">
	            <div class="w-xl-970 mx-auto">
	                <div class="px-38 px-xl-0 w-xl-590">
	                    <h2 class="bold f-18 lh-18">{{ t('Upload photo') }}</h2>
	                    <div class="divider"></div>
	                    
	                    <div class="input-group w-xl-970">
                            <label for="{{ t('Name') }}">{{ t('Name') }}</label>
                            <input class="animlabel" name="modelbook[name]" type="text" value="{{ old('modelbook.name', (isset($modelbook->name) ? $modelbook->name : '')) }}">
                        </div> 

	                    <div class="w-xl-970 mx-auto upload-zone">
	                        <div class="pt-40 px-38 px-lg-0">
	                            <div class="pb-40 mb-40 d-md-flex">
	                                <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
	                                	<?php 
	                                		if (isset($modelbook)) {
	                                			$is_exist = false;
	                                			if ($modelbook->cropped_image == "" && \Storage::url($modelbook->filename)) {
	                                    			$image_path = \Storage::url($modelbook->filename);
	                                    			$is_exist = true;
	                                			}
	                                			if ($modelbook->cropped_image != "" && url(config('filesystems.default') . '/' . str_replace("uploads", "", $modelbook->cropped_image)))
	                                			{
                									$image_path = url(config('filesystems.default') . '/' . str_replace("uploads", "", $modelbook->cropped_image));
                									$is_exist = true;
                								}

                								if ($is_exist != false){
                									?>
                									<img id="output-partner-logo" src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                								<?php } else { ?>
                									<img id="output-partner-logo" src="/uploads/app/default/picture.jpg" alt="{{ trans('metaTags.Go-Models') }}">
                								<?php
                								}
	                                		}
	                                	?>
	                                	<?php if (isset($modelbook) && $is_exist == true) {?>
                                       	 	<a href="#" data-featherlight="{{ route('show-modelbook',['id' => $modelbook->id]) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                                    	<?php }?>
	                                </div>
	                                <div class="d-md-inline-block">
	                                    <!-- <input id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename]" type="file" class="upload_white mb-20"> -->
	                                    <div class="upload-btn-wrapper">
	                                      <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{t('select photo')}}</a>
	                                     <input type="file" id="model-book-img" name="modelbook[filename]" onchange="loadFile(event)" accept="image/*">
	                                    </div>
	                                    
	                                    <p class="w-lg-460 pt-20" id="fileSize-error-msg">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
	                                    <p id="error-profile-logo" class=""></p>
                                        <p  class="mb-20 help-block"  style="display: none;" id="warning-close-windows">{{ t('Uploading your photos can take some minutes Please be patient and DO NOT close this window') }}</p>
	                                </div>
	                            </div>
	                        </div>
	                    </div>

	                </div>
                        <div class="d-flex justify-content-center align-items-center container px-0 pt-40">
                            <button type="submit" class="btn btn-success save">{{t('Save')}}</button>
                        </div>
	            </div>
	        </div>
    		
   	</div>
    {{ Form::close() }}

@endsection

<style type="text/css">
    @media (min-width: 768px) {
      .img-holder {
        height: 346px !important;
      }
    }
    @media (min-width: 980px) {
      .img-holder {
        height: 442px !important;
      }
    }
</style>

@section('page-script')
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
	<link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<script src="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	
	<script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('output-partner-logo');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            $('.zoom').hide();
    };

     $('#modelImage').submit(function(event) {
        
		$('.save').prop('disabled', false);        
		$(".loading-process").hide();
		
        $('#error-profile-logo').html('');
        // $('#fileSize-error-msg').html(''); 

        var ele = document.getElementById('model-book-img');

        var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

        var status = true;
         
        if(parseInt(ele.files.length) > 0){

            var imageType = ele.files[0].type.toLowerCase();
            var imageSize = ele.files[0].size;
            var fileSize = Math.round((imageSize / 1024));
            var extension = imageType.split('/');

            //check image extension  
            if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {
                    
                $('#error-profile-logo').html('{{ t("model_book_valid_image") }} ').css("color", "red");
                status = false;
            }
            // check file size
            if(fileSize > maxUploadImageSize){
              
              $('#fileSize-error-msg').html('{{ t("File") }} "'+ele.files[0].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");

                status = false;
            }else{
                
                $('#fileSize-error-msg').html("{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}").css({'color': 'black'});
            }
            //image required validation
            if($('#model-book-img').val() == ""){
                $('#error-profile-logo').html('{{ t("photo is required") }} ').css("color", "red");
                status = false;
            }
        }
        $("#warning-close-windows").show();
        $('html,body').animate({ scrollTop:  $("#profile-image-div").offset().top }, 'slow', function () {//alert("reached top");    
        });

		if(status == true){
        	$('.save').prop('disabled', true);        
        	$(".loading-process").show();
		}

        // if($('#model-book-img').val() == ""){
        //     $('#error-profile-logo').html('{{ t("File is required") }} ').css("color", "red");
        //     status = false;
        // }

        return status;
    });

    </script>

@endsection
