<?php
add_shortcode( 'dunhakdis_testimonials', 'dunhakdis_testimonials' );
add_action( 'vc_before_init', 'dunhakdis_testimonials_vc' );

function dunhakdis_testimonials( $atts ) 
{
	global $wpdb;

	extract(shortcode_atts( array(
        'hide_avatar' => false,
        'hide_company' => false,
        'hide_rating' => false,
        'has_pagination' => 'yes',
        'has_navigation' => 'yes',
        'data_items' => 3,
        'color' => '',
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
	
	<?php if ( !empty( $color ) ) { ?>
		<style> .dunhakdis-utility-testimonials, .dunhakdis-utility-testimonials a { color: <?php echo esc_html($color); ?>; } </style>
	<?php } ?>
	<?php echo $has_navigation; ?>
	<div class="dunhakdis-utility-testimonials">
		
		<ul class="<?php echo esc_attr( $testimonial_wrapper_class ); ?> dunhakdis-utility-list" data-items="<?php echo intval( $data_items ); ?>" 
		data-pagination="<?php echo ($has_pagination === 'yes') ? 'true' : 'false'; ?>" 
		data-navigation="<?php echo ($has_navigation === 'yes') ? 'true' : 'false'; ?>">

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

function dunhakdis_testimonials_vc() 
{
	vc_map( array(
      	"name" => __( "Testimonials", "dutility" ),
      	"base" => "dunhakdis_testimonials",
      	"class" => "",
      	"category" => __( "Content", "dutility"),
      	"params" => array(
      		array(
            	"type" => "colorpicker",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Color", "dutility" ),
            	"param_name" => "color",
            	"description" => __( "The color of text including links.", "dutility" )
         	),
         	array(
            	"type" => "textfield",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Items", "dutility" ),
            	"param_name" => "data_items",
            	"value" => 4,
            	"description" => __( "How many testimonials to show per slide (carousel only).", "dutility" )
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Columns", "dutility" ),
            	"param_name" => "columns",
            	"description" => __( "Applicable only to 'masonry' style. Will divide your testimonials into selected number of columns.", "dutility" ),
            	"value" => array(
            			'1' => '1',
            			'2' => '2',
            			'3' => '3',
            			'4' => '4',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Style", "dutility" ),
            	"param_name" => "style",
            	"description" => __( "How the testimonial should appear.", "dutility" ),
            	"value" => array(
            			'Carousel' => 'carousel',
            			'List' => 'lists',
            			'Masonry' => 'masonry',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Hide Avatar", "dutility" ),
            	"param_name" => "hide_avatar",
            	"description" => __( "Hides the avatar if set to 'No'.", "dutility" ),
            	"value" => array(
            			'No' => 'no',
            			'Yes' => 'yes',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Hide Company", "dutility" ),
            	"param_name" => "hide_company",
            	"description" => __( "Hides the company if set to 'No'.", "dutility" ),
            	"value" => array(
            			'No' => 'no',
            			'Yes' => 'yes',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Hide Rating", "dutility" ),
            	"param_name" => "hide_rating",
            	"description" => __( "Hides the rating if set to 'No'.", "dutility" ),
            	"value" => array(
            			'No' => 'no',
            			'Yes' => 'yes',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Show Pagination", "dutility" ),
            	"param_name" => "has_pagination",
            	"description" => __( "Hides the pagination if set to 'No' (Carousel Only).", "dutility" ),
            	"value" => array(
            			'Yes' => 'yes',
            			'No' => 'no',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "div",
            	"class" => "",
            	"heading" => __( "Show Navigation", "dutility" ),
            	"param_name" => "has_navigation",
            	"description" => __( "Hides the navigation if set to 'No' (Carousel Only).", "dutility" ),
            	"value" => array(
            			'Yes' => 'yes',
            			'No'  => 'no',
             		)
         	),

      	)
   	));
}