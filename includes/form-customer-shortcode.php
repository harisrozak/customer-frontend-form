<?php

Class ETDTP_FormCustomerShortcode {
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
		// register style and script for the shortcode
		add_action( 'wp_enqueue_scripts', array( $this, 'form_customer_style_and_script' ) );

		// register shortcode
		add_shortcode( 'form_customer', array( $this, 'shortcode_form_customer_callback' ) );
	}

	public function form_customer_style_and_script() {
		// register style
		wp_register_style( 'form-customer', ETDTP_URL . 'assets/form-customer.css', array(), '20191216', 'all' );

		// register scripts
		wp_register_script( 'jquery', false );
		wp_register_script( 'form-customer', ETDTP_URL . 'assets/form-customer.js', array( 'jquery' ), '20191216', true );
		wp_localize_script( 'form-customer', 'wp_ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	public function shortcode_form_customer_callback( $attributes ) {
		// the default attributes
		$default_attributes = array(
			'title'          => 'FORM CUSTOMER',
			'label_name'     => 'Name',
			'label_phone'    => 'Phone Number',
			'label_email'    => 'Email Address',
			'label_budget'   => 'Desired Budget',
			'label_message'	 => 'Message',
			'label_submit'   => 'Submit',
			'length_name'    => '45',
			'length_phone'   => '15',
			'length_email'   => '25',
			'length_budget'  => '25',
			'length_message' => '',
			'textarea_rows'  => '5',
			'textarea_cols'  => '', // if empty, set width to 100% 
		);

		// get shortcode's final attributes
		$atts = shortcode_atts( $default_attributes, $attributes, 'form_customer' );

		// enqueue style and scripts
		wp_enqueue_style( 'form-customer' );
		wp_enqueue_script( 'form-customer' );

		// get the template
		ob_start();		
		require ETDTP_PATH . 'templates/form-customer.php';
		$html = ob_get_contents();
		ob_end_clean();
		
		// return the html
		return $html;
	}
}