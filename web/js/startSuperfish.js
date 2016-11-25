/***************************************************
			SUPER FISH MENU
***************************************************/
jQuery.noConflict()(function($){
$(document).ready(function() {
   $("ul.sf-menu").superfish({ 
            pathClass:  'current',
			autoArrows	: false,
			delay:300,
			speed: 'normal',
			animation:   {opacity:'show'}
        }); 
    });
});