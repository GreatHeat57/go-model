@extends('layouts.logged_in.app-partner')

<?php
    $fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
    $tmpExplode = explode('?', $fullUrl);
    $fullUrlNoParams = current($tmpExplode);
    $attr = ['countryCode' => config('country.icode'), 'slug' => t('favourites')];
?>

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-40 position-relative">
            <div>
                <h1 class="text-center prata">{{t('Find model')}}</h1>
                <div class="divider mx-auto"></div>
                <p class="text-center mb-30 w-lg-596 mx-lg-auto">{{-- $count --}} {{-- t('Model(s) Found') --}}</p>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="javascript:void(0);" class="btn btn-white filters mini-all" title="{{ t('Filter Result') }}"></a>
                <?php /*
                <!-- <a href="javascript:void(0);" class="btn btn-white search mini-all"></a> --> */ ?>
            </div>
        </div>
 
        @include('childs.notification-message')
        @include('model.inc.filter_form')
 
        <?php /* @include('model.inc.search_form') */ ?>

        <?php
            $tabs = array();
            $tabs[ lurl(trans('routes.model-list')) ] = t('All models');
            $tabs[ lurl(trans('routes.v-model-list', $attr), $attr) ] = t('Favorite models');
        ?>
        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="tabs d-none d-md-block">
                <li><a href="{{ lurl(trans('routes.model-list')) }}" class="{{ !($favourite)? 'active' : '' }}">{{ t('All models')}}</a></li>
                <li><a href="{{ lurl(trans('routes.v-model-list', $attr), $attr) }}"  class="{{ ($favourite)? 'active' : '' }}">{{ t('Favorite models') }}</a></li>
            </ul>
        </div>
        
        @include('model.inc.categories')
        @include('model.inc.posts')
    </div>
    @include('childs.bottom-bar')
@endsection

@section('after_scripts')

<!-- Place Auto Complete start -->
{{ Html::script(config('app.cloud_url').'/assets/js/place-autocomplete.js') }}
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googlemaps.key')}}&libraries=places"></script>
<!-- Place Auto Complete End -->

