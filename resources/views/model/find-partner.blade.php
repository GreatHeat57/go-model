@extends('layouts.logged_in.app-model')

@section('content')
<?php
use Illuminate\Support\Facades\Request;

// Keywords
$keywords = rawurldecode(Request::input('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : Request::input('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = Request::input('r');
} else {
	$qLocationId = Request::input('l');
	$qLocation = (Request::filled('r')) ? t('area:') . rawurldecode(Request::input('r')) : Request::input('location');
	$qAdmin = Request::input('r');
}
?>
<?php 
    $attr = ['countryCode' => config('country.icode')];

    if ($isfavorite == 1) {
    	$favoriteClass = 'active';
    	$partnerClass = '';
        $pageTitle = t('Favorite partner');
    } else {
    	$favoriteClass = '';
    	$partnerClass = 'active';
        $pageTitle = t('find partner');
    }
?>
<div class="container px-0 pt-40 pb-60">
    <h1 class="text-center prata">{{ ucWords($pageTitle) }}</h1>
    <div class="text-center mb-30 position-relative">
        <div class="divider mx-auto"></div>
    </div>

    <?php
        $tabs = array();
        $tabs[lurl(trans('routes.partner-list', $attr), $attr)] = t('all partners');
        $tabs[ lurl(trans('routes.partner-list-favourites', $attr), $attr)] = t('Favorites');
    ?>

    <div class="custom-tabs mb-20 mb-xl-30">
        {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
        <ul class="tabs d-none d-md-block">
            <li><a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}" class="{{ $partnerClass }}">{{ t('all partners') }}</a></li>
            <li><a href="{{ lurl(trans('routes.partner-list-favourites', $attr), $attr) }}" class="{{ $favoriteClass }}">{{ t('Favorites') }}</a></li>
        </ul>
    </div>
    @include('childs.notification-message')
    @include('model.inc.partner-list')

    <?php /*
        if (!isset($cacheExpiration)) {
        	$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
        }
    ?>
    @if(isset($paginator) and $paginator->getCollection()->count() > 0 )
        
        <div class="row tab_content mb-40 partner-list append-data">
            @foreach ($paginator->getCollection() as $key => $user)
                <?php $logo = ($user->logo) ? $user->logo : ''; ?>
                
                <div class="col-md-6 col-xl-3 mb-20" id="modelDiv-{{ $user->user_id }}">
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        @if($logo !== "" && file_exists(public_path('uploads').'/'.$logo))
                            <img src="{{ \Storage::url($user->logo) }}"  alt="user">&nbsp;
                        @else
                            <img  src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="user">
                        @endif
                    </div>
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                            <span class="d-block">{{ $user->go_code }}</span>
                            <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                            <span class="d-block">{{ $user->username }}</span>
                        </div>
                        <?php $user_url = lurl(trans('routes.user').'/'.$user->username); ?>
                        <span class="title"><a href="{{ $user_url }}">{{ $user->name }}</a></span>
                        <div class="divider"></div>
                        @if(isset($user->description) && $user->description !== "")
                            <p class="mb-70"><?php echo str_limit(strip_tags($user->description), 120); ?></p>
                        @endif
                        <?php $created_at = \Date::parse($user->created_at)->timezone(config('timezone.id'));?>
                        <span class="info posted mb-30">{{ $created_at }}</span>
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
                                    <a href="javascript:void(0);" class="btn btn-white favorite mini-all saved-partner active" data-partner-id="{{ $user->id }}" id="saved-{{ $user->id }}"></a>
                                @else
                                    <a href="javascript:void(0);" class="btn btn-white favorite mini-all save-partner" data-partner-id="{{ $user->id }}" id="save-{{ $user->id }}"></a>
                                @endif
                            @else
                                <a href="javascript:void(0); class="btn btn-white favorite mini-all save-partner" data-partner-id="{{ $user->id }}" id="save-{{ $user->id }}"></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach <!-- end foreach -->
        </div>
        <div class="text-center"><a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">More posts</a></div>
    @else
        <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
            <h5 class="prata">
                {{ t('No results found') }}
            </h5>
        </div>
    @endif
    */ ?>

                     


                <?php /*
                <!-- pagination -->
                <div class="pagination-bar text-center">
                    @include('customPagination', ['paginator' => $paginator])
                </div>
                <?php */ ?>
</div>
<?php /*
   <!--  @if(isset($paginator) and $paginator->getCollection()->count() > 0 )
        <div class="pagination-bar text-center">
            @include('customPagination', ['paginator' => $paginator])
        </div>
    @endif -->
    */ ?>

@include('childs.bottom-bar')
@endsection
@section('page-script')
{{ Html::script(config('app.cloud_url').'/assets/plugins/autocomplete/jquery.mockjax.js') }}
{{ Html::script(config('app.cloud_url').'/assets/plugins/autocomplete/jquery.autocomplete.min.js') }}
{{ Html::script(config('app.cloud_url').'/assets/js/app/autocomplete.cities.js') }}

<script>
        /* Favorites Translation */
        var lang = {
            labelSavePostSave: "{!! t('Save Job') !!}",
            labelSavePostRemove: "{{ t('Saved Job') }}",
            loginToSavePost: "{!! t('Please log in to save the Ads') !!}",
            loginToSaveSearch: "{!! t('Please log in to save your search') !!}",
            confirmationSavePost: "{!! t('Post saved in favorites successfully !') !!}",
            confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully !') !!}",
            confirmationSaveSearch: "{!! t('Search saved successfully !') !!}",
            confirmationRemoveSaveSearch: "{!! t('Search deleted successfully !') !!}"
        };

        /*  $(document).ready(function(){
             $("select[name='tabs']").on('change', function() {
                if($(this).val() == 1){
                  window.location='{{ lurl(trans('routes.partner-list', $attr), $attr) }}';
                }
                if($(this).val() == 2){
                  
                }
            });

            $('.keyword').on('keyup',function(){
                $.ajax({
                    url: '{{ lurl(trans('routes.partner-list', $attr), $attr) }}',
                    data:'q='+ $(this).val()+'&c='+ $('#catSearch').val()+'&location='+ $('#locSearch').val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.partner-list').html();
                        $('.partner-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });

            });

            $('#catSearch').on('change',function(){
                $.ajax({
                    url: '{{ lurl(trans('routes.partner-list', $attr), $attr) }}',
                    data:'q='+ $('.keyword').val()+'&c='+ $(this).val()+'&location='+ $('#locSearch').val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.partner-list').html();
                        $('.partner-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });
            });

            $('#locSearch').on('change',function(){
                $.ajax({
                    url: '{{ lurl(trans('routes.partner-list', $attr), $attr) }}',
                    data:'q='+ $('.keyword').val()+'&c='+ $('#catSearch').val()+'&location='+ $(this).val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.partner-list').html();
                        $('.partner-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });
            });

            $(document).on('click','.pagination li a',function(e){
                $.ajax({
                    url: '{{ lurl(trans('routes.partner-list', $attr), $attr) }}',
                    data:'q='+ $('.keyword').val()+'&c='+ $('#catSearch').val()+'&location='+ $(this).val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val()+'&page='+$(this).attr('data-page'),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.partner-list').html();
                        $('.partner-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });
            });

        });*/
</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
@endsection