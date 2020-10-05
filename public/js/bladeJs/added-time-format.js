$(document).ready(function(){

	if($('.timeformat-div').find('.d-none').length == 0){

		$('.append-time-div').addClass('d-none');
	}
});
// Show hidden div
$('.append-time-div').click( function(){
	var numItems = $('.timeformat_section').length;
	// timeformat-div
	$('.timeformat-div').find('.d-none').eq(0).removeClass('d-none');

	if($('.timeformat-div').find('.d-none').length == 0){

		$(this).addClass('d-none');
	}
});

// hide click event
if (typeof funnelPageName !== 'undefined' && funnelPageName == 'reg_finish') {

	jQuery.noConflict()(function($){
		// hide click event
		$('.hide-time-div').click( function(){ 
			
			// hide error message on click close button
			$('.'+ $('#'+ $(this).attr('id')).attr('data-error-id')).hide();
			// remove Error style when hide div
		 	var parentDivId = $('#'+ $(this).attr('id')).attr('data-id'); 
			$('#'+ parentDivId).find('.select2 span.select2-selection').attr("style", "");

			$('#'+ $(this).attr('id')+'-select-from').val('').trigger('change');
			$('#'+ $(this).attr('id')+'-select-to').val('').trigger('change'); 
			$('.'+ $(this).attr('id')).addClass('d-none');
			$('.append-time-div').removeClass('d-none');
		});
	});
}else{
	jQuery('.hide-time-div').click( function(){

		// hide error message on click close button
		jQuery('.'+ jQuery('#'+ jQuery(this).attr('id')).attr('data-error-id')).hide();
		// remove Error style when hide div
		var parentDivId = jQuery('#'+ jQuery(this).attr('id')).attr('data-id'); 
		jQuery('#'+ parentDivId).find('.select2 span.select2-selection').attr("style", "");
		jQuery('#'+ jQuery(this).attr('id')+'-select-from').val('').trigger('change');
		jQuery('#'+ jQuery(this).attr('id')+'-select-to').val('').trigger('change'); 
		jQuery('.'+ jQuery(this).attr('id')).addClass('d-none');
		jQuery('.append-time-div').removeClass('d-none');
	});
}




// submit Available Contact
// $('#finish-available-phone-submit-btn').on('click', function(e){
$("#available-phone-data").submit(function(e) {
	e.preventDefault();
	// Validation check
	var status = validAvailableContact();
	
	if(status){
		// ajax call
		saveAvailableContact();
	}else{
		return false;
	}
});

// this is the id of the form
$("#my-data-form").submit(function() {
	
	// e.preventDefault(); // avoid to execute the actual submit of the form.
	
	// Validation check
	var status = validAvailableContact();
	
	if(status){

		return true;
	}else{
		return false;
	}
});

// this is the id of the form
$("#partner-profile-save").submit(function() {
	
	// e.preventDefault(); // avoid to execute the actual submit of the form.
	
	// Validation check
	var status = validAvailableContact();
	
	if(status){

		return true;
	}else{
		return false;
	}
});

// check Valid
function validAvailableContact(){

	var status = true;

	$('.error_timeformat_section1').hide();
	// $('.error_timeformat_section2').hide();
	// $('.error_timeformat_section3').hide();
	
	// Error and success message hide
	$(".print-success-msg").css('display','none');
	$(".print-error-msg").css('display','none');

	// remove Error border-bottom style in select2 
	$('#timeformat_section1').find('.select2 span.select2-selection').attr("style", "");
	// $('#timeformat_section2').find('.select2 span.select2-selection').attr("style", "");
	// $('#timeformat_section3').find('.select2 span.select2-selection').attr("style", "");

	// All select value get 
	var tf1_select_from = $('#tf1-select-from').val();
	var tf1_select_to = $('#tf1-select-to').val();
	// var tf2_select_from = $('#tf2-select-from').val();
	// var tf2_select_to = $('#tf2-select-to').val();
	// var tf3_select_from = $('#tf3-select-from').val();
	// var tf3_select_to = $('#tf3-select-to').val();

	var tf1_select_status = true;
	// var tf2_select_status = true;
	// var tf3_select_status = true;

	// First 
	// Start valid check in Available select One From and to
	if(tf1_select_from == '' || tf1_select_to == ''){

		tf1_select_status = false;
	}

	if(tf1_select_from >= tf1_select_to){

		tf1_select_status = false;
	}
	// End
	
	// Second
	// Start valid check in Available select Two From and to
	// if(tf2_select_from != '' && tf2_select_to != ''){

	// 	if(tf2_select_from >= tf2_select_to){

	// 		tf2_select_status = false;
	// 	}
	// }

	// if(tf2_select_from != '' && tf2_select_to == ''){

	// 	tf2_select_status = false;
	// }

	// if(tf2_select_to != '' && tf2_select_from == ''){

	// 	tf2_select_status = false;
	// }
	// End

	// Third
	// Start valid check in Available select Three From and to
	// if(tf3_select_from != '' && tf3_select_to != ''){

	// 	if(tf3_select_from >= tf3_select_to){

	// 		tf3_select_status = false;
	// 	}
	// }

	// if(tf3_select_from != '' && tf3_select_to == ''){

	// 	tf3_select_status = false;
	// }

	// if(tf3_select_to != '' && tf3_select_from == ''){

	// 	tf3_select_status = false;
	// }
	// End

	if(tf1_select_status == false){
		status = false;
		$('#timeformat_section1').find('.select2 span.select2-selection').attr("style", "border-bottom: solid 1px #fb0c0c !important;");
		$('.error_timeformat_section1').show();
	}

	// if(tf2_select_status == false){
	// 	status = false;
	// 	$('#timeformat_section2').find('.select2 span.select2-selection').attr("style", "border-bottom: solid 1px #fb0c0c !important;");
	// 	$('.error_timeformat_section2').show();
	// }

	// if(tf3_select_status == false){
	// 	status = false;
	// 	$('#timeformat_section3').find('.select2 span.select2-selection').attr("style", "border-bottom: solid 1px #fb0c0c !important;");
	// 	$('.error_timeformat_section3').show();
	// }

	return status;
}


// Ajax call save available contact 
function saveAvailableContact(){

	var fd = $('#available-phone-data').serialize();
	$.ajax({
        url: siteUrl+"/saveUserPhoneAvailable",
        type: "POST",
        data: fd,
        beforeSend: function(){
            $(".loading-process").show();
        },
        complete: function(){
            $(".loading-process").hide();
        },
        success:function(data){ 
			
			if(data.status == true){
                $(".print-success-msg").html(data.message);
                $(".print-success-msg").css('display','block');
        	}else{
        		$(".print-error-msg").html(data.message);
                $(".print-error-msg").css('display','block');
        	}
        }
    });
}