<script>

    var autocomplete;
    var input = document.getElementById('pac-input');
    var options = { types: ['(cities)'] };
    autocomplete = new google.maps.places.Autocomplete(input, options);

    $('#countryid').bind('change', function(e){
        $('#pac-input').removeClass('border-bottom-error');
        var code = $("#countryid option:selected").val();
        $('#pac-input').val('');
        initeCityAutoComplete(code);
    });

    var code = $("#countryid option:selected").val();

    if(code){
       initeCityAutoComplete(code);
    }

    function initeCityAutoComplete(code){

        if(code){
            $('#pac-input').show();

            if($('#pac-input').val() != ""){
                $('#distance_range').show();
            }else{
                $('#distance_range').hide();
            }
        }else{
            $('#distance_range').hide();
            $('#pac-input').hide();
            $('#distance_range').val('');
        }
        // reinitelize the google autocomplete
        initMap();
    }

    $('#locSearch').bind('change', function(e){
        var locSearch = $("#locSearch option:selected").val();
        $("#lSearch").val(locSearch);
    });
    var gender_male = "<?php echo config('constant.gender_male'); ?>";
    var gender_female = "<?php echo config('constant.gender_female'); ?>";
    
    var gender_value = $('#f_gender_value').val();
    var catArr = [];
    
    $('#catSearch :selected').each(function(i, sel){ 
        catArr.push($(sel).attr('data-value'));
    });
    
    catArr = unique(catArr);
    checkboxManage(catArr, gender_value);

    $('#catSearch').bind('change', function(e){
        
        clearCheckbox();
        var catArr = [];

        var gender_value = $('#f_gender_value').val();

        $('#catSearch :selected').each(function(i, sel){ 
            catArr.push($(sel).attr('data-value'));
        });

        catArr = unique(catArr);

        checkboxManage(catArr, gender_value);
        
        
    });

    $('#f_gender_value').bind('change', function(e){
        
        clearCheckbox();
        var catArr = [];

        var is_baby_cat = $("#catSearch option:selected").attr('data-value');
        var gender_value = $('#f_gender_value').val();

        $('#catSearch :selected').each(function(i, sel){
            catArr.push($(sel).attr('data-value'));
        });

        // unique the cat_type_array
        catArr = unique(catArr);

        if( (catArr.indexOf('0') > -1) == true && (catArr.indexOf('1') > -1) == true){
            
            if(gender_value == gender_male){
               hideElements(false, false, true);
            }

            if(gender_value == gender_female){
               hideElements(false, true, false);
            }

            if(gender_value == 0){
               hideElements(false, false, false);
            }

        }else if( (catArr.indexOf('0') > -1) == true && (catArr.indexOf('1') > -1) == false ){
            
            if(gender_value == gender_male){
               hideElements(true, false, true);
            }

            if(gender_value == gender_female){
               hideElements(true, true, false);
            }

            if(gender_value == 0){
               hideElements(true, false, false);
            }

        } else if( (catArr.indexOf('1') > -1) == true){
            hideElements(false, true, true);
        } else {
            if(gender_value == gender_male){
               hideElements(true, false, true);
            }

            if(gender_value == gender_female){
               hideElements(true, true, false);
            }

            if(gender_value == 0){
               hideElements(true, false, false);
            }
        }
    });

    function unique(array){
        return array.filter(function(el, index, arr) {
            return index === arr.indexOf(el);
        });
    }

    function checkboxManage(catArr, gender_value){

        if( (catArr.indexOf('0') > -1) == true && (catArr.indexOf('1') > -1) == true){
            
            if(gender_value == gender_male){
               hideElements(false, false, true);
            }

            if(gender_value == gender_female){
               hideElements(false, true, false);
            }

            if(gender_value == 0){
               hideElements(false, false, false);
            }

        }else if( (catArr.indexOf('0') > -1) == true && (catArr.indexOf('1') > -1) == false ){
            
            if(gender_value == gender_male){
               hideElements(true, false, true);
            }

            if(gender_value == gender_female){
               hideElements(true, true, false);
            }

            if(gender_value == 0){
               hideElements(true, false, false);
            }
        } else if( (catArr.indexOf('1') > -1) == true){
            hideElements(false, true, true);
        }else{
            hideElements(false, false, false);
        }
    }

    function hideElements(kids= false, men= false, women=false){
        
        if(kids){
            $('#dress_checkbox_kids').hide();
            $('#shoe_checkbox_kids').hide();
        }else{
            $('#dress_checkbox_kids').show();
            $('#shoe_checkbox_kids').show();

            if($('.bds:checked').length == $('.bds').length){
                $('#dress_kids_all').prop("checked", true);
            }

            if($('.kids-shoe:checked').length == $('.kids-shoe').length){
                $('#shoe_kid_all').prop("checked", true);
            }
        }        

        if(men){
            $('#dress_checkbox_men').hide();
            $('#shoe_checkbox_men').hide();
        }else{
            $('#dress_checkbox_men').show();
            $('#shoe_checkbox_men').show();

            if($('.mds:checked').length == $('.mds').length){
                $('#dress_men_all').prop("checked", true);
            }

            if($('.men-shoe:checked').length == $('.men-shoe').length){
                $('#shoe_men_all').prop("checked", true);
            }
        }

        if(women){
            $('#dress_checkbox_women').hide();
            $('#shoe_checkbox_women').hide();
        }else{
            $('#dress_checkbox_women').show();
            $('#shoe_checkbox_women').show();

            if($('.wds:checked').length == $('.wds').length){
                $('#dress_women_all').prop("checked", true);
            }

            if($('.women-shoe:checked').length == $('.women-shoe').length){
                $('#shoe_women_all').prop("checked", true);
            }
        }   
    }

    function clearCheckbox(){

        $('#dress_checkbox_kids input:checked').each( function(){
            $(this).prop("checked", false);
        });

        $('#dress_checkbox_men input:checked').each( function(){
            $(this).prop("checked", false);
        });

        $('#dress_checkbox_women input:checked').each( function(){
            $(this).prop("checked", false);
        });

        $('#shoe_checkbox_kids input:checked').each( function(){
            $(this).prop("checked", false);
        });

        $('#shoe_checkbox_men input:checked').each( function(){
            $(this).prop("checked", false);
        });

        $('#shoe_checkbox_women input:checked').each( function(){
            $(this).prop("checked", false);
        });
    }

    $('.bds').change(function(){
        
        if($('.bds:checked').length == $('.bds').length){
            $('#dress_kids_all').prop("checked", true);
        }else{
            $('#dress_kids_all').prop("checked", false);
        }
    });

    $('.mds').change(function(){
        
        if($('.mds:checked').length == $('.mds').length){
            $('#dress_men_all').prop("checked", true);
        }else{
            $('#dress_men_all').prop("checked", false);
        }
    });

    $('.wds').change(function(){
        
        if($('.wds:checked').length == $('.wds').length){
            $('#dress_women_all').prop("checked", true);
        }else{
            $('#dress_women_all').prop("checked", false);
        }
    });

    $('.men-shoe').change(function(){
        
        if($('.men-shoe:checked').length == $('.men-shoe').length){
            $('#shoe_men_all').prop("checked", true);
        }else{
            $('#shoe_men_all').prop("checked", false);
        }
    });
    $('.women-shoe').change(function(){
        
        if($('.women-shoe:checked').length == $('.women-shoe').length){
            $('#shoe_women_all').prop("checked", true);
        }else{
            $('#shoe_women_all').prop("checked", false);
        }
    });
    
    $('.kids-shoe').change(function(){
        
        if($('.kids-shoe:checked').length == $('.kids-shoe').length){
            $('#shoe_kid_all').prop("checked", true);
        }else{
            $('#shoe_kid_all').prop("checked", false);
        }
    });

    
    $('#dress_kids_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#dress_checkbox_kids input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#dress_checkbox_kids input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#dress_men_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#dress_checkbox_men input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#dress_checkbox_men input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#dress_women_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#dress_checkbox_women input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#dress_checkbox_women input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#shoe_kid_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#shoe_checkbox_kids input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#shoe_checkbox_kids input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#shoe_men_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#shoe_checkbox_men input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#shoe_checkbox_men input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#shoe_women_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#shoe_checkbox_women input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#shoe_checkbox_women input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });
</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}

