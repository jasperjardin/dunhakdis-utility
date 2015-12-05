<?php
add_shortcode( 'dunhakdis_portfolio', 'dunhakdis_portfolio' );

function dunhakdis_portfolio( $atts ) 
{ 
	global $wpdb;

	extract(
		shortcode_atts( array(
        	'' => ''
    	), 
    	$atts )
    );
    
    ob_start();
    
    $content = "";

    $args = array(
    		'post_type' => 'portfolio'
    	);

    query_posts( $args );
	?>
	
	<?php if ( have_posts() ) { ?> 
		<div class="dunhakdis-utility-portfolio">
			<ul class="dunhakdis-utility-list dunhakdis-utility-masonry">
				<?php while( have_posts() ) { ?>
					<?php the_post(); ?>
					<li class="item">
						<div class="dunhakdis-utility-portfolio-wrap">

							<div class="dunhakdis-utility-portfolio-thumbnail">
								
								<?php if ( has_post_thumbnail() ) { ?>
									<?php echo the_post_thumbnail(); ?>
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
} ?>