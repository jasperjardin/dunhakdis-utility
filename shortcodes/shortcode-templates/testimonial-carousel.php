<?php
/**
 * Testimonials Carousel Template
 */
?>
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
		<div class="dunhakdis-testimonial-author-about">
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
</div>