<?php

/*
 * CREATE THE RANDOM TEXT BOX
 * @class `WP_Widget`
 */

namespace RTB_SPACE;
defined('ABSPATH') or die("Not today");

class RandomTextBox extends \WP_Widget {

	/* PARAMS
	* @param array $args
	* @param array $instance
	*/

	// PROPERTY
	private $wpdb;
	private $rtb_table;
	private $rtb_count;
	private $rtb_id;
	private $rtb_box;

	// METHODS
	// REQUIRED FOR WORDPRESS PANEL
	public function __construct($rtb_new) {

		// WP GLOBALS NEEDED
		global $wpdb;
		$this->wpdb = $wpdb;

		parent::__construct(
		  'rtb_widget',	// Widget ID
			esc_html__( 'Random Text Box', 'Text Domain'), // Name
			array ( 'Description' => esc_html__ ( 'RTB widget', 'Text Domain' ) , ) // ARGS
		);
	}

	// ASIGN THE TABLE OUTSIDE THE MAIN METHOD
	private function table() {
		$this->rtb_table = $this->wpdb->prefix . 'rtb';
		return;
	}

	// CREATED THE BOX
	public function widget($args, $instance) {

		// ASIGN VALUES FROM TABLE
		$this->table();
		$this->rtb_count = $this->wpdb->get_results( "SELECT count(*) as total from $this->rtb_table");
		$this->rtb_id = rand(1, $this->rtb_count[0]->total);
		$this->rtb_box = $this->wpdb->get_results( "SELECT title,author,text FROM $this->rtb_table where id=$this->rtb_id" );

		// PRINT RESULTS IN BOX
		echo "<div id=\"rtb-background\" class=\"widget\">".
			"<div class=\"widget-title\">Microrrelatos</div>".
			"<div class=\"rtb-title\">". esc_html( $this->rtb_box[0]->title ) . "</div>". "<br>".
			"<div class=\"rtb-text\">". esc_html( $this->rtb_box[0]->text ) . "</div>". "<br>".
			"<div class=\"rtb-author\">". esc_html( $this->rtb_box[0]->author ) . "</div>". "<br>".
		"</div>";
		return $args;
	}

	//REGISTER WIDGET
	public function register() {
		register_widget( '\RTB_SPACE\RandomTextBox' );
		return;
	}
}

// CREATE THE OBJECT
if ( class_exists( '\RTB_SPACE\RandomTextBox' ) ) {
	$rtb = new RandomTextBox($rtb_new);
}

// ADD THE WIDGET TO INIT
add_action( 'widgets_init', array( $rtb, 'register' ) );
