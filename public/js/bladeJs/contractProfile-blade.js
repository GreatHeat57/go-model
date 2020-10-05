// on page load check the price and calculate the tax and show full amount
jQuery.noConflict()(function($){
	$(window).bind("load", function() { 
	   	
	   	var selectedPackage = $('input[name=package]:checked');
	    var package_name = selectedPackage.attr('data-name');
		var currency = selectedPackage.attr('data-currencysymbol');
		var price = parseFloat(selectedPackage.attr('data-price')).toFixed(2);
		var tax = parseFloat(selectedPackage.attr('data-tax'));
		var tax_amount = ((price * tax)/ 100).toFixed(2);
		var total = Math.round(parseFloat(price) + parseFloat(tax_amount)).toFixed(2);
		var is_currency_left = selectedPackage.attr('data-currencyinleft');
		
		if(is_currency_left == 1){
			var description = currency +''+ price +' + '+ currency+''+tax_amount+' ('+vat+') = '+currency+''+total;
		}else{
			var description = price +''+ currency +' + '+ tax_amount+''+currency+' ('+vat+') = '+total+''+currency;
		}
		 
		$('.descprice').html(description);
		
		$('#package_name').html(package_name);
		
		var duration_period = selectedPackage.attr('data-duration_period');
		var duration = selectedPackage.attr('data-duration'); 
		var summary_duration = duration +' '+ duration_period;
		$('.duration_period').html(summary_duration);
	});
	$(document).ready( function(){
		$('.btn-order-submit').prop('disabled', false);
		$('[data-toggle="tooltip"]').tooltip(); 
	});

	$('.btn-order-submit').click(function(event){
		event.preventDefault();
		
		if(!$("#term").is(':checked')){ 
		    $(".checkbox-label-term").addClass("checkbox-error");
		    return false;
	 	}

	 	$('.btn-order-submit').prop('disabled', true);
	 	if(is_user_premium_country_free_access == 1){
	 		makeContractForFreeModel();
	 	}else if(is_free_access_user == 1){
	 		makeContractForFreeModel();
	 	}else{
			dateContarctCrmUpdateApi();
	 	}
	});
});

function dateContarctCrmUpdateApi(){
				
	// var userId = '<?php echo $user->id; ?>';
	// var username = '<?php echo $user->username; ?>';
	// var error = '<?php echo t('Something went wrong Please try again'); ?>';
	// var receive_newsletter = 0;

	if($('#receive_newsletter').length > 0){
		
		if($('#receive_newsletter').is(':checked')){
			receive_newsletter = 1;
		}
	}

	$.ajax({
		url: contract_date_update_route,
        type: 'post',
        data: {
            username: username,
            _token: $("input[name=_token]").val(),
            receive_newsletter: receive_newsletter,
            userId: userId
        },
        beforeSend: function(){
            $(".loading-process").show();
        },
        complete: function(){
            
        },
        success: function(data){
			
			if(data.status == true){
				$('.btn-order-submit').prop('disabled', true);
				$('#order-submit').submit();
            	return true;
			}else{
				$('.btn-order-submit').prop('disabled', false);
				$(".loading-process").hide();
				$('.api-error-message').show();
			 	$(window).scrollTop(0);
				return false;
			}
       	},
        error: function(err){
        	$('.btn-order-submit').prop('disabled', false);
			$(".loading-process").hide();
            console.log(err);
        }
    });
}
// Premium country free model contract sign via ajax
function makeContractForFreeModel(){
	
	$.ajax({
		url: contract_for_free_model_route,
        type: 'post',
        data: {
            username: username,
            _token: $("input[name=_token]").val(),
            userId: userId,
            is_free_country: is_free_access_user,
        },
        beforeSend: function(){
            $(".loading-process").show();
        },
        complete: function(){
            
        },
        success: function(data){
			if(data.status == false){ 
				$('.btn-order-submit').prop('disabled', false);
				$(".loading-process").hide();
				$('.api-error-message').show();
			 	$(window).scrollTop(0);
				return false;
			}else{
				window.location = data.redirect_url;
			}
			return false;
		},
        error: function(err){ 
        	$('.btn-order-submit').prop('disabled', false);
			$(".loading-process").hide();
            console.log(err);
        }
    });
}

