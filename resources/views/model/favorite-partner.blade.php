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
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="f-h2 prata">Find partner</h1>
                <div class="divider mx-auto"></div>
            </div>
            <!-- <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white filters mr-20 mini-all"></a>
                <a href="#" class="btn btn-white search mini-all"></a>
            </div> -->
        </div>

        <?php /* ?>
        <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-auto">
                <input name="q" class="form-control keyword" type="text" placeholder="Search partner" value="{{ $keywords }}">
            </div>
        </div>
        <?php */ ?>

        <?php $attr = ['countryCode' => config('country.icode')]; ?>
        <?php /*
        <!-- <form id="seach" name="search" action="{{ lurl(trans('routes.partner-list', $attr), $attr) }}" method="GET"> -->
            <div class="row bg-white box-shadow py-30 px-38 mb-40 mx-0">
                 <!-- <div class="col-md-6 px-xs-0 pr-md-0 mb-md-30">
                    <input name="q" class="form-control keyword" type="text" placeholder="{{ t('What?') }}" value="{{ $keywords }}">
                </div> -->
                <div class="col-md-6 px-xs-0 pr-md-0 mb-md-30">
                    <select name="c" id="catSearch" class="form-control selecter">
                        <option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
                        @if (isset($cats) and $cats->count() > 0)
                            @foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
                                <option {{ ($qCategory==$itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 px-xs-0 pr-md-0 mb-md-30">
                    <i class="icon-location-2 icon-append"></i>
                    <input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere" placeholder="{{ t('Where?') }}" value="{{ $qLocation }}" title="" data-placement="bottom" data-toggle="tooltip" type="button" data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
                    <input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
                    <input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">
                </div>

                <!-- <div class="col-md-6 px-xs-0 pr-md-0 mb-md-30 d-flex ">
                    <div class="col-md-8"></div>
                    <button class="btn btn-block btn-primary mt-auto p-2 col-md-4">
                        <i class="fa fa-search"></i> <strong>{{ t('Search') }}</strong>
                    </button>
                </div> -->
            </div>
            <!-- {!! csrf_field() !!} -->
        <!-- </form> -->
        */ ?>

<?php $options = [
	0 => t('Select'),
	1 => t('all partners'),
	2 => t('my favorites'),
]
$attr = ['countryCode' => config('country.icode')];
?>
{{ Form::select('tabs',$options,'',['class'=>'tabs d-md-none d-lg-none d-xl-none d-xs-block']) }}
        <div class="custom-tabs mb-20 mb-xl-30">
             
            <ul class="tabs d-none d-md-block">
                <li><a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}" >{{t('all partners')}}</a></li>
                <li><a class="active">{{t('my favorites')}}</a></li>
            </ul>
        </div>

        <!-- <div class="row tab_content mb-40"> -->
<div class="row tab_content mb-40 partner-list">
<?php
if (!isset($cacheExpiration)) {
	$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
}
?>
@if (!empty($paginator) and $paginator->getCollection()->count() > 0 and auth()->user()->user_type_id=='3')
    <?php
if (!isset($cats)) {
	$cats = collect([]);
}

