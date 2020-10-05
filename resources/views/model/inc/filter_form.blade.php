<?php
use Illuminate\Support\Facades\Request;

$keywords = rawurldecode(Request::input('search_content'));
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : Request::input('c');
    /*
    // $fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
    // $tmpExplode = explode('?', $fullUrl);
    // $fullUrlNoParams = current($tmpExplode);
    */

$attr = ['countryCode' => config('country.icode'), 'slug' => t('favourites')];

$formUrl = lurl(trans('routes.model-list'));
if(isset($favourite)){
    if($favourite == 1){
       $formUrl = lurl(trans('routes.v-model-list', $attr), $attr);
    }
}

if( \Auth()->check() ){
    $country_code = isset(auth()->user()->country->code)? auth()->user()->country->code : config('app.default_units_country');
}
?>

<?php
/*
// use Illuminate\Support\Facades\Request;

// // Location
// if (isset($city) and !empty($city)) {
//     $qLocationId = (isset($city->id)) ? $city->id : 0;
//     $qLocation = $city->name;
//     $qAdmin = Request::input('r');
// } else {
//     $qLocationId = Request::input('l');
//     $qLocation = (Request::filled('r')) ? t('area:') . rawurldecode(Request::input('r')) : Request::input('location');
//     $qAdmin = Request::input('r');
// }
*/
?>

<style type="text/css">
    .multiple-select-div ul.select2-selection__rendered {
        line-height: 22px !important;
    }
    .multiple-select-div .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e3eaff;
        border: 1px solid #e3eaff;
    }
