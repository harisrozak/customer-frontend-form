<?php

/**
 * Plugin Name:       Customer Frontend Form
 * Plugin URI:        #
 * Description:       A simple plugin to generate a front-end form for customer via shortcode <code>[form_customer]</code>
 * Version:           0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            harisrozak
 * Author URI:        https://harisrozak.github.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       et-dev-test-project
 * Domain Path:       #
 */

// define plugin constants
define( 'ETDTP_FILE', __FILE__ );
define( 'ETDTP_PATH', plugin_dir_path( __FILE__ ) );
define( 'ETDTP_URL', plugin_dir_url( __FILE__ ) );

// load required files
require_once ETDTP_PATH . 'includes/customer-post-type.php';
require_once ETDTP_PATH . 'includes/form-customer-shortcode.php';
require_once ETDTP_PATH . 'includes/ajax.php';

// run class instances
ETDTP_CustomerPostType::getInstance();
ETDTP_FormCustomerShortcode::getInstance();
ETDTP_Ajax::getInstance();