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
     <?php 
    $modelbook=$data['modelbook'];
    $user_id =$data['user_id'];
    //$image="";
    //print_r($modelbook);
    ?>
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
				<div class="col-sm-12 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-town-hall"></i> {{ t('Genrate Model Book') }} </h2>
                        <div class="mb30">
                        <a class="btn btn-default" href="{{ lurl('account/model-book/') }}">
                                  {{ t('Back to Modelbook') }}
                        </a>
                        </div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 modelbookdiv">
							<div id="protPreload" data-number="1" class="image_div mainmodelbook" >
								<!-- <div id="cropContainerPreload"></div> -->
								<!-- <div id="cropControls cropControlsUpload"></div> -->
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
							<?php
							$i=0;
							if (isset($modelbook) && $modelbook->count() > 0): 
								foreach($modelbook as $key => $modelbooks):
									$image[$key]['url']=\Storage::url($modelbooks->filename);
                                    $image[$key]['id']=$modelbooks->id;
									if($i==0){
										$i=$i+1;
										continue;
									}
									
							?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 modelbookdiv">
									<div id="otherPreloadModel{{ $i }}" data-number="{{ $i+1 }}" class="image_div">
									</div>
							</div>
							<?php 
								$i=$i+1;
								endforeach; 
								//echo $images=json_encode($image);
							?>
							<?php endif; ?>
						</div>
                        <?php if($modelbook->count() > 0) { ?>
						<!-- ADDED BY EXPERT TEAM -->
						<div class="genrate-sedcard">
							<p>
								<a class="btn btn-primary btn-sm" href="{{ lurl('account/'.$user_id.'/downloadmbook') }}">
								  {{ t('Download Modelbook') }}
								</a>
							</p>
						</div>
                        <?php } ?>
						<!-- ENDED BY EXPERT TEAM -->
						<div class="pagination-bar text-center">
							{{ (isset($modelbook)) ? $modelbook->links() : '' }}
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});
			
			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});
			
			$('#checkAll').click(function () {
				checkAll(this);
			});
			
			$('a.delete-action, button.delete-action').click(function(e)
			{
				e.preventDefault(); /* prevents the submit or reload */
				var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");
				
				if (confirmation) {
					if( $(this).is('a') ){
						var url = $(this).attr('href');
						if (url !== 'undefined') {
							redirect(url);
						}
					} else {
						$('form[name=listForm]').submit();
					}
					
				}
				
				return false;
			});
		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}


	</script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
    var image_edit_called = "no";
    var images=<?php echo json_encode($image); ?>;
    //console.log(images);
    var croppicContainerPreloadOptions = {
        // uploadUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=image_upload_in_folder',
        //cropUrl:  "{{ lurl('account/sedcards/cropimg/') }}",
        cropUrl: '<?php echo url('account/model-book/cropimg/'); ?>/'+images[0]["id"],
        loadPicture: images[0]['url'],
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
            jQuery('#protPreload').find('.cropControlCrop').unbind('click');
            jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'none');
            console.log('onBeforeImgCrop')
        },
        onAfterImgCrop: function() {
            jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'inline-block');
            console.log('onAfterImgCrop')
        },
        onReset: function() {
            console.log('onReset')
        },
        onError: function(errormessage) {
            console.log('onError:' + errormessage)
        }
    }
    var cropContainerPreload = new Croppic('protPreload', croppicContainerPreloadOptions);

    for(var i=1;i<images.length;i++){
        var croppicContainerPreloadOptions = {
        // uploadUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=image_upload_in_folder',
        cropUrl: '<?php echo url('account/model-book/cropimg/'); ?>/'+images[i]["id"],
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
            jQuery('#protPreload').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'none');
            console.log('onBeforeImgCrop')
        },
        onAfterImgCrop: function() {
            jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'inline-block');
            console.log('onAfterImgCrop')
        },
        onReset: function() {
            var cropContainerPreload1 = new Croppic('otherPreloadModel'+i, croppicContainerPreloadOptions1);
            jQuery('#otherPreloadModel'+i).find('.cropControlRemoveCroppedImage').css('display', 'none');
        },
        onError: function(errormessage) {
            console.log('onError:' + errormessage)
        }
    }
    var cropContainerPreload= new Croppic('otherPreloadModel'+i, croppicContainerPreloadOptions);
    }
    
    // var croppicContainerPreloadOptions2 = {
    //     uploadUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=image_upload_in_folder',
    //     cropUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=crop_image_upload_in_folder',
    //     loadPicture: 'https://go-models.com/wp-content/uploads/2018/04/IMG_8238_Facetune_01-01-2018-14-36-36-1.jpg',
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
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'none');
    //         console.log('onBeforeImgCrop')
    //     },
    //     onAfterImgCrop: function() {
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'inline-block');
    //         console.log('onAfterImgCrop')
    //     },
    //     onReset: function() {
    //         var cropContainerPreload2 = new Croppic('otherPreloadModel2', croppicContainerPreloadOptions2);
    //         jQuery('#otherPreloadModel2').find('.cropControlRemoveCroppedImage').css('display', 'none');
    //         console.log('onReset')
    //     },
    //     onError: function(errormessage) {
    //         console.log('onError:' + errormessage)
    //     }
    // }
    // var cropContainerPreload2 = new Croppic('otherPreloadModel2', croppicContainerPreloadOptions2);
    // var croppicContainerPreloadOptions3 = {
    //     uploadUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=image_upload_in_folder',
    //     cropUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=crop_image_upload_in_folder',
    //     loadPicture: 'https://go-models.com/wp-content/uploads/2018/04/IMG_0235.jpg',
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
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'none');
    //         console.log('onBeforeImgCrop')
    //     },
    //     onAfterImgCrop: function() {
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'inline-block');
    //         console.log('onAfterImgCrop')
    //     },
    //     onReset: function() {
    //         var cropContainerPreload3 = new Croppic('otherPreloadModel3', croppicContainerPreloadOptions3);
    //         jQuery('#otherPreloadModel3').find('.cropControlRemoveCroppedImage').css('display', 'none');
    //         console.log('onReset')
    //     },
    //     onError: function(errormessage) {
    //         console.log('onError:' + errormessage)
    //     }
    // }
    // var cropContainerPreload3 = new Croppic('otherPreloadModel3', croppicContainerPreloadOptions3);
    // var croppicContainerPreloadOptions4 = {
    //     uploadUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=image_upload_in_folder',
    //     cropUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=crop_image_upload_in_folder',
    //     loadPicture: 'https://go-models.com/wp-content/uploads/2018/04/IMG_0209.jpg',
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
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'none');
    //         console.log('onBeforeImgCrop')
    //     },
    //     onAfterImgCrop: function() {
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'inline-block');
    //         console.log('onAfterImgCrop')
    //     },
    //     onReset: function() {
    //         var cropContainerPreload4 = new Croppic('otherPreloadModel4', croppicContainerPreloadOptions4);
    //         jQuery('#otherPreloadModel4').find('.cropControlRemoveCroppedImage').css('display', 'none');
    //         console.log('onReset')
    //     },
    //     onError: function(errormessage) {
    //         console.log('onError:' + errormessage)
    //     }
    // }
    // var cropContainerPreload4 = new Croppic('otherPreloadModel4', croppicContainerPreloadOptions4);
});
	</script>
@endsection