@extends('layouts.logged_in.app-partner')

@section('content')
<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready( function(){

    var magnificPopup = $.magnificPopup.instance;
    
    $('.some-button').click( function(e){
       <?php // alert();?>
        e.preventDefault();

        var url = $(this).attr('data-url');

        $.ajax({
            method: "get",
            url: url,
            dataType: 'json',
            success: function (response) {
               
                if(response.success){

                    const magnificpopup = $.magnificPopup.instance;

                    magnificpopup.open({
                        mainClass: 'mfp-with-zoom',
                        items: response.imageArr,
                        gallery: { enabled: true },
                        fixedContentPos: true,
                        type: 'image',
                        tError: '<a href="%url%">The image</a> could not be loaded.',
                        <?php /*image: {
                            verticalFit: true
                        },
                         /*zoom: {  
                                    enabled: true,
                                    duration: 100 
                                }*/ ?>
                            });

                    magnificpopup.ev.off('mfpBeforeChange.ajax');
                }

            }, error: function (a, b, c) {
                console.log('error');
            }
        });
    });
});
</script>
<link href="{{ url(config('app.cloud_url') . '/assets/css/magnific-popup.css') }}" rel="stylesheet">
    <div class="container pt-40 pb-60 px-0">
        <h1 class="text-center prata">{{ ucWords(t('My albums')) }}</h1>
        <div class="position-relative">
            <div class="divider mx-auto"></div>
            <?php /*<!-- <p class="text-center mb-30 w-lg-596 mx-lg-auto">On this page, viverra ut sodales pretium, interdum ut metus. Drag & Drop photos to reorder</p>-->*/?>
            <div class="text-center position-absolute-xl xl-to-right-0 xl-to-top-0">
               <?php /*<!--  <a href="{{ lurl('account/album/create') }}" class="btn btn-default add_locale mini-mobile mb-20">{{ t('Upload pictures') }}</a> -->*/?>
                
                <a href="{{ lurl('account/album/genrate/') }}/<?php echo $user->id; ?>" class="btn btn-default insight mini-mobile mb-20">{{ t('Adjust pictures') }}</a>
            </div>

            <form name="listForm" method="POST" action="{{ lurl('account/album/delete') }}">
                    {!! csrf_field() !!}
                @if($data && $data->count() > 0 )
                    <div class="row listForm-deleteAll-container mb-30" style="margin-top: 5%;">
                        <div class="col-md-6 col-6 form-group custom-checkbox middle-checkbox">
                            <input class="checkbox_field" id="checkAll" name="entrie" type="checkbox">
                            <label for="checkAll" id="selected-all" class="checkbox-label "> {{ t('Select') }}: {{ t('All') }}</label>
                        </div>
                        <div class="col-md-6 col-6 form-group custom-checkbox text-right">
                            <button type="submit"  class="btn btn-white trash_white delete-btn">{{ t('Delete') }}</button>
                        </div>
                    </div>
                @endif
            
                @include('childs.notification-message')
                 

                <div class="row drag-n-drop" id="append-album">
                    @if($data && $data->count() > 0 )
                        @foreach($data as $key => $album)
                        <div class="card-to-sort col-md-6 col-xl-3 mb-30">
                            <div class="img-holder position-relative">
                                <div class="img-holder d-flex align-items-center justify-content-center position-relative">

                                    <a href="#"  data-id="{{ $album->filename}}"  data-url="{{ route('alubm-gallery',['id' => $album->id,'user_id' => $album->user_id]) }}" class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all" id="some-button"  ></a>
                                    <a href="{{ lurl('account/album/'.$album->id.'/delete') }}" class="position-absolute to-bottom-0 to-right-0 btn btn-primary trash mini-all delete-btn" title="{{ t('Delete Photo') }}"></a>

                                        @if($album->cropped_image !== "" && $album->cropped_image !== null && Storage::exists($album->cropped_image))
                                            <img src="{{ \Storage::url($album->cropped_image) }}" alt="{{ trans('metaTags.User') }}">
                                        @elseif ($album->filename !== "" && Storage::exists($album->filename))
                                            <img src="{{ \Storage::url($album->filename) }}" alt="{{ trans('metaTags.User') }}" >
                                        @else
                                            <img src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                                        @endif
                                </div>
                            </div>

                            <div class="box-shadow bg-white py-40 px-30">
                                <span class="mb-30">{{ (!empty($album->name) ? str_limit($album->name, config('constant.title_limit')) : t('default title portfolio photos')) }}</span>
                                <div class="d-flex justify-content-between">
                                    <?php /*<!-- <a href="#" class="btn btn-white sort mini-all"></a> -->*/?>
                                    <a href="{{ lurl('account/album/' . $album->id . '/edit') }}" class="btn btn-success edit mini-all" title="{{ t('Edit Photo') }}"></a>
                                    <span class="middle-checkbox">
                                        <div class="col-md-6 form-group custom-checkbox">
                                            <input class="checkbox_field" id="studio_{{$key}}" name="entries[]" type="checkbox" value="{{ $album->id }}">
                                            <label for="studio_{{$key}}" class="checkbox-label">{{ t('Select') }}</label>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </form> 
        </div>

        <div class="text-cente mb-30 position-relative">
            @include('customPagination')
        </div>

        {{ Form::open(array('url' => lurl('account/album-book'), 'method' => 'post', 'files' => true, 'id' => 'modelImage')) }}

        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 mx-xl-auto" id="profile-image-div">
            <div class="w-xl-970 mx-auto">
                <div class="px-38 px-xl-0">
                    <h2 class="bold f-18 lh-18">{{ t('Upload photo') }}</h2>
                    <div class="divider"></div>
                    
                    <input name="panel" type="hidden" value="albumPanel">

                    <div class="input-group w-xl-970">
                        <input class="animlabel" name="album[name]" type="text">
                        <label for="{{ t('Name') }}" class="input-label">{{ t('Name') }}</label>
                    </div>

                   <?php /*<!--  <div class="upload-zone py-80 px-38">
                        <div class="text-center">
                            <input id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename]" type="file" class="upload_white mb-20">
                            <label class="" id="error-profile-logo" class="required"></label>
                            <p class="w-md-440 mx-auto">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                        </div>
                    </div> -->*/?>

                    <div class="w-xl-970 mx-auto upload-zone" >
                        <div class="pt-40 px-38 px-lg-0">
                            <div class="pb-40 mb-40 d-md-flex">
                                <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                    <img id="output-partner-logo" src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="Go Models"/>
                                </div>
                                <div class="d-md-inline-block">
                                    <?php /*<!-- <input id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename]" type="file" class="upload_white mb-20"> -->*/?>
                                    <div class="upload-btn-wrapper">
                                      <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{t('select photo')}}</a>
                                      <input type="file" id="partnerprofileLogo" onchange="loadFile(event)" name="album[filename][]" multiple="multiple" accept="image/x-png,image/gif,image/jpeg,image/jpg"/>
                                    </div>
                                    
                                    <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}
                                        <br /> <span class="font-red">{{ t('Select upto 5 images') }}</span> </p>
                                    <p id="error-profile-logo" class=""></p>
                                    <p  class="mb-20 help-block"  style="display: none;" id="warning-close-windows">{{ t('Uploading your photos can take some minutes Please be patient and DO NOT close this window') }}</p>
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
    </script>

     <script>
        

          var loadFile = function(event) {
            <?php /*
            // var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
            // var fileSize = Math.round((event.target.files[0].size / 1024));
            // var filename = event.target.files[0].name;

            // if(fileSize > imageSize){
            //    $('#error-profile-logo').html('{{ t("File") }} "'+filename+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
            //     return false;
            // } */
            ?>
            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('output-partner-logo');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            <?php /*
            // if($('#partnerprofileLogo').val() == ""){
            //    $('#error-profile-logo').html('{{ t("File is required") }} ').css("color", "red");
            // }else{
            //     $('#error-profile-logo').html('');
            // }
           */?>
          };

        $(document).ready( function(){
        
            $('#modelImage').submit(function(event) {
                 
                var ele = document.getElementById('partnerprofileLogo');
                var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
                 
                var currentUploadImageCount = parseInt(ele.files.length);

                <?php // select 5 image validation ?>
                if(currentUploadImageCount > 5){
                    $('#error-profile-logo').html('{{ t("max select image upload valid") }} ').css("color", "red");
                    return false;
                }

                <?php // check file size is valid ?>
                for (var i = 0; i < ele.files.length; i++) {
                    
                    var imageType = ele.files[i].type.toLowerCase();
                    var imageSize = ele.files[i].size;
                    var fileSize = Math.round((imageSize / 1024));

                    var extension = imageType.split('/');

                    <?php //check image extension  ?> 
                    if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {
                        
                        $('#error-profile-logo').html('{{ t("invalid_image_type") }} ').css("color", "red");
                        return false;   
                    }
                    
                    if(fileSize > maxUploadImageSize){
                        
                        <?php //show large image in image-box ?>
                        var reader = new FileReader();

                        reader.onload = function(){
                            var output = document.getElementById('output-partner-logo');
                            output.src = reader.result;
                        };
                        
                        reader.readAsDataURL(ele.files[i]);

                        $('.zoom').hide();

                        $('#error-profile-logo').html('{{ t("exceeds maximum allowed upload size of") }} ').css("color", "red");
                        
                        $('#error-profile-logo').html('{{ t("File") }} "'+ele.files[i].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");

                        return false;
                    }
                }

                <?php //image required validation ?>
                if($('#partnerprofileLogo').val() == ""){
                    $('#error-profile-logo').html('{{ t("Photo is required") }} ').css("color", "red");
                    return false;
                }else{
                    
                    <?php
                    //max user 30 image upload validation ?>
                    var AlreadyUploadImageCount = parseInt('<?php echo $count; ?>');

                    var totalImageCount =  currentUploadImageCount + AlreadyUploadImageCount;

                    <?php // check total image upload ?>
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