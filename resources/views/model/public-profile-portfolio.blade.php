@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')

@section('content')
    @include('model.public-profile-top')
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
                <li><a href="{{ route('model-sedcard',['id' => $user_id]) }}">{{ t('Sedcard') }}</a></li>
                <li><a href="{{ route('model-portfolio',['id' => $user_id]) }}" class="active">{{ t('Model Book') }}</a></li>
                @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user->id)
                    <li><a href="{{ lurl('user') }}">{{ t('Details') }}</a></li>
                @else
                    <li><a href="{{ lurl(trans('routes.user').'/'.$user_name) }}">{{ t('Details') }}</a></li>
                @endif
            </ul>
        </div>
        @include('model.inc.model-book-list')
    </div>
    @include('childs.bottom-bar')
@endsection
@section('page-script')
<link href="{{ url(config('app.cloud_url') . '/assets/css/magnific-popup.css') }}" rel="stylesheet">
<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}"></script>
<script type="text/javascript">
    // $(document).ready( function(){
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
</script>
<script type="text/javascript">
$(document).ready(function(){

    $('.tabs').on('change',function(){
        if($(this).val() == 0){
            window.location = '{{ lurl(trans('routes.user').'/'.$user_name) }}';
        }
        if($(this).val() == 2){
            window.location = '{{ lurl(trans('routes.user').'/'.$user_name) }}';
        }
    });
});
</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
@endsection