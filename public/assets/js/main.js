$(document).ready(function(){		
	 $('#option_1').on('change',function(){
       if($(this).prop("checked") == true){
            $('#ad_firstname').val($('#first_name').val());
            $('#ad_email').val($('#email').val());
            $('#ad_phone').val($('#phone').val());
            $('#ad_address_1').val($('#address_1').val());
            $('#ad_address_2').val($('#address_2').val());
            $('#ad_postcode').val($('#postcode').val());
            $('#ad_town').val($('#city').val());
            $('#ad_county').val($('#county').val());

        }else if($(this).prop("checked") == false){
            // alert("Checkbox is unchecked.");
        }
     });

     $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    $('.add_new_skill').on('click',function(e){
        e.stopPropagation();
        var skills_value = $('.skills_value').val();
        if(skills_value == '' || skills_value == null){
            e.preventDefault();
            $('#error-skill').html(required_msg);
            $('#error-skill').show(); return false;
            $('.add_new_skill').prop('disabled', true);
        }else{
            // if(/^[a-zA-Z0-9- ]*$/.test(skills_value) == false) {
            if(/[`!~<>;\':@#%^&$*"\[\]\|{}()=_+]/.test(skills_value) == true) {
                $('#error-skill').html(skill_msg);
                $('#error-skill').show(); return false;
            }else{
                $('.add_new_skill').prop('disabled',false);
                $('#error-skill').hide();
            }
        }
        $.ajax({
         type: "POST",
         url: baseurl+"account/profile/talent",
         data:{'title':$('.skills_value').val(),'create': 'create'},
         dataType: 'json',
          beforeSend: function(){
              $(".loading-process").show();
          },
          complete: function(){
              $(".loading-process").hide();
          },
         success: function(data){
          //  console.log(data);
             var talent_html='';
             var obj = JSON.parse(data);
            //  console.log(obj);
             $.each(obj, function(index, element) {
                talent_html += '<a href="javascript:void(0);" class="tag extended delete-talent" data-talent-id="'+element.id+'" style="margin:2px;">'+element.title+'</a>';
            });
            $('.skill-list').html(talent_html);
            $('.skills_value').val("");
         }
        });
    });

    $("body").on('click','.delete-talent',function(e){
         e.stopPropagation();

        var talent_id = $(this).data('talent-id');
        var url = baseurl+'account/profile/talent/'+talent_id+'/delete';
        // console.log(url);
        $.ajax({
          type: "GET",
          url:url,
          dataType: 'json',
          beforeSend: function(){
              $(".loading-process").show();
          },
          complete: function(){
              $(".loading-process").hide();
          },
          success: function(data){

            //  console.log(data);
            var talent_html='';

            if(data != '' && data != null){
              var obj = JSON.parse(data);
              if(obj.length > 0){
                $.each(obj, function(index, element) {
                   talent_html += '<a href="javascript:void(0);" class="tag extended delete-talent" data-talent-id="'+element.id+'" style="margin:2px;">'+element.title+'</a>';
                });
              }
            }
            $('.skill-list').html(talent_html);
          }
        });
    });

    $("body").on('click','.add_new_language',function(e){
        $('.error-message').addClass('d-none');
        $('.success-message').addClass('d-none');
        $('#language').select2('val','0');
        $('#language_form .radio_field').prop('checked',false);
        $('#description1').val('');
    });

    $("body").on('click','.btn-addlanguage',function(e){
      e.preventDefault();
      e.stopPropagation();
      is_checked = false;
      var message = '';
      // console.log($('.language_select option:selected').val());
      $('.pradio').each(function () {
        if ($(this).is(':checked')) {
            is_checked = true;
        }
      });
      
      if($('.language_select option:selected').val() == "0"){ 
        $('.success-msg').addClass('d-none');
        $('.error-msg').removeClass('d-none');
        $('.error-msg').html(language_msg);
      }else if(is_checked == false){
        $('.success-msg').addClass('d-none');
        $('.error-msg').removeClass('d-none');
        $('.error-msg').html(professional_msg);
      }
      // else if($('#description1').val() == ""){
      //   $('.error-message').removeClass('d-none');
      //   $('.error-message').html(description_msg);
      // }
      else{


         $.ajax({
          method: "post",
          url: baseurl + "account/profile/language",
          data: new FormData($('#language_form')[0]),
          contentType: false,
          processData: false,
          beforeSend: function(){
            $('.btn-addlanguage').attr('disabled', true);
            $(".loading-process").show();
          },
          complete: function(){
            $(".loading-process").hide();
          },
          success: function (data) {
            var obj = data;
            
            if(obj.error == false){
              $('.error-msg').addClass('d-none');
              $('.success-msg').removeClass('d-none');
              $('.success-msg').html(obj.message);

              // $.featherlight.close();
              var language_html = '';
              $.each(obj.language, function(index, element) {
                  if (element.language_name != '') {
                      var language_code = element.language_name;
                      var language = $.map(obj.language_list, function(value, key) {
                          if (key == language_code)
                          {
                            return value;
                          }
                           
                      });
                      language = (language[0] != undefined)? language[0] : '';
                  } else {
                    var language = '';
                  }
                  if (element.proficiency_level != '') {

                    if (element.proficiency_level == 'native_language') {
                      var proficiency_level = native_language;
                    }

                    if (element.proficiency_level == 'basic_knowledge') {
                      var proficiency_level = basic_knowledge;
                    }

                    if (element.proficiency_level == 'perfect') {
                      var proficiency_level = perfect;
                    }

                    if (element.proficiency_level == 'advanced') {
                      var proficiency_level = advanced;
                    }

                  } else {
                    var proficiency_level = '';
                  }
               var edit_url = baseurl+'account/profile/language/'+element.id+'/edit';
               var description = (element.description != '') ? element.description : '';
               // language_html +="<p>"+index+"</p>";
               language_html += '<div class="pb-40 mb-40 bb-pale-grey row" id="language_item_'+element.id+'">'+
                                '<div class="col-md-9">'+
                                    '<span class="title">'+language+'</span>'+
                                    '<p class="mb-md-0">'+ proficiency_level +'</p><p class="mb-md-0">'+ description  +'</p>'+
                                '</div>'+
                                '<div class="col-md-3 d-flex justify-content-md-end">'+
                                    '<a href="'+edit_url+'" class="btn btn-white edit_grey mr-20 mini-all add_new_language"></a>'+
                                    '<a href="javascript:void(0);" data-language-id="'+element.id+'"  class="btn btn-white trash_white mini-all delete-language"></a>'+
                                '</div>'+
                            '</div>';          
               });

              $('.language_list').html(language_html);   
              
              setTimeout(function(){
                $('.btn-addlanguage').attr('disabled', false);
                $('#popup-model').modal('hide');
              }, 3000);    
            }else{
              $('.btn-addlanguage').attr('disabled', false);
              $('.success-msg').addClass('d-none');
              $('.error-msg').removeClass('d-none');
              $('.error-msg').html(obj.message);
            }    
          }, error: function (a, b, c) {
            $('.btn-addlanguage').attr('disabled', false);
            console.log('error');
          }
      }); 
      }

     
      
    }); 

    $("body").on('click','.delete-language',function(e){
        var language_id = $(this).attr('data-language-id');
        $.ajax({
          method: "get",
          url: baseurl + "account/profile/language/"+language_id+"/delete",
          data: new FormData($('#language_form')[0]),
          contentType: false,
          processData: false,
          beforeSend: function(){
              $(".loading-process").show();
          },
          complete: function(){
              $(".loading-process").hide();
          },
          success: function (data) {
              var obj = JSON.parse(data);
              if(obj.error == false){
                  // console.log(obj,obj.length);
                  $('#language_item_'+language_id).addClass('d-none');                
              }else{
                  $('.error-message').removeClass('d-none');
                  $('.error-message').html(obj.message);
                } 
          }, error: function (a, b, c) {
              console.log('error');
          }  
      });
    });

    $("body").on('click','.add_new_experience',function(e){
        $('.error-message').addClass('d-none');
        $('.success-message').addClass('d-none');
        $('#title').val('');
        $('[name="experience_to_birthDay"]').val('');
        $('[name="experience_from_birth[day]"]').select2("val", 0);
        $('[name="experience_from_birth[month]"]').select2("val", 0);
        $('[name="experience_from_birth[year]"]').select2("val", 0);
        $('[name="experience_to_birth[day]"]').select2("val", 0);
        $('[name="experience_to_birth[month]"]').select2("val", 0);
        $('[name="experience_to_birth[year]"]').select2("val", 0);
        $('#company').val('');
        $('#experience_description').val('');
    });

    $("body").on('click','.btn-addExperience',function(e){
      e.preventDefault();
      e.stopPropagation();
      is_checked = false;
      var is_to_date_valid = false;

      var from_day = $('[name="experience_from_birth[day]"]').val();
      var from_month = $('[name="experience_from_birth[month]"]').val();
      var from_year = $('[name="experience_from_birth[year]"]').val();
      var to_day = $('[name="experience_to_birth[day]"]').val();
      var to_month = $('[name="experience_to_birth[month]"]').val();
      var to_year = $('[name="experience_to_birth[year]"]').val();

      var experience_from_date =$('[name="experience_from_birthDay"]').val();
      var experience_to_date =$('[name="experience_to_birthDay"]').val();

      is_checked_update = false;

      if($('#up_to_date').is(':checked')){
        is_checked_update = true;
      }else{
        is_checked_update = false;
      }

      if(is_checked_update == true){
        var fullDate = new Date()
        var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
        experience_to_date = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
      }


      if(Date.parse(experience_from_date) >= Date.parse(experience_to_date)){
          $('.success-msg').addClass('d-none');
          $('.error-msg').removeClass('d-none');
          $('.error-msg').html(from_to_msg);
          return false;
      }

        if($('#title').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(title_msg);
            return false;
        }
        if( from_day == '' || from_month == '' || from_year == ''){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(from_date);
            return false;
        }
        
        // if(from_year != null && to_year != null ){
        //   if(from_year >= to_year){
        //     $('.success-message').addClass('d-none');
        //     $('.error-message').removeClass('d-none');
        //     $('.error-message').html(from_to_msg);
        //     return false; 
        //   }
        // }

        if($('#up_to_date').prop('checked') == true){
        }else {
          if(to_day == '' || to_month == '' || to_year == ''){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(to_date_msg);
            return false;
          }
        }
        if($('#company').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(company_msg);
            return false;
        }
        if($('#experience_description').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(description_msg);
            return false;
        }
            $('.error-msg').addClass('d-none');
            $.ajax({
              method: "post",
              url: baseurl + "account/profile/experience",
              data: new FormData($('#experience_form')[0]),
              contentType: false,
              processData: false,
              beforeSend: function(){
                $('.btn-addExperience').attr('disabled', true);
                $(".loading-process").show();
              },
              complete: function(){
                $(".loading-process").hide();
              },
              success: function (data) {
                // console.log(data);
                var experience_html = '';
                var obj = JSON.parse(data);
                if(obj.error == false){
                  $('.error-msg').addClass('d-none');
                  $('.success-msg').removeClass('d-none');
                  $('.success-msg').html(obj.message);

                  // console.log(obj,obj.experience.length);
                  $.each(obj.experience, function(index, element) {
                    var edit_url = baseurl+'account/profile/experience/'+element.id+'/edit';
                     if (element.up_to_date && element.up_to_date == '1') {
                      var to_date = upto_today;
                    } else {
                      var to_date = new Date(element.to);
                      to_date = to_date.getFullYear();  
                    }
                
                    var from_date = new Date(element.from);
                     experience_html+='<div class="pb-40 mb-40 bb-pale-grey row" id="experience_item_'+element.id+'">'+
                        '<div class="col-md-9"><p>'+element.title+' @ '+ element.company+'</p>'+
                          '<p>'+ from_date.getFullYear() +'-'+ to_date +'</p>'+
                        '</div>'+
                        '<div class="col-md-3 d-flex justify-content-md-end">'+
                            '<a href="'+edit_url+'" class="btn btn-white edit_grey mr-20 mini-all add_new_experience"></a>'+
                            '<a data-experience-id="'+element.id+'" href="javascript:void(0);" class="btn btn-white trash_white mini-all delete-experience"></a>'+
                        '</div>'+
                    '</div>';       
                  });
                
                  $('.experience_list').html(experience_html); 
                  setTimeout(function(){
                    $('.btn-addExperience').attr('disabled', false);
                    $('#popup-model').modal('hide');
                  }, 3000);
              }else{
                  $('.btn-addExperience').attr('disabled', false);
                  $('.error-msg').removeClass('d-none');
                  $('.error-msg').html(obj.message);
              } 

              }, error: function (a, b, c) {
                $('.btn-addExperience').attr('disabled', false);
                  console.log('error');
              }
          });
    });
      
    $("body").on('click','.delete-experience',function(e){
        var experience_id = $(this).attr('data-experience-id');
        $.ajax({
          method: "get",
          url: baseurl + "account/profile/experience/"+experience_id+"/delete",
          data: new FormData($('#experience_form')[0]),
          contentType: false,
          processData: false,
          beforeSend: function(){
              $(".loading-process").show();
          },
          complete: function(){
              $(".loading-process").hide();
          },
          success: function (data) {
            // console.log(data);
              var experience_html = '';
              var obj = JSON.parse(data);
              if(obj.error == false){
                  // console.log(obj,obj.experience.length);
                  if(obj.experience.length == 0){
                    experience_html +=' <div class="pb-40 mb-40 bb-pale-grey row">'+
                            '<div class="col-md-12">'+obj.message+'</div>'+
                        '</div>'; 
                    $('.experience_list').html(experience_html); 
                  }else{
                    $('#experience_item_'+experience_id).addClass('d-none');                  
                  }
              }else{
                  $('.error-message').removeClass('d-none');
                  $('.error-message').html(obj.message);
              } 
          }, error: function (a, b, c) {
              console.log('error');
          }
      });
    });


    $("body").on('click','.add_new_reference',function(e){
        $('.error-message').addClass('d-none');
        $('.success-message').addClass('d-none');
        $('#title').val('');
        $('#reference_description').val('');
        $('.birthDate').select2("val", 0);
        $('.birthMonth').select2("val", 0);
        $('.birthYear').select2("val", 0);
    });

    $("body").on('click','.btn-addReference',function(e){
      e.preventDefault();
      e.stopPropagation();
      var is_to_date_valid = false;

        if($('#title').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(title_msg);
        }else if($('.birthDate').val() == '' || $('.birthMonth').val() == '' || $('.birthYear').val() == ''){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(date_msg);
        }else if($('#reference_description').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(description_msg);
        }else{
            $('.error-msg').addClass('d-none');
            $.ajax({
              method: "post",
              url: baseurl + "account/profile/reference",
              data: new FormData($('#reference_form')[0]),
              contentType: false,
              processData: false,
              beforeSend: function(){
                $('.btn-addReference').attr('disabled', true);
                $(".loading-process").show();
              },
              complete: function(){
                  $(".loading-process").hide();
              },
              success: function (data) {
                var reference_html = '';
                var obj = JSON.parse(data);
                // console.log(obj);
                if(obj.error == false){
                      $('.error-msg').addClass('d-none');
                      $('.success-msg').removeClass('d-none');
                      $('.success-msg').html(obj.message);
                      // $.featherlight.close();

                      $.each(obj.reference, function(index, element) {
                        var edit_url = baseurl+'account/profile/reference/'+element.id+'/edit';
                      
                        var from_date = new Date(element.date);
                        from_date = from_date.getFullYear();
                         reference_html+='<div class="pb-40 mb-40 bb-pale-grey row" id="reference_item_'+element.id+'">'+
                              '<div class="col-md-9">'+
                                  '<p>'+element.title+'</p>'+
                                  '<p>'+from_date+'</p>'+
                              '</div>'+
                              '<div class="col-md-3 d-flex justify-content-md-end">'+
                                  '<a href="'+edit_url+'" class="btn btn-white edit_grey mr-20 mini-all add_new_reference"></a>'+
                                  '<a data-reference-id="'+element.id+'" class="btn btn-white trash_white mini-all delete-reference"></a>'+
                              '</div>'+
                          '</div>';       
                      });
                    // console.log(reference_html);
                    $('.reference_list').html(reference_html);
                    setTimeout(function(){
                      $('.btn-addReference').attr('disabled', false);
                      $('#popup-model').modal('hide');
                    }, 3000);
                }
                else{
                  $('.btn-addReference').attr('disabled', false);
                  $('.success-msg').addClass('d-none');
                  $('.error-msg').removeClass('d-none');
                  $('.error-msg').html(obj.message);
                } 
              }, error: function (a, b, c) {
                $('.btn-addReference').attr('disabled', false);
              }
          });
        }   
    });

    $("body").on('click','.delete-reference',function(e){
        var reference_id = $(this).attr('data-reference-id');
        $.ajax({
          method: "get",
          url: baseurl + "account/profile/reference/"+reference_id+"/delete",
          data: new FormData($('#reference_form')[0]),
          contentType: false,
          processData: false,
          beforeSend: function(){
              $(".loading-process").show();
          },
          complete: function(){
              $(".loading-process").hide();
          },
          success: function (data) {
            var reference_html = '';
            var obj = JSON.parse(data);
              if(obj.error == false){
                  // console.log(obj);
                  if(obj.reference.length == 0){
                    reference_html+=' <div class="pb-40 mb-40 bb-pale-grey row">'+
                            '<div class="col-md-12">'+obj.message+'</div>'+
                        '</div>'; 
                    $('.reference_list').html(reference_html); 
                  }else{
                    $('#reference_item_'+reference_id).addClass('d-none');               
                  }
              }else{
                  $('.error-message').removeClass('d-none');
                  $('.error-message').html(obj.message);
              } 
          }, error: function (a, b, c) {
              console.log('error');
          }
      });
    });


     $("body").on('click','.add_new_education',function(e){
        $('.error-message').addClass('d-none');
        $('.success-message').addClass('d-none');
        $('#title').val('');
        $('#reference_description').val('');
        $('.birthDate').select2("val", 0);
        $('.birthMonth').select2("val", 0);
        $('.birthYear').select2("val", 0);
        $('#institute').val('');
        $('#education_description').val('');
    });

    $("body").on('click','.btn-addEducation',function(e){
      e.preventDefault();
      e.stopPropagation();
      var is_to_date_valid = false;

      var from_day = $('[name="education_from_birth[day]"]').val();
      var from_month = $('[name="education_from_birth[month]"]').val();
      var from_year = $('[name="education_from_birth[year]"]').val();
      var to_day = $('[name="education_to_birth[day]"]').val();
      var to_month = $('[name="education_to_birth[month]"]').val();
      var to_year = $('[name="education_to_birth[year]"]').val();
      
      var education_from_date =$('[name="education_from_birthDay"]').val();
      var education_to_date =$('[name="education_to_birthDay"]').val();

      is_checked_update = false;

      if($('#up_to_date').is(':checked')){
        is_checked_update = true;
      }else{
        is_checked_update = false;
      }

      if(is_checked_update == true){
        var fullDate = new Date()
        var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
        education_to_date = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
      }

      if(Date.parse(education_from_date) >= Date.parse(education_to_date)){
          $('.success-msg').addClass('d-none');
          $('.error-msg').removeClass('d-none');
          $('.error-msg').html(from_to_msg);
          return false;
      }


        if($('#title').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(title_msg);
            return false;
        }
        if(from_day == '' || from_month == '' || from_year == ''){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(from_date);
            return false;
        }
        // if(from_year != null && to_year != null ){
        //   if(from_year >= to_year){
        //     $('.success-message').addClass('d-none');
        //     $('.error-message').removeClass('d-none');
        //     $('.error-message').html(from_to_msg);
        //     return false;
        //   }
        // }

        if($('#up_to_date').prop('checked') == true){
        }else {
          if(to_day == '' || to_month == '' || to_year == ''){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(to_date_msg);
            return false;
          }
        }
        if($('#institute').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(institute_msg);
            return false;
        }
        if($('#education_description').val().length == 0){
            $('.success-msg').addClass('d-none');
            $('.error-msg').removeClass('d-none');
            $('.error-msg').html(description_msg);
            return false;
        }

          $('.error-msg').addClass('d-none');
          $.ajax({
              method: "POST",
              url: $('.education_form').attr('action'),
              data: new FormData($('.education_form')[0]),
              enctype: 'multipart/form-data',
              contentType: false,
              processData: false,
              beforeSend: function(){
                $('.btn-addEducation').attr('disabled', true);
                $(".loading-process").show();
              },
              complete: function(){
                  $(".loading-process").hide();
              },
              success: function (data) {
                  // console.log(data);
                  var education_html = '';
                  var obj = JSON.parse(data);
                  // console.log(obj);
                    if(obj.error == false){
                        $('.error-msg').addClass('d-none');
                        $('.success-msg').removeClass('d-none');
                        $('.success-msg').html(obj.message);
                        // $.featherlight.close();

                        $.each(obj.education, function(index, element) {
                          var edit_url = baseurl+'account/profile/education/'+element.id+'/edit';
                        if (element.up_to_date !='' && element.up_to_date == '1') {
                            to_date = upto_today;
                          } else {
                            var to_date = new Date(element.to);
                            to_date = to_date.getFullYear();
                          }
                          var from_date = new Date(element.from);
                            education_html+='<div class="pb-40 mb-40 bb-pale-grey row" id="education_item_'+element.id+'">'+
                                '<div class="col-md-9">'+
                                  '<p>'+element.title+
                                    '<span class="bullet rounded-circle bg-lavender d-inline-block mx-2 mb-1"></span>'+element.institute+
                                  '</p>'+
                                    '<p>'+ from_date.getFullYear() +'-'+ to_date +'</p>'+
                                '</div>'+
                                '<div class="col-md-3 d-flex justify-content-md-end">'+
                                    '<a href="'+edit_url+'" class="btn btn-white edit_grey mr-20 mini-all add_new_education"></a>'+
                                    '<a href="javascript:void(0);" data-education-id="'+element.id+'"  class="btn btn-white trash_white mini-all delete-education"></a>'+
                                '</div>'+
                            '</div>';       
                        });
                        $('.education_list').html(education_html); 
                        setTimeout(function(){
                          $('.btn-addEducation').attr('disabled', false);
                          $('#popup-model').modal('hide'); 
                        }, 3000);
                      }else{
                        $('.btn-addEducation').attr('disabled', false);
                        $('.success-msg').addClass('d-none');
                        $('.error-msg').removeClass('d-none');
                        $('.error-msg').html(obj.message);
                    } 
                  }, error: function (a, b, c) {
                      $('.btn-addEducation').attr('disabled', false);
                  }
          }); 
    });

    $("body").on('click','.delete-education',function(e){
        var education_id = $(this).attr('data-education-id');
        $.ajax({
          method: "get",
          url: baseurl + "account/profile/education/"+education_id+"/delete",
          data: new FormData($('#education_form')[0]),
          contentType: false,
          processData: false,
          beforeSend: function(){
              $(".loading-process").show();
          },
          complete: function(){
              $(".loading-process").hide();
          },
          success: function (data) {
              education_html = '';
              var obj = JSON.parse(data);
              if(obj.error == false){
                  // console.log(obj,obj.education.length);
                  if(obj.education.length == 0){
                    education_html+=' <div class="pb-40 mb-40 bb-pale-grey row">'+
                            '<div class="col-md-12">'+obj.message+'</div>'+
                        '</div>'; 
                    $('.education_list').html(education_html); 
                  }else{
                    $('#education_item_'+education_id).addClass('d-none');                   
                  }
              }else{
                  $('.error-message').removeClass('d-none');
                  $('.error-message').html(obj.message);
              } 
          }, error: function (a, b, c) {
              console.log('error');
          }
      });
    });
});


$(document).on('click','.featherlight-close',function(){
  $('.btn-addlanguage').attr('disabled', false);
  $('.btn-addExperience').attr('disabled', false);
  $('.btn-addReference').attr('disabled', false);
  $('.btn-addEducation').attr('disabled', false);
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// scroll to top function on scroll of 30 px
// window.onscroll = function() {scrollFunction()};

// function scrollFunction() {
//   if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
//     document.getElementById("btnScrollTop").style.display = "block";
//   } else {
//     document.getElementById("btnScrollTop").style.display = "none";
//   }
// }

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}