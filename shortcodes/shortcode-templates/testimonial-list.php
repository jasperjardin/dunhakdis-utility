<?php
/**
 * Testimonials List Template
 */
?>
<div class="dunhakdis-testimonial-item">
	<?php if ( !$hide_avatar ) { ?>
		<?php if ( !empty( $avatar_src ) ) { ?>
			<div class="dunhakdis-testimonial-review-author-avatar">
				<img width="64" height="64" class="avatar" src="<?php echo esc_url( $avatar_src ); ?>" alt="" />
			</div>
		<?php } ?>
	<?php } ?>
	
	<div class="dunhakdis-testimonial-content-wrap">	
		<div class="dunhakdis-testimonial-content">
			<?php the_content(); ?>
		</div>
		<div class="dunhakdis-testimonial-review">
			<div class="dunhakdis-testimonial-author-about">
				<?php if ( !empty( $client_name ) ) { ?>
					<div class="dunhakdis-testimonial-review-author">
						<h3 class="testimonial-author">
							<a href="#">
								<?php echo esc_html( $client_name ); ?>
							</a>
						</h3>
					</div>
				<?php } ?>
				<?php if ( !$hide_company ) { ?>
					<?php if ( $client_company ) { ?>
						<div class="dunhakdis-testimonial-review-author-company">
							<p class="testimonial-company">
								<?php echo esc_html( $client_company ); ?>
							</p>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>