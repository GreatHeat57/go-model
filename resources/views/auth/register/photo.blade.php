@extends('layouts.logged_in.out_of_app')
@section('content')

 @include('childs.register_title')
 @include('childs.notification-message')
 @include('auth.register.inc.wizard_new')

 <!-- <style type="text/css">
    .upload-zone{
        border: 2px dashed #DCDCDC;
        display: -webkit-box;
        /*-webkit-box-pack: unset;*/
    }
    .upload-image-inner-width{
        width: inherit;
    }
    .pd-10{
        padding: 10px 10px 10px 10px;
    }
    #output-partner-logo{
        width: 130px;
        height: 150px;
    }
    .upload-image-div{
        width: 150px;
    }
    .upload-image-div img {
        height: 150px;
        width: 100%;
    }
    #output-partner-logo{
        padding-left: 0px;
    }
 </style> -->

<div class="d-flex align-items-center container px-0 mw-970 pt-20">
    <div class="bg-white box-shadow full-width">
        <div class="d-flex justify-content-center">
            <div class="flex-grow-1 mw-720 py-20 px-30">
                <form name="photo" id="register-photo-tab" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
					{!! csrf_field() !!}

                    <input name="is_profile" type="hidden" value="{{ $user->id }}">
					<input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">


                     

					<div class="pb-40 pt-40 mb-40 bb-light-lavender3" id="profile-image-div">
                        
                        <div class="text-center mb-20 py-40">
                            <h1 class="prata mb-20">{{ t('Show yourshelf :firstname', ['firstname' => $user->profile->first_name]) }}</h1>
                            {{ t('registration_photo_page_yourself_inner_content') }}
                        </div>



                        <?php /*
                        <div class="w-lg-750 w-xl-970 mx-auto upload-zone mb-20 init-elem" id="0">
                            <div class="pt-40 px-38 px-lg-0">
                                <div class="pb-20 mb-20 d-md-flex">
                                    <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                         <?php if (!empty($user->profile->logo) && Storage::exists($user->profile->logo) ) { ?>
                                            
                                                <img id="output-partner-logo-0"  src="{{ \Storage::url($user->profile->logo) }}" alt="{{ trans('metaTags.Go-Models') }}"/>

                                         <?php } else { ?>
                                            <img id="output-partner-logo-0" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="{{ trans('metaTags.User') }}" >
                                        <?php } ?>
                                    </div>
                                    <div class="d-md-inline-block">
                                        <div class="upload-btn-wrapper">
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20 profile-logo">{{ t('select photo') }}</a>
                                          <input type="file" name="profile[logo]" onchange="changeFile(event, 0)" id="partnerprofileLogo" />
                                        </div>
                                        <p class="w-lg-460">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                    </div>
                                </div>
                                <p id="error-profile-logo-0" class="pb-20 pading-10"></label>
                            </div>
                        </div>

                        <?php */ ?>
                        <?php /*
                        <div class="w-lg-750 w-xl-970 mx-auto upload-zone mb-20 init-elem bg-white" id="0" >
                            <div class="px-lg-0 upload-image-inner-width">
                                <div class="d-md-flex">
                                    <div id="uploaded_image" class="dm-md-inline-block position-relative d-flex align-items-center justify-content-center pd-10 upload-image-div">
                                         <?php if (!empty($user->profile->logo) && Storage::exists($user->profile->logo) ) { ?>
                                            
                                                <img id="output-partner-logo-0"  src="{{ \Storage::url($user->profile->logo) }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                                         <?php } else { ?>
                                            <img id="output-partner-logo-0" src="{{ url(config('app.cloud_url').'/images/user_new.jpg') }}" alt="{{ trans('metaTags.User') }}" >
                                        <?php } ?>
                                    </div>
                                    <div class="d-md-inline-block py-30 text-center">
                                        <div class="upload-btn-wrapper">
                                          
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}
                                          <input type="file" id="upload_image" name="upload_image"   accept="image/x-png,image/jpeg,image/jpg"/>
                                        </a>
                                        </div>
                                        
                                        <input type="hidden" id="upload_image_value" name="upload_image_value" <?php if (!empty($user->profile->logo) && Storage::exists($user->profile->logo) ) { ?>value="{{$user->profile->logo}}" <?php }?>>
                                        <p class="w-lg-500 color-gray">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                        <p id="error-profile-logoerror" class=""></p>
                                    </div>
                                </div>
                                <p id="error-profile-pic" class=""></p>
                            </div>
                        </div>
                         */ ?>

                        

                        <div class="w-lg-750 w-xl-970 mx-auto upload-zone mb-20 init-elem" id="0" >
                            <div class="pt-40 px-38 px-lg-0" >
                                <div class="d-md-flex mb-40">
                                    <div id="uploaded_image" class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                         <?php if (!empty($user->profile->logo) && Storage::exists($user->profile->logo) ) { ?>
                                            
                                                <img id="output-partner-logo-0"  src="{{ \Storage::url($user->profile->logo) }}" alt="{{ trans('metaTags.Go-Models') }}"/>

                                         <?php } else { ?>
                                            <img id="output-partner-logo-0" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="{{ trans('metaTags.User') }}" >
                                        <?php } ?>
                                    </div>
                                    
                                     

                                    <div class="d-md-inline-block">
                                        <div class="upload-btn-wrapper">
                                          
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}
                                          <input type="file" id="upload_image" name="upload_image"   accept="image/x-png,image/jpeg,image/jpg"/>
                                        </a>
                                        </div>
                                        
                                        <input type="hidden" id="upload_image_value" name="upload_image_value" <?php if (!empty($user->profile->logo) && Storage::exists($user->profile->logo) ) { ?>value="{{$user->profile->logo}}" <?php }?>>
                                        <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                        <p id="error-profile-logoerror" class=""></p>
                                    </div>
                                </div>
                                <p id="error-profile-pic" class="mb-20 px-10"></p>
                            </div>
                        </div>

                            @if(!empty($modelbook))
                                <?php $i = 1; ?>
                                @foreach($modelbook as $value)
                                    <div class="w-lg-750 w-xl-970 mx-auto upload-zone mb-20 init-elem" id="0">
                                        <div class="pt-40 px-38 px-lg-0">
                                            <div class="pb-40 mb-40 d-md-flex">
                                                <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                                     <?php if (!empty($value->filename) && file_exists(public_path('uploads').'/'.$value->filename) ) { ?>
                                                        <img id="output-partner-logo-{{$i}}"  src="{{ \Storage::url($value->filename) }}" alt="{{ trans('metaTags.Go-Models') }}"/>

                                                     <?php } else { ?>
                                                        <img id="output-partner-logo-{{$i}}" src="{{ url(config('app.cloud_url').'/default/picture.jpg') }}" alt="{{ trans('metaTags.User') }}" >
                                                    <?php } ?>
                                                </div>
                                                <div class="d-md-inline-block">

                                                    <div class="upload-btn-wrapper">
                                                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>
                                                        
                                                        <input type='file' disabled/>
                                                    </div>
                                                    
                                                    <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                @endforeach
                            @endif
                        <div id="append-image"></div>
                    </div>
                    <?php /*
                        <!--  <div class="d-lg-flex justify-content-lg-between justify-content-xl-start text-center"> -->
                    */ ?>
                    <p align="center">
                        <a href="javascript:void(0);" class="btn btn-default add_locale mini-mobile mb-20" id="add_line">{{ t('more photos') }}</a>
                    </p>


                    <p style="display: none;" align="center" id="5imgValid" class="mb-20 help-block">{{ t('You can only upload 5 photos') }}</p>

                    <p style="display: none;" align="center" id="warning-close-windows" class="mb-20 help-block">{{ t('Uploading your photos can take some minutes Please be patient and DO NOT close this window') }}</p>
                        
                    <!-- </div> -->
                    <p align="center">
                        <button type="submit" id="image-upload-register" class="d-inline-block btn btn-success register mb-40">{{ t('save & continue') }}</button>
                    </p>
                 
                    <?php /*
                    	<!-- <div class="text-center">
                            <button type="submit" class="d-inline-block btn btn-success register mb-40">{{ t('Upload') }}</button>
                        </div> -->
                    */ ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadimageModal" class="modal crop-img-div" role="dialog" style="margin-top: inherit;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body1">
                <span class="bold f-20 lh-28 text-center px-38 pt-20">{{ t('Upload and Crop Image') }}</span>
                <?php /*
                    <!-- <h2 class="text-center prata px-38 pt-20">{{ t('Upload and Crop Image') }}</h2>  -->
                */ ?>
                <div class="position-relative">
                    <div class="divider mx-auto"></div>
                </div>
                <div class="form-group mb-10">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="clearfix">
                                <a class="rotate rotate-right pull-right"><i class="fa fa-repeat fa-lg" aria-hidden="true"></i></a>
                                <a class="rotate rotate-left pull-right"><i class="fa fa-undo fa-lg" aria-hidden="true"></i></a>
                            </div>
                            <div id="image_demo"></div>
                        </div>
                    </div>
                </div>
                <div class="text-center ">
                    <button class="btn btn-white no-bg mr-20 mb-20" data-dismiss="modal">{{ t('Cancel') }}</button>
                    <button name="create" type="button" class="btn btn-success crop_image  no-bg mb-20">{{ t('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="{{ url(config('app.cloud_url').'/assets/js/jquery/jquery-latest.js') }}"></script>
@section('page-scripts')
{{ Html::style(config('app.cloud_url').'/css/bladeCss/data-blade.css') }}


<!-- jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<!-- Latest compiled JavaScript -->
<!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<script type="text/javascript">
    var modelBookCount = '<?php echo $modelCount; ?>';
    var defaultPicture = '<?php echo url(config('app.cloud_url').'/uploads/app/default/picture.jpg'); ?>';
    var showValidFileTypes = '<?php echo t('File types: :file_types', ['file_types' => showValidFileTypes('image')]); ?>';
    var userProfileLogo = '<?php echo $user->profile->logo; ?>';
    var imageRequiredError = '<?php echo t("Photo is required"); ?>';
    var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
    var invalid_image_type = '<?php echo t("invalid_image_type"); ?>';
    var maximum_allowed_upload = '<?php echo t("exceeds maximum allowed upload size of"); ?>';
    var fileString = '<?php echo t("File"); ?>';
    var fileTypeValidationError = '<?php echo t("The profile picture must be a file of type: jpg, jpeg, gif, png"); ?>';
    var corruptedImageError = '<?php echo t("uploaded image is corrupted"); ?>';
    var user_id = '<?php echo $user->id; ?>';
    var username = "<?php echo $user->username; ?>";
    var funnelPageName = "reg_photo";
    var selectPhotoInput = '<?php echo t('select photo'); ?>';
    var k = '<?php echo $modelCount; ?>';
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/photo-blade.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
@endsection


 