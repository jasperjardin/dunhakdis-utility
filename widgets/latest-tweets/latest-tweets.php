<?php
/**
 * Adds Dunhakdis_Latest_Tweets_Widget widget.
 */
class Dunhakdis_Latest_Tweets_Widget extends WP_Widget {
    /**
	 * Register widget with WordPress.
	 */
	function __construct() {

		require_once plugin_dir_path( __FILE__ ) . '\TwitterOAuth\autoload.php';

		parent::__construct(
			'dunhakdis_latest_tweets_widget', // Base ID
			__( 'Dunhakdis: Latest Tweets', 'dutility' ), // Name
			array( 'classname' => 'dunhakdis_latest_tweets_widget', 'description' => __( 'Use this widget to display number of tweets.', 'dutility' ), ) // Args
		);

		return;

	}

	/**
	 * The template for the user tweets.
	 *
	 * @return void
	 */
	public function tweet_template( $status = "", $show_date = 0 ) { ?>
		<?php if ( ! empty( $status ) ) { ?>
			<li>
				<div class="dutility-tweet-info">
					<div class="dutility-tweet">
						<?php echo __( dutility_tweet_link_converter( $status->text ) ); ?>
					</div>
					<?php if ( $show_date === 1 ) { ?>
						<div class="dutility-date-tweeted">
							<a target="_blank" href="<?php echo esc_url('https://twitter.com/statuses/'.$status->id); ?>" title="<?php _e( 'View on Twitter', 'dutility' ); ?>">
								<?php echo esc_attr(human_time_diff( strtotime( $status->created_at ), current_time('timestamp') ) ) . __( ' ago', 'dutility' ); ?>
							</a>
						</div>
					<?php } ?>
				</div>
			</li>
		<?php } ?>
	<?php
		return;
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


	$title =  "__( 'Latest Tweets', 'dutility' )";
	$consumer_key = "";
    $consumer_secret = "";
    $access_token = "";
    $access_token_secret = "";
    $maxtweets = 5;
	$exclude_replies = ! empty( $instance['exclude_replies'] ) ? '1' : '0';
    $clear_tweets = "";
    $clear_tweets_format = "";
	$clear_tweets_minutes = array( 30 );
	$clear_tweets_hours = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 24 );
	$show_date = ! empty( $instance['show_date'] ) ? '1' : '0';

    if ( !empty( $instance['title'] ) ) {
        $title = $instance['title'];
    }

	if ( !empty( $instance['consumer_key'] ) ) {
		$consumer_key = $instance['consumer_key'];
    }

	if ( !empty( $instance['consumer_secret'] ) ) {
		$consumer_secret = $instance['consumer_secret'];
    }

	if ( !empty( $instance['access_token'] ) ) {
		$access_token = $instance['access_token'];
    }

	if ( !empty( $instance['access_token_secret'] ) ) {
		$access_token_secret = $instance['access_token_secret'];
    }

	if ( !empty( $instance['maxtweets'] ) ) {
		$maxtweets = $instance['maxtweets'];
    }

	if ( !empty( $instance['clear_tweets'] ) ) {
		$clear_tweets = $instance['clear_tweets'];
    }

	if ( !empty( $instance['show_date'] ) ) {
		$show_date = $instance['show_date'];
    }
	if ( in_array( $clear_tweets, $clear_tweets_minutes ) ) {
		$clear_tweets_format = MINUTE_IN_SECONDS;
	}

	if ( in_array( $clear_tweets, $clear_tweets_hours ) ) {
		$clear_tweets_format = HOUR_IN_SECONDS;
	}


    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

	?>

		<?php echo $args['before_widget']; ?>

		<?php echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>

		<?php $tweets_saved_transients = get_transient( '_dunhakdis_twitter_transient_' ); ?>

