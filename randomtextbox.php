<?php

/*
 * Plugin Name: Random Text Box
 * Plugin URI:  https://github.com/schrottgerardo/random-text-box
 * Description: Share custom text/quotes with this Widget. Random text is the best!
 * Version: 1.1.2
 * Author: Gerardo Schrott
 * Author URI: https://github.com/schrottgerardo/
 * License: GPL3
 */

namespace RTB_SPACE;
defined( 'ABSPATH' ) or die( "Not today" );
define( 'RTB_RUTA', plugin_dir_path(__FILE__) ) ;

// AGREGA EL STYLE
wp_register_style( 'rtb', plugins_url('/css/style.css', __FILE__) );
wp_enqueue_style( 'rtb' );

//ACTIVATION PLUGIN
class RandomTextBox_Setup {

		//PROPERTYS
		private $wpdb;
		private $charset_collate;
		private $table_name;
		private $sql;

	function __construct() {
		//beep beep beep
	}
	//CREATE THE ADMIN MENU OPTIONS TO DO
	//CREATE THE TABLE AT MYSQL DATABASE
	function table() {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->charset_collate = $this->wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$this->table_name = $this->wpdb->prefix . 'rtb';
		$this->sql = "CREATE TABLE $this->table_name (
			id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			title varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			author varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			text longtext COLLATE utf8_unicode_ci
		) $this->charset_collate;";
		dbDelta( $this->sql );
	}

	function activate() {
		$this->table();
		flush_rewrite_rules();
	}

	function deactivate() {
		flush_rewrite_rules();
	}
}

if ( class_exists ( '\RTB_SPACE\RandomTextBox_Setup' ) ) {
	$randomtextbox_setup = new RandomTextBox_Setup();
}

register_activation_hook(__FILE__, array( $randomtextbox_setup, 'activate' ) );
register_deactivation_hook(__FILE__, array( $randomtextbox_setup, 'deactivate' ) );

// RUN THE WIDGET CODE
require_once( RTB_RUTA . '/public/functions.php' );

// RUN THE FORM IN THE ADMIN PANEL
if ( is_admin() ) {
	require_once( RTB_RUTA . '/admin/functions.php' );
}
