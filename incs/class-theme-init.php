<?php
/**
 * VisuAlive functions and definitions
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
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

/**
 * Class VisuAlive_Theme_Init
 */
class VisuAlive_Theme_Init {
	/**
	 * Get instance.
	 *
	 * @return VisuAlive_Theme_Init
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self;
		}

		return $instance;
	}

	/**
	 * Get my class.
	 *
	 * @return string
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public static function get_my_class() {
		return get_called_class();
	}

	/**
	 * Start things up
	 *
	 * @access private
	 * @since  VisuAlive1.0.0
	 */
	private function __construct() {
		$GLOBALS['content_width'] = apply_filters( 'visualive_content_width', 840 );

		add_action( 'after_setup_theme', array( &$this, 'after_setup_theme' ) );
		add_action( 'widgets_init', array( &$this, 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ) );
		add_action( 'body_class', array( &$this, 'body_class' ) );
		add_action( 'post_class', array( &$this, 'post_class' ) );
		add_action( 'comment_class', array( &$this, 'comment_class' ) );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function after_setup_theme() {
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /langs/ directory.
		 * If you're building a theme based on Twenty Sixteen, use a find and replace
		 * to change 'visualive' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'visualive', get_template_directory() . '/langs' );

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', apply_filters( 'visualive_custom_logo', array(
			'height'      => 240,
			'width'       => 240,
			'flex-height' => true,
		) ) );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( apply_filters( 'visualive_set_post_thumbnail_size', '1200, 9999' ) );

		/**
		 * Indicate widget sidebars can use selective refresh in the Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'assets/css/style-editor.css' ) );
	}

	/**
	 * Registers a widget area.
	 *
	 * @link   https://developer.wordpress.org/reference/functions/register_sidebar/
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'visualive' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'visualive' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => __( 'Front page', 'visualive' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Add widgets here to appear in your front page.', 'visualive' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => __( 'Content bottom on posts', 'visualive' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Appears at the bottom of the content on posts.', 'visualive' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => __( 'Content Bottom on pages', 'visualive' ),
			'id'            => 'sidebar-4',
			'description'   => __( 'Appears at the bottom of the content on pages.', 'visualive' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

	/**
	 * Enqueues scripts and styles.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function wp_enqueue_scripts() {
		wp_deregister_script( 'jquery' );
		wp_dequeue_script( 'jquery' );
		wp_deregister_script( 'jquery-core' );
		wp_dequeue_script( 'jquery-core' );
		wp_deregister_script( 'jquery-migrate' );
		wp_dequeue_script( 'jquery-migrate' );

		/**
		 * Theme styles.
		 */
		wp_enqueue_style( 'visualive', get_stylesheet_directory_uri() . '/assets/css/style.min.css' );

		/**
		 * Theme scripts.
		 */
		wp_register_script( 'jquery-core', get_stylesheet_directory_uri() . '/assets/js/script.min.js', array(), false, true );
		wp_register_script( 'jquery', false, array( 'jquery-core' ), false, true );
		wp_enqueue_script( 'jquery' );

		/**
		 * Plugin - VA Social Buzz.
		 */
		add_filter( 'va_social_buzz_include_style', '__return_false' );
		add_filter( 'va_social_buzz_include_script', '__return_false' );
		add_action( 'va_social_buzz_enqueue_scripts', function ( $css, $l10n, $object_name ) {
			wp_add_inline_style( 'visualive', $css );
			wp_localize_script( 'jquery', $object_name, $l10n );
		}, 10, 3 );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function body_class( $classes ) {
		$classes = preg_grep( '/\Aauthor\-.+\z/i', $classes, PREG_GREP_INVERT );

		// Adds a class of custom-background-image to sites with a custom background image.
		if ( get_background_image() ) {
			$classes[] = 'custom-background-image';
		}

		// Adds a class of group-blog to sites with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of no-sidebar to sites without active sidebar.
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'no-sidebar';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}

	/**
	 * Adds custom classes to the array of post classes.
	 *
	 * @param array $classes Classes for the post element.
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function post_class( $classes ) {
		return preg_grep( '/\Ahentry\z/i', $classes, PREG_GREP_INVERT );
	}

	/**
	 * Adds custom classes to the array of comment classes.
	 *
	 * @param array $classes Classes for the comment element.
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function comment_class( $classes ) {
		return preg_grep( '/\Acomment\-author\-.+\z/i', $classes, PREG_GREP_INVERT );
	}
}