		<ul>
			<?php
			// Request for new Twitter data if our transients has expired or is empty.
			if ( empty( $tweets_saved_transients ) ) {

				$connection = new Abraham\TwitterOAuth\TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

			  	$tweets = $connection->get("account/verify_credentials");

				$settings = array(
				    "count" => $maxtweets,
				    "exclude_replies" => $exclude_replies,
				    "trim_user" => true
				);

				$statuses = $connection->get( "statuses/user_timeline", $settings );

				if ( ! empty ( $statuses->errors ) ) {

					echo '<li>' . $statuses->errors[0]->message . '</li>';

					return;
				}


				if ( ! empty ( $statuses ) ) {

					$tweets_saved_transients = $statuses;

					if ( !empty ( $tweets_saved_transients ) ) {

						foreach( $tweets_saved_transients as $status ) {
							if ( isset( $status->text ) ) {
								$this->tweet_template( $status, $show_date );
							}
						}

						// Set the transients.
						set_transient( '_dunhakdis_twitter_transient_', $tweets_saved_transients, $clear_tweets * $clear_tweets_format );

					}

				} else {
					?>
					<li class="no-result">
						<?php _e('Unable to fetch your Tweets. Please make sure you have entered the settings correctly inside widgets.', 'dutility'); ?>
					</li>
					<?php
				}

			} else {

				if ( !empty ( $tweets_saved_transients ) ) {
					foreach( $tweets_saved_transients as $status ) {
						if ( isset( $status->text ) ) {
							$this->tweet_template( $status, $show_date );
						}
					}
				} else {
					?>
					<li class="no-result">
						<?php _e('Unable to fetch your Tweets. Please make sure you have entered the settings correctly inside widgets.', 'dutility'); ?>
					</li>
					<?php
				}

			}
			//echo human_time_diff( '1171502725', '1272508903' ) . ' ago'; ?>
		</ul>
		<?php echo $args['after_widget'];

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
   * @author Jasper J.
   */
  public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
    	$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['consumer_key'] = ( ! empty( $new_instance['consumer_key'] ) ) ? strip_tags( $new_instance['consumer_key'] ) : '';
		$instance['consumer_secret'] = ( ! empty( $new_instance['consumer_secret'] ) ) ? strip_tags( $new_instance['consumer_secret'] ) : '';
		$instance['access_token'] = ( ! empty( $new_instance['access_token'] ) ) ?  strip_tags( $new_instance['access_token'] )  : '';
		$instance['access_token_secret'] = ( ! empty( $new_instance['access_token_secret'] ) ) ? strip_tags( $new_instance['access_token_secret'] ) : '';
    	$instance['maxtweets'] = (int) $new_instance['maxtweets'];
		$instance['exclude_replies'] = !empty($new_instance['exclude_replies']) ? 1 : 0;
    	$instance['clear_tweets'] = $new_instance['clear_tweets'] ;
		$instance['show_date'] = !empty($new_instance['show_date']) ? 1 : 0;

		if ( in_array( $new_instance['clear_tweets'], array(
					'30',
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'24'
				)
			)
		) {
      $instance['clear_tweets'] = $new_instance['clear_tweets'];
    } else {
      $instance['clear_tweets'] = '30 * MINUTE_IN_SECONDS';
    }

	if( $instance['clear_tweets'] === $old_instance['clear_tweets'] ){
	  delete_transient( '_dunhakdis_twitter_transient_' );
	}

