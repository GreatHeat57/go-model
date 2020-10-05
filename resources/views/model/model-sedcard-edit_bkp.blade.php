@extends('layouts.logged_in.app-model')

@section('content')
<?php
// echo phpinfo();
if (isset($data)) {

    $sedcards = $data[0];
	$sedcard_5 = $data[1];
    $count = $data[2];
	$is_image = 0;
    $sedcard1 = array();
    $sedcard2 = array();
    $sedcard3 = array();
    $sedcard4 = array();
    $sedcard5 = array();
    // print_r($sedcard_5);
	foreach ($sedcard_5 as $key => $sedcard) {
		if ($sedcard['image_type'] == 1 && $sedcard['id'] != 0) {
			$sedcard1 = $sedcard;
			$is_image = 20;
		}
		if ($sedcard['image_type'] == 2 && $sedcard['id'] != 0) {
			$sedcard2 = $sedcard;
			$is_image += 20;
		}
		if ($sedcard['image_type'] == 3 && $sedcard['id'] != 0) {
			$sedcard3 = $sedcard;
			$is_image += 20;
		}
		if ($sedcard['image_type'] == 4 && $sedcard['id'] != 0) {
			$sedcard4 = $sedcard;
			$is_image += 20;
		}
		if ($sedcard['image_type'] == 5 && $sedcard['id'] != 0) {
			$sedcard5 = $sedcard;
			$is_image += 20;
		}
	}
}
?>
    <div class="container px-0 pt-40 pb-60" id="profile-image-div">
        <h1 class="text-center prata">{{ ucWords(t('Sedcard photos')) }}</h1>
        <div class="position-relative">
        <div class="divider mx-auto"></div>
            <p class="text-center w-lg-596 mx-lg-auto">&nbsp;</p>
            <div class="text-center xl-to-right-0 xl-to-top-0">
                <a href="{{ route('model-sedcard',['id' => \Auth::user()->id]) }}" class="btn btn-white insight mini-mobile mb-20">{{t('View')}}</a>
                <?php if ($count > 0) {?>
                <a href="{{ lurl('account/sedcards/genrate/') }}/<?php echo $user->id; ?>" class="btn btn-white edit_grey mini-mobile mb-20">{{ t('GenrateSedcard') }}</a>
                <a class="btn btn-white download mini-mobile mb-20" href="{{ lurl('account/'.$user->id.'/downloadsdcard') }}">
                              {{ t('Download Sedcard') }}
                            </a>
            <?php }?>
            </div>
        </div>        
        @include('childs.notification-message')
        <div class="pt-10" style="display: none;" id="warning-close-windows">
            <div class="alert alert-danger">
                <p  class="mb-20 help-block" style="color: #A94442">{{ t('Uploading your photos can take some minutes Please be patient and DO NOT close this window') }}</p>
            </div>
        </div>
       
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 mx-xl-auto">
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="px-20 px-xl-0">
                    <div class="pb-40 mb-40 bb-light-lavender3 text-center">
                        <div class="prog mb-20">
                            <div class="bar position-relative">
                                <div class="prog-bg position-absolute" style="width: {{$is_image}}%"></div>
                                <span class="number box-shadow position-absolute" style="left: calc({{$is_image}}% - 30px);">{{$is_image}}%</span>
                            </div>
                        </div>
                        <?php /*
                        <!-- <p class="f-15 lh-14 dark-grey2 mb-0">Gib einen Wert für "Lebenslauf" ein um dein Profil um 35% zu verbessern!</p> --> */ ?>
                    </div>
                </div>
<form name="sedcard" class="form-horizontal" role="form" method="POST" id="sedcard_form" action="{{ lurl('account/sedcard') }}" enctype="multipart/form-data">
{!! csrf_field() !!}
<input type="hidden" id="image_type" name="image_type" value="">
<div class="px-38 px-xl-0">
<?php

$image_path = '';
$image_exist = 1;

if (!empty($sedcard1)) {

    if ($sedcard1['cropped_image'] == "" && !empty($sedcard1['filename']) && Storage::exists($sedcard1['filename'])) {
        
         $image_path = \Storage::url($sedcard1['filename']); 
    } elseif ($sedcard1['filename'] != "" && !empty($sedcard1['cropped_image']) && Storage::exists($sedcard1['cropped_image'])){

        $image_path = \Storage::url($sedcard1['cropped_image']);
    }elseif ($sedcard1['filename'] != "" && Storage::exists($sedcard1['filename'])) {
        $image_path = \Storage::url($sedcard1['filename']);
    }else{
        $image_exist = 0;
    }
}else{
    $image_exist = 0;
}
?>

