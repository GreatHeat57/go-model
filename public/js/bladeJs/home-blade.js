$(document).ready(function(){var imageEle=$("img");$(imageEle).each(function(){if(typeof $(this).attr("alt")==typeof undefined||$(this).attr("alt")==""){var altText="Go-Models";if($(this).attr("src")!=undefined){var imagename=$(this).attr("src");var last=imagename.substring(imagename.lastIndexOf("/")+1,imagename.length);altText=last.split(".")[0];$(this).attr("alt",altText)}}})});var getUrl=baseurl+"home-ajax-content";var is_reached=false;$(window).on("scroll",function(){setTimeout(function(){if($(window).scrollTop()>=$("#viewpoint").offset().top+$("#viewpoint").outerHeight()-window.innerHeight*3){if(!is_reached){$.ajax({url:getUrl,type:"get",beforeSend:function(){$("#loading_category_section").show()},complete:function(){$("#loading_category_section").hide()},success:function(data){$("#ajax-render").html(data.html);$(".block .testimonials").owlCarousel({slideSpeed:300,paginationSpeed:400,autoHeight:true,loop:true,autoplay:false,autoplayTimeout:5e3,autoplayHoverPause:true,startPosition:0,responsive:{0:{items:1,nav:true,margin:0,navigation:true},767:{items:2,nav:true,margin:0,navigation:true},1399:{items:3,nav:true,margin:0,navigation:true}}});$(".block .testimonials").on("resized.owl.carousel",function(event){var $this=$(this);$this.find(".owl-height").css("height",$this.find(".owl-item.active").height())})},error:function(err){console.log(err)}});is_reached=true}}},100)});
