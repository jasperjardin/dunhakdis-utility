<?php

/**
 * Plugin Name: Dunhakdis Utility
 * Description: A helper plug-in that adds "bells and whistles" to variety of Premium WordPress Theme
 * Version: 1.0
 * Author: Dunhakdis
 * Author URI: http://dunhakdis.me
 * Text Domain: dutility
 * License: GPL2
 *
 * Includes all the file necessary for the plugin.
 *
 * PHP version 5
 *
 * @package   Dunhakdis Utility
 * @author    Dunhakdis <noreply@dunhakdis.me>
 * @copyright 2015 - Dunhakdis 
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://dunhakdis.me
 * @since     1.0
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'DUNHAKDIS_UTILITY_VERSION', 1.0 );

dunhakdis_utility_loader();

function dunhakdis_utility_loader()
{
	
	// All JS and CSS required.
	require_once plugin_dir_path( __FILE__ ) . 'core/enqueue.php';
	// All core functions.
	require_once plugin_dir_path( __FILE__ ) . 'core/functions.php';
	// The Portfolio.
	require_once plugin_dir_path( __FILE__ ) . 'portfolio/portfolio.php';
	// The Testimonials.
	require_once plugin_dir_path( __FILE__ ) . 'testimonials/testimonials.php';
	// Shortcodes.
	require_once plugin_dir_path( __FILE__ ) . 'shortcodes/shortcodes.php';

	return;

}
?>