<div class="pb-40 mb-40 bb-light-lavender3 ">
    <h2 class="bold f-18 lh-18">{{ $sedcard_desc['sedcard_title_1'] }}</h2>
    <div class="divider"></div>
    <p>{!! $sedcard_desc['sedcard_description_1'] !!}</p>
    @if($image_exist)
        <div id="profile-photo-1">
            <div class="profile-photo big dm-md-inline-block position-relative d-flex align-items-center justify-content-center mb-sm-30">
                <img src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                

                 <a href="#"  data-id="{{ $image_path}}"  data-url="{{ route('show-sedcardnew',['id' => $sedcard1['id'],'user_id' => $sedcard1['user_id']]) }}" id="some-button"  class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>


                <a href="{{ lurl('account/sedcards/'.$sedcard1['id'].'/delete') }}" class="btn btn-primary trash mini-all position-absolute to-bottom-0 to-right-0" data-image-type="1" title="{{ t('Delete Photo') }}"></a>
                <?php /*
                <!-- <span class="btn save position-absolute photo-saved">{{t('Photo saved')}}</span> --> */ ?>
            </div>
        </div>
        <?php /* <!-- <img id="output-partner-logo" src="{{ $image_path }}" alt="user" width="75%">&nbsp; --> */ ?>
    @else
    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
        <div class="pt-40 px-38 px-lg-0">
            <div class="d-md-flex">
                <div id="uploaded_image1"  class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                    <img id="sedcardFilename1-output" src="{{ URL::to(config('app.cloud_url') . '/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}" >
                </div>
                <div class="d-md-inline-block">
                    
                    <?php /*
                    <div class="upload-btn-wrapper">
                        <input name="typ_id[]" type="hidden" value="1">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>

                        <input type="file" placeholder="Upload picture" name="sedcard[filename1]" id="sedcardFilename1" onchange="loadLogoFile(event)" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                    </div>
                    */ ?>

                    <div class="upload-btn-wrapper">
                        <input name="typ_id[]" type="hidden" id="sedcardFilename1-imageType" value="1">           
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}                                   
                        <input type="file"  class="upload_image" id="sedcardFilename1" name="sedcard[filename1]"  accept="image/x-png,image/jpeg,image/jpg"/></a>
                    </div>

                        <p id="sedcardFilename1-error-msg" class="w-md-440 mx-auto pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                </div>
            </div>
            <p id="sedcardFilename1-error" class="pt-20 upload-error"></p>
        </div>
    </div>
    @endif
</div>

<?php

$image_path = '';
$image_exist = 1;

if (!empty($sedcard2)) {
    if ($sedcard2['cropped_image'] == "" && !empty($sedcard2['filename']) && Storage::exists($sedcard2['filename'])) { 
        
        $image_path = \Storage::url($sedcard2['filename']); 
    } elseif ($sedcard2['filename'] != "" && !empty($sedcard2['cropped_image']) && Storage::exists($sedcard2['cropped_image'])) { 

       $image_path = \Storage::url($sedcard2['cropped_image']);
    } elseif ($sedcard2['filename'] != "" && Storage::exists($sedcard2['filename'])) {
        $image_path = \Storage::url($sedcard2['filename']);
    } else{
        $image_exist = 0;
    }
}else{
    $image_exist = 0;
}
?>
<div class="pb-40 mb-40 bb-light-lavender3 ">
    <h2 class="bold f-18 lh-18">{{ $sedcard_desc['sedcard_title_2'] }}</h2>
    <div class="divider"></div>
    <p>{!! $sedcard_desc['sedcard_description_2'] !!}</p>
    @if($image_exist)
        <div id="profile-photo-2">
            <div class="profile-photo big dm-md-inline-block position-relative d-flex align-items-center justify-content-center mb-sm-30">
                <img srcset="{{ $image_path }},
                     {{ $image_path }} 2x,
                     {{ $image_path }} 3x"
                     src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                

                <a  data-id='{{ $image_path}}' data-url="{{ route('show-sedcardnew',['id' => $sedcard2['id'],'user_id' => $sedcard2['user_id']]) }}"  id="some-button"  class=" some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                <a href="{{ lurl('account/sedcards/'.$sedcard2['id'].'/delete') }}" class="btn btn-primary trash mini-all position-absolute to-bottom-0 to-right-0" data-image-type="2" title="{{ t('Delete Photo') }}"></a>
            </div>
        </div>
    @else
    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
        <div class="pt-40 px-38 px-lg-0">
            <div class="d-md-flex">
                <div id="uploaded_image2" class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                    <img id="sedcardFilename2-output" src="{{ URL::to(config('app.cloud_url') . '/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}" >
                </div>
                <div class="d-md-inline-block">
                    
                    <?php /*
                    <div class="upload-btn-wrapper">
                        <input name="typ_id[]" type="hidden" value="2">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>

                        <input type="file" placeholder="Upload picture" name="sedcard[filename2]" id="sedcardFilename2" onchange="loadLogoFile(event)" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                    </div>
                    */ ?>

                    <div class="upload-btn-wrapper">
                        
                        <input name="typ_id[]" type="hidden" id="sedcardFilename2-imageType" value="2">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}
                            <input type="file" class="upload_image" placeholder="Upload picture" name="sedcard[filename2]" id="sedcardFilename2" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                        </a>
                    </div>

                        <p id="sedcardFilename2-error-msg" class="w-md-440 mx-auto pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                </div>
            </div>
            <p id="sedcardFilename2-error" class="pt-20 upload-error"></p>
        </div>
    </div>
    @endif
