<?php

/**
 * Adds Dunhakdis_Recent_Post_Widget widget.
 */
class Dunhakdis_Recent_Post_Widget extends WP_Widget {
  /**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'dunhakdis_recent_post_widget', // Base ID
			__( 'Dunhakdis: Blog Widget', 'dutility' ), // Name
			array( 'description' => __( 'Use this widget display blog post.', 'dutility' ), ) // Args
		);
	}

}
