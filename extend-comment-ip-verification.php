<?php
/*
Plugin Name: Extended comments - User IP verification
Version: 1.0
Description: The plugin checks the user's IP address using a hidden field in the comments.
Author: Anton Volkov
*/


function add_js_script() {
	$url_to_script = plugin_dir_url(__FILE__) . 'assets/js/main.js';
	wp_enqueue_script(
		'main',
		$url_to_script,
		array(),
		'1.0.0',
		array(
			'strategy'  => 'defer',
		)
	);
}


add_action( 'wp_enqueue_scripts', 'add_js_script' );
add_action( 'comment_form_logged_in_after', 'extend_comment_custom_fields' );
add_action( 'comment_form_after_fields', 'extend_comment_custom_fields' );

function extend_comment_custom_fields() {
	echo "<input id='client-ip' name='client-ip' type='hidden' value='0.0.0.0' />";
}

add_filter( 'preprocess_comment', 'verify_extend_comment_meta_data' );

function verify_extend_comment_meta_data( $commentdata ) {
	
	if (isset ($_POST['client-ip'])) {
		if ( $_POST['client-ip'] !=  get_ip_user() ) {
			wp_die( __( 'Error: You are not allowed to leave comments.' ) );
		}
	}
		
	return $commentdata;
}

function get_ip_user() {
	return $_SERVER['REMOTE_ADDR'];
}
