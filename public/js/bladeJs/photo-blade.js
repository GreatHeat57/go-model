$(document).ready( function(){
 	$(".loading-process").hide();
    $('#warning-close-windows').hide();
	
	if(modelBookCount >= 5) {
        $("#add_line").addClass("disabled");
        $("#5imgValid").show();
        return false;
    }

    $('#add_line').click( function(){
		modelBookCount++;

        if(modelBookCount >= 6) {
            $("#5imgValid").show();
            $("#add_line").addClass("disabled");
            return false;
       }else{
            $("#5imgValid").hide();
            $("#add_line").removeClass("disabled");
       } 

        var html = "<div class='w-lg-750 w-xl-970 mx-auto upload-zone mb-20 init-elem' id='"+modelBookCount+"'><div class='pt-40 px-38 px-lg-0'><div class='pb-20 d-md-flex'><div class='profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30'><img id='output-partner-logo-"+modelBookCount+"' src="+defaultPicture+" alt='user' ></div><div class='d-md-inline-block'><div class='upload-btn-wrapper'><a href='#' class='btn btn-white upload_white upload-picture mb-20'>"+selectPhotoInput+"</a><input type='file' id='modelImg"+modelBookCount+"'name='modelbook[filename][]' onchange='changeFile(event, "+modelBookCount+")' /></div><p class='w-lg-460 pt-20'>"+showValidFileTypes+"</p></div></div><p id='error-profile-logo-"+modelBookCount+"' class='pb-20'></p></div></div>";
		$('#append-image').append(html);
	});

	$('form#register-photo-tab').submit(function(event) {
            
        var errorShowId = 'error-profile-logo-0';
        if (userProfileLogo == '') {
        
            if($('#upload_image_value').val() == ""){
                $('#error-profile-logoerror').html(imageRequiredError).css("color", "red");
                $('html, body').animate({
                   scrollTop: $("#profile-image-div").offset().top
                }, 1000, function() {
                    //$("#reg-data [name='city']").focus();
                });
                return false;
            }
        }  
		
		var input = $("#append-image :input");
		var count = k;
        for (var i = 0; i < input.length; i++) {

            count++;
            var ele = document.getElementById('modelImg'+count); 
			var errorShowId = 'error-profile-logo-'+count;
            var status = fileValid(ele, errorShowId); 
			var Scroll_div = '#output-partner-logo-'+count;
			
			if(status == false){

                $('html, body').animate({
                   scrollTop: $(Scroll_div).offset().top
                }, 1000, function() {
                    //$("#reg-data [name='city']").focus();
                });
                return false;
            }
        }

        $('#warning-close-windows').show();
        $('#image-upload-register').prop('disabled', true);
        $(".loading-process").show();
        return true;
    });

    function fileValid(ele, errorShowId){
		
		if(ele.files.length !== 0){
            
            var imageType = ele.files[0].type.toLowerCase();
            var imageSize = ele.files[0].size;
            var fileSize = Math.round((imageSize / 1024));

            var extension = imageType.split('/');

            //check image extension  
            if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {
                
                $('#'+errorShowId).html(invalid_image_type).css("color", "red");
                return false;  
            }

            if(fileSize > maxUploadImageSize){
                    
                $('#'+errorShowId).html(maximum_allowed_upload).css("color", "red");
                return false;
            }
        }
        return true;
    }
});

function changeFile(event, i) {
        
    var fileElement = event.target;

    if (fileElement.value == "") {
    	$("#output-partner-logo-"+i).attr("src", defaultPicture); 
	}else{
        loadLogoFile(event ,i);
    }
}

