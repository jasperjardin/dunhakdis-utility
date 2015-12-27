<?php
add_shortcode( 'dunhakdis_testimonials', 'dunhakdis_testimonials' );
add_action( 'vc_before_init', 'dunhakdis_testimonials_vc' );

function dunhakdis_testimonials( $atts ) 
{
	global $wpdb;

	extract( 
    shortcode_atts( array(
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

  $testimonial_id = 'dunhakdis-testimonial-item-' . uniqid();

	$allowed_type = array( 'carousel', 'list', 'masonry' );

	$allowed_columns = array( '1','2','3','4' );

	if ( !in_array( $columns, $allowed_columns ) ) {
		$columns = 4;
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
		<style> <?php echo '#'.$testimonial_id; ?>, <?php echo '#'.$testimonial_id; ?> a { color: <?php echo esc_html($color); ?>; } </style>
	<?php } ?>

  <?php $args = array(
          'post_type' => 'testimonial'
        ); 
  ?>

  <?php query_posts( $args ); ?>

  <?php if ( have_posts() ) { ?>

	<div class="dunhakdis-utility-testimonials" id="<?php echo esc_attr( $testimonial_id ); ?>">
		
		<ul class="<?php echo esc_attr( $testimonial_wrapper_class ); ?> dunhakdis-utility-list" data-items="<?php echo intval( $data_items ); ?>" 
		data-pagination="<?php echo ($has_pagination === 'yes') ? 'true' : 'false'; ?>" 
		data-navigation="<?php echo ($has_navigation === 'yes') ? 'true' : 'false'; ?>">

		<?php while ( have_posts() ) { ?>
      
      <?php the_post(); ?>

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

				$avatar_src  = get_post_meta( get_the_ID(), 'avatar_src', true );
        $client_name = get_post_meta( get_the_ID(), 'client_name', true );
        $client_company = get_post_meta( get_the_ID(), 'client_company', true );

        // convert metabox attachment id to url
        if ( is_numeric( $avatar_src ) ) {
          $avatar_src = wp_get_attachment_image_src( $avatar_src );
          if ( is_array( $avatar_src ) ) {
            if ( isset( $avatar_src[0] ) ) {
              $avatar_src = $avatar_src[0];
            }
          }
          //--
        }

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
      <?php } //end while  ?>
		</ul>
	</div>
  <?php } else { // end if?>
  <div class="alert alert-info">
    <?php $testimonial_link = sprintf('<a target="_blank" href="%s">'.__('here', 'dutility').'</a>', admin_url('post-new.php?post_type=testimonial') ); ?>
      <?php echo sprintf( esc_html__('Ops! There are no testimonials found. Click %s to add new testimonials','dutility'), $testimonial_link ); ?>
  </div>
  <?php } ?>
	<?php
  wp_reset_query();

	$content = ob_get_clean();

	return $content;
}

function dunhakdis_testimonials_vc() 
{
	vc_map( array(
      	"name" => __( "Dunhakdis Testimonials", "dutility" ),
      	"base" => "dunhakdis_testimonials",
      	"class" => "",
        "icon" => plugins_url('dunhakdis-utility/assets/images/icon-testimonials.jpg'),
      	"category" => __( "Content", "dutility"),
      	"params" => array(
      		array(
            	"type" => "colorpicker",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Color", "dutility" ),
            	"param_name" => "color",
            	"admin_label" => true,
            	"description" => __( "The color of text including links.", "dutility" )
         	),
         	array(
            	"type" => "textfield",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Slide Items", "dutility" ),
            	"param_name" => "data_items",
            	"value" => 1,
            	"admin_label" => true,
            	"description" => __( "How many testimonials to show per slide (carousel only).", "dutility" )
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Columns", "dutility" ),
            	"param_name" => "columns",
            	"admin_label" => false,
            	"description" => __( "Applicable only to 'masonry' style. Will divide your testimonials into selected number of columns.", "dutility" ),
            	"value" => array(
            			'4 Columns' => '4',
                  '3 Columns' => '3',
                  '2 Columns' => '2',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Style", "dutility" ),
            	"param_name" => "style",
            	"admin_label" => true,
            	"description" => __( "How the testimonial should appear.", "dutility" ),
            	"value" => array(
            			'Carousel' => 'carousel',
            			'List' => 'list',
            			'Masonry' => 'masonry',
             		)
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "",
            	"class" => "",
            	"admin_label" => false,
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
            	"holder" => "",
            	"class" => "",
            	"admin_label" => false,
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
            	"holder" => "",
            	"class" => "",
            	"admin_label" => false,
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
            	"holder" => "",
            	"class" => "",
            	"admin_label" => false,
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
            	"holder" => "",
            	"class" => "",
            	"admin_label" => false,
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