</div>
<?php

$image_path = '';
$image_exist = 1;

if (!empty($sedcard3)) {
    if ($sedcard3['cropped_image'] == "" && !empty($sedcard3['filename']) && Storage::exists($sedcard3['filename'])) { 
        
        $image_path = \Storage::url($sedcard3['filename']); 
    } elseif ($sedcard3['filename'] != "" && !empty($sedcard3['cropped_image']) && Storage::exists($sedcard3['cropped_image'])) { 

       $image_path = \Storage::url($sedcard3['cropped_image']);
    } elseif ($sedcard3['filename'] != "" && Storage::exists($sedcard3['filename'])) {
        $image_path = \Storage::url($sedcard3['filename']);
    } else{
        $image_exist = 0;
    }
}else{
    $image_exist = 0;
}
?>
<div class="pb-40 mb-40 bb-light-lavender3 ">
    <h2 class="bold f-18 lh-18 fff">{{ $sedcard_desc['sedcard_title_3'] }}</h2>
    <div class="divider"></div>
    <p>{!! $sedcard_desc['sedcard_description_3'] !!}</p>
    @if($image_exist)
        <div id="profile-photo-3">
            <div class="profile-photo big dm-md-inline-block position-relative d-flex align-items-center justify-content-center mb-sm-30">
                <img srcset="{{ $image_path }},
                     {{ $image_path }} 2x,
                     {{ $image_path }} 3x"
                     src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                <a data-id='{{ $image_path}}' data-url="{{ route('show-sedcardnew',['id' => $sedcard3['id'],'user_id' => $sedcard3['user_id']]) }}" id="some-button"  class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                
                <a href="{{ lurl('account/sedcards/'.$sedcard3['id'].'/delete') }}" class="btn btn-primary trash mini-all position-absolute to-bottom-0 to-right-0" data-image-type="3" title="{{ t('Delete Photo') }}"></a>
            </div>
        </div>
    @else
    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
        <div class="pt-40 px-38 px-lg-0">
            <div class="d-md-flex">
                <div id="uploaded_image3" class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                    <img id="sedcardFilename3-output" src="{{ URL::to(config('app.cloud_url') . '/uploads/app/default/picture.jpg') }}" alt="Go Models" >
                </div>
                <div class="d-md-inline-block">
                    <?php /*
                    <div class="upload-btn-wrapper">
                        <input name="typ_id[]" type="hidden" value="3">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>

                        <input type="file" placeholder="Upload picture" name="sedcard[filename3]" id="sedcardFilename3" onchange="loadLogoFile(event)" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                    </div>
                    */ ?>

                    <div class="upload-btn-wrapper">
                        
                        <input name="typ_id[]" type="hidden" id="sedcardFilename3-imageType" value="3">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}

                            <input type="file" class="upload_image" placeholder="Upload picture" name="sedcard[filename3]" id="sedcardFilename3" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                        </a>
                    </div>

                        <p id="sedcardFilename3-error-msg" class="w-md-440 mx-auto pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                </div>
            </div>
            <p id="sedcardFilename3-error" class="pt-20 upload-error"></p>
        </div>
    </div>
    @endif
