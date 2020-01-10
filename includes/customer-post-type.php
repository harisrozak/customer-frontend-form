<?php

Class ETDTP_CustomerPostType {
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
		// register customer post type
		add_action( 'init', array( $this, 'register_post_type' ) );

		// register customer taxonomies
		add_action( 'init', array( $this, 'register_taxonomies' ) );

		// register metaboxes
		add_action( 'add_meta_boxes', array( $this, 'customer_meta_boxes' ) );

		// save meta boxes data on save customer
		add_action( 'save_post', array( $this, 'save_customer_data') );

		// load style on admin add and edit customer
		add_action( 'admin_print_styles-post.php', array( $this, 'customer_meta_box_css' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'customer_meta_box_css' ) );

		// change label 'Title' on admin post column to 'Name'
		add_filter( 'manage_customer_posts_columns', array( $this, 'customer_posts_columns' ) );
	}

	// register custom post type
	public function register_post_type() {
	    register_post_type( 'customer',
	        array(
	            'labels' => array(
	                'name' => _x( 'Customers', 'post type general name' ),
	                'singular_name' => _x( 'Customer', 'taxonomy singular name' ),
	                'add_new' => __( 'Add Customer' ),
	                'add_new_item' => __( 'Add Customer Item' ),
	                'edit' => __( 'Edit' ),
	                'edit_item' => __( 'Edit Customer' ),
	                'new_item' => __( 'New Customer' ),
	                'view' => __( 'View' ),
	                'view_item' => __( 'View Customer' ),
	                'search_items' => __( 'Search Customer' ),
	                'not_found' => __( 'No Customers Found' ),
	                'not_found_in_trash' => __( 'No Customer found in the trash' ),
	                'parent' => __( 'Parent Customer view ' ),
	            ),
	            'public' => false,
	            'show_ui' => true,
	            'supports' => array( 'title' ),
	            'menu_position' => 5, // places menu item directly below Posts
	            'menu_icon' => 'dashicons-groups', // dashicons
	            'taxonomies' => array( 'customer_cat', 'customer_tag' )
	        )
	    );	
	}

	// register custom taxonomies
	public function register_taxonomies() {
		// register customer_cat
		register_taxonomy( 'customer_cat', array( 'customer' ), array(
	 		'hierarchical' => true,
	 		'labels' => array(
		 		'name' => _x( 'Categories', 'taxonomy general name' ),
		 		'singular_name' => _x( 'Category', 'taxonomy singular name' ),
		 		'search_items' =>  __( 'Search Category' ),
		 		'all_items' => __( 'All Category' ),
		 		'parent_item' => __( 'Parent Category' ),
		 		'parent_item_colon' => __( 'Parent Category:' ),
		 		'edit_item' => __( 'Edit Category' ), 
		 		'update_item' => __( 'Update Category' ),
		 		'add_new_item' => __( 'Add New Category' ),
		 		'new_item_name' => __( 'New Category Name' ),
		 		'menu_name' => __( 'Categories' ),
		 	),
	 		'public' => false,
	 		'show_ui' => true,
	 		'show_admin_column' => true,
	 		'query_var' => true,
	 		'rewrite' => array( 'slug' => 'customer_cat' ),
	 	) );

		// register customers_tag
		register_taxonomy( 'customers_tag', array( 'customer' ), array(
	 		'hierarchical' => false,
	 		'labels' => array(
		 		'name' => _x( 'Tags', 'taxonomy general name' ),
		 		'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
		 		'search_items' =>  __( 'Search Tag' ),
		 		'all_items' => __( 'All Tag' ),
		 		'parent_item' => __( 'Parent Tag' ),
		 		'parent_item_colon' => __( 'Parent Tag:' ),
		 		'edit_item' => __( 'Edit Tag' ), 
		 		'update_item' => __( 'Update Tag' ),
		 		'add_new_item' => __( 'Add New Tag' ),
		 		'new_item_name' => __( 'New Tag Name' ),
		 		'menu_name' => __( 'Tags' ),
		 	),
		 	'public' => false,
	 		'show_ui' => true,
	 		'show_admin_column' => true,
	 		'query_var' => true,
	 		'rewrite' => array( 'slug' => 'customers_tag' ),
	 	) );
	}

	public function customer_meta_boxes() {    
	    add_meta_box( 
	        'customer_data',
	        'Customer Data',
	        array( $this, 'customer_meta_boxes_callback' ),
	        'customer' ,
	        'normal',
	        "high"
	    );
	}

	public function save_customer_data( $post_id ) {   
	    // verify if this is an auto save routine
	    // If it is our form has not been submitted, so we dont want to do anything
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	    // verify this came from the our screen and with proper authorization
	    // because save_post can be triggered at other times
	    if ( isset( $_POST[ 'nonce' ] ) && ! wp_verify_nonce( $_POST[ 'nonce' ], '6&eC&D:EuG#kDn' ) ) return;

	   	// atts
		$phone_number = sanitize_text_field( $_POST[ 'phone_number' ] );
		$email = sanitize_email( $_POST[ 'email' ] );
		$budget = sanitize_text_field( $_POST[ 'budget' ] );
		$message = sanitize_text_field( $_POST[ 'message' ] );
		$timezone = sanitize_text_field( $_POST[ 'timezone' ] );
		$datetime = sanitize_text_field( $_POST[ 'datetime' ] );

		// update post meta
	    update_post_meta( $post_id, 'phone_number', $phone_number );
	    update_post_meta( $post_id, 'email', $email );
	    update_post_meta( $post_id, 'budget', $budget );
	    update_post_meta( $post_id, 'message', $message );
	    update_post_meta( $post_id, 'timezone', $timezone );
	    update_post_meta( $post_id, 'datetime', $datetime );
	}

	public function customer_meta_boxes_callback( $post ) {
	    // Use nonce for verification
	    wp_nonce_field( '6&eC&D:EuG#kDn', 'nonce' );

	    $phone_number = get_post_meta( $post->ID, 'phone_number', true );
	    $email = get_post_meta( $post->ID, 'email', true );
	    $budget = get_post_meta( $post->ID, 'budget', true );
	    $message = get_post_meta( $post->ID, 'message', true );
	    $timezone = get_post_meta( $post->ID, 'timezone', true );
	    $datetime = get_post_meta( $post->ID, 'datetime', true );
	 
		require ETDTP_PATH . 'templates/customer-meta-box.php';
	}

	public function customer_meta_box_css() {
		global $typenow;

	    if( 'customer' == $typenow ) {
	        wp_enqueue_style( 'meta-box-css', ETDTP_URL . 'assets/customer-meta-box.css', array(), '20191216', 'all' );
	    }
	}

	public function customer_posts_columns( $posts_columns ) {
		$posts_columns[ 'title' ] = "Name";
		return $posts_columns;
	}
}