<?php
/**
 * Easy Cart Carousel Shortcode
 *
 * @since 1.0
 */

function dunhakdis_easycart_carousel( $atts ) {
	
	global $wpdb;

	$prefix = 'ec'; //Easy cart prefix. Not following 'wp'.

	$fields = join( ',', array(
				'product_id', 'title', 'price', 'list_price', 'post_id',
				'image1', 'image2', 'image3', 'image4',
			));

	$limit = 10;

	$stmt = "select {$fields} from {$prefix}_product limit {$limit}";

	$products = $wpdb->get_results( $stmt, OBJECT );

	ob_start();

	?>

	<?php if ( !empty ( $products ) ) { ?>
	<div class="dunhakdis-utility-easycart-product-carousel">
		<ul class="dunhakdis-utility-owl-carousel">
			<?php foreach ( $products as $product ) { ?>
				<li>
					<?php $src = 'http://localhost/shoemaker/wp-content/plugins/wp-easycart-data/products/pics1/' . $product->image1; ?>
					<div class="d-utility_item">
						<div class="d-utility_item__image" style="height: 400px;overflow:hidden;">
							<img src="<?php echo $src; ?>" />
						</div>
						<div class="d-utility_item__description">
							<div class="d-utility_item___title">
								<h3 class="item-title">
									<a href="<?php echo esc_url( get_permalink( $product->post_id ) ); ?>" title="<?php echo esc_attr( $product->title ); ?>">
										<?php echo esc_html( $product->title ); ?>
									</a>
								</h3>
							</div>
							<div class="d-utility_item___tag">
								<a href="#">Black</a>, 
								<a href="#">Tortoise </a> &amp; 
								<a href="#">Khaki</a>
							</div>
							<div class="d-utility_item___actions">
								<div class="item-price">
									<del>$599.99</del>
									<span class="actual-price">
										$399.99
									</span>
								</div>
							</div>
						</div><!--d-utility_item__details-->
					</div><!--.d-utility_item-->
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>

	<?php

	$content = ob_get_clean();

	return $content;

}

add_shortcode( 'dunhakdis_easycart_carousel', 'dunhakdis_easycart_carousel' );