</div>

<?php
$image_path = '';
$image_exist = 1;

if (!empty($sedcard4)) {
    if ($sedcard4['cropped_image'] == "" && !empty($sedcard4['filename']) && Storage::exists($sedcard4['filename'])) { 
        
        $image_path = \Storage::url($sedcard4['filename']); 
    } elseif ($sedcard4['filename'] != "" && !empty($sedcard4['cropped_image']) && Storage::exists($sedcard4['cropped_image'])) { 

       $image_path = \Storage::url($sedcard4['cropped_image']);
    }elseif ($sedcard4['filename'] != "" && Storage::exists($sedcard4['filename'])) {
        $image_path = \Storage::url($sedcard4['filename']);
    }else{
        $image_exist = 0;
    }
}else{
    $image_exist = 0;
}
?>
<div class="pb-40 mb-40 bb-light-lavender3 ">
    <h2 class="bold f-18 lh-18">{{ $sedcard_desc['sedcard_title_4'] }}</h2>
    <div class="divider"></div>
    <p>{!! $sedcard_desc['sedcard_description_4'] !!}</p>
    @if($image_exist)
        <div id="profile-photo-4">
            <div class="profile-photo big dm-md-inline-block position-relative d-flex align-items-center justify-content-center mb-sm-30">
                <img srcset="{{ $image_path }},
                     {{ $image_path }} 2x,
                     {{ $image_path }} 3x"
                     src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                

                <a  data-id='{{ $image_path}}' data-url="{{ route('show-sedcardnew',['id' => $sedcard4['id'],'user_id' => $sedcard4['user_id']]) }}" id="some-button"  class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>

                <a href="{{ lurl('account/sedcards/'.$sedcard4['id'].'/delete') }}" class="btn btn-primary trash mini-all position-absolute to-bottom-0 to-right-0" data-image-type="4" title="{{ t('Delete Photo') }}"></a>
            </div>
        </div>
    @else
    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
        <div class="pt-40 px-38 px-lg-0">
            <div class="d-md-flex">
                <div id="uploaded_image4" class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                    <img id="sedcardFilename4-output" src="{{ URL::to(config('app.cloud_url') . '/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}" >
                </div>
                <div class="d-md-inline-block">
                    <?php /*
                    <div class="upload-btn-wrapper">
                        <input name="typ_id[]" type="hidden" value="4">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>

                        <input type="file" placeholder="Upload picture" name="sedcard[filename4]" id="sedcardFilename4" onchange="loadLogoFile(event)" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                    </div>
                    */ ?>

                    <div class="upload-btn-wrapper">
                        
                        <input name="typ_id[]" type="hidden" id="sedcardFilename4-imageType" value="4">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}

                            <input type="file" class="upload_image" placeholder="Upload picture" name="sedcard[filename4]" id="sedcardFilename4" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                        </a>
                    </div>

                        <p id="sedcardFilename4-error-msg" class="w-md-440 mx-auto pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                </div>
            </div>
            <p id="sedcardFilename4-error" class="pt-20 upload-error"></p>
        </div>
    </div>
    @endif
</div>

<?php

$image_path = '';
$image_exist = 1;

if (!empty($sedcard5)) {
    if ($sedcard5['cropped_image'] == "" && !empty($sedcard5['filename']) && Storage::exists($sedcard5['filename'])) { 
        
        $image_path = \Storage::url($sedcard5['filename']); 
    } elseif ($sedcard5['filename'] != "" && !empty($sedcard5['cropped_image']) && Storage::exists($sedcard5['cropped_image'])) { 

       $image_path = \Storage::url($sedcard5['cropped_image']);
    }elseif ($sedcard5['filename'] != "" && Storage::exists($sedcard5['filename'])) {
        $image_path = \Storage::url($sedcard5['filename']);
    }else{
        $image_exist = 0;
    }
}else{
    $image_exist = 0;
}
?>

