<?php
/**
 * Dunhakdis Utility Widgets
 *
 * @since 1.0
 */
	$components = array(
		'blog-post/blog-post',
		'social-media/social-media',
	);

	foreach ( $components as $component ) {
		include plugin_dir_path(__FILE__) . $component . '.php';
	}
?>
