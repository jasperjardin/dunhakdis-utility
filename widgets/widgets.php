<?php
/**
 * Dunhakdis Utility Widgets
 *
 * @since 1.0
 */
	$components = array(
		'blog-post/blog-post',
		'social-media/social-media',
		'latest-tweets/latest-tweets'
	);

	foreach ( $components as $component ) {
		include plugin_dir_path(__FILE__) . $component . '.php';
	}
?>
