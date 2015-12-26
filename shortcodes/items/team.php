<?php
add_shortcode( 'dunhakdis_team', 'dunhakdis_team' );
add_action( 'vc_before_init', 'dunhakdis_team_vc' );

function dunhakdis_team( $atts ) {
	extract( shortcode_atts( 
			array(
	        	'avatar' => '',
	        	'name' => '',
	        	'title' => '',
	        	'website' => '',
	        	'facebook' => '',
	        	'googleplus' => '',
	        	'twitter' => '',
	        	'linkedin' => '',
	        	'about' => '',
	    	), $atts 
    	)
	);
	
	ob_start();
	?>
	<div class="dunhakdis-team-container">
		<div class="dunhakdis-team-avatar">
			<img src="<?php echo esc_url_raw( apply_filters( 'dunhakdis_team_filter', $avatar ) ); ?>" >
		</div>
		<div class="dunhakdis-team-name">
			<h3>
				<?php echo esc_html( apply_filters( 'dunhakdis_team_filter', $name ) ); ?>
			</h3>
			<h4 class="dunhakdis-team-title">
				<?php echo esc_html( apply_filters( 'dunhakdis_team_filter', $title ) ); ?>
			</h4>
		</div>
		<div class="dunhakdis-team-social">
			<a href="https://www.facebook.com/<?php echo esc_url_raw( apply_filters( 'dunhakdis_team_filter', $facebook ) ); ?>">
				<span class="">fb</span>
			</a>
			<a href="https://plus.google.com/<?php echo esc_url_raw( apply_filters( 'dunhakdis_team_filter', $googleplus ) ); ?>">
				<span class="">g+</span>
			</a>
			<a href="https://twitter.com/<?php echo esc_url_raw( apply_filters( 'dunhakdis_team_filter', $twitter ) ); ?>">
				<span class="">twitter</span>
			</a>
			<a href="https://www.linkedin.com/in/<?php echo esc_url_raw( apply_filters( 'dunhakdis_team_filter', $linkedin ) ); ?>">
				<span class="">linkedin</span>
			</a>
		</div>
		<div class="dunhakdis-team-about">
			<a class="dunhakdis-team-website" href="<?php echo esc_url_raw( apply_filters( 'dunhakdis_team_filter', $website ) ); ?>">
				<span class="">website</span>
			</a>
			<p>
				<?php echo esc_html( apply_filters( 'dunhakdis_team_filter', $about ) ); ?>
			</p>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

function dunhakdis_team_vc() {
	vc_map( array(
		"name" => __( "Dunhakdis Team", "dutility" ),
		"base" => "dunhakdis_team",
		"class" => "",
		"category" => __( "Content", "dutility"),
		"params" => array(
			array(
				"type" => "attach_image",
				"holder" => "",
				"class" => "",
				"heading" => __( "Avatar", "dutility" ),
				"param_name" => "avatar",
				"value" => "",
				"description" => __( "Input your avatar.", "dutility" ),
			), //Avatar
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Name", "dutility" ),
				"param_name" => "name",
				"value" => "",
				"description" => __( "Please type in your name.", "dutility" ),
			), //Name
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Title", "dutility" ),
				"param_name" => "title",
				"value" => "",
				"description" => __( "Please type in your Title.", "dutility" ),
			), //Title
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "About", "dutility" ),
				"param_name" => "about",
				"value" => "",
				"description" => __( "Write something about yourself.", "dutility" ),
			), //About
			array(
				"type" => "vc_link",
				"holder" => "",
				"class" => "",
				"heading" => __( "Website", "dutility" ),
				"param_name" => "website",
				"value" => "",
				"description" => __( "Write your Website here.", "dutility" ),
			), //website
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Facebook", "dutility" ),
				"param_name" => "facebook",
				"value" => "",
				"description" => __( "Write your Facebook here.", "dutility" ),
			), //Facebook
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Google+", "dutility" ),
				"param_name" => "googleplus",
				"value" => "",
				"description" => __( "Write your Google+ here.", "dutility" ),
			), //Google+
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Twitter", "dutility" ),
				"param_name" => "twitter",
				"value" => "",
				"description" => __( "Write your Twitter here.", "dutility" ),
			), //Twitter
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Linkedin", "dutility" ),
				"param_name" => "linkedin",
				"value" => "",
				"description" => __( "Write your Linkedin here.", "dutility" ),
			), //Linkedin
		) // params
   ) ); //vc_map
}