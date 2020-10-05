// $('#register_data').click( function(){
//     $('.error-text-safari').css('display','none');
//     // var requiredMsg = '{{ t("required_field") }}';

//     $('input,textarea,select,radio').filter('[required]:visible').each(function(i, requiredField){

//         document.getElementsByName($(requiredField).attr('name'))[0].setCustomValidity('');

//         if($(requiredField).val() == '' || $(requiredField).val() == null)
//         {

//             var element = document.getElementsByName($(requiredField).attr('name'))[0];

//             element.oninvalid = function(e) {
//                 e.target.setCustomValidity("");
//                 if (!e.target.validity.valid) {
//                     e.target.setCustomValidity(requiredMsg);
//                 }
//             };

//             document.getElementsByName($(requiredField).attr('name'))[0].reportValidity();

//             $('html, body').animate({
//                 scrollTop: ($(requiredField).offset().top - 100)
//             }, 500, function() {
//                 $(requiredField).focus();
//             });


//             // all id ended with *-jq-err* specialy mentain for safari browser to show html5 validation messages.
//             // below script only run if it detected safari browser 
//             var ua = navigator.userAgent.toLowerCase(); 
//             if (ua.indexOf('safari') != -1) { 
//               if (ua.indexOf('chrome') > -1) {
//                  // Chrome
//               } else {
                
//                 if($(requiredField).hasClass('custom_birthday')){
//                     $('#custom_birthday-jq-err').find('.error-text-safari').css('display','block');
//                 }
//                 // alert("2") // Safari
//                 var err_f = $(requiredField).attr('name')+'-jq-err';
//                 $('#'+err_f).find('.error-text-safari').css('display','block');
//               }
//             }

//             return false;
//         }
//     });
// });

$('.gender-radio').click(function(){
    $('#gender-div').find('.radio-label-error').removeClass('radio-label-error');
});

// Start Google AutoComplate Place cities
var autocomplete;
var input = document.getElementById('pac-input');
var options = { types: ['(cities)'] };
autocomplete = new google.maps.places.Autocomplete(input, options);

$('#countryid').bind('change', function(e){
    $('#pac-input').removeClass('border-bottom-error');
    var code = $("#countryid option:selected").val();
    $('#pac-input').val('');
    $('#street').val('');
    $('#zip').val('');
    $('#geo_state').val('');
    $('#geo_city').val('');
    $('#geo_country').val('');
    initMapRegister();
});

var code = $("#countryid option:selected").val();

if(code){
   initMapRegister();
}

$('#pac-input').bind('change keyup', function(e){
    $('#street').val('');
    $('#zip').val('');
    $('#pac-input').addClass('border-bottom-error');
    $('#is_place_select').val('');
    $('#geo_state').val('');
    $('#geo_city').val('');
    $('#geo_country').val('');
    
    if( $('#pac-input').val() == ""){
        $('#pac-input').removeClass('border-bottom-error');
    }
});
// End Google AutoComplate Place cities

