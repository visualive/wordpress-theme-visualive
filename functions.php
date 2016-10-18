<?php
/**
 * VisuAlive functions and definitions.
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link       https://codex.wordpress.org/Theme_Development
 * @link       https://codex.wordpress.org/Child_Themes
 *             Functions that are not pluggable (not wrapped in function_exists()) are
 *             instead attached to a filter or action hook.
 *             For more information on hooks, actions, and filters,
 * @link       https://codex.wordpress.org/Plugin_API
 * @package    WordPress
 * @subpackage VisuAlive
 * @author     KUCKLU
 * @copyright  Copyright (c) 2016 KUCKLU & VisuAlive
 * @license    GPL-2.0+
 * @since      VisuAlive 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/includes/class-theme-init.php';
require_once dirname( __FILE__ ) . '/includes/class-jetpack-init.php';
require_once dirname( __FILE__ ) . '/includes/class-note-init.php';

$visualive_theme_init   = apply_filters( 'visualive_theme_init', VisuAlive_Theme_Init::get_my_class() );
$visualive_jetpack_init = apply_filters( 'visualive_jetpack_init', VisuAlive_Jetpack_Init::get_my_class() );
$visualive_note_init    = apply_filters( 'visualive_note_init', VisuAlive_Note_Init::get_my_class() );

$visualive_theme_init::init();
$visualive_jetpack_init::init();
$visualive_note_init::init();

/**
 * Jetpack social menu.
 *
 * @since VisuAlive 1.0.0
 */
function visualive_social_menu() {
	if ( function_exists( 'jetpack_social_menu' ) ) {
		jetpack_social_menu();
	}
}