<div class="pb-40 mb-40 bb-light-lavender3 ">
    <h2 class="bold f-18 lh-18">{{ $sedcard_desc['sedcard_title_5'] }}</h2>
    <div class="divider"></div>
    <p>{!! $sedcard_desc['sedcard_description_5'] !!}</p>
    @if($image_exist)
        <div id="profile-photo-5">
            <div class="profile-photo big dm-md-inline-block position-relative d-flex align-items-center justify-content-center mb-sm-30" >
                <img srcset="{{ $image_path }},
                     {{ $image_path }} 2x,
                     {{ $image_path }} 3x"
                     src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                

                <a  data-id='{{ $image_path}}' data-url="{{ route('show-sedcardnew',['id' => $sedcard5['id'],'user_id' => $sedcard5['user_id']]) }}" id="some-button"  class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>

                <a href="{{ lurl('account/sedcards/'.$sedcard5['id'].'/delete') }}" class="btn btn-primary trash mini-all position-absolute to-bottom-0 to-right-0" data-image-type="5" title="{{ t('Delete Photo') }}"></a>
            </div>
        </div>
    @else
    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
        <div class="pt-40 px-38 px-lg-0">
            <div class="d-md-flex">
                <div id="uploaded_image5" class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                    <img id="sedcardFilename5-output" src="{{ URL::to(config('app.cloud_url') . '/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}" >
                </div>
                <div class="d-md-inline-block">
                    <?php /*
                    <div class="upload-btn-wrapper">
                        <input name="typ_id[]" type="hidden" value="4">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>

                        <input type="file" placeholder="Upload picture" name="sedcard[filename5]" id="sedcardFilename5" onchange="loadLogoFile(event)" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                    </div>
                    */ ?>

                    <div class="upload-btn-wrapper">
                        
                        <input name="typ_id[]" type="hidden" id="sedcardFilename5-imageType" value="5">
                        <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}

                            <input type="file" class="upload_image" placeholder="Upload picture" name="sedcard[filename5]" id="sedcardFilename5" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                        </a>
                    </div>
                        <p id="sedcardFilename5-error-msg" class="w-md-440 mx-auto pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                </div>
            </div>
            <p id="sedcardFilename5-error" class="pt-20 upload-error"></p>
        </div>
    </div>
    @endif
</div>

</div>
<?php /* @include('childs.bottom-bar-save') */ ?>
</form>
 
            </div>
        </div>
    </div>

    <div id="uploadimageModal" class="modal crop-img-div" role="dialog" style="margin-top: inherit;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body1">
                <span class="bold f-20 lh-28 text-center px-38 pt-20">{{ t('Upload and Crop Image') }}</span>
                <!-- <h2 class="text-center prata px-38 pt-20">{{ t('Upload and Crop Image') }}</h2> -->
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
                <div class="text-center">
                    <button class="btn btn-white no-bg mb-20 mr-20" data-dismiss="modal">{{ t('Cancel') }}</button>
                    <button name="create" type="button" class="btn btn-success crop_image  no-bg mb-20">{{ t('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
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
    .photo-saved { cursor: default !important; }

    .rotate {
        padding: 5px;
    }

    #image_demo {
        width: 300px;
        padding: 0 !important;
    }

    .croppie-container .cr-slider-wrap {
        width: 100%;        
    }

    .modal-body1 {
        padding-left: 100px;
        padding-right: 100px;
    }

   /* .modal-dialog {
        width: 500px;
        margin: 1rem auto;
    }*/
    
    @media (max-width: 576px) {
        .modal-dialog {
            width: 360px;
            margin: 0.5rem auto;
        }
        .modal-body1 {
            padding-left: 30px;
            padding-right: 30px;
        }
        #image_demo {
            width: 300px;
        }
    }

    @media (max-width: 360px) {
        .modal-dialog {
            width: 310px;
            margin: 0.5rem auto;
        }
        #image_demo {
            width: 250px;
        }
        .btn.no-bg {
            padding: 0 24px !important;
        }
    }
</style>
<link href="{{ url(config('app.cloud_url') . '/assets/css/magnific-popup.css') }}" rel="stylesheet">
<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
@if (config('lang.direction') == 'rtl')
    <link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
@endif
<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
@endif
<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}"></script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/mfp-zoom-slider-popup.js') }}

