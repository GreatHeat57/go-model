/*
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

var path = window.location.pathname; // Returns path only 
var siteUrl = window.location.origin;

$(document).ready(function()
{

	/* CSRF Protection */
	var token = $('meta[name="csrf-token"]').attr('content');
	if (token) {
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': token}
		});
	}

    /* Search Left Sidebar : Categories & Sub-categories */
    $('#subCatsList h5 a').click(function()
    {
        $('#subCatsList').hide();
        $('#catsList').show();
        return false;
    });

    /* Save the Post */
    $('.make-favorite, .save-job, a.saved-job').click(function(){
        savePost(this);
    });

    /* Save the Partner*/
    $('.make-favorite-partner, .save-partner, a.saved-partner').click(function(){
        savePartner(this);
    });

    /* Save the Acount User */
    $('.make-favorite-acount-user').click(function(){
        saveAcountUser(this);
    });

    /* Save the Search */
    $('#saveSearch').click(function(){
        saveSearch(this);
    });

});

/**
 * Save Ad
 * @param elmt
 * @returns {boolean}
 */
function savePost(elmt)
{      

    var postId = $(elmt).attr('data-post-id');
    var segment = $(elmt).attr('data-segment-id');

    $.ajax({
        method: 'POST',
        url: siteUrl + '/ajax/save/post',
        beforeSend: function(){
            $(".loading-process").show();
        },
        complete: function(){
            $(".loading-process").hide();
        },
data: {
            'postId': postId,
            '_token': $('input[name=_token]').val()
        }
    }).done(function(data) {
         
        if (typeof data.logged == "undefined") {
            return false;
        }
	
		/* Guest Users - Need to Log In */
        if (data.logged == '0') {
			$('#quickLogin').modal();
            return false;
        }
	
		/* Logged Users - Notification */
        if (data.status == 1) {

            $('#save-' + data.postId).addClass('active');
            $('#saved-' + data.postId).addClass('active');
            $('#save-' + data.postId).attr("title",textRemoveFromFav);
            $('#saved-' + data.postId).attr("title",textRemoveFromFav);
            
        } else {
            
            $('#save-' + data.postId).removeClass('active');
            $('#saved-' + data.postId).removeClass('active');
            $('#save-' + data.postId).attr("title",textAddtoFav);
            $('#saved-' + data.postId).attr("title",textAddtoFav);
            
            if(segment == 'favourites'){
                // window.location.reload();
                $('#modelDiv-'+postId).hide();

                if(data.is_fav == true){
                    $('#saved-' + data.postId).addClass('fav-post');
                    $('#saved-' + data.postId).attr("title",textRemoveFromFav);
                }else{
                    $('#saved-' + data.postId).removeClass('fav-post');
                    $('#saved-' + data.postId).attr("title",textAddtoFav);
                    var numItems = $('.fav-post').length;
                    if(numItems == 0 && $("#is_last_page").val() == 1){
                        $('.more-post-div').hide();
                        $('.no-result-found-div').show();
                    }
                }
            }
        }
        return false;
    });
    
    return false;
}

/**
 * Save Ad
 * @param elmt
 * @returns {boolean}
 */
