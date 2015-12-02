<?php
add_shortcode( 'dunhakdis_fancy_box', 'dunhakdis_fancy_box' );

function dunhakdis_fancy_box( $atts ) {
	extract(
		shortcode_atts(
			array(
				'title' => 'Yolo Octo Tribble',
				'short_desc' => 'Up To 70% Discount.',
				'button_label' => 'Visit Shop',
				'text_alignment' => 'center-right',
				'background_url' => 'http://demo.theme-sky.com/gon/wp-content/uploads/2015/07/banner-3-1-bg.jpg',
				'link' => 'http://localhost/shoemaker/page-markup-and-formatting/'
			), $atts
		));
	$content = "";

	$allowed_text_alignment = array(
			'center-center',
			'top-center',
			'bottom-center',
			'top-left',
			'center-left',
			'bottom-left',
			'top-right',
			'center-right',
			'bottom-right'
		);

	if ( ! in_array( $text_alignment, $allowed_text_alignment ) ) {
		$text_alignment = 'center-center';
	}

	ob_start(); ?>
		<section class="dunhakdis-utility-fancybox v<?php echo esc_attr( str_replace( '-', ' ', $text_alignment ) ); ?>">
			<div class="dunhakdis-utility-fancybox-wrap">
				<div class="dunhakdis-utility-fancybox-cover-image">
					<img src="<?php echo esc_url($background_url); ?>" />
				</div>
				<div class="dunhakdis-utility-fancybox-details">
					<div class="dunhakdis-utility-fancybox-details-table">
						<div class="dunhakdis-utility-fancybox-details-table-cell">
							<div class="dunhakdis-utility-fancybox-details-table-cell-wrap">
								<div class="dunhakdis-utility-fancybox-title">
									<h3>
										<a href="<?php echo esc_url( $link ); ?>">
											<?php echo esc_html( $title ); ?>
										</a>
									</h3>
								</div>
								<div class="dunhakdis-utility-fancybox-excerpt">
									<p>
										<?php echo esc_html( $short_desc ); ?>
									</p>
								</div>
								<div class="dunhakdis-utility-fancybox-button">
									<a href="<?php echo esc_url( $link ); ?>" class="button">
										<?php echo esc_html( $button_label ); ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</section>
	<?php
	$content = ob_get_clean();
	return $content;
}
?>