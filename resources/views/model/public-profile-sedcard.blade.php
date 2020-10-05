@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')

@section('content')
    @include('model.public-profile-top')


    <link href="{{ url(config('app.cloud_url') . '/assets/css/magnific-popup.css') }}" rel="stylesheet">
    <div class="container pt-40 px-0">
        <div class="custom-tabs mb-20">
            <?php
            $tabs = array();
            $tabs[route('model-sedcard',['id' => $user_id])] = t('Sedcard');
            $tabs[route('model-portfolio',['id' => $user_id])] = t('Model Book');
                if(Auth::user()->user_type_id == 2){
                    $tabs[lurl(trans('routes.user').'/'.$user_name)] = t('Details');
                }else{
                    $tabs[lurl('user')] = t('Details');
                }
            ?>

            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu']) }}
            <ul class="d-none d-md-flex justify-content-center">
                <li><a href="{{ route('model-sedcard',['id' => $user_id]) }}" class="active">{{ t('Sedcard') }}</a></li>
                <li><a href="{{ route('model-portfolio',['id' => $user_id]) }}">{{ t('Model Book') }}</a></li>
                @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user->id)
                    <li><a href="{{ lurl('user') }}">{{ t('Details') }}</a></li>
                @else
                    <li><a href="{{ lurl(trans('routes.user').'/'.$user_name) }}">{{ t('Details') }}</a></li>
                @endif

            </ul>
        </div>
        <?php if (isset($sedcards) && sizeof($sedcards) > 0) { ?>
        <div class="row">
            <?php $not_found_image = 0; 
                foreach ($sedcards as $key => $sedcard) {

        		$image_path = '';
        		if (!empty($sedcard->cropped_image) && \Storage::exists($sedcard->cropped_image)) {
        			$image_path = \Storage::url($sedcard->cropped_image);
        		}elseif (!empty($sedcard->filename) && \Storage::exists($sedcard->filename)) {
                    $image_path = \Storage::url($sedcard->filename);
                }else{
                    $image_path = url(config('app.cloud_url').'/images/sedcard_img.jpg');
                }
        		?>
                @if(!empty($image_path))
                <div class="col-md-6 col-xl-3 mb-30">

                    <!-- <div class="img-holder position-relative"> -->
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        @if($image_path)
                            <!-- <a href="#" data-featherlight="{{ route('show-sedcard',['id' => $sedcard->id]) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a> -->

                             <a href="#"  data-id="{{ $sedcard->filename}}"  data-url="{{ route('show-sedcardnew',['id' => $sedcard->id,'user_id' => $sedcard->user_id]) }}" class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>

                            <!-- <img src="{{ \Storage::url($sedcard->filename) }}" alt="{{ trans('metaTags.Go-Models') }}"  > -->

                            <img src="{{ $image_path}}" alt="{{ trans('metaTags.Go-Models') }}" >
                        @else
                            <div class="px-sm-5 px-50 py-30 align-content-sm-center">{{ t('Not available') }}</div>
                        @endif
                    </div>

                    <div class="box-shadow bg-white py-40 px-30">
                        <span><?php if ($sedcard['image_type'] == 1) {?>
                            {{ $sedcard_title_1 }}
                        <?php } else if ($sedcard['image_type'] == 2) {?>
                            {{ $sedcard_title_2 }}
                        <?php } else if ($sedcard['image_type'] == 3) {?>
                            {{ $sedcard_title_3 }}
                        <?php } else if ($sedcard['image_type'] == 4) {?>
                           {{ $sedcard_title_4 }}
                        <?php } else if ($sedcard['image_type'] == 5) {?>
                            {{ $sedcard_title_5 }}
                        <?php }?>
                        </span>
                    </div>
                </div>
                @else
                <?php $not_found_image++; ?>
                @endif
            <?php } ?>
        </div>
        @if($not_found_image > 0)
            <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                <h5 class="prata">

                @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user->id)
                    <a href="{{ lurl(trans('routes.model-sedcard-edit')) }}"> {{t("Please configure your Sedcard")}}</a>
                @else
                    {{t("Sedcard is not configure")}}
                @endif
               
                </h5>
            </div>
        @endif


        <div class="text-center xl-to-right-0 xl-to-top-0 mb-40">
            
            @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user_id)
                
                <a href="{{ lurl(trans('routes.model-sedcard-edit')) }}" class="btn btn-white upload_white mini-mobile">{{t('Sedcard Generator')}}</a>
            @endif
        </div>

        <?php } else {  ?>
         <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
            <h5 class="prata">
                @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user->id)
                    <a href="{{ lurl(trans('routes.model-sedcard-edit')) }}"> {{t("Please configure your Sedcard")}}</a>
                @else
                    {{t("Sedcard is not configure")}}
                @endif
                
            </h5>
        </div>
        <?php } ?>
    </div>
    @include('childs.bottom-bar')
@endsection
@section('page-script')
<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}"></script>
<script type="text/javascript">
    
    //$.noConflict();

    jQuery(document).ready( function($){

        var magnificPopup = $.magnificPopup.instance;
        
        $('.some-button').click( function(e){
            
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
</script>
<script type="text/javascript">
$(document).ready(function(){

    $('.tabs').on('change',function(){
        if($(this).val() == 1){
            window.location = '{{ lurl(trans('model-portfolio').'/'.$user_id) }}';
        }
        if($(this).val() == 2){
            window.location = '{{ lurl(trans('routes.user').'/'.$user_id) }}';
        }
    });
});
</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
@endsection