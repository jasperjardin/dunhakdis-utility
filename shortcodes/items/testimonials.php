<?php
add_shortcode( 'dunhakdis_testimonials', 'dunhakdis_testimonials' );

function dunhakdis_testimonials( $atts ) 
{
	global $wpdb;

	extract(shortcode_atts( array(
        'hide_avatar' => false,
        'hide_company' => false,
        'hide_rating' => false,
        'has_pagination' => true,
        'has_navigation' => true,
        'data_items' => 3,
        'style' => 'carousel',
        'columns' => '4'
    ), $atts ));

	$testimonial_wrapper_class = 'dunhakdis-utility-owl-carousel dunhakdis-utility-testimonials-carousel';

	$allowed_type = array( 'carousel', 'list', 'masonry' );
	$allowed_column = array( '1','2','3','4' );

	if ( !in_array( $columns, $allowed_column ) ) {
		$columns = 3;
	}

	if ( !in_array( $style, $allowed_type ) ) {
		$style = 'carousel';
	}

	if ( $style === 'list') {
		$testimonial_wrapper_class = 'dunhakdis-utility-testimonials-list';
	}

	if ( $style === 'masonry') {
		$testimonial_wrapper_class = 'dunhakdis-utility-masonry dunhakdis-utility-testimonials-masonry column-'.$columns;
	}

	ob_start();
	?>
	
	<div class="dunhakdis-utility-testimonials">
		
		<ul class="<?php echo esc_attr( $testimonial_wrapper_class ); ?> dunhakdis-utility-list" data-items="<?php echo intval( $data_items ); ?>" 
		data-pagination="<?php echo ($has_pagination) ? 'true' : 'false'; ?>" 
		data-navigation="<?php echo ($has_navigation) ? 'true' : 'false'; ?>">

		<?php for( $i=1; $i<10; $i++ ) { ?>
			<?php 
				$allowed_html = array(
				    'a' => array(
				        'href' => array(),
				        'title' => array()
				    ),
				    'br' => array(),
				    'em' => array(),
				    'strong' => array(),
				); 

				$avatar_src = "http://thrive-demo.dunhakdis.me/wp-content/uploads/avatars/22/901e7d7479f1841a8bf57df3362ac8f0-bpfull.jpg";

				$testimonial_content = "Wireframe Kit is, without any doubt, a powerful tool (especially, in the 
					right hands) and we hope that it will help you make a good start for lots 
					of your projects and ideas! A perfectly simple way of creating 
					a great prototype";

			?>
			<li class="item">
				<?php //Carousel Style. ?>
				<?php if ( $style === 'carousel') { ?>
					<?php include plugin_dir_path( __FILE__ ) . '../shortcode-templates/testimonial-carousel.php'; ?>
				<?php } ?>
				<?php //List Style. ?>
				<?php if ( $style === 'list') { ?>
					<?php include plugin_dir_path( __FILE__ ) . '../shortcode-templates/testimonial-list.php'; ?>
				<?php } ?>
				<?php //Masonry Style. ?>
				<?php if ( $style === 'masonry') { ?>
					<?php include plugin_dir_path( __FILE__ ) . '../shortcode-templates/testimonial-masonry.php'; ?>
				<?php } ?>
			</li>
		<?php } ?>
		</ul>
	</div>

	<?php

	$content = ob_get_clean();

	return $content;
}