jQuery.noConflict()(function($){
    
    $(document).ready(function(){

        if($('#pac-input').val() == ''){

            $('#is_place_select').val('');
        }

        if($('#is_place_select').val()){

            $('#pac-input').removeClass('border-bottom-error');
        }

        $('.register').click(function(){

            var gender_selected = $("input[type='radio'][name='gender']:checked");

            var user_age = $('#user_age').val();
            var category = $('#category').val();
            var email_id = $('#email').val();

            if(user_age != "" && category != "" && email_id != ""){

                if (gender_selected.length == 0) {

                    $('.gender-error').html(genderError);

                    $('html, body').animate({
                        scrollTop: $("#gender-div").offset().top
                    }, 500); 
                    return false;
                }else{
                    $('.gender-error').hide();
                }
            }

        });
        
        var selected_country = $('#country_selected').val();

        if(selected_country == 0 || selected_country == ''){
            var country_code = defaultCountryCode;
        }else{
            var country_code = selected_country;
        }

        $(".country-auto-search").select2({
            minimumResultsForSearch: 5,
            width: '100%',
            templateResult: formatState,
            templateSelection: formatState
        });
        if ($('.phone-code-auto-search').length > 0) {
            $(".phone-code-auto-search").select2({
                minimumResultsForSearch: 5,
                width: '100%',
                templateResult: formatState,
                templateSelection: formatState
            });
        }
    });
    function formatState (opt) {
         if (!opt.id) {
            return opt.text;
        } 

        var optimage = $(opt.element).attr('data-image');
        if(!optimage){
           return opt.text;
        } else {                    
            var $opt = $(
               '<span><img class="country-flg-img" src="' + optimage + '" width="16" height="16" /> ' + opt.text + '</span>'
            );
            return $opt;
        }    
    };
    
    if (userType == 2) {
        $('.for-employer').show();
        $('.for-model').hide();
    }

    if (userType == 3) {
        $('.for-employer').hide();
        $('.for-model').show();
    }
    

    var code = $("#countryid option:selected").val();
    // getUnitsOnCountryChange();
    // commented city code

    var countryname = $("#countryid option:selected").text();
    if(countryname != "" && countryname != null && countryname != undefined){
        $('#country_name').val(countryname);
    }
    // commented city code
    $('#countryid').bind('change', function(e){
       var code = $("#countryid option:selected").val();

       var countryname = $("#countryid option:selected").text();
       $('#country_name').val(countryname);
        // getUnitsOnCountryChange();
    });

    // $('#category').bind('change', function(e){
    //     getUnitsOnCountryChange();
    // });

    // $('input[type=radio][name=gender]').change(function() {
    //     getUnitsOnCountryChange();
    // });
    
    // function getUnitsOnCountryChange(){
    //     var url = "/ajax/getAjaxUnites";
    //     getUnitMesurment(url);
    // }

    // function getUnitMesurment(url){

    //     // get selected dropdown value. height, weight, dressSize
    //     var heightSelected = $("#height_selected").val();
    //     var weightSelected = $("#weight_selected").val();
    //     var dressSizeSelected = $("#dressSize_selected").val();
    //     var shoeSizeSelected = $("#shoeSize_selected").val();

    //     var category_id = $('#category').val();
    //     var gender = $("input[name='gender']:checked").val();
    //     var country_code = $("#countryid option:selected").val();

    //     var siteUrl =  window.location.origin;

    //     data = {
    //         'allUnits' : 1,
    //         'category_id' : (category_id != undefined && category_id != null)? category_id : '',
    //         'gender'  : (gender != undefined && gender != null)? gender : '',
    //         'country_code' :  (country_code != undefined && country_code != null)? country_code : '',
    //     };

    //     $.ajax({
    //         method: "POST",
    //         url: siteUrl + url,
    //         data: data,
    //         beforeSend: function(){
    //             $(".loading-process").show();
    //         },
    //         complete: function(){
    //             $(".loading-process").hide();
    //         },
    //     }).done(function(response) {
    //         if( response.success == true ){

    //             heightSelect =  $("#height");
    //             // var selectHeightLabel = "<?php echo t('Select height'); ?>";
                
    //             if(response.data.height != undefined && response.data.height != null){
                    
    //                 heightSelect.empty();
    //                 heightSelect.append("<option value=''>"+selectHeightLabel+"</option>");
                    
    //                 $.each(response.data.height, function (key, val) {

    //                     // check selected height value
    //                     if(heightSelected != '' && heightSelected == key){
    //                         heightSelect.append($("<option selected></option>").attr("value", key).text(val));
    //                     }else{
    //                         heightSelect.append($("<option></option>").attr("value", key).text(val));
    //                     }
    //                 });
    //             }

    //             weightSelect =  $("#weight");
    //             // var selectweightLabel = "<?php echo t('Select weight'); ?>";

    //             if(response.data.weight != undefined && response.data.weight != null){
    //                 weightSelect.empty();
    //                 weightSelect.append("<option value=''>"+selectweightLabel+"</option>");
    //                 $.each(response.data.weight, function (key, val) {

    //                     // check selected weight value
    //                     if(weightSelected != '' && weightSelected == key){
    //                         weightSelect.append($("<option selected></option>").attr("value", key).text(val));
    //                     }else{
    //                         weightSelect.append($("<option></option>").attr("value", key).text(val));
    //                     }
    //                 });
    //             }


    //             dressSizeSelect =  $("#dressSize");
    //             // var selectdressSizeLabel = "<?php echo t('Select dress size'); ?>";

    //             if(response.data.dress_size != undefined && response.data.dress_size != null){
    //                 dressSizeSelect.empty();
    //                 dressSizeSelect.append("<option value=''>"+selectdressSizeLabel+"</option>");
    //                 $.each(response.data.dress_size, function (key, val) {

    //                     // check selected dressSize value
    //                     if(dressSizeSelected != '' && dressSizeSelected == key){
    //                         dressSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
    //                     }else{
    //                         dressSizeSelect.append($("<option></option>").attr("value", key).text(val));
    //                     }
    //                 });
    //             }

    //             shoeSizeSelect =  $("#shoeSize");
    //             // var selectshoeSizeLabel = "<?php echo t('Select shoe size'); ?>";

    //             if(response.data.shoe_size != undefined && response.data.shoe_size != null){
    //                 shoeSizeSelect.empty();
    //                 shoeSizeSelect.append("<option value=''>"+selectshoeSizeLabel+"</option>");
    //                 $.each(response.data.shoe_size, function (key, val) {

    //                     // check selected dressSize value
    //                     if(shoeSizeSelected != '' && shoeSizeSelected == key){
    //                         shoeSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
    //                     }else{
    //                         shoeSizeSelect.append($("<option></option>").attr("value", key).text(val));
    //                     }
    //                 });
    //             }
    //         }
    //     });
    // }
});

