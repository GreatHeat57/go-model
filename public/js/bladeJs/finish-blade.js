// $('#register_data').click( function(){
//     $('.error-text-safari').css('display','none');
//     // var requiredMsg = '{{ t("required_field") }}';

//     $('#reg-data input').filter('[required]:visible').each(function(i, requiredField){

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

jQuery.noConflict();
jQuery(document).ready(function($){
    $(".form-select2").select2({
        minimumResultsForSearch: 5,
        width: '100%',
    });
});


// $(document).ready(function(){
//     var url = "/ajax/getAjaxUnites";
//     function getUnitMesurment(){

//         // get selected dropdown value. height, weight, dressSize
//         var heightSelected = $("#height_selected").val();
//         var weightSelected = $("#weight_selected").val();
//         var dressSizeSelected = $("#dressSize_selected").val();
//         var shoeSizeSelected = $("#shoeSize_selected").val();

//         // var category_id = $('#category').val();
//         // var gender = $("input[name='gender']:checked").val();
//         // var country_code = $("#countryid option:selected").val();

//         var siteUrl =  window.location.origin;

//         data = {
//             'allUnits' : 1,
//             'category_id' : (category_id != undefined && category_id != null)? category_id : '',
//             'gender'  : (gender != undefined && gender != null)? gender : '',
//             'country_code' :  (country_code != undefined && country_code != null)? country_code : '',
//         };

//         $.ajax({
//             method: "POST",
//             url: siteUrl + url,
//             data: data,
//             beforeSend: function(){
//                 $(".loading-process").show();
//             },
//             complete: function(){
//                 $(".loading-process").hide();
//             },
//         }).done(function(response) {
//             if( response.success == true ){

//                 heightSelect =  $("#height");
//                 // var selectHeightLabel = "<?php echo t('Select height'); ?>";
                
//                 if(response.data.height != undefined && response.data.height != null){
                    
//                     heightSelect.empty();
//                     heightSelect.append("<option value=''>"+selectHeightLabel+"</option>");
                    
//                     $.each(response.data.height, function (key, val) {

//                         // check selected height value
//                         if(heightSelected != '' && heightSelected == key){
//                             heightSelect.append($("<option selected></option>").attr("value", key).text(val));
//                         }else{
//                             heightSelect.append($("<option></option>").attr("value", key).text(val));
//                         }
//                     });
//                 }

//                 weightSelect =  $("#weight");
//                 // var selectweightLabel = "<?php echo t('Select weight'); ?>";

//                 if(response.data.weight != undefined && response.data.weight != null){
//                     weightSelect.empty();
//                     weightSelect.append("<option value=''>"+selectweightLabel+"</option>");
//                     $.each(response.data.weight, function (key, val) {

//                         // check selected weight value
//                         if(weightSelected != '' && weightSelected == key){
//                             weightSelect.append($("<option selected></option>").attr("value", key).text(val));
//                         }else{
//                             weightSelect.append($("<option></option>").attr("value", key).text(val));
//                         }
//                     });
//                 }


//                 dressSizeSelect =  $("#dressSize");
//                 // var selectdressSizeLabel = "<?php echo t('Select dress size'); ?>";

//                 if(response.data.dress_size != undefined && response.data.dress_size != null){
//                     dressSizeSelect.empty();
//                     dressSizeSelect.append("<option value=''>"+selectdressSizeLabel+"</option>");
//                     $.each(response.data.dress_size, function (key, val) {

//                         // check selected dressSize value
//                         if(dressSizeSelected != '' && dressSizeSelected == key){
//                             dressSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
//                         }else{
//                             dressSizeSelect.append($("<option></option>").attr("value", key).text(val));
//                         }
//                     });
//                 }

//                 shoeSizeSelect =  $("#shoeSize");
//                 // var selectshoeSizeLabel = "<?php echo t('Select shoe size'); ?>";

//                 if(response.data.shoe_size != undefined && response.data.shoe_size != null){
//                     shoeSizeSelect.empty();
//                     shoeSizeSelect.append("<option value=''>"+selectshoeSizeLabel+"</option>");
//                     $.each(response.data.shoe_size, function (key, val) {

//                         // check selected dressSize value
//                         if(shoeSizeSelected != '' && shoeSizeSelected == key){
//                             shoeSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
//                         }else{
//                             shoeSizeSelect.append($("<option></option>").attr("value", key).text(val));
//                         }
//                     });
//                 }
//             }
//         });
//     }
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
            console.log('validation success!');
            $("#reg-data").submit();
            $(".loading-process").show();
            return true;
        },
        fail: function() {
            console.log('validation fail!');
            return false;
        }
    });
});
