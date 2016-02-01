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
 	$('.dunhakdis-utility-masonry').imagesLoaded(function(){
	 		$('.dunhakdis-utility-masonry').isotope({
				// options...
				itemSelector: '.item',
				masonry: {
				}
			});
 		});
    /**
    * Begin Instagram ajax call
    */
    var dutility_instagram_endpoint_api_url = 'https://api.instagram.com/v1/users/3/media/recent/?access_token=2870182492.1677ed0.62f6b43513214219a5b5ce65024b95b2';
    $.ajax({
        type: 'GET',
        url: dutility_instagram_endpoint_api_url,
        contentType: "application/json",
        dataType: 'jsonp',
        data: {
            action: 'dutility_instagram_endpoint',
        },
        success: function( respone ) {
            var imagesObjects = response.data;
            console.log( response );
            $.each( imagesObjects, function( nodeListIndex, nodeListItem ) {
                //console.log(nodeListItem.images);
                var imageSrcUrl = nodeListItem.images.thumbnail.url;
                $("<img />").attr("src", imageSrcUrl).appendTo("#images");
            });
        },

        error: function(error) {
           console.log(error.message);
        }
    }); //$.ajax

});