<!-- Slider Customize js -->
<script>
    $.noConflict();
    jQuery(document).ready(function($) {


        $('#clear-all').click(function(){
            
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $('#model-filter-form')[0].reset();
            $('#model-filter-form').find('input:text').val('');
            $('#model-filter-form').find(".select-2").val('').trigger('change');
            $('#model-filter-form').find(".remove-focus").css({ 'box-shadow':'none' });
            return true;
        });

        $('#radius').slider({
            formatter: function(value) {
                var html = '<?php echo t('Within show'); ?>, (<b>'+value+'</b>) </b>';
                $('#tooltip-miles').html(html);
            }
        });

        $('#countryid').bind('change', function(e){
            $('#radius').slider('setValue', 0);
        });

        $('#pac-input').bind('change keyup', function(e){
            
            $('#pac-input').addClass('border-bottom-error');
            $('#is_place_select').val('');
            
            if( $('#pac-input').val() == ""){
                $('#pac-input').removeClass('border-bottom-error');
                $('#radius').slider('setValue', 0);
                $('#latitude').val('');
                $('#longitude').val('');
                $('#distance_range').hide();
            }
        });

        $('#model-filter-form').submit(function(event) {

            // if cities empty, form submit true
            if($('#pac-input').val() == ""){
                
                $('#pac-input').removeClass('border-bottom-error');
                return true;
            }

            // if cities not empty and place selected in google Autocomplate place, form submit true, else form submit false  
            if($('#pac-input').val() != "" && $('#is_place_select').val() == 1){

                $('#pac-input').removeClass('border-bottom-error');
                return true;
            }else{

                $('html, body').animate({
                    scrollTop: $("#model-filter-form").offset().top
                }, 1000, function() {
                    $("#model-filter-form [name='city']").focus();
                });
                
                $('#pac-input').addClass('border-bottom-error');
                return false;
            }

            return true;
        });
    });
</script>
    <!-- disable autocomplete off on google autocomplete -->
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById("pac-input").autocomplete = 'city-add';
        }
    </script>
@endsection

