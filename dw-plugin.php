<?php
/*
Plugin Name: Dashboard Widget Plugin
Description: Adds a custom dashboard widget to admin dashboard
Version:1.0
Author: Ahmad 
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('DW_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DW_PLUGIN_URL', plugin_dir_url(__FILE__));

// Main class
require_once DW_PLUGIN_PATH . 'includes/class-dw-plugin.php';

// Activation and deactivation hooks
register_activation_hook(__FILE__, array('Dw_Plugin', 'activate'));
register_deactivation_hook(__FILE__, array('Dw_Plugin', 'deactivate'));

add_action('plugins_loaded', array('Dw_Plugin', 'get_instance'));
