@extends('layouts.logged_in.app-partner')

@section('content')
    @include('common.spacer')

    <?php 
        $album = $data['album'];
        $user_id = $data['user_id'];
        $image = array();

        // if (isset($album) && $album->count() > 0) {
        // 	foreach ($album as $key => $albums) {
        // 		$image[$key]['url'] = \Storage::url('/album/' . $albums->filename);
        // 		$image[$key]['id'] = $albums->id;
        // 		$image[$key]['cropped_image'] = ($albums->cropped_image) ? $albums->cropped_image : '';
        // 	}
        // }
    ?>
    <div class="container pt-40 px-0 ">
        <div class="row">
            <div class="w-xl-1220 mx-auto">
                @include('childs.notification-message')
            </div>
            <div class="col-sm-12 page-content mb-30">
                <h1 class="text-center prata">{{ ucWords(t('Photo portfolio')) }}</h1>
                <div class="position-relative">
                    <div class="divider mx-auto"></div>
                    <p class="text-center mb-30 w-lg-596 mx-lg-auto notes-zone">{{ t("Now you can customize your pictures, When you're done, please click on the green icon for each image")}}</p>
                    <div class="text-center mb-30 ">
                        <?php $attr = ['countryCode' => config('country.icode')];?>
                        <a href="{{ lurl(trans('routes.account-album', $attr), $attr) }}" class="btn btn-default arrow_left mini-mobile">{{ t('Back to Album') }}</a>
                    </div>
                </div>

                

                <?php
                    $i = 0;
                    if(isset($album) && $album->count() > 0){
                ?>
                   <!--  <div class="box-shadow bg-white row border-bottom pb-4 mx-xl-auto mb-30">
                        <div class="col-md-12 pt-20">
                            <div id="cropContainerPreload"></div>
                        </div>
                    </div> -->
                    <div class="inner-box box-shadow bg-white model-back-book">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-none">
                        <?php foreach ($album as $key => $albums) { 
                            $image[$key]['url'] = \Storage::url($albums->filename);
                            $image[$key]['id'] = $albums->id;
                        ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 modelbookdiv padding-none">
                                <div id="otherPreloadModel{{ $i }}" class="crop-images"></div>
                            </div>
                        <?php 
                            $i = $i + 1;
                        } 
                        ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                        <h5 class="prata">{{ t('Images not found') }}</h5>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
     @include('childs.bottom-bar')
@endsection


<style type="text/css">
    @media (max-width: 425px){
        .inner-box{
            padding: 0px !important;
        }
    }
    .model-back-book .modelbookdiv:first-child{
      margin-top: 85px !important;
    }


    #cropContainerPreload,#otherPreloadModel0,#otherPreloadModel1,#otherPreloadModel2,#otherPreloadModel3,#otherPreloadModel4,#otherPreloadModel5,#otherPreloadModel6,#otherPreloadModel7,#otherPreloadModel8,#otherPreloadModel9,#otherPreloadModel10,#otherPreloadModel11,#otherPreloadModel12,#otherPreloadModel13,#otherPreloadModel14,#otherPreloadModel15,#otherPreloadModel16,#otherPreloadModel17,#otherPreloadModel18,#otherPreloadModel19,#otherPreloadModel20,#otherPreloadModel21,#otherPreloadModel22,#otherPreloadModel23,#otherPreloadModel24,#otherPreloadModel25,#otherPreloadModel26,#otherPreloadModel27,#otherPreloadModel28,#otherPreloadModel29,#otherPreloadModel30 {
            width: 466px;
            height: 579px;
            position: relative;
            border: 1px solid #ccc;
            margin: 0 auto;
    }
    

</style>

@section('after_scripts')
<link href="{{ url(config('app.cloud_url').'/assets/css/croppic.css')}}" rel="stylesheet">
<script src="{{ url(config('app.cloud_url').'/assets/js/croppic.js') }}"></script>

    <script type="text/javascript">

        jQuery.noConflict()(function(jQuery){

            var image_edit_called = "no";
            var images = <?php echo json_encode($image); ?>;
            
            // var croppicContainerPreloadOptions = {
            //     cropUrl: '<?php // echo url('account/album/cropimg/'); ?>/'+images[0]["id"],
            //     loadPicture: images[0]['url'],
            //     enableMousescroll: true,
            //     loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            //     onBeforeImgUpload: function() {
            //         console.log('onBeforeImgUpload')
            //     },
            //     onAfterImgUpload: function() {
            //         console.log('onAfterImgUpload')
            //     },
            //     onImgDrag: function() {
            //         console.log('onImgDrag')
            //     },
            //     onImgZoom: function() {
            //         console.log('onImgZoom')
            //     },
            //     onBeforeImgCrop: function() {
            //         jQuery('#cropContainerPreload').find('.cropControlCrop').unbind('click');
            //         console.log('onBeforeImgCrop')
            //     },
            //     onAfterImgCrop: function() {
            //         jQuery('#cropContainerPreload').find('.cropControlCrop').css('display', 'inline-block');
            //         console.log('onAfterImgCrop')
            //     },
            //     onReset: function() {
            //         console.log('onReset')
            //     },
            //     onError: function(errormessage) {
            //         console.log('onError:' + errormessage)
            //     }
            // };

            // var cropContainerPreload = new Croppic('cropContainerPreload', croppicContainerPreloadOptions);
            
        
        for(var i=0; i<=images.length; i++){

            var croppicContainerPreloadOptions = {
                cropUrl: '<?php echo url('account/album/cropimg/'); ?>/'+images[i]["id"],
                loadPicture: images[i]['url'],
                enableMousescroll: true,
                loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
                onBeforeImgUpload: function() {
                    console.log('onBeforeImgUpload')
                },
                onAfterImgUpload: function() {
                    console.log('onAfterImgUpload')
                },
                onImgDrag: function() {
                    console.log('onImgDrag')
                },
                onImgZoom: function() {
                    console.log('onImgZoom')
                },
                onBeforeImgCrop: function() {
                    jQuery('#cropContainerPreload').find('.cropControlCrop').css('display', 'none');
                    console.log('onBeforeImgCrop')
                },
                onAfterImgCrop: function() {
                    jQuery('#cropContainerPreload').find('.cropControlCrop').css('display', 'inline-block');
                    console.log('onAfterImgCrop')
                },
                onReset: function() {
                    console.log('onReset')
                },
                onError: function(errormessage) {
                    console.log('onError:' + errormessage)
                }
            };

            var cropContainerPreload = new Croppic('otherPreloadModel'+i, croppicContainerPreloadOptions);
        }
        });



    </script>
@endsection