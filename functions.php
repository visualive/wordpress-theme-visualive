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

	wp_register_style( 'visualive', get_stylesheet_directory_uri() . '/assets/css/style.min.css' );
	wp_enqueue_style( 'visualive' );

	wp_register_script( 'jquery-core', get_stylesheet_directory_uri() . '/assets/js/script.min.js', array(), false, true );
	wp_register_script( 'jquery', false, array( 'jquery-core' ), false, true );
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'test_wp_enqueue_scripts' );



add_filter( 'va_social_buzz_include_style', '__return_false' );
add_filter( 'va_social_buzz_include_script', '__return_false' );

add_action( 'va_social_buzz_enqueue_scripts', function ( $css, $l10n, $object_name ) {
	wp_add_inline_style( 'twentysixteen-style', $css );
	wp_localize_script( 'twentysixteen-script', $object_name, $l10n );
}, 10, 3 );

