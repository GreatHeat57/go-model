<?php
use Illuminate\Support\Facades\Requset;

// $fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
// $tmpExplode = explode('?', $fullUrl);
// $fullUrlNoParams = current($tmpExplode);


// Keywords
$keywords = rawurldecode(Request::input('search_content'));

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

$attr = ['countryCode' => config('country.icode'), 'slug' => t('favourites')];

$formUrl = lurl(trans('routes.model-list'));
if(isset($favourite)){
    if($favourite == 1){
       $formUrl = lurl(trans('routes.v-model-list', $attr), $attr);
    }
}
?>

<?php $attr = ['countryCode' => config('country.icode')]; ?>

 {{ Form::open(array('url' => $formUrl , 'method' => 'post', 'id' => 'model-search-form', 'name' => 'search' )) }}
    <input type="hidden" name="is_search" value="1">
    <div class="row bg-white box-shadow searchbar py-30 px-38 mb-40 mx-0">
       <!-- <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30"> -->
            <!-- <div class="d-flex col-md-12 col-xl-12">
                <div class="col-md-6 col-xs-6"> -->
            <div class="row">
                <div class="col-md-6 input-group">
                    {{ Form::text('search_content', $keywords, ['id' => 'qsearch', 'class' => 'search', 'placeholder' => t('What?') ]) }}
                </div>

                <?php //echo Request::get('category_id'); ?>
                <!-- <div class="col-md-6 col-xs-6"> -->
                <div class="col-md-6 input-group">
                    <select  name="category_id" id="catSearch" class="form-control" >
                        <option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
                        @if (isset($cats) and $cats->count() > 0)
                            
                            <?php /* 
                            @foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
                                <option {{ (Request::get('category_id') == $itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
                            @endforeach
                             */ ?>

                            @foreach ($cats as $itemCat)
                                <option {{ (Request::get('category_id') == $itemCat->parent_id) ? ' selected="selected"' : '' }} value="{{ $itemCat->parent_id }}"> {{ $itemCat->name }} </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        <?php /*
        <!-- </div> -->
        <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
            <!-- <div class="d-flex col-md-12 col-xl-12">
                <div class="col-md-6 col-xs-6"> -->
            <div class="row">
                <div class="col-md-6 input-group">
                    <select name="countryid" id="countryid" class="form-control">
                        <option value=""> {{ t('Select a country') }} </option>
                        @foreach ($countries as $item)
                        <option value="{{ $item->get('code') }}">{{ $item->get('name') }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <div class="col-md-6 col-xs-6"> -->
                <div class="col-md-6 input-group">
                    <select id="locSearch" name="location" class="form-control">
                        <option value="" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}>
                            {{ t('Select a city') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <?php */ ?>
        <input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
        <input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">
        <div class="d-lg-flex justify-content-lg-between justify-content-xl-start">
            <a href="{{ url()->current() }}" class="btn btn-success reset mini-under-desktop mr-20">{{ t('Clear all') }}</a>
            <button type="submit" id="submit-filter" class="btn btn-white search mini-under-desktop mr-20">{{ t('Search') }}</button>
        </div>
    </div>
</form>




