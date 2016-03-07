<?php

/**
 * Adds Dunhakdis_Social_Media_Widget widget.
 */
class Dunhakdis_Social_Media_Widget extends WP_Widget {
  /**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'dunhakdis_social_media_widget', // Base ID
			__( 'Dunhakdis: Social Media Widget', 'dutility' ), // Name
			array( 'classname' => 'dunhakdis_social_media_widget', 'description' => __( 'Use this widget to display social links.', 'dutility' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title =  __( 'Recent Posts', 'dutility' );
		$fb = "";
    $twitter = "";
    $instagram = "";
    $googleplus = "";
    $linkedin = "";
    $email = "";
		$newtab = ! empty( $instance['newtab'] ) ? '1' : '0';

    if ( !empty( $instance['title'] ) ) {
        $title = $instance['title'];
    }
    if ( !empty( $instance['fb'] ) ) {
        $fb = $instance['fb'];
    }
    if ( !empty( $instance['twitter'] ) ) {
        $twitter = $instance['twitter'];
    }
		if ( !empty( $instance['instagram'] ) ) {
        $instagram = $instance['instagram'];
    }
		if ( !empty( $instance['googleplus'] ) ) {
        $googleplus = $instance['googleplus'];
    }
		if ( !empty( $instance['linkedin'] ) ) {
        $linkedin = $instance['linkedin'];
    }
		if ( !empty( $instance['email'] ) ) {
        $email = $instance['email'];
    }

    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );


	// 'fb_icon'		 	=>	 apply_filters( 'dutility_social_icons', 'fa fa-facebook'),
	// 'twitter_icon'		=>	 apply_filters( 'dutility_social_icons', 'fa fa-twitter'),
	// 'instagram_icon' 	=>	 apply_filters( 'dutility_social_icons', 'fa fa-instagram'),
	// 'googleplus_icon' 	=>	 apply_filters( 'dutility_social_icons', 'fa fa-google-plus'),
	// 'linkedin_icon' 	=>	 apply_filters( 'dutility_social_icons', 'fa fa-linkedin'),
	// 'email_icon'	 	=>	 apply_filters( 'dutility_social_icons', 'fa fa-envelope'),
	$dutility_social_icons_hint = apply_filters( 'dutility_social_icons_hint',
								array(
									'fb_hint'		 	=>	 'Follow us on Facebook',
									'twitter_hint'		=>	 'Follow us on Twitter',
									'instagram_hint' 	=>	 'Follow us on Instagram',
									'googleplus_hint' 	=>	 'Follow us on G+',
									'linkedin_hint' 	=>	 'Visit our LinkedIn account',
									'email_hint'	 	=>	 'Send us an Email',
								)
							);
	foreach ( $dutility_social_icons_hint as $key => $value ) {
		if ( !empty( $dutility_social_icons_hint[$key] ) ) {
			$$key = $dutility_social_icons_hint[$key];
		}
	}
	$dutility_social_icons = apply_filters( 'dutility_social_icons',
								array(
									'fb_icon'		 	=>	 'fa fa-facebook',
									'twitter_icon'		=>	 'fa fa-twitter',
									'instagram_icon' 	=>	 'fa fa-instagram',
									'googleplus_icon' 	=>	 'fa fa-google-plus',
									'linkedin_icon' 	=>	 'fa fa-linkedin',
									'email_icon'	 	=>	 'fa fa-envelope',
								)
							);
	foreach ( $dutility_social_icons as $key => $value ) {
		if ( !empty( $dutility_social_icons[$key] ) ) {
			$$key = $dutility_social_icons[$key];
		}
	}

	$dutility_social_icons_ligatures = apply_filters( 'dutility_social_icons_ligatures',
								array(
									'fb_icon_ligature'		 	=>	 ' ',
									'twitter_icon_ligature'		=>	 ' ',
									'instagram_icon_ligature' 	=>	 ' ',
									'googleplus_icon_ligature' 	=>	 ' ',
									'linkedin_icon_ligature' 	=>	 ' ',
									'email_icon_ligature'	 	=>	 ' ',
								)
							);
	foreach ( $dutility_social_icons_ligatures as $key => $value ) {
		if ( !empty( $dutility_social_icons_ligatures[$key] ) ) {
			$$key = $dutility_social_icons_ligatures[$key];
		}
	}
		?>
		<?php echo $args['before_widget']; ?>

		<?php  echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>
		<ul>

			<?php if ( !empty( $instance['fb'] ) ) { ?>
  			<li>
					<div class="dutility-social-media-link facebook-wrap">

						<?php if ($newtab == 0) { ?>

			  				<a href="<?php echo esc_url($fb); ?>" title="<?php _e('Facebook', 'dutility') ?>" class="facebook" data-hint="<?php echo esc_html( $fb_hint ); ?>">

								<span class="<?php echo $fb_icon; ?>"> <?php echo esc_html( $fb_icon_ligature ); ?> </span>

			          		</a>

						<?php }else{ ?>

							<a href="<?php echo esc_url($fb); ?>" title="<?php _e('Facebook', 'dutility') ?>" class="facebook" target="_blank" data-hint="<?php echo esc_html( $fb_hint ); ?>">

								<span class="<?php echo $fb_icon; ?>"> <?php echo esc_html( $fb_icon_ligature ); ?> </span>

		          			</a>

						<?php } ?>

					</div>
  			</li>
			<?php } ?>
			<?php if ( !empty( $instance['twitter'] ) ) { ?>
				<li>
					<div class="dutility-social-media-link twitter-wrap">

						<?php if ($newtab == 0) { ?>

			  				<a href="<?php echo esc_url($twitter); ?>" title="<?php _e('Twitter', 'dutility') ?>" class="twitter" data-hint="<?php echo esc_html( $twitter_hint ); ?>">

								<span class="<?php echo $twitter_icon; ?>"> <?php echo esc_html( $twitter_icon_ligature ); ?> </span>

			          		</a>

						<?php }else{ ?>

			  				<a href="<?php echo esc_url($twitter); ?>" title="<?php _e('Twitter', 'dutility') ?>" class="twitter" target="_blank" data-hint="<?php echo esc_html( $twitter_hint ); ?>">

								<span class="<?php echo $twitter_icon; ?>"> <?php echo esc_html( $twitter_icon_ligature ); ?> </span>

			          		</a>

						<?php } ?>

					</div>
  			</li>
			<?php } ?>
			<?php if ( !empty( $instance['instagram'] ) ) { ?>
				<li>
					<div class="dutility-social-media-link instagram-wrap">

						<?php if ($newtab == 0) { ?>

			  				<a href="<?php echo esc_url($instagram); ?>" title="<?php _e('Instagram', 'dutility') ?>" class="instagram" data-hint="<?php echo esc_html( $instagram_hint ); ?>">

								<span class="<?php echo $instagram_icon; ?>"> <?php echo esc_html( $instagram_icon_ligature ); ?> </span>

			          		</a>

						<?php }else{ ?>

			  				<a href="<?php echo esc_url($instagram); ?>" title="<?php _e('Instagram', 'dutility') ?>" class="instagram" target="_blank" data-hint="<?php echo esc_html( $instagram_hint ); ?>">

								<span class="<?php echo $instagram_icon; ?>"> <?php echo esc_html( $instagram_icon_ligature ); ?> </span>

			          		</a>

						<?php } ?>

					</div>
  			</li>
			<?php } ?>
			<?php if ( !empty( $instance['googleplus'] ) ) { ?>
				<li>
					<div class="dutility-social-media-link googleplus-wrap">

						<?php if ($newtab == 0) { ?>

			  				<a href="<?php echo esc_url($googleplus); ?>" title="<?php _e('Google+', 'dutility') ?>" class="googleplus" data-hint="<?php echo esc_html( $googleplus_hint ); ?>">

								<span class="<?php echo $googleplus_icon; ?>"> <?php echo esc_html( $googleplus_icon_ligature ); ?> </span>

			          		</a>

						<?php }else{ ?>

			  				<a href="<?php echo esc_url($googleplus); ?>" title="<?php _e('Google+', 'dutility') ?>" class="googleplus" target="_blank" data-hint="<?php echo esc_html( $googleplus_hint ); ?>">

								<span class="<?php echo $googleplus_icon; ?>"> <?php echo esc_html( $googleplus_icon_ligature ); ?> </span>

			          		</a>

						<?php } ?>

					</div>
  			</li>
			<?php } ?>
			<?php if ( !empty( $instance['linkedin'] ) ) { ?>
				<li>
					<div class="dutility-social-media-link linkedin-wrap">

						<?php if ($newtab == 0) { ?>

			  				<a href="<?php echo esc_url($linkedin); ?>" title="<?php _e('Linkedin', 'dutility') ?>" class="linkedin" data-hint="<?php echo esc_html( $linkedin_hint ); ?>">

								<span class="<?php echo $linkedin_icon; ?>"> <?php echo esc_html( $linkedin_icon_ligature ); ?> </span>

			          		</a>

						<?php }else{ ?>

			  				<a href="<?php echo esc_url($linkedin); ?>" title="<?php _e('Linkedin', 'dutility') ?>" class="linkedin" target="_blank" data-hint="<?php echo esc_html( $linkedin_hint ); ?>">

								<span class="<?php echo $linkedin_icon; ?>"> <?php echo esc_html( $linkedin_icon_ligature ); ?> </span>

							</a>

						<?php } ?>

					</div>
  			</li>
			<?php } ?>
			<?php if ( !empty( $instance['email'] ) ) { ?>
				<li>
					<div class="dutility-social-media-link email-wrap">

						<?php if ($newtab == 0) { ?>

			  				<a href="mailto:<?php echo esc_url($email); ?>" title="<?php _e('Email', 'dutility') ?>" class="email" data-hint="<?php echo esc_html( $email_hint ); ?>">

								<span class="<?php echo $email_icon; ?>"> <?php echo esc_html( $email_icon_ligature ); ?> </span>

			          		</a>

						<?php }else{ ?>

			  				<a href="mailto:<?php echo esc_url($email); ?>" title="<?php _e('Email', 'dutility') ?>" class="email" target="_blank" data-hint="<?php echo esc_html( $email_hint ); ?>">

								<span class="<?php echo $email_icon; ?>"> <?php echo esc_html( $email_icon_ligature ); ?> </span>

			          		</a>

						<?php } ?>

					</div>
  			</li>
			<?php } ?>

		</ul>
		<div class="clearfix"></div>
		<?php
		echo $args['after_widget'];
	}


	/**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
	    $instance = $old_instance;
	    $instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['fb'] = ( ! empty( $new_instance['fb'] ) ) ? esc_url( $new_instance['fb'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? esc_url( $new_instance['twitter'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? esc_url( $new_instance['instagram'] ) : '';
		$instance['googleplus'] = ( ! empty( $new_instance['googleplus'] ) ) ? esc_url( $new_instance['googleplus'] ) : '';
		$instance['linkedin'] = ( ! empty( $new_instance['linkedin'] ) ) ? esc_url( $new_instance['linkedin'] ) : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? esc_url( $new_instance['email'] ) : '';
		$instance['newtab'] = !empty($new_instance['newtab']) ? 1 : 0;

    return $instance;
  }

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Social Media', 'dutility' );
	    $fb = isset( $instance['fb'] ) ? $instance['fb']  : '';
	    $twitter = isset( $instance['twitter'] ) ? $instance['twitter']  : '';
	    $instagram = isset( $instance['instagram'] ) ? $instance['instagram']  : '';
	    $googleplus = isset( $instance['googleplus'] ) ? $instance['googleplus']  : '';
	    $linkedin = isset( $instance['linkedin'] ) ? $instance['linkedin']  : '';
	    $email = isset( $instance['email'] ) ? $instance['email']  : '';
		$newtab = isset($instance['newtab']) ? (bool) $instance['newtab'] : false;

		?>
		<p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'dutility' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

			<span class="help-text">
				<em><?php _e('You can use this field to enter the widget title.', 'dutility'); ?></em>
			</span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fb' ); ?>"><?php _e( 'Facebook link: ', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fb' ); ?>" name="<?php echo $this->get_field_name( 'fb' ); ?>" type="url" value="<?php if(isset($fb)) echo esc_attr($fb);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter link: ', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="url" value="<?php if(isset($twitter)) echo esc_attr($twitter);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Instagram link: ', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="url" value="<?php if(isset($instagram)) echo esc_attr($instagram);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'googleplus' ); ?>"><?php _e( 'Google Plus link: ', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name( 'googleplus' ); ?>" type="url" value="<?php if(isset($googleplus)) echo esc_attr($googleplus);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'Linkedin link: ', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="url" value="<?php if(isset($linkedin)) echo esc_attr($linkedin);?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email: ', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="url" value="<?php if(isset($email)) echo esc_attr($email);?>" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('newtab'); ?>" name="<?php echo $this->get_field_name('newtab'); ?>"<?php checked( $newtab ); ?> />
			<label for="<?php echo $this->get_field_id('newtab'); ?>"><?php _e( 'Open Link on New Tab', 'dutility' ); ?></label><br />
		</p>
		<?php
	}

} // Class Dunhakdis_Social_Media_Widget

add_action( 'widgets_init', 'dunhakdis_register_social_media_widget' );

function dunhakdis_register_social_media_widget() {

	register_widget( 'Dunhakdis_Social_Media_Widget' );

	return;
}
