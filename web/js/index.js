/***************************************************
			Camera Slider
***************************************************/
jQuery.noConflict()(function($){
    $('#camera_wrap_1').camera({
        thumbnails: false,
        pagination: false,
        loader: 'bar',
        loaderPadding: 0,
        loaderStroke: 3,
        pagination: true,
        loaderColor: '#7d7d7d'
    });
});


/***************************************************
			jCarousel
***************************************************/
jQuery.noConflict()(function($){
var $zcarousel = $('#projects-carousel');

    if( $zcarousel.length ) {

        var scrollCount;
        var itemWidth;

        if( $(window).width() < 479 ) {
           		scrollCount = 1;
            	itemWidth = 300;
        	} else if( $(window).width() < 768 ) {
            	scrollCount = 2;
            	itemWidth = 200;
        	} else if( $(window).width() < 960 ) {
            	scrollCount = 3;
            	itemWidth = 172;
        	} else {
            	scrollCount = 4;
            	itemWidth = 230;
        }

        $zcarousel.jcarousel({
			   easing: 'easeInOutQuint',
        	   animation : 800,
               scroll    : scrollCount,
               setupCallback: function(carousel) {
               carousel.reload();
                },
                reloadCallback: function(carousel) {
                    var num = Math.floor(carousel.clipping() / itemWidth);
                    carousel.options.scroll = num;
                    carousel.options.visible = num;
                }
            });
        }
});