jQuery.noConflict()(function($){
	$('.mfp-profile').click(function() {

		// if already container exist, remove container
		if ($('.pac-container').length > 0) {

			$('.pac-container').remove();
		}
		
		var autocomplete;
	    var id = $(this).attr('id');

	    if( id != "" && id != null && id != undefined ){

	    	url =  baseurl+"contract/update-profile-popup/" + id;
			
			$.ajax({
		        type: "GET",
		        url: url,
		        beforeSend: function(){
	                jQuery(".loading-process").show();
	                jQuery("#contract-form").attr("disabled", true);
	            },
	            complete: function(){
	                jQuery(".loading-process").hide();
	                jQuery("#contract-form").attr("disabled", false);
	            },
		        success: function(result) {

		        	if( result.status == true ){

		        		jQuery('.mfp-profile').magnificPopup({
			                items: {
			                    src: result.html,
			                    type: 'inline'
			                },
			                closeOnBgClick:false,
							closeBtnInside:true,
			            }).magnificPopup('open');


			        	jQuery("input[name='email']").attr('disabled','disabled');
	    				jQuery(".country-id").prop('disabled',true);
	    				jQuery('body').addClass('body-container');

			            jQuery.magnificPopup.instance.close = function() {
			            	jQuery('body').removeClass('body-container');
			            	jQuery.magnificPopup.proto.close.call(this);
			            }

	    				jQuery('body').addClass('body-container');

						jQuery.magnificPopup.instance.close = function() {
							jQuery('body').removeClass('body-container');
							jQuery.magnificPopup.proto.close.call(this);
						}

	    				var code = $("#countryid option:selected").val();

	    				// get city input
						var input = document.getElementById('pac-input');

						// set cities options 
						var options = { types: ['(cities)'], componentRestrictions: {country: code.toLowerCase() }};
						
						// call Google autoComplate Place 
					    autocomplete = new google.maps.places.Autocomplete(input, options);
					    autocomplete.setOptions(options);
					    autocomplete.setFields(['address_components', 'geometry']);
					    document.getElementById("pac-input").autocomplete = 'city-add';

					    autocomplete.addListener('place_changed', function() {
				    	var place = autocomplete.getPlace();
							
							if (place.geometry) {

								if(place.address_components){
									placeToState(place);
									jQuery('#pac-input').removeClass('border-bottom-error');
						      		jQuery('#is_place_select').val('1');
						      	}else{
							        jQuery('#is_place_select').val('0');
						      	}
							}
					  	});
						
						var countryname = $("#countryid option:selected").text();

				        if(countryname != "" && countryname != null && countryname != undefined){
				        	jQuery('#country_name').val(countryname);
				        }

				        // commented city code
				        jQuery('#countryid').bind('change', function(e){
				           var countryname = $("#countryid option:selected").text();
				           jQuery('#country_name').val(countryname);
				        });


				        jQuery(window).on('load', function() {
						   var code = $("#countryid option:selected").val();
						   var countryname = $("#countryid option:selected").text();
						   jQuery('#country_nm').html(countryname);
						});

				        jQuery("#cs_birthday").birthdayPicker({
				            dateFormat: "littleEndian",
				            sizeClass: "form-control custom_birthday form-select2",
				            callback: selected_date
				        });

				        jQuery('.form-select2').select2({
				            closeOnSelect: true,
				            minimumResultsForSearch: Infinity
				        });

				        function placeToState(place){
						    place.address_components.forEach(function(c) {
						        switch(c.types[0]){
						            case 'administrative_area_level_1':     //  Note some countries don't have states
						              if (document.getElementById("geo_state")) {
						                document.getElementById("geo_state").value = c.long_name;
						              }
					                break; 
						        }
						    });
						    return true;
						}

				        function selected_date($date) {
				            var selected_date = $date;

				            var dateArr = selected_date.split('-');

				            if( !isNaN(dateArr[0]) && !isNaN(dateArr[1]) && !isNaN(dateArr[2]) ){
				            	
				            	var DOB = new Date(selected_date);
					            var today = new Date();
					            var age = today.getTime() - DOB.getTime();

					           
					            age = Math.floor(age / (1000 * 60 * 60 * 24 * 365.25));

					            if (age < 18) {
					                jQuery(".parent_details").css("display", "block");
					                jQuery('.parent_details').show();
					                
					                jQuery("input[name='fname_parent']").prop('required',true);
					                jQuery("input[name='lname_parent']").prop('required',true);

					            } else {
					                jQuery(".parent_details").css("display", "none");
					                jQuery('.parent_details').hide();

					                jQuery("input[name='fname_parent']").val('');
					                jQuery("input[name='lname_parent']").val('');

					                jQuery("input[name='fname_parent']").prop('required',false);
					                jQuery("input[name='lname_parent']").prop('required',false);

					            }
				            }
				        }

				        set_date(jQuery('[name="user_birthdate"]').val());

						function set_date($date){
							// append showing error
							jQuery('#cs_birthday').append("<p class='help-block err-input' id='cs_birthday_birthDay'></p>");
							if ( $date != '' ) {
								var DOB = new Date($date);
					            jQuery('[name="cs_birthday_birth[day]"]').val(DOB.getDate()).trigger('change');
					            jQuery('[name="cs_birthday_birth[month]"]').val(DOB.getMonth() + 1).trigger('change');
					            jQuery('[name="cs_birthday_birth[year]"]').val(DOB.getFullYear()).trigger('change');

								jQuery('[name="cs_birthday_birthDay"]').val($date);
								selected_date($date);
							}
						}

						jQuery("#cs_birthday").on('change', function (){   
	        				var $d = jQuery('select.birthDate').val();
					        var $m = jQuery('select.birthMonth').val();
					        var $y = jQuery('select.birthYear').val();
							if($d == '' || $m == '' || $y == ''){
				             	jQuery('[name="cs_birthday_birthDay"]').val('');
					        }
					    });
						
						//  city change event
						jQuery('#pac-input').bind('change keyup', function(e){
					        jQuery('#street-input').val('');
							jQuery('#zip-input').val('');
							jQuery('#geo_state').val('');
					        jQuery('#pac-input').addClass('border-bottom-error');
					        jQuery('#is_place_select').val('');
					        
					        if(jQuery('#pac-input').val() == ""){
					            
					            jQuery('#is_place_select').val('');
					            jQuery('#pac-input').addClass('border-bottom-error');
					        }
					    });

						// if city is blanck, add border-bottom color red 
					    if(jQuery('#pac-input').val() == ''){

			                jQuery('#is_place_select').val('');
			                jQuery('#pac-input').addClass('border-bottom-error');
			            }

			            // if place not selcted or invalid place border bottom red
			            if(jQuery('#is_place_select').val()){

			                jQuery('#pac-input').removeClass('border-bottom-error');
			            }else{

			            	jQuery('#pac-input').addClass('border-bottom-error');
			            }

						jQuery('#contract-form').click(function(e){
							
							e.preventDefault();

							jQuery('#pac-input').removeClass('border-bottom-error');
					        // if cities empty, form submit true
					        if(jQuery('#pac-input').val() == "" || jQuery('#is_place_select').val() != 1){
					            jQuery('#city-row .err-input').html(validCityNameError).css('color', 'red');;
					            jQuery('#pac-input').addClass('border-bottom-error');
								return false;
					        }
							submitProfileData();
						});
					
						jQuery('#cs_birthday').find('.select2-container--default').css({"width": "33%", "padding-right": "10px"});
						jQuery('#countryid').find('.select2-container--default').css({"width": "100%"});
					
		        	}else{
		        		alert(SomethingWentWrongError);
		        	}
		        },
		    });
	    }
	});
	$('.package-selection').click(function () {
		selectedPackage = $(this).val();

		var package_name = $(this).attr('data-name');
		var price = parseFloat($(this).attr('data-price')).toFixed(2);
		var tax = parseFloat($(this).attr('data-tax'));
		var tax_amount = ((price * tax)/ 100).toFixed(2);
		var total = Math.round(parseFloat(price) + parseFloat(tax_amount)).toFixed(2);
		var currency = $(this).attr('data-currencysymbol');
		var is_currency_left = $(this).attr('data-currencyinleft');

		if(is_currency_left == 1){
			var description = currency +' '+ price +' + '+ currency+' '+tax_amount+' ('+vat+') = '+currency+' '+total;
		}else{
			var description = price +' '+ currency +' + '+ tax_amount+' '+currency+' ('+vat+') = '+total+' '+currency;
		}
		$('.descprice').html(description);
		$('#feature-' + selectedPackage).slideToggle();
		var duration_period = $(this).attr('data-duration_period');
		var duration = $(this).attr('data-duration'); 
		var summary_duration = duration +' '+ duration_period;
		$('.duration_period').html(summary_duration);
		$('#package_name').html(package_name);
	});
});

