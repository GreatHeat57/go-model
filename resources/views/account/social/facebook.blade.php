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
    $sedcards=$data['sedcards'];
    $user_id =$data['user_id'];
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
						<h2 class="title-2"><i class="icon-town-hall"></i> {{ t('Genrate sedcards') }} </h2>
                        <div class="mb30">
                        <a class="btn btn-default" href="{{ lurl('account/sedcards/') }}">
                                  {{ t('Back to Sedcard') }}
                        </a>
                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div id="protPreload" data-number="1" class="image_div">
								<!-- <div id="cropContainerPreload"></div> -->
								<!-- <div id="cropControls cropControlsUpload"></div> -->
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
							<?php
							$i=0;
							if (isset($sedcards) && $sedcards->count() > 0): 
								foreach($sedcards as $key => $sedcard):
									$image[$key]['url']=\Storage::url($sedcard->filename);
                                    $image[$key]['id']=$sedcard->id;
									if($i==0){
										$i=$i+1;
										continue;
									}
									
							?>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div id="otherPreload{{ $i }}" data-number="{{ $i+1 }}" class="image_div">
									</div>
							</div>
							<!-- <img src="{{ \Storage::url($sedcard->filename) }}" height="100px" width="100px"> -->
							<?php 
								$i=$i+1;
								endforeach; 
								//echo $images=json_encode($image);
							?>
							<?php endif; ?>
						</div>
						<!-- ADDED BY EXPERT TEAM -->
						<div class="genrate-sedcard">
							<p>
								<a class="btn btn-primary btn-sm" href="{{ lurl('account/sedcards/downloadsdcard/') }}/<?php echo $user_id; ?>">
								  {{ t('Download Sedcard') }}
								</a>
							</p>
						</div>
						<!-- ENDED BY EXPERT TEAM -->
						<div class="pagination-bar text-center">
							{{ (isset($sedcards)) ? $sedcards->links() : '' }}
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
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
        cropUrl: '<?php echo url('account/sedcards/cropimg/'); ?>/'+images[0]["id"],
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
            jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'none');
            console.log('onBeforeImgCrop')
        },
        onAfterImgCrop: function() {
            jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'inline-block');
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
        cropUrl: '<?php echo url('account/sedcards/cropimg/'); ?>/'+images[i]["id"],
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
            jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'none');
            jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'none');
            console.log('onBeforeImgCrop')
        },
        onAfterImgCrop: function() {
            jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'inline-block');
            jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'inline-block');
            console.log('onAfterImgCrop')
        },
        onReset: function() {
            var cropContainerPreload1 = new Croppic('otherPreload'+i, croppicContainerPreloadOptions1);
            jQuery('#otherPreload'+i).find('.cropControlRemoveCroppedImage').css('display', 'none');
        },
        onError: function(errormessage) {
            console.log('onError:' + errormessage)
        }
    }
    var cropContainerPreload= new Croppic('otherPreload'+i, croppicContainerPreloadOptions);
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
    //         jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'none');
    //         console.log('onBeforeImgCrop')
    //     },
    //     onAfterImgCrop: function() {
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'inline-block');
    //         console.log('onAfterImgCrop')
    //     },
    //     onReset: function() {
    //         var cropContainerPreload2 = new Croppic('otherPreload2', croppicContainerPreloadOptions2);
    //         jQuery('#otherPreload2').find('.cropControlRemoveCroppedImage').css('display', 'none');
    //         console.log('onReset')
    //     },
    //     onError: function(errormessage) {
    //         console.log('onError:' + errormessage)
    //     }
    // }
    // var cropContainerPreload2 = new Croppic('otherPreload2', croppicContainerPreloadOptions2);
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
    //         jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'none');
    //         console.log('onBeforeImgCrop')
    //     },
    //     onAfterImgCrop: function() {
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'inline-block');
    //         console.log('onAfterImgCrop')
    //     },
    //     onReset: function() {
    //         var cropContainerPreload3 = new Croppic('otherPreload3', croppicContainerPreloadOptions3);
    //         jQuery('#otherPreload3').find('.cropControlRemoveCroppedImage').css('display', 'none');
    //         console.log('onReset')
    //     },
    //     onError: function(errormessage) {
    //         console.log('onError:' + errormessage)
    //     }
    // }
    // var cropContainerPreload3 = new Croppic('otherPreload3', croppicContainerPreloadOptions3);
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
    //         jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'none');
    //         jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'none');
    //         console.log('onBeforeImgCrop')
    //     },
    //     onAfterImgCrop: function() {
    //         jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload1').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload2').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload3').find('.cropControlCrop').css('display', 'inline-block');
    //         jQuery('#otherPreload4').find('.cropControlCrop').css('display', 'inline-block');
    //         console.log('onAfterImgCrop')
    //     },
    //     onReset: function() {
    //         var cropContainerPreload4 = new Croppic('otherPreload4', croppicContainerPreloadOptions4);
    //         jQuery('#otherPreload4').find('.cropControlRemoveCroppedImage').css('display', 'none');
    //         console.log('onReset')
    //     },
    //     onError: function(errormessage) {
    //         console.log('onError:' + errormessage)
    //     }
    // }
    // var cropContainerPreload4 = new Croppic('otherPreload4', croppicContainerPreloadOptions4);
});
	</script>
@endsection
