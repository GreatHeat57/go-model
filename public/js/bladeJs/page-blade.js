jQuery.noConflict()(function($){
    $(document).ready( function(){
        if (is_auth && user_type_id == 2){
            $('.section_1').attr('href', model_list_url);
            $('.section_2').attr('href', model_list_url);
            $('.section_3').attr('href', model_list_url).addClass('next green white');
            $('.section_4').attr('href', model_list_url).addClass('next green white');
        }else if(is_auth && user_type_id == 3){
            $('.section_1').attr('href', 'javascript:void(0);').addClass('disabled disabled_opacity');
            $('.section_2').attr('href', 'javascript:void(0);').addClass('disabled disabled_opacity');
            $('.section_3').attr('href', 'javascript:void(0);').addClass('disabled disabled_opacity green white');
            $('.section_4').attr('href', 'javascript:void(0);').addClass('disabled disabled_opacity green white');
        }else{
            $('.section_1').attr('href', login_url);
            $('.section_2').attr('href', '#').addClass('mfp-register-form');
            $('.section_3').attr('href', '#').addClass('mfp-register-form green white');
            $('.section_4').attr('href', '#').addClass('mfp-register-form green white');
        }

        //go-premium buttons conditions
        if (is_auth){
            $('.premium_section').attr('href', 'javascript:void(0);').addClass('disabled disabled_opacity');
            $('.premium_section_2').attr('href', 'javascript:void(0);').addClass('disabled disabled_opacity green next');
        }else{
            $('.premium_section').attr('href', '#').addClass('mfp-register-form');
            $('.premium_section_2').attr('href', '#').addClass('mfp-register-form green next');
        }

        if (is_auth && user_type_id == 2){ 
            $('.post_job').attr('href', model_list_url);
        }else{
            $('.post_job').attr('href', post_job_url);
        }
    });
});
