@if( isset($album) && count($album) > 0 )
    <div class="row append-data">
        @foreach($album as $key => $ab )
            <div class="col-md-6 col-xl-3 mb-30">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <a href="#" data-featherlight="{{ route('album-img-zoom-popup',['id' => $ab->id]) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>

                    <a href="#"  data-id="{{ $ab->filename}}"  data-url="{{ route('alubm-gallery',['id' => $ab->id,'user_id' => $ab->user_id]) }}" class="some-button position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all" id="some-button"  ></a>
                    
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
    @if($is_load_more_albums == true)
        <div class="text-center show-all-div mb-30">
            <a href="javascript:void(0);" id="show-all" class="btn btn-white refresh more-posts">{{ t('Show All') }}</a>
        </div>
    @endif
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
@endif<script src="{{ url(config('app.cloud_url') . '/assets/js/magnific-popup.min.js') }}"></script>
<script type="text/javascript">
<?php  /*   $(document).ready( function(){

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
                           /* });

                    magnificpopup.ev.off('mfpBeforeChange.ajax');
                }

            }, error: function (a, b, c) {
                console.log('error');
            }
        });
    });
});*/ ?>
</script>

<script type="text/javascript">
    
    $(document).ready(function(){
        
        $("#show-all").click(function(){
            
            var user_id = "<?php echo $user_id ; ?>";
            
            $.ajax({
                
                url: '<?php echo url('show-all-albums') ?>',
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