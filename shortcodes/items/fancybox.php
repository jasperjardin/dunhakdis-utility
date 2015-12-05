<?php
add_shortcode( 'dunhakdis_fancy_box', 'dunhakdis_fancy_box' );
add_action( 'vc_before_init', 'dunhakdis_fancybox_vc' );

function dunhakdis_fancy_box( $atts ) {
	extract(
		shortcode_atts(
			array(
				'title' => __('Fancy box title', 'dutility'),
				'short_desc' => __('Add short excerpt or leave blank to remove.','dutility'),
				'button_label' => '',
				'text_alignment' => 'center-center',
				'background_url' => plugins_url('dunhakdis-utility/assets/images/fancybox.jpg'),
				'color' => '',
				'link' => '#',
				'hide' => 'no'
			), $atts
		));
	
	$content = '';
	$classes = '';

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

	$target = '';

	$fancybox_id = '';

	if ( ! in_array( $text_alignment, $allowed_text_alignment ) ) {
		$text_alignment = 'center-center';
	}

	if ( 'yes' == $hide ) {
		$classes = 'hide-default';
	}

	// Convert the link to understandable Visual Composer link field.
	if ( function_exists( 'vc_build_link' ) ) {
		$vc_link = vc_build_link( $link );

		if ( !empty( $vc_link ) ) {
		
			if ( isset( $vc_link['url'] ) ) {
				$link = $vc_link['url'];
			}
			if ( isset( $vc_link['target'] ) ) {
				$target = $vc_link['target'];
			}
		}
	}

	if ( is_numeric( $background_url ) ) {
		$background_url = wp_get_attachment_image_src( $background_url, 'full' );
		if ( !empty( $background_url ) && is_array( $background_url ) ) {
			$background_url = $background_url[0];
		}
	}

	ob_start(); ?>
		<?php $fancybox_id = sprintf('dunhakdis-utility-%s', uniqid()); ?>
		<section id="<?php echo esc_attr( $fancybox_id ); ?>" class="<?php echo esc_html($classes);?> dunhakdis-utility-fancybox v<?php echo esc_attr( str_replace( '-', ' ', $text_alignment ) ); ?>">
			<?php if ( !empty( $color ) ) {?>
				<style scoped>	
					#<?php echo $fancybox_id; ?>,
					#<?php echo $fancybox_id; ?> a{
						color: <?php echo esc_attr($color); ?>
					}
				</style>
			<?php } ?>
			<div class="dunhakdis-utility-fancybox-wrap">
				<div class="dunhakdis-utility-fancybox-cover-image">
					<img src="<?php echo esc_url($background_url); ?>" />
				</div>
				<div class="dunhakdis-utility-fancybox-details">
					<div class="dunhakdis-utility-fancybox-details-table">
						<div class="dunhakdis-utility-fancybox-details-table-cell">
							<div class="dunhakdis-utility-fancybox-details-table-cell-wrap">
								<div class="dunhakdis-utility-fancybox-title">
									<?php if ( !empty( $title ) ) { ?>
										<h3>
											<a target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $title ); ?>">
												<?php echo esc_html( $title ); ?>
											</a>
										</h3>
									<?php } ?>
								</div>
								<div class="dunhakdis-utility-fancybox-excerpt">
									<?php if ( !empty( $short_desc ) ) { ?>
									<p>
										<?php echo esc_html( $short_desc ); ?>
									</p>
									<?php } ?>
								</div>
								<div class="dunhakdis-utility-fancybox-button">
									<?php if ( !empty( $button_label ) ) { ?>
										<a target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url( $link ); ?>" class="button">
											<?php echo esc_html( $button_label ); ?>
										</a>
									<?php } ?>
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


/**
 * Visual Composer
 */
function dunhakdis_fancybox_vc() 
{

	vc_map( array(
      	"name" => __( "Dunhakdis FancyBox", "dutility" ),
      	"base" => "dunhakdis_fancy_box",
      	"class" => "",
      	"category" => __( "Content", "dutility"),
      	"params" => array(
      		array(
            	"type" => "textfield",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Title", "dutility" ),
            	"param_name" => "title",
            	"admin_label" => true,
            	"description" => __( "The title of the fancybox.", "dutility" )
         	),
         	array(
            	"type" => "textfield",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Short Excerpt", "dutility" ),
            	"param_name" => "short_desc",
            	"value" => __('Add short excerpt or leave blank to remove','dutility'),
            	"admin_label" => true,
            	"description" => __( "Provide a short excerpt for this fancybox.", "dutility" )
         	),
			array(
            	"type" => "textfield",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Button Label", "dutility" ),
            	"param_name" => "button_label",
            	"value" => '',
            	"admin_label" => false,
            	"description" => __( "Add a label to the button of this fancybox.", "dutility" )
         	),
         	
			array(
            	"type" => "dropdown",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Text Alignment", "dutility" ),
            	"param_name" => "text_alignment",
            	"admin_label" => false,
            	"description" => __( "Select the way you would like the text to be aligned.", "dutility" ),
            	"value" => array(
            			'Center Center' => 'center-center',
            			'Top Center' => 'top-center',
            			'Bottom Center' => 'bottom-center',
            			'Center Right' => 'center-right',
            			'Top Right' => 'top-right',
            			'Bottom Right' => 'bottom-right',
            			'Top Left' => 'top-left',
            			'Center Left' => 'center-left',
            			'Bottom Left' => 'bottom-left'
            		)
         	),
         	array(
         		"type" => "attach_image",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Background Image", "dutility" ),
            	"param_name" => "background_url",
            	"value" => '',
            	"admin_label" => true,
            	"description" => __( "Upload or select an image for this fancy box.", "dutility" )
            ),
            array(
         		"type" => "colorpicker",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Text Color", "dutility" ),
            	"param_name" => "color",
            	"value" => '',
            	"admin_label" => true,
            	"description" => __( "Choose a color for the link and the text. Leave blank to use the theme default. Can be useful to fix contrast issues with background.", "dutility" )
            ),
            array(
         		"type" => "vc_link",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Link", "dutility" ),
            	"param_name" => "link",
            	"value" => '',
            	"admin_label" => false,
            	"description" => __( "Add or select a page to link this fancy box the any content of your website.", "dutility" )
            ),
            array(
         		"type" => "dropdown",
            	"holder" => "",
            	"class" => "",
            	"heading" => __( "Hover Only Texts", "dutility" ),
            	"param_name" => "hide",
            	"admin_label" => false,
            	"description" => __( "Select 'yes' to hide the text and make it appear on hover.", "dutility" ),
            	"value" => array(
            			'No' => 'no',
            			'Yes' => 'yes'
            		)
            ),
      	)
   	));
}
?>