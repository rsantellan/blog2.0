jQuery.noConflict()(function($){
  $(document).ready(function(){
          $('#slides-item').slides({
              generateNextPrev: true,
              generatePagination: false,
              effect: 'fade',
              crossfade: true,
              preload: true,
              preloadImage: $('#image-loader-location').val(),
              pause: 2500,
              hoverPause: true
          });
          $('a.zoom').colorbox({photo : true, rel:'gal'});
      });
 });