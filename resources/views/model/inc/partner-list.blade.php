<?php
    if (!isset($cacheExpiration)) {
    	$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
    }
?>

<?php 
    if(isset($isfavorite) && $isfavorite == 1){
        // $favClass =  'active';
        // $class = '';
        $segment = 'favourites';
        // $pageTitle = t('Favorite jobs');
    }else{
        // $favClass =  '';
        // $class = 'active'; 
        $segment = '';
        // $pageTitle = t('Latest jobs');
    }
?>

<input type="hidden" id="pageNo" value="<?php echo isset($pageNo) ? $pageNo : 1 ?>"/>
<input type="hidden" id="is_last_page" value="<?php echo isset($is_last_page) ? $is_last_page : 0 ?>"/>

<div class="no-result-found-div bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30" style="display: none">
    <h5 class="prata">
       {{ t('No results found') }}
    </h5>
</div>

@if(isset($paginator) and !empty($paginator) and $paginator->getCollection()->count() > 0 )
    
    <div class="row tab_content mb-40 partner-list append-data">
        @foreach ($paginator->getCollection() as $key => $user)
            <?php 

                // $showName = (!empty($user->company_name) && !is_null($user->company_name)) ? $user->company_name : $user->full_name;

                $city = ($user->city) ? $user->city : '';

                if(!empty($city)){
                    $city_name = explode(',', $city);
                    $city = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $city;
                }

                $country = ($user->country_name) ? $user->country_name : '';
                $show_city_country = '';

                if(!empty($city)){
                    $show_city_country = $city;
                }
                if(!empty($city) && !empty($country)){
                    $show_city_country .= ', ';
                }
                
                $show_city_country .= $country;

            
                $logo = ($user->logo) ? $user->logo : ''; 
            ?>

            <?php $show_category = ''; ?>

            @if(count($partnerCategories) > 0)
                @foreach ($partnerCategories as $cat)
                    @if($cat->parent_id == $user->category_id)
                        <?php  $show_category = $cat->name; ?>
                    @endif
                @endforeach
            @endif
            
            <div class="all-post-div-count col-md-6 col-xl-3 mb-20" id="modelDiv-{{ $user->user_id }}">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    @if($logo !== "" && file_exists(public_path('uploads').'/'.$logo))
                        <img src="{{ \Storage::url($user->logo) }}"  alt="{{ trans('metaTags.User') }}">&nbsp;
                    @else
                        <img  src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.User') }}">
                    @endif
                    @if( App\Helpers\CommonHelper::checkUserType(config('constant.country_free')) &&  auth()->user()->id != $user->id )
                        <a href="#freejobs" data-toggle="modal" class="btn btn-white insight signed position-absolute to-right to-top-20 mini-all" title="{{ t('View profile') }}"></a>
                    @else
                        <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class="btn btn-white insight signed position-absolute to-right to-top-20 mini-all" title="{{ t('View profile') }}"></a>
                    @endif
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block"><?php echo !empty($user->go_code) ? $user->go_code : ''; ?></span>
                        @if(!empty($user->go_code) && !empty($show_category))
                            <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        @endif
                        <span class="d-block">{{ $show_category }}</span>
                    </div>
                    <?php $user_url = lurl(trans('routes.user').'/'.$user->username); ?>
                    @if( App\Helpers\CommonHelper::checkUserType(config('constant.country_free')) &&  auth()->user()->id != $user->id )
                        <span class="title" title="{{ t('View profile') }}"><a href="#freejobs" data-toggle="modal" >{{ $user->full_name }}</a></span>
                    @else
                        <span class="title" title="{{ t('View profile') }}"><a href="{{ $user_url }}">{{ $user->full_name }}</a></span>
                    @endif

                    @if($user->is_operator == 0)
                    <span> {{ $show_city_country }}</span>
                    @endif
                    <div class="divider"></div>
                    @if(isset($user->description) && $user->description !== "")
                        <p class="mb-70 overflow-wrap"><?php echo str_limit(strCleaner($user->description), config('constant.description_limit')); ?></p>
                    @endif
                    <?php //$created_at = \Date::parse($user->created_at)->timezone(config('timezone.id'));?>
                    <span class="posted mb-30">
                        <?php
                            date_default_timezone_set(config('timezone.id'));
                            $start  = date_create($user->last_login_at);
                            $end    = date_create();
                            
                            $diff   = date_diff( $start, $end );
                            
                            if ($diff->y) {
                                echo t('Last Active');
                                echo ': ';
                                echo  (($diff->y == 1) ? t(':value year ago', ['value' => $diff->y]): t(':value years ago', ['value' => $diff->y]));
                            }
                            else if ($diff->m) {
                                echo t('Last Active');
                                echo ': ';
                                echo  (($diff->m == 1) ? t(':value month ago',['value' => $diff->m]): t(':value months ago',['value' => $diff->m]));
                            }
                            else if ($diff->d) {
                                echo t('Last Active');
                                echo ': ';
                                echo  (($diff->d == 1) ? t(':value day ago',['value' => $diff->d]): t(':value days ago',['value' => $diff->d]));
                            }
                            else if ($diff->h) {
                                echo t('Last Active');
                                echo ': ';
                                echo  (($diff->h == 1) ? t(':value hour ago',['value' => $diff->h]): t(':value hours ago',['value' => $diff->h]));
                            }
                            else if ($diff->i) {
                                echo t('Last Active');
                                echo ': ';
                                echo  (($diff->i == 1) ? t(':value minute ago',['value' => $diff->i]): t(':value minutes ago',['value' => $diff->i]));
                            }
                            else if ($diff->s) {
                                echo t('Last Active');
                                echo ': ';
                                echo  (($diff->s == 1) ? t(':value second ago',['value' => $diff->s]): t(':value seconds ago',['value' => $diff->s]));
                            }  
                        ?>
                    </span>
                    <div class="d-flex justify-content-end">
                        @if (auth()->check())
                            <?php
                            	if ($isfavorite !== 1) {
                            		// check this record is favorite Partners
                            		$key = array_search($user->id, array_column($favoritePartners, 'fav_user_id'));
                            	} else {
                            		$key = true;
                            	}
                        	?>

                            @if($key !== false)
                                <a href="javascript:void(0);" class="btn btn-white favorite mini-all make-favorite-partner fav-post active" data-is-fav="{{ $isfavorite }}" data-partner-id="{{ $user->id }}" id="save-{{ $user->id }}" title="{{ t('Remove from Favorite') }}"></a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-white favorite mini-all make-favorite-partner" data-is-fav="{{ $isfavorite }}" data-partner-id="{{ $user->id }}" id="save-{{ $user->id }}" title="{{ t('Add to Favorite') }}"></a>
                            @endif
                        @else
                            <a href="javascript:void(0);" class="btn btn-white favorite mini-all make-favorite-partner" data-is-fav="{{ $isfavorite }}" data-partner-id="{{ $user->id }}" id="save-{{ $user->id }}" title="{{ t('Add to Favorite') }}"></a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach <!-- end foreach -->
    </div>

    @if( isset($paginator) and !empty($paginator) and $paginator->total() > 12 )
        <div class="text-center more-post-div"><a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">{{ t('load more') }}</a></div>
    @endif

@else
    <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
        <h5 class="prata">
            {{ t('No results found') }}
        </h5>
    </div>
@endif

@section('page-script')
    @parent

    <script>
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
                            $("#more-posts").addClass("disabled");
                            $('.more-post-div').hide();
                        }
                        
                        $('.append-data').append(append);
                        
                        $('.make-favorite-partner').unbind("click");
                    
                        /* Save the Acount User */
                        $('.make-favorite-partner').bind("click", function(){
                            savePartner(this);
                        });
                    }
                });
            });
        });
    </script>
@endsection