/***************************************************
			ISOTOP - PORTFOLIO
***************************************************/
jQuery.noConflict()(function($){
	// cache container
	var $container = $('#container-portfolio');

	// initialize isotope
	$container.isotope({
				  itemSelector : '.item-block',
				  layoutMode : 'fitRows'
	});

      var $optionSets = $('#filters'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
          var $this = $(this);
          // don't proceed if already selected
          if ( $this.hasClass('selected') ) {
            return false;
          }
          var $optionSet = $this.parents('#filters');
          $optionSet.find('.selected').removeClass('selected');
          $this.addClass('selected');
		});

	// filter items when filter link is clicked
	$('#filters a').click(function(){
	  var selector = $(this).attr('data-filter');
	  $container.isotope({ filter: selector });
	  return false;
	});
});

/***************************************************
					Flickr
***************************************************/
	
	
/* Major Colorbox */
jQuery.noConflict()(function($){
$(document).ready(function() {	
	$('a.zoom').colorbox();
	$('.mask a[data-rel="zoom-img"]').colorbox({inline:true});
});
});