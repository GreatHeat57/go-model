@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        @if(isset($album))
            <h1 class="text-center prata">{{ t('Edit Album Photos') }}</h1>
        @else
            <h1 class="text-center prata"> {{ t('Add Album Photos') }} </h1>
        @endif

        <div class="position-relative">

            <div class="divider mx-auto"></div>

            <div class="text-center mb-30">
                <?php $attr = ['countryCode' => config('country.icode')];?>
                <a href="{{ url()->previous() }}" title="{{ t('Back to Album') }}" class="btn btn-white mini-mobile arrow_left ">{{ t('Back to Album') }}</a>
            </div>

            <div class="w-xl-1220 mx-auto">
                @include('childs.notification-message')
            </div>

            @if(isset($album))
                {{ Form::open(array('url' => lurl('account/album/' . $album->id), 'method' => 'PUT', 'files' => true, 'id' => 'modelImage')) }}
                <input name="album_id" id="is_edit" type="hidden" value="{{ $album->id }}">
            @else
                {{ Form::open(array('url' => lurl('account/album-book'), 'files' => true, 'id' => 'modelImage')) }}

                <input name="album_id" id="is_edit" type="hidden" value="no">

            @endif

            <input name="panel" type="hidden" value="albumPanel">

            <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto" id="profile-image-div">
                <div class="w-xl-970 mx-auto">
                    <div class="px-38 px-xl-0 w-xl-590">
                        <h2 class="bold f-18 lh-18">{{ t('Upload photo') }}</h2>

                        <div class="divider"></div>

                        <div class="input-group w-xl-970">
                            @if(!isset($album))
                                <!-- <label for="lastname">{{ t('Name') }}</label> -->
                                {{ Form::label(t('Name'), t('Name'), ['class' => 'position-relative input-label']) }}
                                <input class="animlabel" name="album[name]" value="{{ old('album.name', (isset($album->name) ? $album->name : '')) }}" type="text" >
                            @else
                            {{ Form::label(t('Name'), t('Name'), ['class' => 'position-relative input-label']) }}
                            <input class="animlabel" name="album[name]" value="{{ old('album.name', (isset($album->name) ? $album->name : '')) }}" type="text" placeholder="{{ t('Name') }}">
                            @endif
                        </div>


                       <!--  <div class="upload-zone py-80 px-38">
                            <div class="text-center">
                                <input id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename]" type="file" class="upload_white mb-20">
                                <label id="error-profile-logo" class=""></label>
                                <p class="w-md-440 mx-auto">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                            </div>
                        </div> -->

                        <div class="w-xl-970 mx-auto upload-zone">
                            <div class="pt-40 px-38 px-lg-0">
                                <div class="pb-40 mb-40 d-md-flex">
                                    <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">

                                    <?php

                                 if (isset($album)) {
                                	$is_exist = false;
                                	if ($album->cropped_image == "") {

                                		if (Storage::exists($album->filename)) {
                                			?>

                                                                                    <img id="output-partner-logo" src="{{ \Storage::url($album->filename) }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                                                                            <?php $is_exist = true;
                                		}
                                	} else {
		                            if (Storage::exists($album->cropped_image)) {?>
                                                <img id="output-partner-logo"  src="{{ \Storage::url($album->cropped_image) }}" alt="{{ trans('metaTags.Go-Models') }}"/>

                                             <?php $is_exist = true;}
	                                }
	                                if ($is_exist == false) {?>
                                                <img id="output-partner-logo" src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                                            <?php }
                                    } else {?>

                                            <img id="output-partner-logo" src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}"/>

                                    <?php }?>

                                    <?php if (isset($album) && $is_exist == true) {?>
                                        <a href="#" data-featherlight="{{ route('album-img-zoom-popup',['id' => $album->id]) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                                    <?php }?>

                                       <!--  <a href="#" class="btn btn-primary trash mini-all position-absolute to-bottom-0 to-right-0"></a> -->
                                        <!-- <span class="btn save position-absolute photo-saved">Photo saved</span> -->
                                    </div>
                                    <div class="d-md-inline-block">
                                        <!-- <input id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename]" type="file" class="upload_white mb-20"> -->
                                        <?php if (isset($album)) {?>
                                            <div class="upload-btn-wrapper">
                                                <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{t('select photo')}}</a>
                                                <input type="file"  id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename]" accept="image/x-png,image/gif,image/jpeg,image/jpg"/>
                                            </div>
                                    <?php } else {?>
                                        <div class="upload-btn-wrapper">
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{t('select photo')}}</a>
                                          <input type="file"  id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename][]" multiple="multiple" accept="image/x-png,image/gif,image/jpeg,image/jpg" />
                                        </div>
                                    <?php }?>

                                        <p class="w-lg-460">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}
                                        <br /> <span class="font-red">{{-- t('select photo') --}}</span> </p>

                                        <p id="error-profile-logo" class=""></p>
                                        <p  class="mb-20 help-block"  style="display: none;" id="warning-close-windows">{{ t('Uploading your photos can take some minutes Please be patient and DO NOT close this window') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                        <div class="d-flex justify-content-center align-items-center container px-0 pt-40">
                            <button type="submit" class="btn btn-success save" id="upload-photo">{{ t('Save') }}</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}


@endsection

@section('after_scripts')
    <script>

        $(document).ready( function(){

            $('#checkAll').click( function(){
                checkAll(this);
            });

            $('a.delete-btn, button.delete-btn').click(function(e)
            {
                e.preventDefault(); /* prevents the submit or reload */
                var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");

                if (confirmation) {
                    if( $(this).is('a') ){
                        var url = $(this).attr('href');
                        if (url !== 'undefined') {
                            window.location.href = url;
                        }
                    } else {
                        $('form[name=listForm]').submit();
                    }

                }

                return false;
            });

        });

        function checkAll(bx) {
            var chkinput = document.getElementsByTagName('input');
            for (var i = 0; i < chkinput.length; i++) {
                if (chkinput[i].type == 'checkbox') {
                    chkinput[i].checked = bx.checked;
                }
            }
        }
    </script>

     <script>


          var loadFile = function(event) {

            // var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
            // var fileSize = Math.round((event.target.files[0].size / 1024));
            // var filename = event.target.files[0].name;

            // if(fileSize > imageSize){
            //    $('#error-profile-logo').html('{{ t("File") }} "'+filename+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
            //     return false;
            // }

            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('output-partner-logo');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);

            $('.zoom').hide();

            // if($('#partnerprofileLogo').val() == ""){
            //    $('#error-profile-logo').html('{{ t("File is required") }} ').css("color", "red");
            // }else{
            //     $('#error-profile-logo').html('');
            // }

          };

        $(document).ready( function(){

            $('#modelImage').submit(function(event) {

                var ele = document.getElementById('partnerprofileLogo');

                if($('#is_edit').val() !== 'no'){
                    if(ele.files.length == 0){
                        $("#warning-close-windows").show();
                        $('html,body').animate({ scrollTop:  $("#profile-image-div").offset().top }, 'slow', function () {//alert("reached top");    
                        });
                        $('.save').prop('disabled', true);        
                        $(".loading-process").show();
                        return true;
                    }
                }

               var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

                var currentUploadImageCount = parseInt(ele.files.length);

                // select 5 image validation
                if(currentUploadImageCount > 5){
                    $('#error-profile-logo').html('{{ t("max select image upload valid") }} ').css("color", "red");
                    return false;
                }

                // check file size is valid
                for (var i = 0; i < ele.files.length; i++) {

                    var imageType = ele.files[i].type.toLowerCase();
                    var imageSize = ele.files[i].size;
                    var fileSize = Math.round((imageSize / 1024));

                    var extension = imageType.split('/');

                    //check image extension
                    if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {

                        $('#error-profile-logo').html('{{ t("invalid_image_type") }} ').css("color", "red");
                        return false;
                    }

                    if(fileSize > maxUploadImageSize){

                        var reader = new FileReader();

                        reader.onload = function(){
                            var output = document.getElementById('output-partner-logo');
                            output.src = reader.result;
                        };

                        reader.readAsDataURL(ele.files[i]);

                        $('.zoom').hide();

                        $('#error-profile-logo').html('{{ t("File") }} "'+ele.files[i].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");

                        return false;
                    }
                }

                //image required validation
                if($('#partnerprofileLogo').val() == ""){
                    $('#error-profile-logo').html('{{ t("Photo is required") }} ').css("color", "red");
                    return false;
                }else{

                    //max user 30 image upload validation
                    var AlreadyUploadImageCount = parseInt('<?php echo $count; ?>');

                    var totalImageCount =  currentUploadImageCount + AlreadyUploadImageCount;

                    // check total image upload
                    if(totalImageCount > 30){
                        $('#error-profile-logo').html('{{ t("You can upload a maximum of 30 pictures") }} ').css("color", "red");
                        return false;
                    }

                    $('#error-profile-logo').html('');
                    $("#warning-close-windows").show();
                    $('html,body').animate({ scrollTop:  $("#profile-image-div").offset().top }, 'slow', function () {//alert("reached top");    
                    });
                    $('.save').prop('disabled', true);        
                    $(".loading-process").show();
                    return true;
                }
             });
        })

    </script>
@endsection