</style>
<form role="form" action="{{ $formUrl }}" method="POST" id="model-filter-form">
    {!! csrf_field() !!}
    <input type="hidden" name="is_filter" value="1">
    <input type="hidden" name="country_code" value="{{ $country_code }}" id="country_code">

    <input type="hidden" name="is_place" value="1" id="is_place_select">

    <div class="row bg-white box-shadow filter-area py-30 px-38 mb-40 mx-0">
            
            <div class="row">
                <div class="col-md-6 input-group">
                    {{ Form::text('search_content', $keywords, ['id' => 'qsearch', 'class' => 'search', 'placeholder' => t('What?') ]) }}
                </div>

                <?php /* echo Request::get('category_id'); 
                    <!-- <div class="col-md-6 col-xs-6"> */ ?>
                <div class="col-md-6 input-group multiple-select-div remove-focus">
                    <select  name="category_id[]" id="catSearch"  class="form-control select-2 multiple-select-category" multiple="true">
                        <?php /*
                        <!-- <option value="" data-value="" {{-- ($qCategory=='') ? 'selected="selected"' : '' --}}> {{-- t('All Categories') --}} </option> --> */ ?>
                        @if (isset($cats) and $cats->count() > 0)
                            
                            <?php /* 
                            @foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
                                <option {{ (Request::get('category_id') == $itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
                            @endforeach
                             */ ?>
                            
                            @foreach ($cats as $itemCat)
                            
                            <?php $CategoryIdChecked = (Request::get('category_id'))? Request::get('category_id') : old('category_id'); ?>

                                <?php /* 
                                <option data-value="{{ $itemCat->is_baby_model }}" {{ (Request::get('category_id') == $itemCat->parent_id || old('category_id') == $itemCat->parent_id) ? ' selected="selected"' : '' }} value="{{ $itemCat->parent_id }}" > {{ $itemCat->name }} </option> */ ?>

                                <option data-value="{{ $itemCat->is_baby_model }}" value="{{ $itemCat->parent_id }}"
                                        @if($CategoryIdChecked)
                                            @if ( in_array($itemCat->parent_id , $CategoryIdChecked) )
                                                selected="selected"
                                            @endif
                                        @endif
                                > {{ $itemCat->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <?php /*
           <!--  <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30"></div> --> */ ?>
            
            <div class="row"> 
                
                <div class="col-md-6 input-group remove-focus">
                    <select  name="countryid" id="countryid"  class="form-control select-2 country-auto-search" >
                        <option value="" data-value="" {{ (old('countryid')=='') ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
                        @if(isset($countries) && count($countries) > 0)
                            @foreach ($countries as $item)
                                <option value="{{ $item->get('code') }}" {{ (Request::get('countryid') == $item->get('code') || old('countryid') == $item->get('code')) ? ' selected="selected"' : '' }} >{{ $item->get('asciiname') }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- city -->
                <div class="col-md-6 input-group remove-focus">
                    <?php /* 
                    <select id="locSearch" name="cityid" class="form-control city-auto-search">
                        <option value="" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}>{{ t('Select a city') }}</option>
                    </select> */ ?>
                    <input type="text" name="city" placeholder="{{ t('Enter city') }}" id="pac-input" value="{{ (Request::get('city')) ? Request::get('city') : '' }}" class="search" style="display: none;">

                    <input type="hidden" name="latitude" value="{{ (Request::get('latitude')) ? Request::get('latitude') : '' }}" id="latitude">
                    <input type="hidden" name="longitude" value="{{ (Request::get('longitude')) ? Request::get('longitude') : '' }}" id="longitude">
                </div>
                <!-- End city -->
            </div>
            <div class="row" id="distance_range" style="display: none;">
                <!-- Radius -->
                <div class="col-md-6 input-group remove-focus">
                    <div class="custom-bootstrap-slider flex-xl-grow-1">
                        <div class="w-md-330 mx-auto mx-xl-0"  >
                            <span id="tooltip-miles">{{ t('Within show') }}</span>
                            <input id="radius" name="radius" data-slider-id='radiusSlider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ (Request::get('radius')) ? Request::get('radius') : '' }}"/>
                        </div>
                    </div>
                </div>
                <!-- End country -->
            </div>

            <?php /*
            <!-- <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30"></div> --> */ ?>

            <?php 
                $request_gender_id = old('gender_id');
                if(Request::get('gender_id')){
                    $request_gender_id = Request::get('gender_id');
                }
            ?>
            <div class="row">

                <!-- gender -->
                <div class="col-md-6 remove-focus">
                    <div class="input-group remove-focus">
                        <select name="gender_id" id="f_gender_value"  class="form-control select-2 form-select2">
                            <option value=""> {{ t('Gender') }} </option>
                            <option value="0" {{ (old('gender_id') == '0') ? 'selected' : '' }}>{{ t("Both") }} </option>
                            @if ($genders->count() > 0)
                                @foreach ($genders as $gender)
                                <option value="{{ $gender->tid }}" {{ ( $gender->tid == $request_gender_id) ? 'selected' : '' }}>{{ t($gender->name) }} </option>
                              @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- End gender -->
                <!-- Hair Color -->
                <div class="col-md-6 remove-focus">
                    <div class="input-group multiple-select-div remove-focus">
                        <select name="hairColor[]" id="f_blocHairColor" class="form-control multiple-select-hairColor select-2" multiple="true" >
                            @if(isset($hairColors) && count($hairColors) > 0)
                            <?php $hairColorsChecked = (Request::get('hairColor'))? Request::get('hairColor') : old('hairColor'); ?>
                            @foreach($hairColors as $key => $hairColor)
                                <option value="{{ $key }}"
                                        @if($hairColorsChecked)
                                            @if ( in_array($key , $hairColorsChecked) )
                                                selected="selected"
                                            @endif
                                        @endif
                                > {{ $hairColor }}</option>
                            @endforeach
                            @endif
                            <input type="hidden" id="hairColorQueryString" value="{{ httpBuildQuery(Request::except(['type'])) }}">
                        </select>
                    </div>
                </div>
                <!-- End Hair Color -->
            </div>
            <div class="row">
                <!-- Eye color -->
                <div class="col-md-6 remove-focus">
                    <div class="input-group multiple-select-div remove-focus">
                        <select name="eyeColor[]" id="f_blocEyeColor" class="form-control multiple-select-eyeColor select-2" multiple="true">
                            @if(isset($eyeColors) && count($eyeColors) > 0)
                            
                            <?php $eyeColorsChecked = (Request::get('eyeColor'))? Request::get('eyeColor') : old('eyeColor'); ?>

                            @foreach ($eyeColors as $key => $eyeColor)
                                <option value="{{ $key }}"
                                        @if($eyeColorsChecked)
                                            @if (in_array($key , $eyeColorsChecked))
                                                selected="selected"
                                            @endif
                                        @endif
                                > {{ $eyeColor }}</option>
                            @endforeach
                            @endif
                            <input type="hidden" id="f_eyeColorQueryString" value="{{ httpBuildQuery(Request::except(['type'])) }}">
                        </select>
                    </div>
                </div>
                <!-- End Eye color -->
                <!-- Skin Color  -->
                <div class="col-md-6 remove-focus">
                    <div class="input-group multiple-select-div remove-focus">
                        <select name="skinColor[]"  id="blocSkinColor" class="form-control multiple-select-skinColor select-2" multiple="true">
                            @if(isset($skinColors) && count($skinColors) > 0)

                            <?php $skinColorsChecked = (Request::get('skinColor'))? Request::get('skinColor') : old('skinColor'); ?>

                            @foreach($skinColors as $key => $skinColor)
                                <option value="{{ $key }}"
                                        @if($skinColorsChecked)
                                            @if( in_array($key , $skinColorsChecked) )
                                                selected="selected"
                                            @endif
                                        @endif
                                > {{ $skinColor }}</option>
                            @endforeach
                            @endif
                            <input type="hidden" id="skinColorQueryString" value="{{ httpBuildQuery(Request::except(['type'])) }}">
                        </select>
                    </div>
                </div>
                <!--End Skin Color  -->
            </div>
            <!-- Height -->
            <div class="row model-filter">
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select  name="minHeight" id="minHeight" class="form-control select-2 form-select2">
                        <option value=""> {{ t('height_min') }} </option>
                        @if(isset($properties['height']) && count($properties['height']) > 0)
                        <?php  $minHeightSelected = (Request::get('minHeight'))? Request::get('minHeight') : old('minHeight'); ?>
                        @foreach($properties['height'] as $key => $height)
                            <option value="{{ $key }}" {{ ( $minHeightSelected == $key ) ? 'selected' : '' }}>{{ $height }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 input-group remove-focus">
                    <select name="maxHeight" id="maxHeight" class="form-control select-2 form-select2">
                        <option value=""> {{ t('height_max') }} </option>
                        @if(isset($properties['height']) && count($properties['height']) > 0)
                        <?php  $maxHeightSelected = (Request::get('maxHeight'))? Request::get('maxHeight') : old('maxHeight'); ?>
                        @foreach($properties['height'] as $key => $height)
                            <option value="{{ $key }}" {{ ( $maxHeightSelected == $key ) ? 'selected' : '' }}>{{ $height }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        <!-- End Height -->
        <!-- Weight -->
            <div class="row model-filter">
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select  name="minWeight" id="minWeight" class="form-control select-2 form-select2">
                        <option value=""> {{ t('weight_min') }} </option>
                        @if(isset($properties['weight']) && count($properties['weight']) > 0)
                        <?php  $minWeightSelected = (Request::get('minWeight'))? Request::get('minWeight') : old('minWeight'); ?>
                        @foreach($properties['weight'] as $key => $weight)
                            <option value="{{ $key }}" {{ ( $minWeightSelected == $key ) ? 'selected' : '' }}>{{ $weight }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select name="maxWeight" id="maxWeight" class="form-control select-2 form-select2">
                        <option value=""> {{ t('weight_max') }} </option>
                        @if(isset($properties['weight']) && count($properties['weight']) > 0)
                        <?php  $maxWeightSelected = (Request::get('maxWeight'))? Request::get('maxWeight') : old('maxWeight'); ?>
                        @foreach($properties['weight'] as $key => $weight)
                            <option value="{{ $key }}" {{ ( $maxWeightSelected == $key ) ? 'selected' : '' }}>{{ $weight }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        <!-- End Weight -->
        <!-- Chest -->
            <div class="row model-filter">
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select  name="minChest" id="minChest" class="form-control select-2 form-select2">
                        <option value=""> {{ t('chest_min') }} </option>
                        @if(isset($properties['chest']) && count($properties['chest']) > 0)
                            <?php  $minChestSelected = (Request::get('minChest'))? Request::get('minChest') : old('minChest'); ?>

                            @foreach($properties['chest'] as $ck => $chestFrom)
                                <option value="{{ $ck }}" {{ ( $minChestSelected == $ck ) ? 'selected' : '' }}>{{ $chestFrom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select name="maxChest" id="maxChest" class="form-control select-2 form-select2">
                        <option value=""> {{ t('chest_max') }} </option>
                        @if(isset($properties['chest']) && count($properties['chest']) > 0)
                        
                            <?php  $maxChestSelected = (Request::get('maxChest'))? Request::get('maxChest') : old('maxChest'); ?>

                            @foreach($properties['chest'] as $ckt => $chestTo)
                                <option value="{{ $ckt }}" {{ ( $maxChestSelected == $ckt ) ? 'selected' : '' }}>{{ $chestTo }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        <!-- End Chest -->
        <!-- Waist -->
            <div class="row model-filter">
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select  name="minWaist" id="minWaist" class="form-control select-2 form-select2">
                        <option value=""> {{ t('waist_min') }} </option>
                        @if(isset($properties['waist']) && count($properties['waist']) > 0)

                            <?php  $minWaistSelected = (Request::get('minWaist'))? Request::get('minWaist') : old('minWaist'); ?>
                            @foreach($properties['waist'] as $wk => $waistFrom)
                                <option value="{{ $wk }}" {{ ( $minWaistSelected == $wk ) ? 'selected' : '' }}>{{ $waistFrom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select name="maxWaist" id="maxWaist" class="form-control select-2 form-select2">
                        <option value=""> {{ t('waist_max') }} </option>
                        @if(isset($properties['waist']) && count($properties['waist']) > 0)
                        
                            <?php  $maxWaistSelected = (Request::get('maxWaist'))? Request::get('maxWaist') : old('maxWaist'); ?>

                            @foreach($properties['waist'] as $wkt => $waistTo)
                                <option value="{{ $wkt }}" {{ ( $maxWaistSelected == $wkt ) ? 'selected' : '' }}>{{ $waistTo }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        <!-- End Waist -->
        <!-- Hips -->
            <div class="row model-filter">
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select  name="minHips" id="minHips" class="form-control select-2 form-select2">
                        <option value=""> {{ t('hips_min') }} </option>
                        @if(isset($properties['hips']) && count($properties['hips']) > 0)

                            <?php  $minHipsSelected = (Request::get('minHips'))? Request::get('minHips') : old('minHips'); ?>
                            @foreach($properties['hips'] as $hk => $hipsFrom)
                                <option value="{{ $hk }}" {{ ( $minHipsSelected == $hk ) ? 'selected' : '' }}>{{ $hipsFrom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <!-- <div class="col-md-6 col-xs-6"> -->
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select name="maxHips" id="maxHips" class="form-control select-2 form-select2">
                        <option value=""> {{ t('hips_max') }} </option>
                        @if(isset($properties['hips']) && count($properties['hips']) > 0)
                        
                            <?php  $maxHipsSelected = (Request::get('maxHips'))? Request::get('maxHips') : old('maxHips'); ?>

                            @foreach($properties['hips'] as $hkt => $hipsTo)
                                <option value="{{ $hkt }}" {{ ( $maxHipsSelected == $hkt ) ? 'selected' : '' }}>{{ $hipsTo }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        <!-- End  Hips -->
        <!-- Age -->
            <div class="row model-filter">
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select  name="minAge" id="minAge" class="form-control select-2 form-select2">
                        <option value=""> {{ t('age_min') }} </option>
                        @if(isset($properties['age']) && count($properties['age']) > 0)

                        <?php  $minAgeSelected = (Request::get('minAge'))? Request::get('minAge') : old('minAge'); ?>

                        @foreach($properties['age'] as $key => $ageFrom)
                            <option value="{{ $key }}" {{ ( $minAgeSelected == $key ) ? 'selected' : '' }}>{{ $ageFrom }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 input-group remove-focus">
                    <select name="maxAge" id="maxAge" class="form-control select-2 form-select2">
                        <option value=""> {{ t('age_max') }} </option>
                        @if(isset($properties['age']) && count($properties['age']) > 0)
                        
                        <?php $maxAgeSelected = (Request::get('maxAge'))? Request::get('maxAge') : old('maxAge'); ?>

                        @foreach($properties['age'] as $key =>  $ageTo)
                            <option value="{{ $key }}" {{ ( $maxAgeSelected == $key ) ? 'selected' : '' }}>{{ $ageTo }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        <!-- End Age -->

            <?php 
                $request_tattoo_id = old('tattoo');
                if(Request::get('tattoo') !== ""){
                    $request_tattoo_id = Request::get('tattoo');
                }
            ?>
            <div class="row">
                <!-- gender -->
                <div class="col-md-6 remove-focus">
                    <div class="input-group remove-focus">
                        <select name="tattoo" id="tattoo_value"  class="form-control select-2">
                            <option value=""> {{ t('Tattoo') }} </option>
                            <option value="1" {{ ($request_tattoo_id === '1') ? 'selected' : '' }}>{{ t("Yes") }} </option>
                            <option value="2" {{ ($request_tattoo_id === '2') ? 'selected' : '' }}>{{ t("No") }} </option>
                        </select>
                    </div>
                </div>
            </div>

        <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="form-group custom-checkbox col-md-12 mb-30 accordion-header" id="dress_checkbox_kids">
                    <div>
                        <div>
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseBabyDress">
                                <span class="bold mb-20">{{ t('baby_dress_size_lable') }}</span>
                            </a>
                        </div>
                        <div id="collapseBabyDress" class="collapse" data-parent="#accordion">
                            <div class="row mx-0">
                                <?php $checked = ($dress_kids_check_all == 1 || old('dress_kids_check_all') == 1)? 'checked="checked"' : ''; ?>
                                <input class="checkbox_field" id="dress_kids_all" value="1" name="dress_kids_check_all" type="checkbox" {{ $checked }}>
                                <label for="dress_kids_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                            </div>
                            <div class="row mx-0">
                                @if(isset($properties['dress_unit_kids']))
                                    @foreach($properties['dress_unit_kids'] as $key => $dressSize)
                                    <?php
                                        $checked = "";

                                        if (isset($selectedDressSizeKids) && !empty($selectedDressSizeKids)) {
                                            if(in_array($key, $selectedDressSizeKids)){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                        if (old('dress_size_kids') && !empty(old('dress_size_kids'))) {
                                            if(in_array($key, old('dress_size_kids'))){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                    ?>
                                    <input class="checkbox_field dressSize bds" id="option_dress_kids_{{ $key }}" value="{{ $key }}" name="dress_size_kids[]" type="checkbox" {{ $checked }}>
                                    <label for="option_dress_kids_{{ $key }}" class="checkbox-label col-sm-2" >{{ $dressSize }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group custom-checkbox col-md-12 mb-30 accordion-header" id="dress_checkbox_men">
                    <div>
                        <div>
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseMenDress">
                                <span class="bold mb-20">{{ t('men_dress_size_lable') }}</span>
                            </a>
                        </div>
                        <div id="collapseMenDress" class="collapse" data-parent="#accordion">
                            <div class="row mx-0">
                                <?php $checked = ( $dress_men_check_all == 1 || old('dress_men_check_all') == 1 )? 'checked="checked"' : ''; ?>
                                <input class="checkbox_field" id="dress_men_all" name="dress_men_check_all" value="1" type="checkbox" {{ $checked }}>
                                <label for="dress_men_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                            </div>
                            <div class="row mx-0">
                                @if(isset($properties['dress_unit_men']))
                                    @foreach($properties['dress_unit_men'] as $key => $dressSize)
                                    <?php
                                        $checked = "";

                                        if (isset($selectedDressSizeMen) && !empty($selectedDressSizeMen)) {
                                            if(in_array($key, $selectedDressSizeMen)){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                        if (old('dress_size_men') && !empty(old('dress_size_men'))) {
                                            if(in_array($key, old('dress_size_men'))){
                                                $checked = 'checked="checked"';
                                            }
                                        }
                                    ?>
                                    <input class="checkbox_field dressSize mds" id="option_dress_men_{{ $key }}" value="{{ $key }}" name="dress_size_men[]" type="checkbox" {{ $checked }}>
                                    <label for="option_dress_men_{{ $key }}" class="checkbox-label col-sm-2" >{{ $dressSize }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group custom-checkbox col-md-12 mb-30 accordion-header" id="dress_checkbox_women">
                    <div>
                        <div>
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseWomenDress">
                                <span class="bold mb-20">{{ t('women_dress_size_lable') }}</span>
                            </a>
                        </div>
                        <div id="collapseWomenDress" class="collapse" data-parent="#accordion">
                            <div class="row mx-0">
                                <?php $checked = ($dress_women_check_all == 1 || old('dress_women_check_all') == 1 )? 'checked="checked"' : ''; ?>
                                <input class="checkbox_field" id="dress_women_all" name="dress_women_check_all" value="1" type="checkbox" {{ $checked }}>
                                <label for="dress_women_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                            </div>
                            <div class="row mx-0">
                                @if(isset($properties['dress_unit_women']))
                                    @foreach($properties['dress_unit_women'] as $key => $dressSize)
                                    <?php
                                        $checked = "";

                                        if (isset($selectedDressSizeWomen) && !empty($selectedDressSizeWomen)) {
                                            if(in_array($key, $selectedDressSizeWomen)){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                        if (old('dress_size_women') && !empty(old('dress_size_women'))) {
                                            if(in_array($key, old('dress_size_women'))){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                    ?>
                                    <input class="checkbox_field dressSize wds" id="option_dress_women_{{ $key }}" value="{{ $key }}" name="dress_size_women[]" type="checkbox" {{ $checked }}>
                                    <label for="option_dress_women_{{ $key }}" class="checkbox-label col-sm-2" >{{ $dressSize }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group custom-checkbox col-md-12 mb-30 accordion-header" id="shoe_checkbox_kids">
                    <div>
                        <div>
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseBabyShoes">
                                <span class="bold mb-20">{{ t('baby_shoe_size_lable') }}</span>
                            </a>
                        </div>
                        <div id="collapseBabyShoes" class="collapse" data-parent="#accordion">
                            <div class="row mx-0">
                                <?php $checked = ($shoe_kid_check_all == 1 || old('shoe_kid_check_all') == 1 )? 'checked="checked"' : ''; ?>
                                <input class="checkbox_field" id="shoe_kid_all" name="shoe_kid_check_all" value="1" type="checkbox" {{ $checked }}>
                                <label for="shoe_kid_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                            </div>
                            <div class="row mx-0">
                                @if(isset($properties['shoe_unit_kids']))
                                    @foreach($properties['shoe_unit_kids'] as $key => $shoeSize)
                                    <?php
                                        $checked = "";

                                        if (isset($selectedShoeSizeKids) && !empty($selectedShoeSizeKids)) {
                                            if(in_array($key, $selectedShoeSizeKids)){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                        if (old('shoe_size_kids') && !empty(old('shoe_size_kids'))) {
                                            if(in_array($key, old('shoe_size_kids'))){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                    ?>
                                    <input class="checkbox_field shoeSize kids-shoe" id="option_shoe_kids_{{ $key }}" value="{{ $key }}" name="shoe_size_kids[]" type="checkbox" {{ $checked }}>
                                    <label for="option_shoe_kids_{{ $key }}" class="checkbox-label col-sm-2" >{{ $shoeSize }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group custom-checkbox col-md-12 mb-30 accordion-header" id="shoe_checkbox_men">
                    <div>
                        <div>
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseMenShoes">
                                <span class="bold mb-20">{{ t('men_shoe_size_lable') }}</span>
                            </a>
                        </div>
                        <div id="collapseMenShoes" class="collapse" data-parent="#accordion">
                            <div class="row mx-0">
                                <?php $checked = ($shoe_men_check_all == 1 || old('shoe_men_check_all') == 1 )? 'checked="checked"' : ''; ?>
                                <input class="checkbox_field" id="shoe_men_all" name="shoe_men_check_all" value="1" type="checkbox" {{ $checked }}>
                                <label for="shoe_men_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                            </div>
                            <div class="row mx-0">
                                @if(isset($properties['shoe_unit_men']))
                                    @foreach($properties['shoe_unit_men'] as $key => $shoeSize)
                                    <?php
                                        $checked = "";

                                        if (isset($selectedShoeSizeMen) && !empty($selectedShoeSizeMen)) {
                                            if(in_array($key, $selectedShoeSizeMen)){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                        if (old('shoe_size_men') && !empty(old('shoe_size_men'))) {
                                            if(in_array($key, old('shoe_size_men'))){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                    ?>
                                    <input class="checkbox_field shoeSize men-shoe" id="option_shoe_men_{{ $key }}" value="{{ $key }}" name="shoe_size_men[]" type="checkbox" {{ $checked }}>
                                    <label for="option_shoe_men_{{ $key }}" class="checkbox-label col-sm-2" >{{ $shoeSize }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group custom-checkbox col-md-12 mb-30 accordion-header" id="shoe_checkbox_women">
                    <div>
                        <div>
                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseWomenShoes">
                                <span class="bold mb-20">{{ t('women_shoe_size_lable') }}</span>
                            </a>
                        </div>
                        <div id="collapseWomenShoes" class="collapse" data-parent="#accordion">
                            <div class="row mx-0">
                                <?php $checked = ($shoe_men_check_all == 1 || old('shoe_women_check_all') == 1)? 'checked="checked"' : ''; ?>
                                <input class="checkbox_field" id="shoe_women_all" name="shoe_women_check_all" value="1" type="checkbox" {{ $checked }}>
                                <label for="shoe_women_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                            </div>
                            <div class="row mx-0">
                                @if(isset($properties['shoe_unit_women']))
                                    @foreach($properties['shoe_unit_women'] as $key => $shoeSize)
                                    <?php
                                        $checked = "";

                                        if (isset($selectedShoeSizeWomen) && !empty($selectedShoeSizeWomen)) {
                                            if(in_array($key, $selectedShoeSizeWomen)){
                                                $checked = 'checked="checked"';
                                            }
                                        }

                                        if (old('shoe_size_women') && !empty(old('shoe_size_women'))) {
                                            if(in_array($key, old('shoe_size_women'))){
                                                $checked = 'checked="checked"';
                                            }
                                        }


                                    ?>
                                    <input class="checkbox_field shoeSize women-shoe" id="option_shoe_women_{{ $key }}" value="{{ $key }}" name="shoe_size_women[]" type="checkbox" {{ $checked }}>
                                    <label for="option_shoe_women_{{ $key }}" class="checkbox-label col-sm-2" >{{ $shoeSize }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php /*
        <!-- Dress size -->
            <div class="row">
                <div class="col-md-6 input-group">
                    <select  name="minDressSize" id="minDressSize" class="form-control">
                        <option value=""> {{ t('dresssize_min') }} </option>
                        @foreach($properties['dress_size'] as $key => $dressSize)
                            <option value="{{ $key }}" {{ (Request::get('minDressSize')==$key) ? 'selected' : '' }}>{{ $dressSize }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="minDressSize_selected" value="{{ $minDressSize }}">
                </div>
                <div class="col-md-6 input-group">
                    <select name="maxDressSize" id="maxDressSize" class="form-control">
                        <option value=""> {{ t('dresssize_max') }} </option>
                        @foreach($properties['dress_size'] as $key => $dressSize)
                            <option value="{{ $key }}" {{ (Request::get('maxDressSize')==$key) ? 'selected' : '' }}>{{ $dressSize }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="maxDressSize_selected" value="{{ $maxDressSize }}">
                </div>
            </div>
        <!-- End Dress size -->
        <!-- Shoe size -->
            <div class="row">
                <div class="col-md-6 input-group">
                    <select  name="minShoeSize" id="minShoeSize" class="form-control">
                        <option value=""> {{ t('shoesize_min') }} </option>
                        @foreach($properties['shoe_size'] as $key => $shoeSize)
                            <option value="{{ $key }}" {{ (Request::get('minShoeSize')==$key) ? 'selected' : '' }}>{{ $shoeSize }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="minShoeSize_selected" value="{{ $minshoeSize }}">
                </div>
                <!-- <div class="col-md-6 col-xs-6"> -->
                <div class="col-md-6 input-group">
                    <select name="maxShoeSize" id="maxShoeSize" class="form-control">
                        <option value=""> {{ t('shoesize_max') }} </option>
                        @foreach($properties['shoe_size'] as $key => $shoeSize)
                            <option value="{{ $key }}" {{ (Request::get('maxShoeSize')==$key) ? 'selected' : '' }}>{{ $shoeSize }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="maxShoeSize_selected" value="{{ $maxshoeSize }}">
                </div>
            </div>
        <!-- End Shoe size -->

        */ ?>
        <div class="d-lg-flex justify-content-xl-start">
            <button type="submit" id="submit-filter" class="btn btn-success white-search mini-under-desktop mr-20">{{ t('Search') }}</button>
            <a  href="javascript:void(0);" id="clear-all" class="bold text-decoration-underline btn-clear mini-under-desktop mr-20">{{ t('Clear all') }}</a>
        </div>
    </div>
</form>