function submitProfileData(){
	
	$('input,textarea,select').filter('[required]:visible').each(function(i, requiredField){
		
		if($(requiredField).val() == '' || $(requiredField).val() == null){

	    	document.getElementsByName($(requiredField).attr('name'))[0].setCustomValidity('');
	        
	        var element = document.getElementsByName($(requiredField).attr('name'))[0];

	        element.oninvalid = function(e) {
	            e.target.setCustomValidity("");
	            if (!e.target.validity.valid) {
	                e.target.setCustomValidity(requiredMsg);
	            }
	        };

	        document.getElementsByName($(requiredField).attr('name'))[0].reportValidity();

	        $('html, body').animate({
	            scrollTop: ($(requiredField).offset().top - 100)
	        }, 500, function() {
	            $(requiredField).focus();
	        });

	        return false;
	    }
	});

    var user_id = $("input[name='user_id']").val();
    var email = $("input[name='email']").val();
    var first_name = $("input[name='first_name']").val();
    var last_name = $("input[name='last_name']").val();
    var fname_parent = $("input[name='fname_parent']").val();
    var lname_parent = $("input[name='lname_parent']").val();
    var street = $("input[name='street']").val();
    var country = $("input[name='country']").val();
    var country_name = $("#country_name").val();
    var zip = $("input[name='zip']").val();
    var city = $("input[name='city']").val();
    var gender = $("input[name='gender']:checked").val();
    var cs_birthday_birthDay = $("input[name='cs_birthday_birthDay']").val();
 	var user_type_id = $("input[name='user_type_id']").val();
 	var geo_state = $("input[name='geo_state']").val();
	var formData = {
	    _token : $("input[name='_token']").val(),
	    user_id : user_id,
	    email : email,
	    first_name : first_name,
	    last_name : last_name,
	    fname_parent : fname_parent,
	    lname_parent : lname_parent,
	    street : street,
	    country :country,
	    country_name : country_name,
	    zip : zip,
	    city : city,
	    gender : gender,
	    cs_birthday_birthDay : cs_birthday_birthDay,
	    type: user_type_id,
	    geo_state: geo_state,
	};

	$.ajax({
	    method: "post",
	    url: $("#user-profile").attr('action'),
	    dataType: 'json',
	    data:formData,
	    beforeSend: function(){
	        $(".loading-process").show();
	        $("#contract-form").attr("disabled", true);
	        clearMessage();
	    },
	    complete: function(){
	        $(".loading-process").hide();
	        $("#contract-form").attr("disabled", false);
	    },
	    success: function (data) {
	    	if( data != undefined && data.success == false ){
	            $(".err-input").html('');
	            $("p").removeClass('help-block');

	            $.each( data.errors, function( key, value ) {
	                $('#'+key).addClass('help-block');
	                $('#'+key).html(value[0]);
	            });
	        } else {
	            if(data.success){
	            	jQuery('.mfp-profile').magnificPopup().magnificPopup('close');

	                if(data.message != undefined && data.message != "" && data.message != null){
	                   	$(".print-success-msg").css('display','block');
	                    $(".print-success-msg").append('<p>'+data.message+'</p>');

	                    $('#register-form').prop("disabled", true);
	                }
					$(".user_name").html(first_name+' '+last_name);
					$(".user_street").html(street);
					$(".user_location").html(zip);
					$("#country_nm").html(country_name);
					$("#city_nm").html(city);

					var DOB = new Date(cs_birthday_birthDay);

					$('[name="cs_birthday_birth[day]"]').val(DOB.getDate()).trigger('change');
		            $('[name="cs_birthday_birth[month]"]').val(DOB.getMonth() + 1).trigger('change');
		            $('[name="cs_birthday_birth[year]"]').val(DOB.getFullYear()).trigger('change');
		            jQuery('[name="cs_birthday_birthDay"]').val(cs_birthday_birthDay);

		            setTimeout(function(){ clearMessage() }, 9000);
	            }
	        }
		}, error: function (a, b, c) {
	        console.log('error');
	    }
	});
}
function clearMessage(){
    $(".print-success-msg").html('');
    $(".print-success-msg").hide();
    $("p").removeClass('help-block');
    $(".err-input").html('');
}