foreach ($paginator->getCollection() as $key => $user) {
    /*
	$model_id = \Auth::user()->id;
	$modeldata = \App\Models\UserProfile::where('user_id', $model_id)->first();
	$gender = \Auth::user()->gender_id;
	$parent_category = explode(',', $modeldata->parent_category);
	$count_match = DB::table('posts')->where(
		[
			['user_id', $user->id],
			['model_category_id', $modeldata->category_id],
			['ismodel', '1'],
			['gender_type_id', $gender],
			['height_from', '<=', $modeldata->height_id],
			['height_to', '>=', $modeldata->height_id],
			['weight_from', '<=', $modeldata->weight_id],
			['weight_to', '>=', $modeldata->weight_id],
			['dressSize_from', '<=', $modeldata->size_id],
			['dressSize_to', '>=', $modeldata->size_id],
			['verified_email', '1'],
		]
	)->orWhere(
		[
			['user_id', $user->id],
			['model_category_id', $modeldata->category_id],
			['ismodel', '1'],
			['gender_type_id', '2'],
			['height_from', '<=', $modeldata->height_id],
			['height_to', '>=', $modeldata->height_id],
			['weight_from', '<=', $modeldata->weight_id],
			['weight_to', '>=', $modeldata->weight_id],
			['dressSize_from', '<=', $modeldata->size_id],
			['dressSize_to', '>=', $modeldata->size_id],
			['verified_email', '1'],
		]);

	$count = $count_match->whereIN('category_id', $parent_category)->count();
    */
	// if ($count > 0) {

	// $profile = \App\Models\UserProfile::where('user_id', $user->id)->get();
	// $profile = $profile[0] ? $profile[0] : array();

    $logo = ($user->logo) ? $user->logo : '';

    if($logo !== "" && file_exists(public_path('uploads').'/'.$logo)){
        $logo = \Storage::url($user->logo);
    }else{
        $logo = url('images/icons/ico-nopic.png');
    }

	// $logo = (!empty($profile) && $profile->logo) ? \Storage::url($profile->logo) : '';
	// if (!empty($profile->logo)) {
	// 	$logo = \Storage::url($profile->logo);
	// } elseif (!empty($gravatar)) {
	// 	$logo = $gravatar;
	// } else {
	// 	$logo = url('images/icons/ico-nopic.png');
 //    }

	// echo "<pre>";
	// print_r($profile);
	// echo "</pre>";
	// exit;
	?>

        <div class="col-md-6 col-xl-3 mb-20">
            <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                <img src="{{ $logo }}" alt="{{ trans('metaTags.User') }}" />
                <!-- <a href="#" class="btn btn-white members invite position-absolute to-right to-top-20 mini-all"></a> -->
            </div>
            <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                    <span class="d-block">partner # {{ $user->id }}</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">{{ $user->username }}</span>
                </div>
                <span class="title">{{ $user->name }}</span>
                <span>
                    <!-- <strong><i class="fa fa-map-marker"></i></strong> -->
                    <img src="{{ url('images/flags/16/' . strtolower($user->country_code) . '.png') }}" data-toggle="tooltip" title="{{ $user->country_code }}" alt="{{ strtolower($user->country_code) . '.png' }}">
                </span>
                <div class="divider"></div>
                

                    @if(isset($user->description) && $user->description !== "")
                        <p class="mb-70"><?php echo str_limit(strip_tags($user->description), config('constant.title_limit')); ?></p>
                    @endif

                    <?php /*// $company = \App\Models\Company::where('user_id', $user->id)->get();
                    @foreach ($company as $com)
                        <a href="">{{ mb_ucfirst($com->name) }}</a>
                        <br>
                        {{ $com->description }}
                    @endforeach */ ?>
                 
                 <?php $created_at = \Date::parse($user->created_at)->timezone(config('timezone.id')); ?>

                <span class="info posted mb-20">{{ $created_at }}</span>
                    <?php  /* // $created_at = \Date::parse($profile->created_at)->timezone(config('timezone.id'));
	                   $cd = $profile->created_at->ago();
                    ?>
                    {{ $cd }} */?>
                
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20 saved-partner active" data-partner-id="{{ $user->id }}" id="saved-{{ $user->id }}"></a>

                    <?php /* ?>
                    @if (auth()->check())
                        @if (\App\Models\Favorite::where('user_id',  \Auth::user()->id)->where('fav_user_id', $user->id)->count() <= 0)
                        <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-partner" data-partner-id="{{ $user->id }}" id="save-{{ $user->id }}"></a>
                        @else
                        <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20 saved-partner active" data-partner-id="{{ $user->id }}" id="saved-{{ $user->id }}"></a>
                        @endif
                    @else
                        <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-partner" data-partner-id="{{ $profile->id }}" id="save-{{ $user->id }}"></a>
                    @endif
                    <?php */?>
                    <!-- <a href="#" class="btn btn-white favorite mini-all make-favorite-partner"></a> -->
                </div>
            </div>
        </div>

        <!--/.job-item-->
    <?php
// }

}?>
@else
    <div class="col-md-12 col-xl-3 mb-20">
        @if (\Illuminate\Support\Str::contains(\Route::currentRouteAction(), 'Search\CompanyController'))
            {{ t('No jobs were found for this company') }}
        @else
            {{ t('No result, Refine your search using other criteria') }}
        @endif
    </div>
@endif
        </div>
    </div>

    @if(!empty($paginator))
    <div class="pagination-bar text-center">
        @include('loadPagination', ['paginator' => $paginator])
    </div>
    @endif

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

         $(document).ready(function(){
            $("select[name='tabs']").on('change', function() {
                if($(this).val() == 1){
                  window.location='{{ lurl(trans('routes.partner-list', $attr), $attr) }}';
                }
                if($(this).val() == 2){
                  window.location='{{ route('favorite-partners') }}';
                }
            });

            $('.keyword').on('keyup',function(){
                $.ajax({
                    url: '{{ lurl("favorite-partners", $attr) }}',
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
                    url: '{{ lurl("favorite-partners", $attr) }}',
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
                    url: '{{ lurl("favorite-partners", $attr) }}',
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
                    url: '{{ lurl("favorite-partners", $attr) }}',
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

        });
</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
@endsection