@extends('layouts.logged_in.app-model')

@section('content')

<style type="text/css">
    .upload-zone{
        display: grid !important;
    }
</style>

    <div class="container pt-40 pb-60 px-0">
        <h1 class="text-center prata">{{ ucwords(t('Portfolio photos')) }}</h1>
        <div class="position-relative">
            <div class="divider mx-auto"></div>
            <p class="text-center mb-30 w-lg-596 mx-lg-auto">{{t('portfolio subtitle :number', ['number' => $imageUploadLimit] )}}</p>
            <div class="text-center xl-to-right-0 xl-to-top-0">
                <a href="{{ route('model-portfolio',['id' => $user->id ]) }}" class="btn btn-white insight mini-mobile mb-20">{{t('View')}}</a>
                <?php if (isset($modelbooks) && $modelbooks->count() > 0) {?>
                <a href="{{ lurl('account/model-book/genrate/') }}/<?php echo $user->id; ?>" class="btn btn-white upload_white mini-mobile mb-20">{{ t('GenrateModelBook') }}</a>
                <a class="btn btn-white download mini-mobile mb-20" href="{{ lurl('account/'.$user->id.'/downloadmbook') }}">{{ t('Download Modelbook') }}</a>
                <?php }?>

            </div>
        </div>
        <div class="error-msg mb-30 py-2 d-none alert alert-danger"></div>
        
        @include('childs.notification-message')
        
        <form id="model-book-form" name="listForm" method="POST" action="{{ lurl('account/model-book/delete') }}">
            {!! csrf_field() !!}
                @if($modelbooks && $modelbooks->count() > 0 )
                    <div class="row listForm-deleteAll-container mb-30">
                        <div class="col-md-6 col-6 form-group custom-checkbox middle-checkbox">
                            <input class="checkbox_field" id="checkAll" name="entrie" type="checkbox">
                            <label for="checkAll" id="selected-all" class="checkbox-label "> {{ t('Select') }}: {{ t('All') }}</label>
                        </div>
                        <div class="col-md-6 col-6 form-group custom-checkbox text-right">
                            <button type="submit"  class="btn btn-white mini-mobile trash_white delete-btn">{{ t('Delete') }}</button>
                        </div>
                    </div>
                @endif

               

                <?php /*
                @include('flash::message')
                @if (isset($errors) and $errors->any())
                    <div class="alert alert-danger w-xl-970 mx-auto">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><strong>{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}</strong></h5>
                        <ul class="list list-check">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                */ ?>
                <?php
                    
                    $image_path = '';
                    
                    if (isset($modelbooks) && $modelbooks->count() > 0) { ?>
                        <div class="row drag-n-drop">
                            <?php 
                            foreach ($modelbooks as $key => $modelbook) {
                                
                                $image_exist = 0;
                                if ($modelbook->cropped_image == "" && !empty($modelbook->filename) && Storage::exists($modelbook->filename)) {
                                    $image_path = \Storage::url($modelbook->filename);
                                    $image_exist = 1;
                                }elseif ($modelbook->filename != "" && !empty($modelbook->cropped_image) && Storage::exists($modelbook->cropped_image)){

                                    $image_path = \Storage::url($modelbook->cropped_image);
                                    $image_exist = 1;
                                }elseif ($modelbook->filename != "" && Storage::exists($modelbook->filename)) {
                                    $image_path = \Storage::url($modelbook->filename);
                                    $image_exist = 1;
                                }
                        		
                                /*
                                if ($modelbook->cropped_image == "" && \Storage::url($modelbook->filename)) {
                        			// echo "if";
                        			$image_path = \Storage::url($modelbook->filename);
                        		}
                        		if ($modelbook->cropped_image != "" && url(config('filesystems.default') . '/' . str_replace("uploads", "", $modelbook->cropped_image))) {
                        			// echo "else";
                        			$image_path = url(config('filesystems.default') . '/' . str_replace("uploads", "", $modelbook->cropped_image));
                        		} */ ?>

                               
                                    <div class="card-to-sort col-md-6 col-xl-3 mb-30 modelbook-item-{{ $modelbook->id }} model-book-div">
                                        <div class="img-holder position-relative">
                                            <div class="img-holder d-flex align-items-center justify-content-center position-relative">

                                                <a href="#" data-id='{{ $image_path}}' data-url="{{ route('show-gallery',['id' => $modelbook->id, 'user_id' => $modelbook->user_id]) }}" data-titel="{{  (!empty($modelbook->name) ? str_limit($modelbook->name, config('constant.title_limit')) : t('Model Book Photo')) }}"   id="some-button" class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                                                <!-- <a href="#" data-featherlight="{{ route('show-modelbook',['id' => $modelbook->id]) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a> -->

                                                <a href="javascript:void(0);" class="position-absolute to-bottom-0 to-right-0 btn btn-primary trash mini-all delete-btn delete-specific-modelbook" id="{{ $modelbook->id }}" title="{{ t('Delete Photo') }}"></a>

                                                <?php /* <a href="{{ lurl('account/model-book/'.$modelbook->id.'/delete') }}" class="position-absolute to-bottom-0 to-right-0 btn btn-primary trash mini-all delete-btn delete-specific-modelbook" id="{{ $modelbook->id }}" title="{{ t('Delete Photo') }}"></a> */ ?>
                                                @if($image_exist)
                                                    <img src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                                                @else
                                                    <img src="{{ url(config('app.cloud_url') . '/images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}" >
                                                @endif
                                            </div>   
                                        </div>
                                        <div class="box-shadow bg-white py-40 px-20 model-book-photo-title">
                                            <span class="mb-30">{{  (!empty($modelbook->name) ? str_limit($modelbook->name, config('constant.title_limit')) : t('Model Book Photo')) }}
                                            </span>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ lurl('account/model-book/' . $modelbook->id . '/edit') }}" class="btn btn-success edit mini-all" title="{{ t('Edit Photo') }}"></a>
                                                <span class="middle-checkbox">
                                                    <div class="col-md-6 form-group custom-checkbox">
                                                        <input class="checkbox_field" id="studio_{{$key}}" name="entries[]" type="checkbox" value="{{ $modelbook->id }}">
                                                        <label for="studio_{{$key}}" class="checkbox-label">{{ t('Select') }}</label>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                            }   ?>
                        </div>
                        @include('customPagination', ['paginator' => $modelbooks])
                    <?php 
                } ?>
        </form>
        <form name="modelbook" id="modelbook-img-upload" class="form-horizontal modelbook" role="form" method="POST" action="{{ lurl(trans('routes.model-portfolio-edit')) }}" enctype="multipart/form-data">
            <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 mx-xl-auto" id="profile-image-div">
                <div class="w-xl-970 mx-auto">
                    <div class="px-38 px-xl-0">
                        <h2 class="bold f-18 lh-18">{{ t('Upload photo') }}</h2>
                        <div class="divider"></div>

                        <div class="input-group w-xl-970">
                            <input class="animlabel" name="modelbook[name]" type="text">
                            <label for="{{ t('Name') }}">{{ t('Name') }}</label>
                        </div>

                        <div class="w-xl-970 mx-auto upload-zone">
                            <div class="pt-40 px-38 px-lg-0">
                                <div class="pb-20 mb-20 d-md-flex">
                                    <div id="dvPreview" class="dm-md-inline-block position-relative d-flex align-items-center justify-content-center mb-sm-30 profile-photo dvPreview">
                                       <!--  <img id="output-model-book-img" src="{{ URL::to(config('app.cloud_url') . '/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}" class="mr-md-20 " />
                                        <div id="dvPreview"></div> -->
                                    </div>
                                </div>
                            </div>

                            

                            <div class="d-md-inline-block text-center px-38 px-lg-0">
                                         
                                <div class="upload-btn-wrapper">
                                  <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{t('select photo')}}</a>

                                  <input type="file" id="model-book-img" name="modelbook[filename][]"  multiple="multiple" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                                </div>

                                <!-- <p id="fileSize-error-msg" class="text-center">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p> -->

                                 <p id="fileSize-error-msg" class="text-center pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}
                                        <br /> <span class="font-red">{{ t('maximum photo amount is :number', [ 'number' => $imageUploadLimit]) }}</span> </p>

                                <p id="error-model-book-img" class=""></p>
                                <p  class="mb-20 help-block"  style="display: none;" id="warning-close-windows">{{ t('Uploading your photos can take some minutes Please be patient and DO NOT close this window') }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center container px-0 pt-40">
                            <button type="submit" class="btn btn-success save">{{t('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('page-script')
<style type="text/css">
    .input-group > .form-control, .input-group > .custom-select{
        height: 55px;
        line-height: 42px;
    }
    .file-input .upload_white{
        line-height: 18px !important;
    }
    .krajee-default .file-footer-caption{
        margin-bottom:0 !important;
    }
    .krajee-default .file-caption-info, .krajee-default .file-size-info{
        height:20px !important;
    }
</style>
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css"> -->

<link href="{{ url(config('app.cloud_url') . '/assets/css/magnific-popup.css') }}" rel="stylesheet">

<link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
@if (config('lang.direction') == 'rtl')
    <link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
@endif



<script src="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>


@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>


@endif
<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}" type="text/javascript"></script>
 <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script> -->
<script type="text/javascript">

    // $('#model-book-form').submit(function(event) {
        
    //     $('#error-model-book-img').html('');
    //     var ele = document.getElementById('model-book-img');

    //     var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

    //     var status = true;
         
    //     if(parseInt(ele.files.length) > 0){

    //         var imageType = ele.files[0].type.toLowerCase();
    //         var imageSize = ele.files[0].size;
    //         var fileSize = Math.round((imageSize / 1024));
    //         var extension = imageType.split('/');

    //         //check image extension  
    //         if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {
                    
    //             $('#error-model-book-img').html('{{ t("model_book_valid_image") }} ').css("color", "red");
    //             status = false;
    //         }
    //         // check file size
    //         if(fileSize > maxUploadImageSize){
    //           //$('#fileSize-error-msg').css({'color': 'red'});
              
    //           $('#fileSize-error-msg').html('{{ t("File") }} "'+ele.files[0].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");

    //             status = false;
    //         }else{
    //             //$('#fileSize-error-msg').css({'color': 'black'});
    //             $('#fileSize-error-msg').html("{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}").css({'color': 'black'});
    //         }
    //         //image required validation
    //         if($('#model-book-img').val() == ""){
    //             $('#error-model-book-img').html('{{ t("File is required") }} ').css("color", "red");
    //             status = false;
    //         }else{
    //             //max user 30 image upload validation
    //             var AlreadyUploadImageCount = parseInt('<?php //echo $totalCount; ?>');
    //             var totalImageCount =  AlreadyUploadImageCount + 1;

    //             // check total image upload
    //             if(totalImageCount > 30){
    //                 $('#error-model-book-img').html('{{ t("You can upload a maximum of 30 pictures") }} ').css("color", "red");
    //                  status = false;
    //             }
    //         }
    //     }

    //     if($('#model-book-img').val() == ""){
    //         $('#error-model-book-img').html('{{ t("File is required") }} ').css("color", "red");
    //         status = false;
    //     }

    //     return status;
    // });
    
    var AlreadyUploadImageCount; 
    AlreadyUploadImageCount = parseInt('<?php echo $totalCount; ?>');
     
    $(document).ready( function(){
        
        $('#modelbook-img-upload').submit(function() {
            
            var fileUpload = document.getElementById("model-book-img");
            var dvPreview = document.getElementById("dvPreview");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            var currentUploadImageCount = parseInt(fileUpload.files.length);
            var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
            var imageUploadLimit = "{{ $imageUploadLimit }}";
            
            // select 5 image validation
            if(currentUploadImageCount > 5){
                
                $('#error-model-book-img').html('{{ t("max select image upload valid") }} ').css("color", "red");
                dvPreview.innerHTML = "";
                return false;
            }

            //image required validation
            if($('#model-book-img').val() == ""){
                
                $('#error-model-book-img').html('{{ t("Photo is required") }} ').css("color", "red");
                dvPreview.innerHTML = "";
                return false;
            }else{
                
                //max user 30 image upload validation
                var totalImageCount =  currentUploadImageCount + AlreadyUploadImageCount;
                // check total image upload
                if(totalImageCount > imageUploadLimit){
                    
                    $('#error-model-book-img').html('{{ t("You can upload a maximum of :number pictures", ["number" => $imageUploadLimit]) }} ').css("color", "red");
                    dvPreview.innerHTML = "";
                    return false;
                }
            }

            for (var i = 0; i < fileUpload.files.length; i++) {
                
                var file = fileUpload.files[i];
                var imageType = file.type.toLowerCase();
                var extension = imageType.split('/');

                //check image extension  
                if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {

                    $('#error-model-book-img').html('{{ t("invalid_image_type_modelBook") }} ').css("color", "red");
                    dvPreview.innerHTML = "";
                    return false;   
                }
                
                var imageSize = fileUpload.files[i].size;
                var fileSize = Math.round((imageSize / 1024));

                if(fileSize > maxUploadImageSize){
                    
                    $('#error-model-book-img').html('{{ t("exceeds maximum allowed upload size of") }} ').css("color", "red");
                    
                    $('#error-model-book-img').html('{{ t("File") }} "'+fileUpload.files[i].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");
                    dvPreview.innerHTML = "";
                    return false;
                }
            }

            $("#warning-close-windows").show();
            $('html,body').animate({ scrollTop:  $("#profile-image-div").offset().top }, 'slow', function () {//alert("reached top");    
            });
            $('.save').prop('disabled', true);        
            $(".loading-process").show();
            return true;

        });
    });


    window.onload = function () {
    
        var fileUpload = document.getElementById("model-book-img");

        fileUpload.onchange = function () {

            if (typeof (FileReader) != "undefined") {

                $('#error-model-book-img').html('');

                var dvPreview = document.getElementById("dvPreview");
                dvPreview.innerHTML = "";
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;

                var currentUploadImageCount = parseInt(fileUpload.files.length);

                // select 5 image validation
                if(currentUploadImageCount > 5){
                    
                    $('#error-model-book-img').html('{{ t("max select image upload valid") }} ').css("color", "red");
                    dvPreview.innerHTML = "";
                    return false;
                }
                
                for (var i = 0; i < fileUpload.files.length; i++) {
                    
                    var file = fileUpload.files[i];
                    
                    if (regex.test(file.name.toLowerCase())) {
                        
                        var reader = new FileReader();
                        
                        reader.onload = function (e) {
                            var img = document.createElement("IMG");
                            // img.height = "100px";
                            // img.width = "100px";
                            // img.attr("style", "height:100px;width: 100px");
                            // img.attr("src", e.target.result);
                            // img.class = "mr-md-10";
                            // img.style = "height: 100px; width: 15%; margin-right: 10px";
                            img.src = e.target.result;
                            dvPreview.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    } else {

                        $('#error-model-book-img').html('{{ t("invalid_image_type_modelBook") }} ').css("color", "red");
                        // alert(file.name + " is not a valid image file.");
                        dvPreview.innerHTML = "";
                        return false;
                    }
                }
                return true;
            } else {
                alert("This browser does not support HTML5 FileReader.");
                return false;
            }
        }
    };

    // var loadFile = function(event) {

    //     var input_id = event.target.id;
    //     $('#error-model-book-img').html('');

    //     var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

    //     // var ele = document.getElementById('model-book-img');



    //     // var currentUploadImageCount = parseInt(ele.files.length);

    //     // // console.log(currentUploadImageCount); return false;


    //     // // check file size is valid
    //     // for (var i = 0; i < ele.files.length; i++) {
            
    //     //     var imageType = ele.files[i].type.toLowerCase();
    //     //     var imageSize = ele.files[i].size;
    //     //     var fileSize = Math.round((imageSize / 1024));

    //     //     var extension = imageType.split('/');
            
    //     //     var filename = event.target.files[i].name;

    //     //     var dataId = 'output-model-book-img';
            
    //     //     if(i > 0){

    //     //         console.log(i);
                
    //     //          var appendData = '<img id="output-model-book-img-'+i+'" class="mr-md-20" />';
    //     //         $('.append').append(appendData);
    //     //         var dataId = 'output-model-book-img-'+i;

    //     //         console.log(appendData);


    //     //     }

    //     //     console.log(dataId);
            

    //     //     var reader = new FileReader();
            
    //     //     reader.onload = function(){
    //     //         var output = document.getElementById(dataId);
    //     //         output.src = reader.result;
    //     //     };
            
    //     //     reader.readAsDataURL(event.target.files[i]);
    //     // }

    //     // return false;


    //     if(parseInt(event.target.files.length) > 0) {
    //         var fileSize = Math.round((event.target.files[0].size / 1024));

    //         var filename = event.target.files[0].name;

    //         var reader = new FileReader();
    //         reader.onload = function(){
    //           var output = document.getElementById('output-model-book-img');
    //           output.src = reader.result;
    //         };
            
    //         reader.readAsDataURL(event.target.files[0]);

    //         // if(fileSize > imageSize){
    //         //     $('#fileSize-error-msg').css({'color': 'red'});
    //         //     return false;
    //         // }else{
    //         //     $('#fileSize-error-msg').css({'color': 'black'});
    //         // }
    //     }
    // };

    /* Initialize with defaults (sedcard) */
    $('.btn-upload').fileinput({
            browseLabel:"upload picture",
            browseClass: 'btn btn-white upload_white mb-20 col-12',
            language: '{{ config('app.locale') }}',
            @if (config('lang.direction') == 'rtl')
                rtl: true,
            @endif
            showPreview: true,
            allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
            showUpload: false,
            showRemove: false,
            maxFileSize: {!! (int)config('settings.upload.max_file_size', 1000) !!},
            fileActionSettings:{
                showZoom: false,
            }
    });


    $(document).ready( function(){
        
        var modelBookDivCount =  $('.model-book-div').length;

        if(modelBookDivCount == 0){
            $('button.delete-btn').prop( "disabled", true );
        }else{
            $('button.delete-btn').prop( "disabled", false);
        }
        
        $('.delete-specific-modelbook').click(function(e){

            e.preventDefault();
            
            var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");
            
            if (confirmation) {
                
                var modelBookId = $(this).attr("id");
                url = baseurl + "account/model-book/"+modelBookId+"/delete";
            
                $.ajax({

                    method: "get",
                    url: url,
                    beforeSend: function(){
                      $(".loading-process").show();
                    },
                    complete: function(){
                      $(".loading-process").hide();
                    },
                    success: function (data) {
                        if(data.status == true){
                            AlreadyUploadImageCount = AlreadyUploadImageCount - 1;
                            $('.error-msg').addClass('d-none');
                            $('.modelbook-item-'+modelBookId).remove(); 
                        }else{
                           
                            $('.error-msg').removeClass('d-none');
                            $('.error-msg').val(data.message);
                        } 

                        $('.modelbook-item-'+modelBookId).removeClass('model-book-div');

                        // if curren page model-book record not exist, disabled delete button 
                        if($('.model-book-div').length == 0){

                            $('button.delete-btn').prop( "disabled", true);
                        }
                        
                        // if no more model-book images redirect to model-book creat page
                        if(data.returnUrl != ''){
                            var redirect = baseurl + '<?php echo trans('routes.model-portfolio-edit') ?>';
                            window.location.href = redirect;
                            return true; 
                        }
                    }, 
                    error: function (a, b, c) {
                        console.log('error');
                    }  
                });
            }
            return false;
        });


        $('#checkAll').click( function(){
            checkAll(this);

        });
        $('button.delete-btn').click(function(e)
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
                    
                    var is_checked = false;
                    var chkinput = document.getElementsByTagName('input');
                    for (var i = 0; i < chkinput.length; i++) {
                        if (chkinput[i].type == 'checkbox') {
                            if($('#'+chkinput[i].id).prop("checked") == true){
                               is_checked = true;
                            }
                        }
                    }

                    if(is_checked == false){
                       alert('{{ t("Please select an item from the list") }}');
                       return false; 
                    }

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
    
<?php 
if (isset($modelbooks) && $modelbooks->count() > 0) 
{ 
    $image_path = '';
?>

// $(document).ready( function(){

//     var magnificPopup = $.magnificPopup.instance;
    
//     $('.some-button').click( function(e){
//         e.preventDefault();

//         var url = $(this).attr('data-url');

//         $.ajax({
//             method: "get",
//             url: url,
//             dataType: 'json',
//             success: function (response) {
               
//                 if(response.success){

//                     const magnificpopup = $.magnificPopup.instance;

//                     magnificpopup.open({
//                         mainClass: 'mfp-with-zoom',
//                         items: response.imageArr,
//                         gallery: { enabled: true },
//                         fixedContentPos: true,
//                         type: 'image',
//                         tError: '<a href="%url%">The image</a> could not be loaded.',
//                         /*image: {
//                             verticalFit: true
//                         },
//                          /*zoom: {  
//                                     enabled: true,
//                                     duration: 100 
//                                 }*/
//                             });

//                     magnificpopup.ev.off('mfpBeforeChange.ajax');
//                 }

//             }, error: function (a, b, c) {
//                 console.log('error');
//             }
//         });
//     });
// });
<?php    
}
?>
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/mfp-zoom-slider-popup.js') }}
@endsection