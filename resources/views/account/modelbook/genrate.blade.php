@extends('layouts.logged_in.app-model')

@section('content')
	@include('common.spacer')
     <?php $modelbook = $data['modelbook'];
$user_id = $data['user_id'];?>
		<div class="container pt-40 px-0">
            <h1 class="text-center prata"> {{ ucWords(t('GenrateModelBook')) }}</h1>
            <div class="position-relative">
                <div class="divider mx-auto"></div>
                <p class="text-center mb-30 mx-lg-auto notes-zone">{{ t('Sedcard subtitle') }}</p>
                <div class="text-center mb-30 xl-to-right-0 xl-to-top-0">
                    <a class="btn btn-white arrow_left" href="{{ lurl(trans('routes.model-portfolio-edit')) }}">
                      {{ t('Back to Modelbook') }}
                    </a>
                </div>
            </div>
            @include('childs.notification-message')
			<div class="row">
				
				<div class="col-sm-12 page-content mb-30 model-back-book">
                        <?php 
                            $i = 0;
                            if (isset($modelbook) && $modelbook->count() > 0) {
	                    ?>
					       <div class="inner-box box-shadow bg-white">
						        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 modelbookdiv padding-none" style="margin-top: 85px !important;">
							        <div id="protPreload" data-number="1" class="image_div mainmodelbook"></div>
						        </div>
						        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-none">
	                               <?php foreach ($modelbook as $key => $modelbooks) {
                                		$image[$key]['url'] = \Storage::url($modelbooks->filename);
                                		$image[$key]['id'] = $modelbooks->id;
		                                if ($i == 0) {
			                            $i = $i + 1;
			                            continue;
                                        }
                                    ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 modelbookdiv padding-none">
		                                <div id="otherPreloadModel{{ $i }}" data-number="{{ $i+1 }}" class="image_div"></div>
	                                </div>
                    	            <?php
                                        $i = $i + 1;
	                               }
                                ?>
						        </div>
                            </div>
                        <?php } ?>
                        <!-- <div class="pagination-bar text-center">
                            {{ (isset($modelbook)) ? $modelbook->links() : '' }}
                        </div> -->
                        @include('customPagination', ['paginator' => $modelbook])
                        <?php if ($modelbook->count() > 0) {?>
						<!-- ADDED BY EXPERT TEAM -->
						<div class="genrate-sedcard pt-40">
							<p>
								<a class="btn btn-white download btn-sm mb-30" href="{{ lurl('account/'.$user_id.'/downloadmbook') }}">
								  {{ t('Download Modelbook') }}
								</a>
							</p>
						</div>
                        <!-- ENDED BY EXPERT TEAM -->


                    </div>
                        <?php }?>
                </div>
            </div>
            @if (isset($modelbook) && $modelbook->count() == 0)
                <div class="text-center bg-white box-shadow position-relative mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                    <h5 class="prata">{{ t('No records found') }}</h5>
                </div>
            @endif
		</div>
@endsection

@section('page-script')
<style type="text/css">
    ul.pagination {
        display: inline-block;
        padding: 0;
        margin: 0;
    }
    ul.pagination li {display: inline;}
    ul.pagination li a,ul.pagination li span {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
        margin-right: 5px;
    }
    ul.pagination li.active span {
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
    }
    .genrate-sedcard{
        top: 0 !important;
    }

    ul.pagination li a:hover:not(.active) {background-color: #ddd;}
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

@if (isset($modelbook) && $modelbook->count() > 0)
	<script type="text/javascript">
		jQuery(document).ready(function() {
        var image_edit_called = "no";
        var images=<?php echo json_encode($image); ?>;
        var croppicContainerPreloadOptions = {
            // uploadUrl: 'https://go-models.com/wp-admin/admin-ajax.php?action=image_upload_in_folder',
            //cropUrl:  "{{ lurl('account/sedcards/cropimg/') }}",
            cropUrl: '<?php echo url('account/model-book/cropimg/'); ?>/'+images[0]["id"],
            loadPicture: images[0]['url'],
            enableMousescroll: true,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onBeforeImgUpload: function() {
                // console.log('onBeforeImgUpload')
            },
            onAfterImgUpload: function() {
                // console.log('onAfterImgUpload')
            },
            onImgDrag: function() {
                // console.log('onImgDrag')
            },
            onImgZoom: function() {
                // console.log('onImgZoom')
            },
            onBeforeImgCrop: function() {
                jQuery('#protPreload').find('.cropControlCrop').unbind('click');
                jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'none');
                jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'none');
                jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'none');
                jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'none');
                // console.log('onBeforeImgCrop')
            },
            onAfterImgCrop: function() {
                jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'inline-block');
                jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'inline-block');
                jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'inline-block');
                jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'inline-block');
                // console.log('onAfterImgCrop')
            },
            onReset: function() {
                // console.log('onReset')
            },
            onError: function(errormessage) {
                // console.log('onError:' + errormessage)
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
                // console.log('onBeforeImgUpload')
            },
            onAfterImgUpload: function() {
                // console.log('onAfterImgUpload')
            },
            onImgDrag: function() {
                // console.log('onImgDrag')
            },
            onImgZoom: function() {
                // console.log('onImgZoom')
            },
            onBeforeImgCrop: function() {
                jQuery('#protPreload').find('.cropControlCrop').css('display', 'none');
                jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'none');
                jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'none');
                jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'none');
                jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'none');
                // console.log('onBeforeImgCrop')
            },
            onAfterImgCrop: function() {
                jQuery('#protPreload').find('.cropControlCrop').css('display', 'inline-block');
                jQuery('#otherPreloadModel1').find('.cropControlCrop').css('display', 'inline-block');
                jQuery('#otherPreloadModel2').find('.cropControlCrop').css('display', 'inline-block');
                jQuery('#otherPreloadModel3').find('.cropControlCrop').css('display', 'inline-block');
                jQuery('#otherPreloadModel4').find('.cropControlCrop').css('display', 'inline-block');
                console.log('onAfterImgCrop');
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
    });
	</script>
@endif

@endsection