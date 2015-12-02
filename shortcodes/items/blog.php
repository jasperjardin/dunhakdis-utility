<?php
add_shortcode( 'dunhakdis_blogs', 'dunhakdis_blogs' );

function dunhakdis_blogs( $atts ) 
{
	global $wpdb;

	$args = array(
			'post_type' => 'post'
		);

	ob_start();

	$content = "";

	query_posts( $args );

	if ( have_posts() ) {
		while( have_posts() ) {
			the_post();
			?>
			<h3>
				<a href="<?php echo esc_url( the_title() ); ?>" title="<?php echo esc_attr( the_title() ); ?>">
					<?php the_title(); ?>
				</a>
			</h3>
			<?php the_post_thumbnail(); ?>
			<p>
				<?php the_excerpt(); ?>
			</p>
			<?php
		}
	}

	wp_reset_query();

	$content = ob_get_clean();

	return $content;
}
?>