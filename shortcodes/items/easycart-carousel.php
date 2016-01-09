<?php
/**
 * Easy Cart Carousel Shortcode
 *
 * @since 1.0
 */

if ( ! in_array( 'wp-easycart/wpeasycart.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	return;
}

add_shortcode( 'dunhakdis_easycart_carousel', 'dunhakdis_easycart_carousel' );
add_action( 'vc_before_init', 'dunhakdis_easycart_carousel_vc' );

function dunhakdis_easycart_carousel( $atts ) {
	
	global $wpdb;

	$prefix = 'ec'; //Easy cart prefix. Not following 'wp' standard.

	$storepage_id = intval( get_option('ec_option_storepage') );

	if ( ! $storepage_id ) {
		return;
	}

	$store_url = get_permalink( $storepage_id );

	$fields = join( ',', array(
				'product_id', 'model_number', 'title', 'price', 'list_price', 'post_id',
				'image1', 'image2', 'image3', 'image4',
			));

	$limit = apply_filters( 'dunhakdis_utility_ec_limit', 10 );

	$stmt = "select {$fields} from {$prefix}_product limit {$limit}";

	$products = $wpdb->get_results( $stmt, OBJECT );

	ob_start();

	?>

	<?php if ( !empty ( $products ) ) { ?>
	<?php $ec_currency = new ec_currency(); ?>

	<div class="dunhakdis-utility-easycart-product-carousel">

		<ul class="dunhakdis-utility-owl-carousel">
			
			<?php foreach ( $products as $product ) { ?>

				<li>
					<?php $src = plugins_url() . '/wp-easycart-data/products/pics1/' . $product->image1; ?>
					<?php 
						$product_link = add_query_arg( 
							array(
								'model_number' => $product->model_number
							),
							$store_url
						); 
					?>

					<div class="d-utility_item">
						<div class="d-utility_item__image" >
							<a href="<?php echo esc_url( $product_link ); ?>" title="<?php echo esc_attr( $product->title ); ?>">
								<img class="lazyOwl" src="<?php echo esc_url( $src ); ?>" data-src="<?php echo esc_url( $src ); ?>" />
							</a>
						</div>
						<div class="d-utility_item__description">
							<div class="d-utility_item___title">
								<h3 class="item-title">
									<a href="<?php echo esc_url( $product_link ); ?>" title="<?php echo esc_attr( $product->title ); ?>">
										<?php echo esc_html( $product->title ); ?>
									</a>
								</h3>
							</div>
							<div class="d-utility_item___tag">
							</div>
							<div class="d-utility_item___actions">
								<div class="item-price">
									<?php if ( !empty ( $product->list_price ) ) { ?>
										<del class="item-list-price">
											<?php echo esc_html( $ec_currency->get_currency_display( $product->list_price ) ); ?>
										</del>
									<?php } ?>
									<span class="item-actual-price">
										<?php echo esc_html( $ec_currency->get_currency_display( $product->price ) ); ?>
									</span>
								</div>
								<div class="item-buy-link">
									<a title="<?php _e('Buy', 'dutility'); ?>" href="<?php echo esc_url( $product_link ); ?>" class="d-utility-buy-link">
										<?php _e('Buy', 'dutility'); ?>
									</a>
								</div>
							</div>
						</div><!--d-utility_item__details-->
					</div><!--.d-utility_item-->
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php } else { ?>
	<p class="spacer">&nbsp;</p>
	<div class="ec_products_no_results mg-top-15">
		<?php _e('There are no products to display yet.', 'dutility'); ?>
	</div>
	<?php } ?>

	<?php

	$content = ob_get_clean();

	return $content;

}

function dunhakdis_easycart_carousel_vc() {
	
	vc_map( 
		array(
      		"name" => __( "Dunhakdis Easy Cart Carousel", "dutility" ),
      		"base" => "dunhakdis_easycart_carousel",
      		"class" => "",
      		"category" => __( "Content", "dutility"),
      		"icon" => plugins_url('dunhakdis-utility/assets/images/icon-easycart.jpg'),
      		"params" => array(
      			array(
            		"type" => "textfield",
            		"holder" => "",
            		"class" => "",
            		"heading" => __( "No. of Items", "dutility" ),
            		"param_name" => "posts_per_page",
            		"admin_label" => true,
            		"description" => __( "How many number of products would you like to display in the carousel?", "dutility" ),
            		"value" => 10
         		),
         	)//params
      	)
	);

}