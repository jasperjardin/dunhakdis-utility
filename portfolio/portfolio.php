<?php
add_action( 'init', 'd_utility_portfolio_register' );
add_action( 'init', 'd_utility_portfolio_taxonomy' );
add_filter( 'post_updated_messages', 'd_utility_portfolio_messages' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function d_utility_portfolio_register() {

	$labels = array(
		'name'               => __( 'Portfolio', 'Portfolio', 'dutility' ),
		'singular_name'      => __( 'Portfolio', 'Portfolio', 'dutility' ),
		'menu_name'          => __( 'Porfolios', 'admin menu', 'dutility' ),
		'name_admin_bar'     => __( 'Portfolio', 'add new on admin bar', 'dutility' ),
		'add_new'            => __( 'Add New', 'portfolio', 'dutility' ),
		'add_new_item'       => __( 'Add New Portfolio', 'dutility' ),
		'new_item'           => __( 'New Portfolio', 'dutility' ),
		'edit_item'          => __( 'Edit Portfolio', 'dutility' ),
		'view_item'          => __( 'View Portfolio', 'dutility' ),
		'all_items'          => __( 'All Portfolios', 'dutility' ),
		'search_items'       => __( 'Search Portfolios', 'dutility' ),
		'parent_item_colon'  => __( 'Parent Portfolios:', 'dutility' ),
		'not_found'          => __( 'No portfolio found.', 'dutility' ),
		'not_found_in_trash' => __( 'No portfolio found in trash.', 'dutility' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'dutility' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'			 => 'dashicons-portfolio',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'portfolio', $args );
}
/**
 * Book update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function d_utility_portfolio_messages( $messages ) {

	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	if ( 'portfolio' !== $post_type ) 
	{
		return $messages;
	}

	$messages['portfolio'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Portfolio updated.', 'dutility' ),
		2  => __( 'Custom field updated.', 'dutility' ),
		3  => __( 'Custom field deleted.', 'dutility' ),
		4  => __( 'Portfolio updated.', 'dutility' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Portfolio restored to revision from %s', 'dutility' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Portfolio published.', 'dutility' ),
		7  => __( 'Portfolio saved.', 'dutility' ),
		8  => __( 'Portfolio submitted.', 'dutility' ),
		9  => sprintf(
			__( 'Portfolio scheduled for: <strong>%1$s</strong>.', 'dutility' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'dutility' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Portfolio draft updated.', 'dutility' )
	);

	if ( $post_type_object->publicly_queryable ) 
	{

		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View portfolio', 'dutility' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview portfolio', 'dutility' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;

	}

	return $messages;
}

/**
 * Portfolio Taxonomy
 *
 * Registers our portfolio taxonomy
 * 
 * @return void
 */
function d_utility_portfolio_taxonomy() 
{
	register_taxonomy(
		'portfolio-category',
		'portfolio',
		array(
			'label' => __( 'Categories' ),
			'rewrite' => array( 'slug' => 'portfolio-category' ),
			'hierarchical' => true,
		)
	);

	return;
}