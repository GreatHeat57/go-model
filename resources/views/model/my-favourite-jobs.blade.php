@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')

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
                <h1 class="prata">{{ t('Favourite jobs') }}</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white filters mr-20 mini-under-desktop ">{{ t('Filters') }}</a>
                <a href="#" class="btn btn-white search mini-under-desktop active">{{ t('Search') }}</a>
            </div>
        </div>

       <?php $attr = ['countryCode' => config('country.icode')];?>
        <div class="row justify-content-md-between searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-auto">
                <!-- <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
                {!! csrf_field() !!} -->
                <input name="q" class="keyword" type="text" placeholder="{{t('search job')}}" value="{{ $keywords }}">
                <!-- {{ Form::submit('Keresés') }} -->
                <!-- </form> -->
            </div>
        </div>
            <!-- <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
                {!! csrf_field() !!} -->
                <div class="row bg-white box-shadow py-30 px-38 mb-40 mx-0">

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
                        <input type="text" id="locSearch" name="location" class="locinput input-rel searchtag-input has-icon tooltipHere"
                           placeholder="{{ t('Where?') }}" value="{{ $qLocation }}" title="" data-placement="bottom"
                           data-toggle="tooltip" type="button"
                           data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
                        <input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
                        <input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">
                    </div>

                    <!-- <div class="col-md-2 px-xs-0 pr-md-0 mb-md-30"> -->

                       <!--  <button class="btn btn-block btn-primary float-right">
                            <i class="fa fa-search"></i> <strong>{{ t('Search') }}</strong>
                        </button> -->
                    <!-- </div> -->
                </div>
            <!-- </form> -->
<?php $options = [
	0 => t('Select'),
	1 => t('work search'),
	2 => t('my favorites'),
]
?>
<!-- {{ Form::select('tabs',$options,'',['class'=>'tabs d-md-none d-lg-none d-xl-none d-xs-block']) }} -->
        <div class="custom-tabs mb-20 mb-xl-30">
            <ul class="d-none d-md-block">
                <?php $attr = ['countryCode' => config('country.icode')];?>
                <li><a href="{{ lurl(trans('routes.v-search', $attr), $attr) }}">{{ t('work search') }}</a></li>
                <li><a href="{{ URL('account/favourite') }}" class="active" data-id="2">{{t('my favorites')}}</a></li>
            </ul>
        </div>

        <div class="row mb-40 job-list">
            <?php
// print_r($posts);
if (isset($posts) && $posts->count() > 0) {
	foreach ($posts as $key => $post) {
		// Fixed 1

		if (!empty($post->post)) {
			$post = $post->post;
		}

		// Get Post's Country
		if ($post->city) {
			$country = $post->country->name;
		} else {
			$country = '-';
		}

		// Get Post's City
		if ($post->city) {
			$city = $post->city->name;
		} else {
			$city = '-';
		}

		// Get Post's Category
		if ($post->city) {
			$category = $post->category->name;
		} else {
			$category = '-';
		}

		// Get Post's Category
		if ($post->user) {
			$user_name = $post->user->name;
		} else {
			$user_name = '-';
		}
		?>
                <div class="col-md-6 mb-20">
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30 position-relative">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                            <span class="d-block">job # {{$post->id}}</span>
                            <span class="bullet rounded-circle bg-lavender d-block mx-2"></span>
                            <span class="d-block">{{$category}}</span>
                        </div>
                        <a href="{{ $post->uri }}"><span class="title">{{ $post->title }}</span></a>
                        <span>Jobart, Jobart</span>
                        <div class="divider"></div>
                        <div class="mb-30 job-desc-cls">{!! nl2br($post->description) !!}</div>
                        <!-- <span class="info city mb-10">{{ $city }} ,{{ $country}}</span> -->
                        <span class="info appointment mb-10">{{ $post->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</span>
                        <span class="info partner mb-30">{{$user_name}}</span>
                        <span class="info posted">posted 1 day ago</span>
                         @if (auth()->check())
                            @if (\App\Models\SavedPost::where('user_id',  \Auth::user()->id)->where('post_id', $post->id)->count() <= 0)
                            <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" data-post-id="{{ $post->id }}" id="save-{{ $post->id }}"></a>
                            @else
                            <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20 saved-job active" data-post-id="{{ $post->id }}" id="saved-{{ $post->id }}"></a>
                            @endif
                        @else
                            <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20 save-job" data-post-id="{{ $post->id }}" id="save-{{ $post->id }}"></a>
                        @endif
                    </div>
                </div>
            <?php }
} else {?>
     <div class="item-list">
        @if (\Illuminate\Support\Str::contains(\Route::currentRouteAction(), 'Search\CompanyController'))
            {{ t('No jobs were found for this company') }}
        @else
            {{ t('No result, Refine your search using other criteria') }}
        @endif
    </div>
<?php }?>
        </div>
    </div>
    <div class="pagination-bar text-center">
        @include('loadPagination', ['paginator' => $posts])
    </div>
    @include('childs.bottom-bar')
@endsection
@section('page-script')
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
                  window.location='{{ lurl(trans('routes.v-search', $attr), $attr) }}';
                }
                if($(this).val() == 2){
                  window.location='{{ URL('account/favourite') }}';
                }
            });

            $('.keyword').on('keyup',function(){
                $.ajax({
                    url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
                    data:'q='+ $(this).val()+'&c='+ $('#catSearch').val()+'&location='+ $('#locSearch').val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.job-list').html();
                        $('.job-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });

            });

            $('#catSearch').on('change',function(){
                $.ajax({
                    url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
                    data:'q='+ $('.keyword').val()+'&c='+ $(this).val()+'&location='+ $('#locSearch').val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.job-list').html();
                        $('.job-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });
            });

            $('#locSearch').on('change',function(){
                $.ajax({
                    url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
                    data:'q='+ $('.keyword').val()+'&c='+ $('#catSearch').val()+'&location='+ $(this).val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val(),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.job-list').html();
                        $('.job-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });
            });

            $(document).on('click','.pagination li a',function(e){
                $.ajax({
                    url: '{{ lurl(trans('routes.v-search', $attr), $attr) }}',
                    data:'q='+ $('.keyword').val()+'&c='+ $('#catSearch').val()+'&location='+ $(this).val()+'&l='+$('#lSearch').val()+'&r='+$('#rSearch').val()+'&page='+$(this).attr('data-page'),
                    type: 'get',
                    success: function (data) {
                        var $result = $(data).find('.job-list').html();
                        $('.job-list').html($result);
                        var $paginationlinks = $(data).find('.pagination-bar').html();
                        $('.pagination-bar').html($paginationlinks);
                    }
                });
            });

        });
</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
@endsection