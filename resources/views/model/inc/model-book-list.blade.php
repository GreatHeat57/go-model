<?php 
    if (isset($modelbooks) && sizeof($modelbooks) > 0) { ?>
        
        <div class="row append-data" id="modelbook-list">
            
            <?php  $is_image_available = false;
            
            $i = 0;
                
            foreach ($modelbooks as $key => $model) {
                $image_path = '';

                
                if (!empty($model->cropped_image) && \Storage::url($model->cropped_image)) {
                    $image_path = \Storage::url($model->cropped_image);
                }elseif (!empty($model->filename) && \Storage::url($model->filename)) {
        			$image_path = \Storage::url($model->filename);
        		} ?>
                    @if($image_path)
                        <?php $is_image_available = true;   ?>
                        <div class="col-md-6 col-xl-3 mb-30">

                            <!-- <div class="img-holder position-relative"> -->
                            <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                               
                                <a href="#" data-id='{{ $model->filename}}' data-url="{{ route('show-gallery',['id' => $model->id, 'user_id' => $model->user_id]) }}" data-titel="{{  (!empty($model->name) ? str_limit($model->name, config('constant.title_limit')) : t('Model Book Photo')) }}"   id="some-button" class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                                <img src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}" >
                            </div>
                            <div class="box-shadow bg-white py-40 px-30 model-book-photo-title">
                                <span>{{ (!empty($model->name) ? str_limit($model->name, config('constant.title_limit')) : t('Portfolio photos')) }}</span>
                            </div>
                        </div>
                        <div class="pt-40 pb-60 px-38 px-lg-0 w-lg-720 d-none" id="modal_{{$key+1}}" >
                            <span class="bold f-20 lh-28">{{ t('Photo view full size') }}</span>
                            <div class="divider"></div>
                            <img src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}">
                        </div>
                    @else
                        <?php  $is_image_available = false;
                           $i = $i + 1; ?>
                    @endif
                <?php 
            } ?>
        </div>
        
        @if($is_image_available == false && $i > 1)
            <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                <h5 class="prata">
                    @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user->id)
                        <a href="{{ lurl(trans('routes.model-portfolio-edit')) }}">{{t('Please configure your Portfolio')}}</a>
                    @else
                        {{t("Portfolio is not available")}}
                    @endif
                </h5>
            </div>
        @endif
        
        <?php /* ?>

            @if($is_load_more_modelbook == true)
                <div class="text-center show-all-div mb-30">
                    <a href="javascript:void(0);" id="show-all" class="btn btn-white refresh more-posts">{{ t('Show All') }}</a>
                </div>
            @endif
        */ ?>

        <?php $attr = ['countryCode' => config('country.icode')];?>
        
        <div class="text-center xl-to-right-0 xl-to-top-0 mb-40">
            
            @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user_id)

                <a href="{{ lurl(trans('routes.model-portfolio-edit', $attr), $attr) }}" class="btn btn-white upload_white mini-mobile">{{t('ModelBook Generator')}}</a>
            @endif

            @if($is_load_more_modelbook == true)
                
                <a href="javascript:void(0);" id="show-all" class="show-all-div btn btn-white refresh more-posts">{{ t('Show All') }}</a>
            @endif
        </div>
        <?php 
    } 
    else {  ?>
            
        <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
            <h5 class="prata">
                
                @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user->id)
                    <a href="{{ lurl(trans('routes.model-portfolio-edit')) }}">{{t('Please configure your Portfolio')}}</a>
                @else
                    {{t("Portfolio is not available")}}
                @endif
            </h5>
        </div>
<?php } ?>
<link href="{{ url(config('app.cloud_url') . '/assets/css/magnific-popup.css') }}" rel="stylesheet">
<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}" type="text/javascript"></script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/mfp-zoom-slider-popup.js') }}

<script type="text/javascript">
//     $(document).ready( function(){

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
    
    $(document).ready(function(){
        
        $("#show-all").click(function(){
            
            var user_id = "<?php echo $user_id ; ?>";
            
            $.ajax({
                
                url: '<?php echo url('show-all-modelbook') ?>',
                type : 'GET',
                data : {'user_id' : user_id},
                dataType :'json',
                beforeSend: function(){
                    $(".loading-process").show();
                },
                complete: function(){
                    $(".loading-process").hide();
                },
                success : function(res){
                    var append = $(res.html).filter(".append-data").html();
                    $('.append-data').append(append); 
                    $(".show-all-div").hide();
                }
            });
        });
    });
</script>