    return $instance;
  }


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 * @author Jasper J.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest Tweets', 'dutility' );
		$consumer_key = isset( $instance['consumer_key'] ) ? $instance['consumer_key']  : '';
		$consumer_secret = isset( $instance['consumer_secret'] ) ? $instance['consumer_secret']  : '';
		$access_token = isset( $instance['access_token'] ) ? $instance['access_token']  : '';
		$access_token_secret = isset( $instance['access_token_secret'] ) ? $instance['access_token_secret']  : '';
		$maxtweets = isset( $instance['maxtweets'] ) ? $instance['maxtweets']  : '';
		$exclude_replies = isset( $instance['exclude_replies'] ) ? $instance['exclude_replies']  : '';
		$clear_tweets =  __('30 * MINUTE_IN_SECONDS', 'dutility');
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date']  : '';

		foreach ( $instance as $key => $value ) {
			if ( !empty( $instance[$key] ) ) {
				$$key = $instance[$key];
			}
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'consumer_key' ); ?>"><?php _e( 'Consumer Key:', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'consumer_key' ); ?>" type="text" value="<?php echo esc_attr( $consumer_key ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'consumer_secret' ); ?>"><?php _e( 'Consumer Secret:', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>" type="text" value="<?php echo esc_attr( $consumer_secret ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php _e( 'Access Token:', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'access_token_secret' ); ?>"><?php _e( 'Access Token Secret:', 'dutility' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'access_token_secret' ); ?>" name="<?php echo $this->get_field_name( 'access_token_secret' ); ?>" type="text" value="<?php echo esc_attr( $access_token_secret ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'maxtweets' ); ?>"><?php _e( 'Number of Tweets to show: ', 'dutility' ); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'maxtweets' ); ?>" name="<?php echo $this->get_field_name( 'maxtweets' ); ?>" type="number" value="<?php echo esc_attr( $maxtweets ); ?>" >
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('exclude_replies'); ?>"><?php _e( 'Exclude Replies: ', 'dutility' ); ?></label>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('exclude_replies'); ?>" name="<?php echo $this->get_field_name('exclude_replies'); ?>"<?php checked( $exclude_replies ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e( 'Show Date: ', 'dutility' ); ?></label>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>"<?php checked( $show_date ); ?> />
		</p>

		<p>
	      <label for="<?php echo $this->get_field_id( 'clear_tweets' ); ?>"><?php _e( 'Clear Tweets Every:', 'dutility' ); ?></label>
	      <select class="widefat" id="<?php echo $this->get_field_id( 'clear_tweets' ); ?>" name="<?php echo $this->get_field_name( 'clear_tweets' ); ?>" >

			<option value="<?php echo esc_attr('30'); ?>"<?php selected( $clear_tweets, '30' ); ?>>
				<?php _e( '30 Minutes', 'dutility' ); ?>
			</option>

			<option value="<?php echo esc_attr('1'); ?>"<?php selected( $clear_tweets, '1' ); ?>>
	          <?php _e( '1 Hour', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('2'); ?>"<?php selected( $clear_tweets, '2'  ); ?>>
	          <?php _e( '2 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('3'); ?>"<?php selected( $clear_tweets, '3'  ); ?>>
	          <?php _e( '3 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('4'); ?>"<?php selected( $clear_tweets, '4'  ); ?>>
	          <?php _e( '4 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('5'); ?>"<?php selected( $clear_tweets, '5'  ); ?>>
	          <?php _e( '5 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('6'); ?>"<?php selected( $clear_tweets, '6'  ); ?>>
	          <?php _e( '6 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('7'); ?>"<?php selected( $clear_tweets, '7'  ); ?>>
	          <?php _e( '7 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('8'); ?>"<?php selected( $clear_tweets, '8'  ); ?>>
	          <?php _e( '8 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('9'); ?>"<?php selected( $clear_tweets, '9'  ); ?>>
	          <?php _e( '9 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('10'); ?>"<?php selected( $clear_tweets, '10'  ); ?>>
	          <?php _e( '10 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('11'); ?>"<?php selected( $clear_tweets, '11'  ); ?>>
	          <?php _e( '11 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('12'); ?>"<?php selected( $clear_tweets, '12'  ); ?>>
	          <?php _e( '12 Hours', 'dutility' ); ?>
	        </option>

			<option value="<?php echo esc_attr('24'); ?>"<?php selected( $clear_tweets, '24'  ); ?>>
	          <?php _e( '24 Hours', 'dutility' ); ?>
	        </option>

	      </select>

			<span class="help-text">
				<em><?php _e('This will pull your latest tweets based on what you have selected.', 'dutility'); ?></em>
			</span>

		</p>
		<?php

	}// Function form()

}// Class Dunhakdis_Blog_Post_Widget


//Converts Twitter links to a readable and clickable format.
if ( !function_exists('dutility_tweet_link_converter')) {

	function dutility_tweet_link_converter($status, $targetBlank=true, $linkMaxLen=250){

		// Open with target
			$target = $targetBlank ? " target=\"_blank\" " : "";

		// Convert links to url.
			$status = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]/i', '<a class="dutility_twitter_link" href="\0" target="_blank">\0</a>', $status);

		// Converts @ to follow.
			$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a class=\"dutility_twitter_link\" href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

		// Return the status.
			return $status;
	}
}


add_action( 'widgets_init', 'dunhakdis_register_latest_tweets_widget' );

function dunhakdis_register_latest_tweets_widget() {

	register_widget( 'Dunhakdis_Latest_Tweets_Widget' );

	return;
}
