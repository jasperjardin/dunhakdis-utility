<?php

add_shortcode( 'dunhakdis_portfolio', 'dunhakdis_portfolio' );
add_action( 'vc_before_init', 'dunhakdis_portfolio_vc' );

function dunhakdis_portfolio( $atts ) 
{ 
	global $wpdb;

	extract(
		shortcode_atts( array(
        	'columns' => 5, //Select: 1,2,3,4,5: The number of columns(items) to show.
        	'style' => 'masonry', //Select: masonry, grid, carousel.
        	'posts_per_page' => 0, //Any numbers: Default '0' to display number of page base on the user reading settings.
        	'sort' => '',  //Select: default(''), alphabetical, random.
    	), 
    	$atts )
    );
    
    ob_start();

    $portfolio_classes = '';
    
    // Filter allowed columns.
    $allowed_columns = array(1, 2, 3, 4,5);
    	if ( !in_array( $columns, $allowed_columns ) ) {
    		$columns = 3;
    	}
    
    // Filter allowed style.
    $allowed_style = array('masonry', 'grid', 'carousel');
    	if ( !in_array( $style, $allowed_style ) ) {
    		$style = 'masonry';
    	}

    // Filter allowed sort.
    $allowed_sort = array('','alphabetical','random');
    	if ( !in_array( $sort, $allowed_sort) ) {
    		$sort = '';
    	}

    $content = "";

    //Begin the query arguments.
    $args = array(
    		'post_type' => 'portfolio',
    		'posts_per_page' => $posts_per_page,
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


   	$portfolio_classes = 'dunhakdis-utility-masonry';

   	//Replace Carousel Class.
   	//Carousel.
   	if ( 'carousel' === $style )  {
   		$portfolio_classes = 'dunhakdis-utility-owl-carousel';
   		$columns = 'n-a';
   	}

    query_posts( $args );

	?>
	
	<?php if ( have_posts() ) { ?> 
		<div class="dunhakdis-utility-portfolio column-<?php echo intval( $columns ); ?> style-<?php echo esc_attr($style); ?>">
			<ul class="dunhakdis-utility-list <?php echo esc_attr( $portfolio_classes ); ?>">
				<?php while( have_posts() ) { ?>
					<?php the_post(); ?>
					<li class="item">
						<div class="dunhakdis-utility-portfolio-wrap">

							<div class="dunhakdis-utility-portfolio-thumbnail">
								<?php $size = ''; ?>
								<?php if ( has_post_thumbnail() ) { ?>
								  	<?php if ( 'grid' === $style )  { ?>
										<?php $size = 'grid_size'; ?>
									<?php } ?>
									<?php echo the_post_thumbnail($size); ?>
								<?php } else { ?>
									<img src="<?php echo plugins_url('dunhakdis-utility/assets/images/portfolio-default.jpg'); ?>" alt="<?php echo esc_attr( the_title() ); ?>">
								<?php } ?>

							</div>

							<div class="dunhakdis-utility-portfolio-details">
								<div class="dunhakdis-utility-portfolio-details-title">
									<h3>
										<a href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>">
											<?php the_title(); ?>
										</a>
									</h3>
								</div>
								<div class="dunhakdis-utility-portfolio-details-link">
									<a href="#">
										<span class="symbol">
											&rarr;
										</span>
									</a>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	<?php } else { ?>
		<div class="alert alert-info">
			<p>
				<?php _e('There are no items found in your portfolio','dutility'); ?>
			</p>
		</div>
	<?php  } ?>
	<?php 
	wp_reset_query();
	$content = ob_get_clean();
	
	return $content;
} 


function dunhakdis_portfolio_vc() {
	vc_map( array(
      	"name" => __( "Dunhakdis Portfolio", "dutility" ),
      	"base" => "dunhakdis_portfolio",
      	"class" => "",
      	"category" => __( "Content", "dutility"),
      	"params" => array(
	      		array(
	            	"type" => "dropdown",
	            	"holder" => "",
	            	"class" => "",
	            	"heading" => __( "Columns", "dutility" ),
	            	"param_name" => "columns",
	            	"admin_label" => true,
	            	"description" => __( "Select the number of columns you want your portfolio to have.", "dutility" ),
	            	"value" => array(
	            			'3' => '3',
	            			'1' => '1',
	            			'2' => '2',
	            			'4' => '4',
	            			'5' => '5'
	            		)
	         	),
	         	array(
	            	"type" => "dropdown",
	            	"holder" => "",
	            	"class" => "",
	            	"heading" => __( "Style", "dutility" ),
	            	"param_name" => "style",
	            	"admin_label" => true,
	            	"description" => __( "Select the style for your portfolio.", "dutility" ),
	            	"value" => array(
	            			'Masonry' => 'masonry',
	            			'Grid' => 'grid',
	            			'Carousel' => 'carousel',
	            		)
	         	),
	         	array(
	            	"type" => "textfield",
	            	"holder" => "",
	            	"class" => "",
	            	"heading" => __( "No. of Items", "dutility" ),
	            	"param_name" => "posts_per_page",
	            	"admin_label" => true,
	            	"value" => 10,
	            	"description" => __( "How many portfolio items you want to show?", "dutility" )
	         	),
	         	array(
	            	"type" => "dropdown",
	            	"holder" => "",
	            	"class" => "",
	            	"heading" => __( "Order By", "dutility" ),
	            	"param_name" => "sort",
	            	"admin_label" => true,
	            	"description" => __( "Arrange the items using the selected option.", "dutility" ),
	            	"value" => array(
	            			'Default' => '',
	            			'Alphabetical' => 'alphabetical',
	            			'Random' => 'random',
	            		)
	         	),
         	)
      ));
}
?>