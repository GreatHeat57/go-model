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

$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
$tmpExplode = explode('?', $fullUrl);
$fullUrlNoParams = current($tmpExplode);

?>
<form id="seach" name="search" action="{{ $fullUrlNoParams }}" method="POST">
	<div class="row justify-content-md-between searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
  		<div class="row">
	        <div class="col-md-4 input-group">
	            {{ Form::text('search_content', $keywords, ['id' => 'qsearch', 'class' => 'search', 'placeholder' => t('What?') ]) }}
	        </div>
	        <div class="col-md-4 input-group">
                <select  name="category_id" id="catSearch" class="form-control custom-select-2" >
                    <option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
                    @if (isset($cats) and $cats->count() > 0)
                        @foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
                            <option {{ (Request::get('category_id') == $itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
                        @endforeach
                    @endif
                </select>
            </div>
	        <div class="col-md-4 input-group">
                <select id="locSearch" name="cityid" class="form-control custom-select-2">
                	@if(isset($cities) and !empty($cities))
                		@foreach($cities as $c)
                			<option value="{{ $c->id }}">{{ $c->name }}</option>
                		@endforeach
                	@endif
                    <!-- <option value="" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}>
                        {{ t('Select a city') }}
                    </option> -->
                </select>
	        </div>
	    </div>
	    {!! csrf_field() !!}
	    <div class="d-lg-flex justify-content-lg-between justify-content-xl-start">
            <a href="{{ url()->current() }}" class="btn btn-success reset mini-under-desktop">{{ t('Clear all') }}</a>
            <button type="submit" id="submit-filter" class="btn btn-white search mini-under-desktop mr-20">{{ t('Search') }}</button>
        </div>
	</div>
</form>
        <?php /*
<div class="container">
	<div class="search-row-wrapper">
		<div class="container">
			<?php $attr = ['countryCode' => config('country.icode')]; ?>
			<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<input name="q" class="form-control keyword" type="text" placeholder="{{ t('What?') }}" value="{{ $keywords }}">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<select name="c" id="catSearch" class="form-control selecter">
						<option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
						@if (isset($cats) and $cats->count() > 0)
							@foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
								<option {{ ($qCategory==$itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 search-col locationicon">
					<i class="icon-location-2 icon-append"></i>
					<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
						   placeholder="{{ t('Where?') }}" value="{{ $qLocation }}" title="" data-placement="bottom"
						   data-toggle="tooltip" type="button"
						   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
				</div>

				<input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
				<input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<button class="btn btn-block btn-primary">
						<i class="fa fa-search"></i> <strong>{{ t('Search') }}</strong>
					</button>
				</div>
				{!! csrf_field() !!}
			</form>
		</div>
	</div>
	<!-- /.search-row  width: 24.6%; -->
</div>

<?php */ ?>
<script type="text/javascript">
	$(".custom-select-2").select2({
        minimumResultsForSearch: Infinity,
        width: '100%'
    });
</script>