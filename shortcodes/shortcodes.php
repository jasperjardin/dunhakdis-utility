<?php
/**
 * This file loads all the shortcodes
 *
 * @since  1.0 
 */

// Including all Shortcode files from a shortcodes sub folder and avoiding adding a unnecessary global 
// just to determine a path that is already available everywhere just using WP core functions.
foreach ( glob( plugin_dir_path( __FILE__ ) . "items/*.php" ) as $file ) 
{
    require_once $file;
}
?>