function savePartner(elmt)
{   
    // var postId = $(elmt).closest('li').attr('id');
    var partnerId = $(elmt).attr('data-partner-id');
    var isFavPage = $(elmt).attr('data-is-fav');
    var attr = $(elmt);
    
    $.ajax({
        method: 'POST',
        url: siteUrl + '/account/save/partner',
        beforeSend: function(){
            $(".loading-process").show();
        },
        complete: function(){
            $(".loading-process").hide();
        },
        data: {
            'partnerId': partnerId,
            '_token': $('input[name=_token]').val()
        }
    }).done(function(data) {

        if (typeof data.logged == "undefined") {
            return false;
        }
    
        /* Guest Users - Need to Log In */
        if (data.logged == '0') {
            $('#quickLogin').modal();
            return false;
        }

        if(attr.hasClass( "active" )){
            if(isFavPage == 1){
                // $('#modelDiv-'+id).hide();
                $('#modelDiv-'+partnerId).hide();
            } else {
                $('#modelDiv-'+partnerId).show();
                // $('#modelDiv-'+id).show();
            }
            attr.removeClass('active');
            attr.attr("title",textAddtoFav);

        }else{
            attr.addClass('active');
            attr.attr("title",textRemoveFromFav);
        }

        if(isFavPage == 1){

            $('#save-'+partnerId).removeClass('fav-post');

            var numItems = $('.fav-post').length;
            if(numItems == 0 && $("#is_last_page").val() == 1){
                $('.more-post-div').hide();
                $('.no-result-found-div').show();
            }
        }

        // console.log(data);
        // if (typeof data.logged == "undefined") {
        //     return false;
        // }
    
        // /* Guest Users - Need to Log In */
        // if (data.logged == '0') {
        //     $('#quickLogin').modal();
        //     return false;
        // }

        // if(attr.hasClass( "active" )){

        //     console.log("if");

        //     console.log(isFavPage);

        //     if(isFavPage == 1){

        //         console.log(isFavPage);

        //         $('#modelDiv-'+partnerId).hide();

        //         console.log('#save-'+partnerId);

        //         $('#save-'+partnerId).removeClass('fav-post');

        //         var numItems = $('.fav-post').length;
        //         if(numItems == 0 && $("#is_last_page").val() == 1){
        //             $('.more-post-div').hide();
        //             $('.no-result-found-div').show();
        //         }
        //     } 
        //     attr.removeClass('active');
        //     attr.attr("title",textAddtoFav);
        // }else{
        //     attr.addClass('active');
        //     attr.attr("title",textRemoveFromFav);
        // }
        /* Logged Users - Notification */
        // if (data.status == 1) {
        //     $('#save-' + data.partnerId).addClass('active');
        //     $('#saved-' + data.partnerId).addClass('active');
        //     // alert(lang.confirmationSavePost);
        // } else {
        //     $('#save-' + data.partnerId).removeClass('active');
        //     $('#saved-' + data.partnerId).removeClass('active');
        //     // alert(lang.confirmationRemoveSavePost);
        //     if(path.indexOf('favorite-partners') >= 0){
        //         window.location.reload();
        //     }
        // }
        
        return false;
    });
    
    return false;
}

/**
 * Save Search
 * @param elmt
 * @returns {boolean}
 */
function saveSearch(elmt)
{   
    var url = $(elmt).attr('name');
    var countPosts = $(elmt).attr('count');

    $.ajax({
        method: 'POST',
        url: siteUrl + '/ajax/save/search',
        data: {
            'url': url,
            'countPosts': countPosts,
            '_token': $('input[name=_token]').val()
        }
    }).done(function(data) {
        if (typeof data.logged == "undefined") {
            return false;
        }
	
		/* Guest Users - Need to Log In */
        if (data.logged == '0') {
			$('#quickLogin').modal();
            return false;
        }
	
		/* Logged Users - Notification */
        if (data.status == 1) {
            alert(lang.confirmationSaveSearch);
        } else {
            alert(lang.confirmationRemoveSaveSearch);
        }
        
        return false;
    });
    
    return false;
}
/**
 * Save Acount User
 * @param elmt
 * @returns {boolean}
*/
function saveAcountUser(elmt){

    var segment = $(elmt).attr('data-segment-id');
    var id = $(elmt).attr('id');
    var attr = $(elmt);
    var siteUrl =  window.location.origin;
    var isFavPage = $(elmt).attr('data-is-fav');
    
    var url      = window.location.href;
    var urlArr = url.split("/");

    url = siteUrl + "/account/favorite/"+id; 
    $.ajax({
        method: "GET",
        url: url,
        beforeSend: function(){
            $(".loading-process").show();

            disableScrolling();
            // $(window).on({
            //     'mousewheel': function(e) {
            //         e.preventDefault();
            //         e.stopPropagation();
            //     }
            // })
        },
        complete: function(){
            $(".loading-process").hide();
            // $(window).unbind("mousewheel");
            enableScrolling();
        },
    }).done(function(e) {
        if(attr.hasClass( "active" )){
            if(isFavPage){
                $('#modelDiv-'+id).hide();
            } else {
                $('#modelDiv-'+id).show();
            }
            attr.removeClass('active');
            attr.attr("title",textAddtoFav);
        }else{
            attr.addClass('active');
            attr.attr("title",textRemoveFromFav);
        }

        if(segment == 'favourites'){

            $('#'+id).removeClass('fav-post');

            var numItems = $('.fav-post').length;
            if(numItems == 0 && $("#is_last_page").val() == 1){
                $('.more-post-div').hide();
                $('.no-result-found-div').show();
            }
        }
    });


    // windows scrolling disable before ajax call
    function disableScrolling(){
        
        var x=window.scrollX;
        var y=window.scrollY;

        window.onscroll=function(){ window.scrollTo(x, y); };
    }

    // conplate ajax call after windows scrolling enable
    function enableScrolling(){
        window.onscroll=function(){};
    }
}