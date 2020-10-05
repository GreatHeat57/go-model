$(window).on('load', function(){
    // testimonials
    $('.block .testimonials').owlCarousel({
        slideSpeed : 300,
        paginationSpeed : 400,
        autoHeight:true,
        loop:true,
        autoplay:false,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        startPosition: 0,
        responsive:{
            0:{
                items:1,
                nav: true,
                margin: 0,
                navigation : true, // Show next and prev buttons
            },
            767:{
                items:2,
                nav: true,
                margin: 0,
                navigation : true, // Show next and prev buttons
            },
            1399:{
                items:3,
                nav: true,
                margin: 0,
                navigation : true, // Show next and prev buttons
            }
        }
    });

    $('.block .testimonials').on('resized.owl.carousel', function(event) {
        var $this = $(this);
        $this.find('.owl-height').css('height', $this.find('.owl-item.active').height() );
    });

    // featured models
    $('.block .featured-models').owlCarousel({
        slideSpeed : 300,
        paginationSpeed : 400,
        autoHeight:true,
        loop:true,
        autoplay:false,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        startPosition: 0,
        responsive:{
            0:{
                items:3,
                nav: true,
                margin: 20,
                navigation : true, // Show next and prev buttons
            },
            767:{
                items:4,
                nav: true,
                margin: 20,
                navigation : true, // Show next and prev buttons
            },
            979:{
                items:6,
                nav: true,
                margin: 20,
                navigation : true, // Show next and prev buttons
            },
            1599:{
                items:8,
                nav: true,
                margin: 20,
                navigation : true, // Show next and prev buttons
            }
        }
    });

    $('.block .featured-models').on('resized.owl.carousel', function(event) {
        var $this = $(this);
        $this.find('.owl-height').css('height', $this.find('.owl-item.active').height() );
    });
});