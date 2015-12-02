/**
 * All the scripts we need to run the shortcodes
 * and other kind of functionality that belong
 * to this nifty plugin
 *
 * @since 1.0
 */
jQuery(document).ready( function($) 
{
 	'use strict';

 	$(window).load(function(){
 		/**
 	 * This function checks if propValue is undefine or not.
 	 * 
 	 * @return the propValue if set, otherwise, defaultValue set.
 	 */
 	var dutility_attr = function( propValue, defaultValue ) {
 		return !propValue ? defaultValue : propValue;
 	}

 	var dutility_bool_string = function( string ) {
 		return string === "false" ? false: true;
 	}

 	/**
 	 * Begin carousel
 	 */
 	var $carousel = $('.dunhakdis-utility-owl-carousel');

 	$.each( $carousel, function(){

 		var prop_items = dutility_attr( $(this).attr('data-items'), 4 );
 		var prop_navigation = dutility_attr( $(this).attr('data-navigation'), true );
 		var prop_pagination = dutility_attr( $(this).attr('data-pagination'), true );

 			prop_navigation = dutility_bool_string( prop_navigation );
 			prop_pagination = dutility_bool_string( prop_pagination );
 		
	  	$(this).owlCarousel({
	  		navigation: prop_navigation,
	  		items: prop_items,
	  		pagination: prop_pagination,
	  		lazyLoad: true,
	  		navigationText: false
	  	});

 	});

 	/**
 	 * Begin Isotopes
 	 */
 	$('.dunhakdis-utility-testimonials-masonry').imagesLoaded(function(){
 		$('.dunhakdis-utility-testimonials-masonry').isotope({
			// options...
			itemSelector: '.item',
			masonry: {
			}
		});
 	});
 	});

 	
});