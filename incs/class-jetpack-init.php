<?php
/**
 * Jetpack Compatibility File.
 *
 * @link       https://jetpack.me
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

/**
 * Class VisuAlive_Jetpack_Init
 */
class VisuAlive_Jetpack_Init {
	/**
	 * Get instance.
	 *
	 * @return VisuAlive_Jetpack
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
	 * @since  VisuAlive 1.0.0
	 */
	private function __construct() {
		add_action( 'after_setup_theme', array( &$this, 'after_setup_theme' ) );
		add_action( 'init', array( &$this, 'nova_restaurant_init' ) );
		add_filter( 'register_post_type_args', array( &$this, 'register_post_type_args' ), 10, 2 );
		add_filter( 'admin_enqueue_scripts', array( &$this, 'change_nova_dashboard_icon' ) );
		add_filter( 'dashboard_glance_items', array( &$this, 'dashboard_glance_items' ) );
	}

	/**
	 * Sets up theme defaults and registers support for various Jetpack features.
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function after_setup_theme() {
		/**
		 * Add theme support for Infinite Scroll.
		 */
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => array( &$this, '_cb_infinite_scroll_render' ),
			'footer'    => 'page',
		) );

		/**
		 * Add theme support for Responsive Videos.
		 */
		add_theme_support( 'jetpack-responsive-videos' );

		/**
		 * Add theme support for Social Menus
		 */
		add_theme_support( 'jetpack-social-menu' );

		/**
		 * Add support for Testimonials CPT
		 */
		add_theme_support( 'jetpack-testimonial' );

		/**
		 * Add support for Portfolio CPT
		 */
		add_theme_support( 'jetpack-portfolio' );

		/**
		 * Add support for the Nova CPT (menu items)
		 */
		add_theme_support( 'nova_menu_item' );
	}

	/**
	 * Register post type args.
	 *
	 * @param array  $args      Array of arguments for registering a post type.
	 * @param string $post_type Post type key.
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function register_post_type_args( $args, $post_type ) {
		if ( 'nova_menu_item' === $post_type ) {
			$args['labels']['menu_name'] = __( 'Service menu', 'visualive' );
			$args['description']         = __( 'Items on your service menu', 'visualive' );
			$args['menu_icon']           = 'dashicons-media-document';
			$args['public']              = false;
			$args['show_ui']             = true;
		}

		return $args;
	}

	/**
	 * Remove nova style.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function nova_restaurant_init() {
		remove_action( 'admin_head', array( Nova_Restaurant::init(), 'set_custom_font_icon' ) );
		remove_filter( 'dashboard_glance_items', array( Nova_Restaurant::init(), 'add_to_dashboard' ) );
	}

	/**
	 * Change nova dashboard icon.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function change_nova_dashboard_icon() {
		$menu_icon = <<<EOM
#dashboard_right_now .service-menu-count a:before,
#dashboard_right_now .service-menu-count span:before {
    content: '\\f497';
}
EOM;

		wp_add_inline_style( 'wp-admin', $menu_icon );
	}

	/**
	 * Add to Dashboard At A Glance.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function dashboard_glance_items() {
		$menu_item_post_type = 'nova_menu_item';
		$number_menu_items   = wp_count_posts( $menu_item_post_type );

		if ( current_user_can( 'administrator' ) ) {
			$number_menu_items_published = sprintf( '<a href="%1$s">%2$s</a>',
				esc_url( get_admin_url( get_current_blog_id(), 'edit.php?post_type=' . $menu_item_post_type ) ),
				sprintf( _n( '%1$d Service Menu Item', '%1$d Service Menu Items', intval( $number_menu_items->publish ), 'visualive' ), number_format_i18n( $number_menu_items->publish ) )
			);
		} else {
			$number_menu_items_published = sprintf( '<span>%1$s</span>',
				sprintf( _n( '%1$d Service Menu Item', '%1$d Service Menu Items', intval( $number_menu_items->publish ), 'visualive' ), number_format_i18n( $number_menu_items->publish ) )
			);
		}

		echo '<li class="service-menu-count">' . $number_menu_items_published . '</li>';
	}

	/**
	 * Custom render function for Infinite Scroll.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function _cb_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) {
				get_template_part( 'components/post/content', 'search' );
			} else {
				get_template_part( 'components/post/content', get_post_format() );
			}
		}
	}
}
