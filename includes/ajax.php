<?php

Class ETDTP_Ajax {
	// instance
	private static $instance;
	
	// getInstance
	public static function getInstance() {
		if( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	// __construct
	private function __construct() {
		add_action( 'wp_ajax_save_data_customer', array( $this, 'ajax_save_data_customer' ) ); /* for logged in user */
		add_action( 'wp_ajax_nopriv_save_data_customer', array( $this, 'ajax_save_data_customer' ) ); /* for non-logged in user */
	}

	public function ajax_save_data_customer() {
		// check nonce
		check_ajax_referer( '6&eC&D:EuG#kDn', 'nonce' );

		// atts
		$name 		  = sanitize_text_field( $_POST['name'] );
		$phone_number = sanitize_text_field( $_POST['phone_number'] );
		$email 	  	  = sanitize_email( $_POST['email'] );
		$budget   	  = sanitize_text_field( $_POST['budget'] );
		$message  	  = sanitize_text_field( $_POST['message'] );
		$timezone 	  = sanitize_text_field( $_POST['timezone'] );
		$datetime 	  = sanitize_text_field( $_POST['datetime'] );

		// insert post
		$post_id = wp_insert_post( array(
			'post_title'  => $name,
			'post_status' => 'publish',
			'post_type'   => 'customer',
			'meta_input'  => array(
		        'phone_number' => $phone_number,
		        'email'	 	   => $email,
		        'budget' 	   => $budget,
		        'message' 	   => $message,
		        'timezone' 	   => $timezone,
		        'datetime' 	   => $datetime,
		    ),
		) );

		// notice success
		wp_send_json( array( 'post_id' => $post_id ) );
	}
}