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
        'data_items' => 3
    ), $atts ));

	ob_start();

	?>
	
	<div class="dunhakdis-utility-testimonials">
		
		<ul class="dunhakdis-utility-owl-carousel" data-items="<?php echo intval( $data_items ); ?>" 
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
			<li>
				<div class="dunhakdis-testimonial-item">
					<div class="dunhakdis-testimonial-content">
						<p>
							<?php echo wp_kses( $testimonial_content, $allowed_html ); ?>
						</p>
					</div>
					<div class="dunhakdis-testimonial-review">
						<?php if ( !$hide_avatar ) { ?>
							<div class="dunhakdis-testimonial-review-author-avatar">
								<img width="64" height="64" class="avatar" src="<?php echo esc_url( $avatar_src ); ?>" alt="" />
							</div>
						<?php } ?>
						<div class="dunhakdis-testimonial-review-author">
							<h3 class="testimonial-author">
								<a href="#">
									John Doe
								</a>
							</h3>
						</div>
						<?php if ( !$hide_company ) { ?>
						<div class="dunhakdis-testimonial-review-author-company">
							<p class="testimonial-company">
								Convergys Bacolod, CEO
							</p>
						</div>
						<?php } ?>
					</div>
				</div>
			</li>
		<?php } ?>
		</ul>
	</div>

	<?php

	$content = ob_get_clean();

	return $content;
}