<?php
add_shortcode( 'dunhakdis_team', 'dunhakdis_team' );
add_action( 'vc_before_init', 'dunhakdis_team_vc' );

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
				"description" => __( "Upload an avatar for this member. The avatar will be automatically resize to 150x150 thumbnail size.", "dutility" ),
			), //Avatar
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Name", "dutility" ),
				"param_name" => "name",
				"value" => "",
				"description" => __( "The name of the member.", "dutility" ),
			), //Name
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Title", "dutility" ),
				"param_name" => "title",
				"value" => "",
				"description" => __( "What's the role of this member in your team or company?", "dutility" ),
			), //Title
			array(
				"type" => "textarea",
				"holder" => "",
				"class" => "",
				"heading" => __( "About", "dutility" ),
				"param_name" => "about",
				"value" => "",
				"description" => __( "Tell something about this member of your team.", "dutility" ),
			), //About
			array(
				"type" => "vc_link",
				"holder" => "",
				"class" => "",
				"heading" => __( "Website", "dutility" ),
				"param_name" => "website",
				"value" => "",
				"description" => __( "Enter the website of the member. Leave blank to disable the website link in member's name.", "dutility" ),
			), //website
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Facebook", "dutility" ),
				"param_name" => "facebook",
				"value" => "",
				"description" => __( "Enter the team member's Facebook Profile Url. Leave blank to disable.", "dutility" ),
			), //Facebook
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Google+", "dutility" ),
				"param_name" => "googleplus",
				"value" => "",
				"description" => __( "Enter the team member's Google Plus Url. Leave blank to disable.", "dutility" ),
			), //Google+
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Twitter", "dutility" ),
				"param_name" => "twitter",
				"value" => "",
				"description" => __( "Enter the team member's Twitter Url. Leave blank to disable.", "dutility" ),
			), //Twitter
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => __( "Linkedin", "dutility" ),
				"param_name" => "linkedin",
				"value" => "",
				"description" => __( "Enter the team member's LinkedIn Url. Leave blank to disable.", "dutility" ),
			), //Linkedin
		) // params
   ) ); //vc_map
}

/**
 * Callback function
 * @param  [type] $atts [description]
 * @return [type]       [description]
 */
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
			
		<?php if ( is_numeric( $avatar  ) ) { ?>

			<?php $avatar = wp_get_attachment_image_url( intval( $avatar ), 'thumbnail' ); ?>
	
		<?php } ?>
		
		<?php if ( !empty( $avatar ) ) { ?>	
			<div class="dunhakdis-team-avatar">
				<img class="avatar" src="<?php echo esc_url( $avatar ); ?>" alt="<?php _e('Profile', 'shoemaker'); ?>">
			</div>
		<?php } ?>

		<div class="dunhakdis-team-details">

			<?php if ( !empty( $name ) ) { ?>

			<h3 class="dunhakdis-team-name">
				
				<?php if ( function_exists( 'vc_build_link') ) { ?>
					<?php $website = vc_build_link( $website ); ?>
					<?php if ( is_array( $website ) ) { ?>
						<?php if ( !empty( $website['url'] ) ) { ?>
							<?php $website = $website['url']; ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>

				<?php if ( !empty( $website ) ) { ?>
					<a href="<?php echo esc_url( $website ); ?>" title="<?php echo esc_attr( $name ); ?>">
				<?php } ?>

					<?php echo esc_html( $name ); ?>

				<?php if ( !empty( $website ) ) { ?>
					</a>
				<?php } ?>
			</h3>
			
			<?php } ?>

			<?php if ( !empty( $title ) ) { ?>
				<h4 class="dunhakdis-team-title">
					<?php echo esc_html( $title ); ?>
				</h4>
			<?php } ?>

			<div class="dunhakdis-team-social">
				<?php 
					$social_media_collection = array(
						'facebook' => array(
								'icon' => 'fa fa-facebook',
								'class' => 'dunhakdis-team-fb',
								'link' => $facebook,
								'title' => __('Facebook', 'shoemaker')
							),
						'twitter' => array(
								'icon' => 'fa fa-twitter',
								'class' => 'dunhakdis-team-tw',
								'link' => $twitter,
								'title' => __('Twitter', 'shoemaker')
							),
						'googleplus' => array(
								'icon' => 'fa fa-google-plus',
								'class' => 'dunhakdis-team-gplus',
								'link' => $googleplus,
								'title' => __('Google+', 'shoemaker')
							),
						'linkedin' => array(
								'icon' => 'fa fa-linkedin',
								'class' => 'dunhakdis-team-linkedin',
								'link' => $linkedin,
								'title' => __('LinkedIn', 'shoemaker')
							),
						); 
					?>
					<ul>
					<?php
					foreach( $social_media_collection as $social_media ) { ?>
						<?php if ( ! empty( $social_media['link'] ) ) { ?>
							<li>
								<a class="<?php echo esc_attr( $social_media['class'] ); ?>" href="<?php echo esc_url( $social_media['link'] ); ?>" title="<?php echo esc_attr( $social_media['title'] ); ?>">
									<span class="<?php echo esc_attr( $social_media['icon'] ); ?>"></span>
								</a>
							</li>
						<?php } ?>				
					<?php } ?>
					</ul>

			</div>

			<?php if ( ! empty( $about ) ) { ?>
				<div class="dunhakdis-team-about">
					<p>
						<?php echo esc_html( $about ); ?>
					</p>
				</div>
			<?php } ?>

		</div><!--.dunhakdis-team-details-->
		
	</div>
	<?php
	return ob_get_clean();
}