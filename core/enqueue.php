<?php
/**
 * Register all the assets we need
 *
 * @since  1.0
 */

function dunhakdis_utility_scripts() 
{
	
	$css_dir = plugin_dir_url('') . 'dunhakdis-utility/assets/css/';
	$js_dir = plugin_dir_url('')  . 'dunhakdis-utility/assets/js/';

	// Dunhakdis Utility Stylesheet.
	wp_enqueue_style( 'dunhakdis-utility-stylesheet', esc_url( $css_dir . 'dunhakdis-utility.css' ), $deps = array(), $ver = DUNHAKDIS_UTILITY_VERSION );

	// jQuery Isotopes.
	wp_enqueue_script( 'dunhakdis-utility-isotopes', esc_url( $js_dir . 'dunhakdis-isotopes.js' ), array( 'jquery' ), DUNHAKDIS_UTILITY_VERSION, true );
	
	// jQuery Owl Carousel.
	wp_enqueue_script( 'dunhakdis-utility-owl-carousel', esc_url( $js_dir . 'dunhakdis-owl-carousel.js' ), array( 'jquery' ), DUNHAKDIS_UTILITY_VERSION, true );
	
	// Dunhakdis Utility Scripts.
	wp_enqueue_script( 'dunhakdis-utility-script', esc_url( $js_dir . 'dunhakdis-script.js' ), array( 'dunhakdis-utility-isotopes', 'dunhakdis-utility-owl-carousel' ), DUNHAKDIS_UTILITY_VERSION, true );

	return;

}

add_action( 'wp_enqueue_scripts', 'dunhakdis_utility_scripts' );