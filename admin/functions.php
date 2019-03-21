<?php
/*
 * The Admin panel box
*/

namespace RTB_SPACE;
defined('ABSPATH') or die("Not today");

	function add_widget() {
		wp_add_dashboard_widget('id_rtb_widget', 'Random Text Box', '\RTB_SPACE\admin_widget');
	}

	function admin_widget() {
		global $wpdb;
		if ( isset( $_POST['rtb_submit'] ) ){
			$table = $wpdb->prefix . 'rtb';
			$wpdb->insert($table,
			array(
		    'title' => filter_var($_POST['title'], FILTER_SANITIZE_STRING),
				'author' => filter_var($_POST['author'], FILTER_SANITIZE_STRING),
				'text' => filter_var($_POST['text'], FILTER_SANITIZE_STRING)
			),
			array('%s', '%s', '%s')
 			);
	 	}
?>
		<form action="" id="rtb_form" method="post">
			<meta charset="UTF-8" />
			<h3 style="text-align:center"><strong>NUEVO MICRORRELATO</strong></h3>
			<label>titulo: <input type="text" name='title'></label>
			<br>
			<label>Autor: <input type="text" name='author'></label>
			<br>
			<label>relato: <textarea type="textarea" name='text' cols="40" rows="5"></textarea></label>
			<input type="submit" name="rtb_submit" value="enviar">
		</form>
<?php
}

add_action( 'wp_dashboard_setup', '\RTB_SPACE\add_widget');
