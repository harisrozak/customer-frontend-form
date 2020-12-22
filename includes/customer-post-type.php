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
		$post_type_labels = array(
            'name' 			   	 => __( 'Customers', 'et-dev-test-project' ),
            'singular_name'	     => __( 'Customer', 'et-dev-test-project' ),
            'add_new' 		   	 => __( 'Add Customer', 'et-dev-test-project' ),
            'add_new_item' 	   	 => __( 'Add Customer Item', 'et-dev-test-project' ),
            'edit' 			   	 => __( 'Edit', 'et-dev-test-project' ),
            'edit_item' 	   	 => __( 'Edit Customer', 'et-dev-test-project' ),
            'new_item' 		   	 => __( 'New Customer', 'et-dev-test-project' ),
            'view' 			   	 => __( 'View', 'et-dev-test-project' ),
            'view_item' 	   	 => __( 'View Customer', 'et-dev-test-project' ),
            'search_items' 	   	 => __( 'Search Customer', 'et-dev-test-project' ),
            'not_found' 	   	 => __( 'No Customers Found', 'et-dev-test-project' ),
            'not_found_in_trash' => __( 'No Customer found in the trash', 'et-dev-test-project' ),
            'parent' 			 => __( 'Parent Customer view ', 'et-dev-test-project' ),
        );

	    register_post_type( 'customer',
	        array(
	            'labels' 		=> $post_type_labels,
	            'public' 		=> false,
	            'show_ui' 		=> true,
	            'supports' 		=> array( 'title' ),
	            'menu_position' => 5, // places menu item directly below Posts
	            'menu_icon' 	=> 'dashicons-groups', // dashicons
	            'taxonomies' 	=> array( 'customer_cat', 'customer_tag' )
	        )
	    );	
	}

	// register custom taxonomies
	public function register_taxonomies() {
		$customer_cat_labels = array(
	 		'name' 				=> __( 'Categories', 'et-dev-test-project' ),
	 		'singular_name' 	=> __( 'Category', 'et-dev-test-project' ),
	 		'search_items' 		=> __( 'Search Category', 'et-dev-test-project' ),
	 		'all_items' 		=> __( 'All Category', 'et-dev-test-project' ),
	 		'parent_item' 		=> __( 'Parent Category', 'et-dev-test-project' ),
	 		'parent_item_colon' => __( 'Parent Category:', 'et-dev-test-project' ),
	 		'edit_item' 		=> __( 'Edit Category', 'et-dev-test-project' ), 
	 		'update_item' 		=> __( 'Update Category', 'et-dev-test-project' ),
	 		'add_new_item' 		=> __( 'Add New Category', 'et-dev-test-project' ),
	 		'new_item_name' 	=> __( 'New Category Name', 'et-dev-test-project' ),
	 		'menu_name' 		=> __( 'Categories', 'et-dev-test-project' ),
	 	);

	 	$customer_tag_labels = array(
	 		'name' 				=> __( 'Tags', 'et-dev-test-project' ),
	 		'singular_name' 	=> __( 'Tag', 'et-dev-test-project' ),
	 		'search_items' 		=> __( 'Search Tag', 'et-dev-test-project' ),
	 		'all_items' 		=> __( 'All Tag', 'et-dev-test-project' ),
	 		'parent_item' 		=> __( 'Parent Tag', 'et-dev-test-project' ),
	 		'parent_item_colon' => __( 'Parent Tag:', 'et-dev-test-project' ),
	 		'edit_item' 		=> __( 'Edit Tag', 'et-dev-test-project' ), 
	 		'update_item' 		=> __( 'Update Tag', 'et-dev-test-project' ),
	 		'add_new_item' 		=> __( 'Add New Tag', 'et-dev-test-project' ),
	 		'new_item_name' 	=> __( 'New Tag Name', 'et-dev-test-project' ),
	 		'menu_name' 		=> __( 'Tags', 'et-dev-test-project' ),
	 	);

		// register customer_cat
		register_taxonomy( 'customer_cat', array( 'customer' ), array(
	 		'hierarchical' 		=> true,
	 		'labels' 			=> $customer_cat_labels,
	 		'public' 			=> false,
	 		'show_ui' 			=> true,
	 		'show_admin_column' => true,
	 		'query_var' 		=> true,
	 		'rewrite' 			=> array( 'slug' => 'customer_cat' ),
	 	) );

		// register customers_tag
		register_taxonomy( 'customers_tag', array( 'customer' ), array(
	 		'hierarchical' 		=> false,
	 		'labels' 			=> $customer_tag_labels,
		 	'public' 			=> false,
	 		'show_ui' 			=> true,
	 		'show_admin_column' => true,
	 		'query_var' 		=> true,
	 		'rewrite' 			=> array( 'slug' => 'customers_tag' ),
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
	    if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( $_POST['nonce'], '6&eC&D:EuG#kDn' ) ) return;

	   	// atts
		$phone_number = sanitize_text_field( $_POST['phone_number'] );
		$email 		  = sanitize_email( $_POST['email'] );
		$budget		  = sanitize_text_field( $_POST['budget'] );
		$message 	  = sanitize_text_field( $_POST['message'] );
		$timezone 	  = sanitize_text_field( $_POST['timezone'] );
		$datetime 	  = sanitize_text_field( $_POST['datetime'] );

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
	    $email 	 	  = get_post_meta( $post->ID, 'email', true );
	    $budget		  = get_post_meta( $post->ID, 'budget', true );
	    $message	  = get_post_meta( $post->ID, 'message', true );
	    $timezone 	  = get_post_meta( $post->ID, 'timezone', true );
	    $datetime 	  = get_post_meta( $post->ID, 'datetime', true );
	 
		require ETDTP_PATH . 'templates/customer-meta-box.php';
	}

	public function customer_meta_box_css() {
		global $typenow;

	    if( 'customer' == $typenow ) {
	        wp_enqueue_style( 'meta-box-css', ETDTP_URL . 'assets/customer-meta-box.css', array(), '20191216', 'all' );
	    }
	}

	public function customer_posts_columns( $posts_columns ) {
		$posts_columns['title'] = __( 'Name', 'et-dev-test-project' );
		return $posts_columns;
	}
}