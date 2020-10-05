@extends('layouts.logged_in.app-model')

@section('content')
	@include('common.spacer')
    <?php
$sedcards = $data['sedcards'];
$user_id = $data['user_id'];
?>

<style type="text/css">
	
	@media (min-width: 320px) and (max-width: 480px) { 
       
		.inner-img {
        	padding-right: 0px !important;
    		padding-left: 0px !important;
        }

        .inner-img .cropImgWrapper{
        	width: 434px !important;
    		height: 542px !important;
        }

        .inner-img .cropImgWrapper img{
        	width: 434px !important;
    		height: 542px !important;
        }

 		img.croppedImg {
        	width: 100% !important;
        }
        .image_div {
        	width: 100% !important;
        }

        #protPreload .cropImgWrapper{
        	width: auto !important;
        }

       /* #protPreload {
    	    width: 466px !important;
        }*/
	}

    @media (min-width: 768px) and (max-width: 1024px) {

    	.inner-img {
        	padding-right: 0px !important;
    		padding-left: 0px !important;
        }

        .inner-img .cropImgWrapper{
        	width: 434px !important;
    		height: 542px !important;
        }

        .inner-img .cropImgWrapper img{
        	width: 434px !important;
    		height: 542px !important;
        }

        img.croppedImg {
        	width: 100% !important;
        }

        .image_div {
        	width: 100% !important;
        }

        #protPreload .cropImgWrapper{
        	width: auto !important;
        }

       /* #protPreload {
    	    width: 466px !important;
        }*/
	}
</style>

<div class="container pt-40 px-0">
		<h1 class="text-center prata"> {{ ucWords(t('Genrate sedcards')) }}</h1>
        <div class="position-relative">
            <div class="divider mx-auto"></div>
			<p class="text-center mb-30 mx-lg-auto notes-zone">{{ t('Sedcard subtitle') }}</p>
            <div class="text-center mb-30 xl-to-right-0 xl-to-top-0">
            	<a class="btn btn-white arrow_left" href="{{ lurl(trans('routes.model-sedcard-edit')) }}">
		          {{ t('Back to Sedcard') }}
		        </a>
            </div>
        </div>
	    @include('childs.notification-message')
	<div class="row">
		<div class="col-sm-12 page-content mb-30">
				<?php $image = array(); $i = 0;
				if (isset($sedcards) && $sedcards->count() > 0) { ?>
					<div class="inner-box box-shadow bg-white" id="sedcard-div">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 overflow-hidden mb-4 pl-0">
							<div id="protPreload" data-number="1" class="image_div"></div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 overflow-hidden inner-img">

							<?php 
							foreach ($sedcards as $key => $sedcard) {
								
								if(\Storage::exists($sedcard->filename)){
								
									$image[$key]['url'] = \Storage::url($sedcard->filename);
									$image[$key]['id'] = $sedcard->id;

									if ($i == 0) { $i = $i + 1; continue; } ?>
								
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 overflow-hidden mb-4 inner-img">
											<div id="otherPreload{{ $i }}" data-number="{{ $i+1 }}" class="image_div"></div>
										</div>
										<?php $i = $i + 1; 
									}
								} ?>
								
						</div>
						<div class="pagination-bar text-center">
							{{ (isset($sedcards)) ? $sedcards->links() : '' }}
						</div>
					</div>
					<?php 
				} ?>

				@if (isset($sedcards) && $sedcards->count() == 0)
			        <div class="text-center bg-white box-shadow position-relative mx-xl-auto pt-20 pr-20 pb-20 pl-20 mb-20">
			            <h5 class="prata">{{ t('No records found') }}</h5>
			        </div>
		        @endif

		        <div class="text-center bg-white box-shadow position-relative mx-xl-auto pt-20 pr-20 pb-20 pl-20 mb-20" id="no_records" style="display: none;">
		            <h5 class="prata">{{ t('No records found') }}</h5>
		        </div>
				
				<?php if (isset($sedcards) && $sedcards->count() > 0) {?>
					<div class="genrate-sedcard">
						<p>
							<a class="btn btn-white download btn-sm mb-30" href="{{ lurl('account/'.$user_id.'/downloadsdcard') }}">
							  {{ t('Download Sedcard') }}
							</a>
						</p>
					</div>
				<?php } ?>
		</div>

	</div>
</div>
@endsection
@section('page-script')
    <style type="text/css">
       .inner-box {
         padding: 20px 5px 20px 12px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/js/croppic.js') }}"></script>
    <link href="{{ url(config('app.cloud_url').'/assets/css/croppic.css')}}" rel="stylesheet">
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

			$('a.delete-action, button.delete-action').click(function(e){
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
@if( isset($sedcards) && $sedcards->count() > 0 )
	<script type="text/javascript">
		jQuery(document).ready(function() {
	    var image_edit_called = "no";
	    var images=<?php echo json_encode($image); ?>;

	    console.log(images);
	    // check image langth && not empty
	    if (images.length === 0){
	    	$('#sedcard-div').hide();
	    	$('#no_records').show();
	    	return false;
	    }

	    var croppicContainerPreloadOptions = {
	        // uploadUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=image_upload_in_folder',
	        //cropUrl:  "{{ lurl('account/sedcards/cropimg/') }}",
	        cropUrl: '<?php echo url('account/sedcards/cropimg/'); ?>/'+images[0]["id"],
	        loadPicture: images[0]['url'],
	        enableMousescroll: true,
	        zoomFactor:1,
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

			if(images.length > 0){
				for(var i=1;i<images.length;i++){
			        var croppicContainerPreloadOptions = {
				        cropUrl: '<?php echo url('account/sedcards/cropimg/'); ?>/'+images[i]["id"],
				        loadPicture: images[i]['url'],
				        enableMousescroll: true,
				        zoomFactor:1,
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
			}

		});
	</script>
@endif
@endsection