<!-- <script type="text/javascript">
    $(document).ready( function(){

    var magnificPopup = $.magnificPopup.instance;
    
    $('.some-button').click( function(e){
        //alert();
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
                        /*image: {
                            verticalFit: true
                        },
                         /*zoom: {  
                                    enabled: true,
                                    duration: 100 
                                }*/
                            });

                    magnificpopup.ev.off('mfpBeforeChange.ajax');
                }

            }, error: function (a, b, c) {
                console.log('error');
            }
        });
    });
});
</script> -->
<script type="text/javascript">

    // this code comment by : Aj 16/10/2019 (on submit form)
    /*
    $('#sedcard_form').submit(function(event) { 
        var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
        
        var status = true;

        for (var i = 1; i <= 5 ; i++) { 

            var ele = document.getElementById('sedcardFilename'+i);

            if(ele != null){
                if(parseInt(ele.files.length) > 0){

                    var imageType = ele.files[0].type.toLowerCase();
                    var imageSize = ele.files[0].size;
                    var fileSize = Math.round((imageSize / 1024));
                    var extension = imageType.split('/');

                    //check image extension  
                    if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {
                            
                        $('#sedcardFilename'+i+'-error').html('{{ t("sedcard_valid_image") }} ').css("color", "red");
                        status = false;
                    }
                    if(fileSize > maxUploadImageSize){
                      //$('#sedcardFilename'+i+'-error-msg').css({'color': 'red'});

                       $('#sedcardFilename'+i+'-error-msg').html('{{ t("File") }} "'+ele.files[0].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");

                        status = false;
                    }else{
                        $('#sedcardFilename'+i+'-error-msg').html("{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}").css({'color': 'black'});
                    }
                }
            }
        }
        $("#warning-close-windows").show();
        $('html,body').animate({ scrollTop:  $("#profile-image-div").offset().top }, 'slow', function () {//alert("reached top");    
        });
        $('.save').prop('disabled', true);        
        $(".loading-process").show();
        return status;
    });
    
    var loadLogoFile = function(event) {  

        var input_id = event.target.id;
        $('#'+input_id+'-error').html('');

        var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

        if(parseInt(event.target.files.length) > 0) {
            var fileSize = Math.round((event.target.files[0].size / 1024));

            var filename = event.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById(input_id+'-output');
              output.src = reader.result;
            };
            
            reader.readAsDataURL(event.target.files[0]);

            // if(fileSize > imageSize){
            //     $('#'+input_id+'-error-msg').css({'color': 'red'});
            //     return false;
            // }else{
            //     $('#'+input_id+'-error-msg').css({'color': 'black'});
            // }
        }
    };

    */


    $('.trash').on('click',function(e){
        
        e.stopPropagation();
        e.preventDefault();

        var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");

        if(confirmation == false){
            return false;
        }

        var instruction = '{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}';
        var image_type = $(this).attr('data-image-type');
        var form_url = $(this).attr('href');

        $.ajax({
            method: "GET",
            url: form_url,
            data: new FormData($('#sedcard_form')[0]),
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            beforeSend: function(){
            $(".loading-process").show();
            },
            complete: function(){
                $(".loading-process").hide();
            },
            success: function (data) { 
                var upload_html =   '<div class="w-lg-750 w-xl-970 mx-auto upload-zone">'+
                                        '<div class="pt-40 px-38 px-lg-0">'+
                                            '<div class="d-md-flex">'+
                                                '<div id="uploaded_image'+image_type+'" class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">'+
                                                        '<img id="sedcardFilename'+image_type+'-output" src="{{ URL::to("uploads/app/default/picture.jpg") }}" alt="Go Models" >'+
                                                '</div>'+
                                                '<div class="d-md-inline-block">'+
                                                    '<div class="upload-btn-wrapper">'+
                                                        '<input id="sedcardFilename'+image_type+'-imageType" name="typ_id[]" type="hidden" value="'+ image_type +'">'+
                                                        '<a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}'+
                                                        '<input class="upload_image" type="file" placeholder="Upload picture" name="sedcard[filename'+ image_type +']" id="sedcardFilename'+ image_type +'" accept="image/x-png,image/gif,image/jpeg,image/jpg"></a>'+
                                                    '</div>'+
                                                        '<p id="sedcardFilename'+image_type+'-error-msg" class="w-md-440 mx-auto pt-20">'+instruction+'</p>'+
                                                '</div>'+
                                            '</div>'+
                                            '<p id="sedcardFilename'+image_type+'-error" class="pt-20 upload-error"></p>'+
                                        '</div>'+
                                    '<div>';                         
                $("#profile-photo-"+image_type).html(upload_html);
                $('.upload_image').bind("change");
                // applyFilePreview();
            }, error: function (a, b, c) {
                console.log('error');
            }
        });
    });

    /*
    applyFilePreview();

    function applyFilePreview(){
        
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
            maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
            fileActionSettings:{
                showZoom: false,
            }
        });
    }
    */


