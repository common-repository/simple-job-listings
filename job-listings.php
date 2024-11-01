<?php
/*
Plugin Name: Job Listings
Plugin URI: http://www.5hdagency.com
Description: Simple Job Listings plugin. Use `[jobs order="title" show_date="y"]`
Version: 1.0
Author: 5HD Agency
Author URI: http://www.5hdagency.com
Text Domain: joblistings
*/

if ( !function_exists( 'add_action' ) ) {
	die('Whoops! Nothing to see here...');
}

define( 'JOBLISTINGS_VERSION', '0.1' );
define( 'JOBLISTINGS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'JOBLISTINGS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'JobListings', 'activate_plugin' ) );
register_deactivation_hook(  __FILE__, array( 'JobListings', 'deactivate_plugin' ) );

add_action( 'init', array( 'JobListings', 'init' ) );
add_filter( 'user_has_cap',  array( 'JobListings', 'add_perms' ) );

require_once( JOBLISTINGS__PLUGIN_DIR . 'class.joblistings.php' );