jQuery.noConflict()(function($){

    $("#cs_birthday").birthdayPicker({
        dateFormat: "littleEndian",
        sizeClass: "form-control custom_birthday cs_birthday-drop form-select2 validate",
        callback: selected_date
    });


    $("#cs_birthday").on('change', function (){   
        
        var $d = $('select.birthDate').val();
        var $m = $('select.birthMonth').val();
        var $y = $('select.birthYear').val();

        if(parseInt($d, 10) == 0 || parseInt($m, 10) == 0 || parseInt($y, 10) == 0){
            parentInputHideShow();
            jQuery(".parent-fields").css("display", "none");
        }
    });

    function selected_date($date){
        
        // $('#fname_parent').prop('required', false);
        // $('#lname_parent').prop('required' , false);
        // parentInputHideShow();
        
        var selected_date = $date;
        var show_parent = true;
        if(selected_date != '' && selected_date != undefined){
            var SelectDateArr = selected_date.split('-');
            if(SelectDateArr[0] == 'NaN' || SelectDateArr[1] == 'NaN' || SelectDateArr[2] == 'NaN'){
                show_parent = false;
            }
        }
        if(show_parent == true){
            var DOB = new Date(selected_date);
            var today = new Date();
            var age = today.getTime() - DOB.getTime();

            age = Math.floor(age / (1000 * 60 * 60 * 24 * 365.25));

            $('#user_age').val(age);

            if (age < 18) {
                jQuery(".parent-fields").css("display", "block");
                // $('#fname_parent').prop('required', true);
                // $('#lname_parent').prop('required' , true);
                $('#fname_parent').addClass('validate');
                $('#lname_parent').addClass('validate');
            } else {
                jQuery(".parent-fields").css("display", "none");
                $('#fname_parent').val('');
                $('#lname_parent').val('');
                $('#fname_parent').removeClass('validate');
                $('#lname_parent').removeClass('validate');
            }
        }
    }

    function set_date($date){
        if ( $date != '' ) {
            var DOB = new Date($date);
            $('select.birthYear').val(DOB.getFullYear());
            $('select.birthMonth').val(DOB.getMonth() + 1);
            $('select.birthDate').val(DOB.getDate());

            $('[name="cs_birthday_birthDay"]').val($date.split("/").reverse().join("-"));
            selected_date($date);
        }
    }

    function parentInputHideShow(){
        // $('#fname_parent').val('');
        // $('#lname_parent').val('');
        // $('#fname_parent').prop('required', false);
        // $('#lname_parent').prop('required' , false);
        $('#fname_parent').removeClass('validate');
        $('#lname_parent').removeClass('validate');
        $('#fname_parent').next('.form-input-error-msg').removeClass('show-error');
        $('#lname_parent').next('.form-input-error-msg').removeClass('show-error');
        $('#fname_parent').closest('.input-group').removeClass('has-error');
        $('#lname_parent').closest('.input-group').removeClass('has-error');
    }


    if(cs_birthday_birthDay != null && cs_birthday_birthDay != undefined && cs_birthday_birthDay != '') {

        var birthday = cs_birthday_birthDay;
    }else{
        var birthday = userBirthday;
    }
    
    set_date(birthday);

     $('.form-select2').select2({
        closeOnSelect: true,
        minimumResultsForSearch: 1
     });
});