// start crop image functionalities
$(document).ready(function(){

    var viewportWidth = 300;
    var viewport = $(window).width();

    if (viewport < 361) {
        viewportWidth = 250;
    }

    // sedcard picture input reset after upload image or close popup
    $('#uploadimageModal').on('hide.bs.modal', function(){
        
        $("#image_type").val('');
        if ($('.upload_image').length > 0) {
            $('.upload_image').val("");
        }
        scrollLock.enablePageScroll(document.getElementById('uploadimageModal'));
    });

    var opts = {
            viewport: { 
                width: 208, 
                height: 260
            },
            boundary: {
                width: viewportWidth,
                height: 300
            },
            enableOrientation: true
        };
    var image_crop = new Croppie(document.getElementById('image_demo'), opts)

    // default profile picture extention
    var imageExtension = 'png';

    // change event sedcard image input
    $(document).on('change', '.upload_image', function() {
        
        $('.upload-error').html('');
        // get curent selected image
        var sedcardImage = document.getElementById(this.id);
        var elementById = this.id;
        var sedcardImageTypeId = $("#"+elementById+'-imageType').val()
        var errorId = $('#'+elementById+'-error');

        // get maxupload image size
        var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

        // sedcard image validate
        if(sedcardImage.files.length > 0) { 
            var sedcardImageType = sedcardImage.files[0].type.toLowerCase();
            var sedImageSize = sedcardImage.files[0].size;
            var sedcardFileSize = Math.round((sedImageSize / 1024));
            var sedcardImageExtension = sedcardImageType.split('/');

            //check image extension  
            if($.inArray(sedcardImageExtension[1], ['gif','png','jpg','jpeg']) == -1) {
                $(errorId).html('{{ t("sedcard_valid_image") }} ').css("color", "red");
                return false;   
            }

            // file size check
            if(sedcardFileSize > maxUploadImageSize){
                $(errorId).html('{{ t("File") }} "'+sedcardImage.files[0].name+'" ('+sedcardFileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");
                return false;
            }
        }
            
        var reader = new FileReader();
        reader.onload = function (event) {
        image_crop.bind({
            url: event.target.result
          }).then(function(){
            // console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);

        // get image type string
        imageExtension = this.files[0].type.toLowerCase();

        // split image type string to array
        imageExtensionArr = imageExtension.split('/');

        // image type
        imageExtension = imageExtensionArr[1];

        $("#image_type").val(sedcardImageTypeId);
        // open model image croping
        $('#uploadimageModal').modal('show');
        scrollLock.disablePageScroll(document.getElementById('uploadimageModal'));
    });


    $('.rotate').click(function(event){
        var degree = 90;
        if($(this).hasClass("rotate-right")) {
            degree = -90;
        }
        image_crop.rotate(degree);
    });

    // crop image save
    $('.crop_image').click(function(event){

        event.preventDefault();
        //var img_width = 580;
        //var img_height = 665;

        // if($('#image_type').val() == 1){
            
        //     img_width = 580;
        //     img_height = 665;
        // }

        
        // var img_width = 450;
        // var img_height = 562;

        var img_width = 960;
        var img_height = 1200;

        // if($('#image_type').val() == 1){
        //     img_width = 960;
        //     img_height = 1200;
        // }

        image_crop.result({
          type: 'canvas',
          // size: 'viewport',
          size : 'original',
          format : imageExtension,
        }).then(function(response){
          
            $.ajax({
            
                url: '<?php echo lurl('/'); ?>' + "/cropSedcardImage",
                type: "POST",
                data:{"image": response, 'image_type': $('#image_type').val()},
                beforeSend: function(){
                    $(".loading-process").show();
                },
                complete: function(){
                    $(".loading-process").hide();
                },
                success:function(data){ 
                    
                    $('#uploadimageModal').modal('hide');
                    $(data.viewImageDivId).html(data.html);
                    
                    if(data.success == true){

                        // $("#error-profile-logo").hide();
                        // $("#success-profile-logo").show();
                        // $("#success-profile-logo").html(data.message).css("color", "green");;
                    }else{

                        // $("#success-profile-logo").hide();
                        // $("#error-profile-logo").show();
                        $(data.errorElementId).html(data.error).css("color", "red");;
                    }
                }
            });
        })
    });
}); 
// End crop image functionalities 

</script>
@endsection

