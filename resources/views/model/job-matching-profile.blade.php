@extends( Auth::User()->user_type_id == config('constant.partner_type_id')  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )
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
    @include('partner.public-profile-top')
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
                        <li><a href="{{ lurl('partner-public-portfolio') }}" >{{ t('Portfolio') }}</a></li>
                        <li><a href="{{ lurl('user') }}" class="active">{{ t('Details') }}</a></li>
                    @else

                        <li><a href="{{ lurl('partner-public-portfolio/'.$user->id) }}" >{{ t('Portfolio') }}</a></li>

                        <li><a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class="">{{ t('Details') }}</a></li>

                        @if( Auth::User()->user_type_id == config('constant.model_type_id') && Auth::User()->user_register_type != config('constant.user_type_free'))

                            <?php $attr = ['countryCode' => config('country.icode'), 'user_id' => $user->id]; ?>
                            <li>
                                <a href="{{ lurl(trans('routes.job-match-profile', $attr), $attr) }}" class="active">{{ t('Latest jobs Portal') }}
                                    <span class="msg-num tab rejected ">{{ isset($matchCount)? $matchCount : '0' }}</span>
                                </a>
                            </li>
                        @endif

                    @endif
                @endif
            </ul>
        </div>

        @include('childs.notification-message')
        @include('search.inc.posts')

        
    </div>
    @include('childs.bottom-bar')
   
@endsection

@section('page-script')
    <style type="text/css">
        .select2-container {
            z-index: 99999 !important;
        }
    </style>
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