function readCookie(name) {
    var n = name + "=";
    var cookie = document.cookie.split(";");
    for(var i=0;i < cookie.length;i++) {
      var c = cookie[i];
      while (c.charAt(0)==" "){c = c.substring(1,c.length);}
      if (c.indexOf == 0){return c.substring(n.length,c.length);}
    }
    return null;
}

// disable autocomplete off on google autocomplete
// window.onload = function() {
    
//     var isFirefox = typeof InstallTrigger !== 'undefined';

//     if(isFirefox){
//         document.getElementById("pac-input").autocomplete = 'off';
//     }else{
//         document.getElementById("pac-input").autocomplete = 'city-add';
//     }

//     document.getElementById("gclid_field").value =  readCookie("gclid");
// }

// $('#reg-data').submit(function(event) {
//     $(".loading-process").hide();
//     $('#pac-input').removeClass('border-bottom-error');
//     // if cities empty, form submit true
//     if($('#pac-input').val() == "" || $('#is_place_select').val() != 1){
        
//         $('#pac-input').addClass('border-bottom-error');

//         $('html, body').animate({
//             scrollTop: $("#phone-code-row").offset().top
//         }, 1000, function() {
//             $("#reg-data [name='city']").focus();
//         });
//         return false;
//     }
//     $('#register_data').prop('disabled', true);
//     $(".loading-process").show();
//     return true;
// });

$(document).ready(function() {
    var globOpts = {
        bootstrap: true,
        mail: {
            format: true,
            confirm: true
        },
        password: {
            format: true,
            formatRegEx: /\b([A-Z0-9])([a-z0-9]+)?\b/gm,
            confirm: true
        },
        telephone: {
            numbersOnly: false
        },
        showErrors: true
    }

    var fv = new formValidator(globOpts)
    var validation = fv.validate('#reg-data', '#register_data', {
        success: function() {
            // console.log('validation success!');
            $(".loading-process").hide();
            $('#pac-input').removeClass('border-bottom-error');
            // if cities empty, form submit true
            if($('#pac-input').val() == "" || $('#is_place_select').val() != 1){
                
                $('#pac-input').addClass('border-bottom-error');
                $('html, body').animate({
                    scrollTop: $("#phone-code-row").offset().top
                }, 1000, function() {
                    $("#reg-data [name='city']").focus();
                });
                return false;
            }
            $("#reg-data").submit();
            $(".loading-process").show();
            return true;
        },
        fail: function() {
            // console.log('validation fail!');
            return false;
        }
    });
});
 