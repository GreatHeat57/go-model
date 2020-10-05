@extends( Auth::User()->user_type_id == config('constant.partner_type_id')  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content')
    @include('partner.public-profile-top')

    <link href="{{ url(config('app.cloud_url') . '/assets/css/magnific-popup.css') }}" rel="stylesheet">
    <div class="container pt-40 px-0">
        <div class="custom-tabs mb-20">
            <?php
            $tabs = array();

            if($user->id == Auth::User()->id){
                $tabs[lurl('user')] = t('Details');
                $tabs[lurl('partner-public-portfolio')] = t('Portfolio');

            }else{
                $tabs[lurl(trans('routes.user').'/'.$user->username)] = t('Details');
                $tabs[lurl('partner-public-portfolio/'.$user->id)] = t('Portfolio'); 

                if(Auth::check() && Auth::User()->user_type_id == config('constant.model_type_id') && Auth::User()->user_register_type != config('constant.user_type_free')){
                    $attr = ['countryCode' => config('country.icode'), 'user_id' => $user->id];
                    $tabs[lurl(trans('routes.job-match-profile', $attr), $attr)] = t('Latest jobs Portal');
                }                
            }
               
            ?>
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="d-none d-md-flex justify-content-center">
                @if(isset($user))
                    @if($user->id == Auth::User()->id)
                        <li><a href="{{ lurl('partner-public-portfolio') }}" class="active">{{ t('Portfolio') }}</a></li>
                        <li><a href="{{ lurl('user') }}" >{{ t('Details') }}</a></li>
                    @else
                        <li><a href="{{ lurl('partner-public-portfolio/'.$user->id) }}" class="active">{{ t('Portfolio') }}</a></li>
                        <li><a href="{{ lurl(trans('routes.user').'/'.$user->username) }}">{{ t('Details') }}</a></li>
                        
                        
                        @if( Auth::User()->user_type_id == config('constant.model_type_id') && Auth::User()->user_register_type != config('constant.user_type_free') )

                            <?php $attr = ['countryCode' => config('country.icode'), 'user_id' => $user->id]; ?>
                            <li>
                                <a href="{{ lurl(trans('routes.job-match-profile', $attr), $attr) }}" class="position-relative">{{ t('Latest jobs Portal') }}
                                    <span class="msg-num tab rejected ">{{ isset($matchCount)? $matchCount : '0' }}</span>
                                </a>
                            </li>
                        @endif

                    @endif
                @endif
            </ul>
        </div>
        @include('partner.inc.album-list')

        <?php /*
        @if( isset($album) && count($album) > 0 )
            <div class="row">
                @foreach($album as $key => $ab )
                    <div class="col-md-6 col-xl-3 mb-30">
                        <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                            <a href="#" data-featherlight="{{ route('album-img-zoom-popup',['id' => $ab->id]) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                           <!--  <img srcset="{{ URL::to('images/avatars/avatar-photo-upload.png') }},
                                         {{ URL::to('images/avatars/avatar-photo-upload@2x.png') }} 2x,
                                         {{ URL::to('images/avatars/avatar-photo-upload@3x.png') }} 3x"
                                 src="{{ URL::to('images/avatars/avatar-photo-upload.png') }}" alt="Go Models"/> -->

                                @if($ab->cropped_image !== "" && $ab->cropped_image !== null && Storage::exists($ab->cropped_image))
                                    <img class="" src="{{ \Storage::url($ab->cropped_image) }}" alt="{{ trans('metaTags.Go-Models') }}">
                                @elseif ($ab->filename !== "" && Storage::exists($ab->filename))
                                    <img class="" src="{{ \Storage::url($ab->filename) }}" alt="{{ trans('metaTags.Go-Models') }}"  >
                                @else
                                    <img class="" src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                                @endif
                        </div>
                        <div class="box-shadow bg-white py-40 px-30">
                            <span class="mb-30">{{ (!empty($ab->name) ? str_limit($ab->name, config('constant.title_limit')) : t('default title portfolio photos')) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30">
                <h5 class="prata">
                    @if($user->id == Auth::User()->id)
                        <a href="{{ lurl(trans('routes.account-album')) }}"> {{t("Please configure your Portfolio")}}</a>
                    @else
                        {{t("Portfolio is not configure")}}
                    @endif
                </h5>
            </div>

        @endif

        <?php */ ?>
    </div>


   @include('childs.bottom-bar')
   @include('partner.inc.send-message')
@endsection
<style type="text/css">
    @media (min-width: 768px) {
      .img-holder {
        height: 346px !important;
      }
    }

    @media (min-width: 980px) {
      .img-holder {
        height: 442px !important;
      }
    }
</style>
@section('page-script')
<style type="text/css">
    .select2-container {
        z-index: 99999 !important;
    }
</style>
<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready( function(){

    var magnificPopup = $.magnificPopup.instance;
    
    $('.some-button').click( function(e){
       // alert();
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
<script>
    function formatState (opt) {
             if (!opt.id) {
                return opt.text;
            } 

            var optimage = $(opt.element).attr('data-image'); 
            if(!optimage){
               return opt.text;
            } else {                    
                var $opt = $(
                   '<span><img class="country-flg-img" src="' + optimage + '" width="16" height="16" /> ' + opt.text + '</span>'
                );
                return $opt;
            }    
        };
    $(document).ready( function(){
            $(".phone-code-search").select2({
                // minimumResultsForSearch: 5,
                minimumResultsForSearch: 5,
                width: '100%',
                dropdownParent: $("#sendMessage"),
                templateResult: formatState,
                templateSelection: formatState
            });
            $('#send-message').submit( function(e){
                e.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: $('#send-message').attr('action'),
                    type: 'POST',
                    data: formData,
                    cache       : false,
                    contentType : false,
                    processData : false,
                    beforeSend: function(){
                        $(".loading-process").show();
                        clearMessage();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    success: function (response) {

                        if( response != undefined && response.success == false ){

                            $(".print-error-msg").html('');
                            $(".print-error-msg").css('display','block');
                            $("div").removeClass('invalid-input');

                            if (typeof response.errors == "string") {
                                $(".print-error-msg").append('<p>'+response.errors+'</p>');

                            } else {
                                $.each( response.errors, function( key, value ) {
                                    $('#'+key).addClass('invalid-input');
                                    $(".print-error-msg").append('<p>'+value[0]+'</p>');
                                });
                            }
                            
                        } else {
                       
                            if( response.message != undefined && response.message !== ""){
                                $(".print-success-msg").html(response.message);
                                $(".print-success-msg").css('display','block');
                            }
                        }
                    }
                });

            });

            $('#sendMessage').on('hidden.bs.modal', function () {
                $('.textarea-description').val('');
                $('#send-message').find('.input-group').removeClass("invalid-input");
                $('#send-message')[0].reset();
                $('#send-message').find("#phone_code").val({{(auth()->check()) ? auth()->user()->phone_code : ''}}).trigger('change');
                clearMessage();
            });

            // clear all the messages after model is closed
            function clearMessage(){

                $(".print-error-msg").html('');
                $(".print-error-msg").css('display','none');
                $(".print-success-msg").html('');
                $(".print-success-msg").css('display','none');
             }
    })
</script>
@endsection