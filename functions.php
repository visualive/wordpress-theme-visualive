<?php
/**
 * Created by PhpStorm.
 * User: kuck1u
 * Date: 16/10/13
 * Time: 5:10
 */

function test_wp_enqueue_scripts() {
	wp_deregister_script( 'jquery' );
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery-core' );
	wp_dequeue_script( 'jquery-core' );
	wp_deregister_script( 'jquery-migrate' );
	wp_dequeue_script( 'jquery-migrate' );

	wp_register_script( 'jquery-core', get_stylesheet_directory_uri() . '/assets/js/script.min.js', array(), false );
	wp_register_script( 'jquery', false, array( 'jquery-core' ), false );
}
add_action( 'wp_enqueue_scripts', 'test_wp_enqueue_scripts' );