function loadLogoFile(event, i) {
    var fileSize = Math.round((event.target.files[0].size / 1024));
    var filename = event.target.files[0].name;
        
    if(fileSize > maxUploadImageSize){
		
		$("#output-partner-logo-"+i).attr("src", defaultPicture);
        $('#'+event.target.id).val(''); 

        $('#error-profile-logo-'+i).html(fileString+' '+filename+' ('+fileSize+' KB) '+maximum_allowed_upload+' '+imageSize+' KB.').css("color", "red");
        return false;
    }else{
        $('#error-profile-logo-'+i).html('');
    }

    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output-partner-logo-'+i);
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

jQuery.noConflict();

jQuery(document).ready( function($){

    var viewportWidth = 300;
    var viewport = $(window).width();

    if (viewport < 360) {
        
        viewportWidth = 250;
    }
    
    // profile picture input reset after upload image or close popup
    $('#uploadimageModal').on('hide.bs.modal', function(){
        
        if ($('#upload_image').length > 0) {
            
            $('#upload_image').val("");
        }
        scrollLock.enablePageScroll(document.getElementById('uploadimageModal'));
    })

	$("#error-profile-pic").hide();

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
          width:200,
          height:200,
          type:'square' //circle
        },
        boundary:{
          width:viewportWidth,
          height:300
        },
        enableOrientation: true
    });

    var imageType = 'png';

    $('#upload_image').on('change', function(){

        // $("#success-profile-pic").hide();
        $("#error-profile-pic").show();

        // get curent selected image
        var partnerprofileLogo = document.getElementById('upload_image');
        
        // profile logo validate
        if(partnerprofileLogo.files.length > 0) { 
            
            var logoImageType = partnerprofileLogo.files[0].type.toLowerCase();
            var logoImageSize = partnerprofileLogo.files[0].size;
            var logoFileSize = Math.round((logoImageSize / 1024));
            var logoExtension = logoImageType.split('/');

            //check image extension  
            if($.inArray(logoExtension[1], ['gif','png','jpg','jpeg']) == -1) {

                $('#error-profile-pic').html(fileTypeValidationError).css("color", "red");
                return false;   
            }

            // file size check
            if(logoFileSize > maxUploadImageSize){

                $('#error-profile-pic').html(fileString+' '+partnerprofileLogo.files[0].name+' ('+logoFileSize+' KB) '+maximum_allowed_upload+' '+maxUploadImageSize+' KB.').css("color", "red");
                return false;
            }
        }else{

            $('#error-profile-logo').html(corruptedImageError).css("color", "red");
            return false;
        }
    
        var reader = new FileReader();
        reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
          }).then(function(){
          });
        }
        reader.readAsDataURL(this.files[0]);

        imageType = this.files[0].type.toLowerCase();

        imageTypeArr = imageType.split('/');

        imageType = imageTypeArr[1];

        $('#uploadimageModal').modal('show');
        scrollLock.disablePageScroll(document.getElementById('uploadimageModal'));
    });

    $('.rotate').click(function(event){
        var degree = 90;
        if($(this).hasClass("rotate-right")) {
            degree = -90;
        }
        // console.log($image_crop);
        $image_crop.croppie('rotate', degree);
    });

    $('.crop_image').click(function(event){
        
        $image_crop.croppie('result', {
          type: 'canvas',
          // size: 'viewport',
          size : { width: 600, height: 600 },
          format : imageType,
        }).then(function(response){
          
            $.ajax({
            
                url: siteUrl+"/cropProfileImage",
                type: "POST",
                data:{"image": response, "user_id": user_id},
                beforeSend: function(){
                    $(".loading-process").show();
                },
                complete: function(){
                    $(".loading-process").hide();
                },
                success:function(data){ 
                    
                    $('#uploadimageModal').modal('hide');
                    $('#uploaded_image').html(data.html);
                    
                    if(data.success == true){

                        $("#error-profile-pic").hide();
                        $("#error-profile-logoerror").hide();
                        // $("#success-profile-pic").show();
                        $("#upload_image_value").val(data.imagename);
                        // $("#success-profile-pic").html(data.message).css("color", "green");
                    }else{

                        // $("#success-profile-pic").hide();
                        $("#error-profile-pic").show();
                        $("#error-profile-pic").html(data.message).css("color", "red");
                    }
                }
            });
        })
    });
});