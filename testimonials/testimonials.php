<?php
add_action( 'init', 'd_utility_testimonials' );
/**
 * Register a testimonial post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function d_utility_testimonials() 
{
	$labels = array(
		'name'               => __( 'Testimonials', 'post type general name', 'dutility' ),
		'singular_name'      => __( 'Testimonial', 'post type singular name', 'dutility' ),
		'menu_name'          => __( 'Testimonials', 'admin menu', 'dutility' ),
		'name_admin_bar'     => __( 'Testimonial', 'add new on admin bar', 'dutility' ),
		'add_new'            => __( 'Add New', 'testimonial', 'dutility' ),
		'add_new_item'       => __( 'Add New Testimonial', 'dutility' ),
		'new_item'           => __( 'New Testimonial', 'dutility' ),
		'edit_item'          => __( 'Edit Testimonial', 'dutility' ),
		'view_item'          => __( 'View Testimonial', 'dutility' ),
		'all_items'          => __( 'All Testimonials', 'dutility' ),
		'search_items'       => __( 'Search Testimonials', 'dutility' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'dutility' ),
		'not_found'          => __( 'No testimonials found.', 'dutility' ),
		'not_found_in_trash' => __( 'No testimonials found in trash.', 'dutility' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'dutility' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'			 => 'dashicons-testimonial',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor' )
	);

	register_post_type( 'testimonial', $args );

}

add_filter( 'post_updated_messages', 'd_utility_testimonials_messages' );
/**
 * Testimonial update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function d_utility_testimonials_messages( $messages ) {
	
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	if ( 'testimonial' !== $post_type ) 
	{
		return $messages;
	}

	$messages['testimonial'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Testimonial updated.', 'dutility' ),
		2  => __( 'Custom field updated.', 'dutility' ),
		3  => __( 'Custom field deleted.', 'dutility' ),
		4  => __( 'Testimonial updated.', 'dutility' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Testimonial restored to revision from %s', 'dutility' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Testimonial published.', 'dutility' ),
		7  => __( 'Testimonial saved.', 'dutility' ),
		8  => __( 'Testimonial submitted.', 'dutility' ),
		9  => sprintf(
			__( 'Testimonial scheduled for: <strong>%1$s</strong>.', 'dutility' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'dutility' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Testimonial draft updated.', 'dutility' )
	);

	if ( $post_type_object->publicly_queryable ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View testimonial', 'dutility' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview testimonial', 'dutility' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}