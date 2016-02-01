<?php

/**
 * Adds Dunhakdis_Instagram_Widget widget.
 */
class Dunhakdis_Instagram_Widget extends WP_Widget {
  /**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'dunhakdis_instagram_widget', // Base ID
			__( 'Dunhakdis: Instagram Widget', 'dutility' ), // Name
			array(
                'classname' => 'dunhakdis_instagram_widget',
                'description' => __( 'Use this widget to display Instagram posts.', 'dutility' ),
            ) // Args
		);
	} // function __construct()

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

        $title =  __( 'Instagram Widget', 'dutility' );

        if ( !empty( $instance['title'] ) ) {
            $title = $instance['title'];
        }

        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );


        echo $args['before_widget']; ?>

  		<?php  echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>

        <div id="images">
        </div>

  		<?php echo $args['after_widget'];
  	} // Public function widget()

} // Class Dunhakdis_Instagram_Widget

function Dunhakdis_Request_HTTP($method, $url, $header, $data){

    if( $method == 1 ){
        $method_type = 1; // 1 = POST
    }else{
        $method_type = 0; // 0 = GET
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_HEADER, 0);

    if( $header !== 0 ){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }

    curl_setopt($curl, CURLOPT_POST, $method_type);

    if( $data !== 0 ){
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    $response = curl_exec($curl);
    $json = json_decode($response, true);
    curl_close($curl);
    return $json;
} // function Dunhakdis_Request_HTTP()

add_action( 'wp_ajax_dutility_instagram_endpoint', 'dutility_instagram_endpoint_callback' );
function dutility_instagram_endpoint_callback() {


}

add_action( 'widgets_init', 'dunhakdis_register_instagram_widget' );

function dunhakdis_register_instagram_widget() {

	register_widget( 'Dunhakdis_Instagram_Widget' );

	return;
}
