<?php
add_shortcode( 'dunhakdis_blogs', 'dunhakdis_blogs' );
add_action( 'vc_before_init', 'dunhakdis_blogs_vc' );

function dunhakdis_blogs( $atts ) 
{
	global $wpdb;

	extract( shortcode_atts( 
			array(
	        	'display_style' => 'carousel', //array( 'list', 'masonry', 'carousel', 'classic' );
	        	'posts_per_page' => 0,
	        	'sort' => ''
	    	), $atts 
    	)
	);

	

	ob_start();

	$content = "";

	$dunhakdis_utility_blog_classes = '';

	$allowed_display_style = array( 'list', 'masonry', 'carousel', 'classic' );

	if ( !in_array( $display_style, $allowed_display_style ) ) {
		$display_style = 'masonry';
	}

	if ( !in_array( $sort, array( '', 'alphabetical', 'random' ) ) ) 
	{
		$sort = '';
	}

	$thumbnail_size = apply_filters( 'dutility-blog-thumbnail-size', array(
				'masonry' => 'medium',
				'list' => 'medium',
				'carousel' => 'medium',
				'classic' => 'blog-featured-image-single'
			));

	if ( 'masonry' === $display_style ) {
		$dunhakdis_utility_blog_classes = 'dunhakdis-utility-masonry';
	}

	if ( 'carousel' === $display_style ) {
		$dunhakdis_utility_blog_classes = 'dunhakdis-utility-carousel dunhakdis-utility-owl-carousel';
	}

	// Configure the query parameters
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => intval( $posts_per_page ),
	);


    //Filter orders.
	//Random.
	if ( 'random' === $sort ) {
		$args['orderby'] = 'rand';
	}
	//Alphabetical
	if ( 'alphabetical' === $sort ) {
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
	}

	query_posts( $args );

	if ( have_posts() ) { ?>
	<div class="dunhakdis-utility-blog">
		<ul data-items="3" class="dunhakdis-utility-list <?php echo $dunhakdis_utility_blog_classes; ?> <?php echo esc_attr($display_style); ?>">
			<?php while( have_posts() ) {
				the_post();
				?>
				<li <?php post_class( array('item') ); ?>>

					<div class="blog-item">
						
						<!--Post Thumbnail-->
						<div class="blog-item-thumbnail">

							<a href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>">
								
								<?php if ( has_post_thumbnail() ) { ?>
									
									<?php the_post_thumbnail( $thumbnail_size[ $display_style ] ); ?>

								<?php } else { ?>

									<img src="<?php echo plugins_url('dunhakdis-utility/assets/images/blog.jpg'); ?>" alt="<?php echo esc_attr( the_title() ); ?>">

								<?php } ?>
							</a>

						</div>
						<div class="blog-item-details">
							<!--Post Title-->
							<div class="blog-item-title">
								<h3>
									<a href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>">
										<?php the_title(); ?>
									</a>
								</h3>
							</div>
							<!--Post Meta-->
							<div class="blog-item-meta">
								<ul class="dunhakdis-utility-list">
									<li class="blog-item-comments-number">
										<span class="blog-item-comments-number-label">
											<?php _e('Comments:','dutility'); ?>
										</span>
										<span class="blog-item-comments-number-number">
											<?php comments_number( '0', '1', '%' ); ?>
										</span>
									</li>
									<li class="blog-item-date">
										<span class="blog-item-date-label">
											<?php _e('Posted On:','dutility'); ?>
										</span>
										<span class="blog-item-date-date">
											 <?php the_time( get_option( 'date_format' ) ); ?>
										</span>
									</li>
									<li class="blog-item-comments-categories">
										<span class="blog-item-categories-label">
											<?php _e('Categories:','dutility'); ?>
										</span>
										<span class="blog-item-categories-categories">
											<?php the_category($sep=', '); ?>
										</span>
									</li>
									<li class="blog-item-author">
										<span class="blog-item-author-label">
											<?php _e('By:','dutility'); ?>
										</span>
										<span class="blog-item-author-author">
											 <?php the_author_posts_link(); ?>
										</span>
									</li>
								</ul>
							</div>
							<!--Post Excerpt-->
							<div class="blog-item-excerpt">
								<?php the_excerpt(); ?>
							</div>
						</div>
					</div><!--.blog-item-->

				</li>
			<?php } ?>
		</ul>	
	</div>
	<?php
	}

	wp_reset_query();

	$content = ob_get_clean();

	return $content;
}

function dunhakdis_blogs_vc() 
{
	vc_map( array(
      	"name" => __( "Dunhakdis Blogs", "dutility" ),
      	"base" => "dunhakdis_blogs",
      	"class" => "",
      	"category" => __( "Content", "dutility"),
      	"params" => array(
      		array(
            	"type" => "dropdown",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Display Style", "dutility" ),
            	"param_name" => "display_style",
            	"admin_label" => true,
            	"description" => __( "Select a style for your blog.", "dutility" ),
            	"value" => array(
            			'Carousel' => 'carousel',
            			'Masonry' => 'masonry',
            			'Classic' => 'classic',
            			'List' => 'list'
            		)
         	),
         	array(
            	"type" => "textfield",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "No. of Posts", "dutility" ),
            	"param_name" => "posts_per_page",
            	"admin_label" => true,
            	"description" => __( "The number of posts to show. Leave blank to leave to use default value set in your reading settings.", "dutility" ),
            	"value" => "10"
         	),
         	array(
            	"type" => "dropdown",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Order By", "dutility" ),
            	"param_name" => "sort",
            	"admin_label" => true,
            	"description" => __( "Select a sorting order.", "dutility" ),
            	"value" => array(
            			'Default' => '',
            			'Alphabetical' => 'alphabetical',
            			'Random' => 'random',
            		)
         	),
         )
      )
	);
}
?>