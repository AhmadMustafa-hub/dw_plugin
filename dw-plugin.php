<?php
/**
 * Plugin Name: DW Plugin
 * Description: A simple plugin that demonstrates the WordPress REST API and React.
 * Version: 1.0.1
 * Author: Ahmad
 * License: GPL2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DW_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'DW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once DW_PLUGIN_PATH . 'includes/class-dw-plugin.php';

register_activation_hook( __FILE__, array( 'DW_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DW_Plugin', 'deactivate' ) );

DW_Plugin::get_instance();
