@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')
<?php $attr = ['countryCode' => config('country.icode')]; ?>
<?php 
    if(isset($favourites_tab) && $favourites_tab == 1){
        $favClass =  'active';
        $class = '';
        $segment = 'favourites';
        $pageTitle = t('Favorite jobs');
    }else{
        $favClass =  '';
        $class = 'active'; 
        $segment = '';
        $pageTitle = t('Latest jobs Portal');
    }
?>
@section('content')
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{ ucWords(t('Jobs')) }}</h1>
        <div class="text-center mb-30 position-relative">
            <div class="divider mx-auto"></div>
        </div>
    
        <?php
    
            $favAttr = ['countryCode' => config('country.icode'), 'slug' => t('favourites')];
            $tabs = array();

            $tabs[lurl(trans('routes.search', $attr), $attr)] = t('Latest jobs Portal');
            $tabs[lurl(trans('routes.v-search', $favAttr), $favAttr)] = t('Favorite jobs');

            if(Auth::user()->user_type_id == config('constant.model_type_id')){
                $tabs[lurl(trans('routes.job-info'))] = t('Job Info');
            }
           
        ?>
    
        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="d-none d-md-block">

                <li><a href="{{ lurl(trans('routes.search', $attr), $attr) }}" class="{{ $class }}" data-id="1">{{ t('Latest jobs Portal') }}</a></li>

                <li><a href="{{ lurl(trans('routes.v-search', $favAttr), $favAttr) }}" class="{{ $favClass }}" data-id="2">{{ t('Favorite jobs') }}</a></li>
                
                @if(Auth::user()->user_type_id == config('constant.model_type_id'))
                    <li><a href="{{ lurl(trans('routes.job-info')) }}" class="" data-id="3">{{ t('Job Info') }}</a></li>
                @endif
               
            </ul>
        </div>
        
        @include('childs.notification-message')
        @include('search.inc.posts')
       
    </div>
@include('childs.bottom-bar')

    @section('page-script')
        {{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
        <script type="text/javascript">
            $(document).ready(function (){

                if($("#is_last_page").val() == 1){
                    $("#more-posts").addClass("disabled");
                    $('.more-post-div').hide();
                }

                $('.more-posts').click(function(){ 

                    var is_fav_page = '<?php echo $segment; ?>';

                    var numItems = $('.all-post-div-count').length;
                    if(is_fav_page == 'favourites'){
                        numItems = $('.fav-post').length;
                    }

                    var pageNo = $("#pageNo").val();
                    var data = 'page=' + pageNo + '&show_record=' + numItems;
                    var type = 'get';
                    
                    $.ajax({
                        url: '<?php echo url()->current(); ?>',
                        type : type,
                        dataType :'json',
                        beforeSend: function(){
                            $(".loading-process").show();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        data : data,
                        success : function(res){

                            var append = $(res.html).filter(".append-data").html();

                            $("#pageNo").val(res.pageNo);
                            
                            if(res.is_last_page == 1){
                                $("#is_last_page").val(res.is_last_page);
                                $('.more-post-div').hide();
                                $("#more-posts").addClass("disabled");
                            }

                            $('.append-data').append(append);
                            
                            $('.save-job').unbind("click");
                        
                            /* Save the Acount User */
                            $('.save-job').bind("click", function(){
                                savePost(this);
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
@endsection