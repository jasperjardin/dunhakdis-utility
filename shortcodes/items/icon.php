<?php
add_shortcode( 'dunhakdis_icon', 'dunhakdis_icon' );
add_action( 'vc_before_init', 'dunhakdis_icon_vc' );

function dunhakdis_icon( $atts ) {
	extract( shortcode_atts( 
			array(
	        	'icon' => 'star',
	        	'text' => ''
	    	), $atts 
    	)
	);
	
	ob_start();
	
	if ( function_exists('vc_map') ){ ?>
	<div class="dunhakdis_icon_container">
		<span class="dunhakdis_icon <?php echo esc_attr( apply_filters( 'dunhakdis_icon_filter', $icon ) ); ?>"></span>
		<p> <?php echo esc_attr( apply_filters( 'dunhakdis_icon_filter', $text ) ); ?></p>
	</div>
	<?php } else { ?>

	<div class="dunhakdis_icon_container">
		<span class="dunhakdis_icon fa fa-<?php echo esc_attr( apply_filters( 'dunhakdis_icon_filter', $icon ) ); ?>"></span>
		<p> <?php echo esc_attr( apply_filters( 'dunhakdis_icon_filter', $text ) ); ?></p>
	</div>
	<?php
	}
	return ob_get_clean();
}

function dunhakdis_icon_vc() {
	vc_map( array(
		"name" => __( "Dunhakdis Icon", "dutility" ),
		"base" => "dunhakdis_icon",
		"class" => "",
		"category" => __( "Content", "dutility"),
		"params" => array(
			array(
				"type" => "iconpicker",
				"holder" => "",
				"class" => "",
				"heading" => __( "Icon", "dutility" ),
				"param_name" => "icon",
				"value" => "star",
				"settings" => array(
					"emptyIcon" => false, // default true, display an "EMPTY" icon?
					"iconsPerPage" => 200, // default 100, how many icons per/page to display
				),
				"description" => __( "Please type in your icon'.", "dutility" )
			), 
			array(
				"type" => "textarea",
				"holder" => "",
				"class" => "",
				"heading" => __( "Text", "dutility" ),
				"param_name" => "text",
				"value" => __( "", "dutility" ),
				"description" => __( "Type in your text.", "dutility" )
			)
		) // params
   ) ); //vc_map
}