<?php
/**
 * Note Compatibility File.
 *
 * @link       https://conductorplugin.com/downloads/note/
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
 * Class VisuAlive_Note_Init
 */
class VisuAlive_Note_Init {
	/**
	 * Get instance.
	 *
	 * @return VisuAlive_Note_Init
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
		add_filter( 'note_template_path', array( &$this, 'theme_template_path' ) );
		add_filter( 'note_widget_template_types', array( &$this, 'note_widget_template_types' ) );
		add_filter( 'note_tinymce_editor_types', array( $this, 'note_tinymce_editor_types' ) );
		add_filter( 'note_tinymce_editor_settings', array( $this, 'note_tinymce_editor_settings' ), 10, 2 );
		add_filter( 'note_widget_templates', array( $this, 'note_widget_templates' ) );
		add_filter( 'note_widget_css_classes', array( $this, 'note_widget_css_classes' ), 10, 3 );
		add_action( 'note_widget_title_before', array( $this, 'note_widget_title_before' ), 10, 3 );
		add_action( 'note_widget_template_before', array( $this, 'note_widget_template_before' ), 10, 7 );
		add_action( 'note_widget_template_after', array( $this, 'note_widget_template_after' ), 10, 7 );
	}

	/**
	 * This function returns the template path for which themes should place their
	 * templates into to override Note default templates (i.e. your-theme/note/).
	 *
	 * @return string Directory for Note theme templates.
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function theme_template_path() {
		return untrailingslashit( apply_filters( 'visualive_note_template_path', 'components/note' ) );
	}

	/**
	 * Set up the widget template types.
	 *
	 * @param array $types Widget template types.
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function note_widget_template_types( $types ) {
		if ( ! isset( $types['visualive-hero'] ) ) {
			$types['visualive-hero'] = __( 'VisuAlive Hero', 'visualive' );
		}

		if ( ! isset( $types['visualive-features'] ) ) {
			$types['visualive-features'] = __( 'VisuAlive Features', 'visualive' );
		}

		return $types;
	}

	/**
	 * This function adds Baton Note Widget editor types to Note.
	 *
	 * @param array $types Widget template types.
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function note_tinymce_editor_types( $types ) {
		if ( ! in_array( 'visualive-hero', $types ) ) {
			$types[] = 'visualive-hero';
		}

		return $types;
	}

	/**
	 * This function adjusts Note Widget TinyMCE editor settings based on editor type.
	 *
	 * @param array  $settings    Settings.
	 * @param string $editor_type Editor type.
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function note_tinymce_editor_settings( $settings, $editor_type ) {
		switch ( $editor_type ) :
			case 'visualive-hero':
				$settings['plugins'] = explode( ' ', $settings['plugins'] );
				$note_image          = array_search( 'note_image', $settings['plugins'] );

				if ( false !== $note_image ) {
					unset( $settings['plugins'][ $note_image ] );

					$settings['plugins'] = array_values( $settings['plugins'] );
				}

				$settings['plugins'] = implode( ' ', $settings['plugins'] );
				$wp_image            = array_search( 'wp_image', $settings['blocks'] );

				if ( false !== $wp_image ) {
					unset( $settings['blocks'][ $wp_image ] );

					$settings['blocks'] = array_values( $settings['blocks'] );
				}
				break;
			default:
				$settings['style_formats'][] = array(
					'title'      => __( 'Button', 'visualive' ),
					'selector'   => 'a',
					'attributes' => array(
						'class' => 'button',
					),
				);
				$settings['style_formats'][] = array(
					'title'      => __( 'Button Alternate', 'visualive' ),
					'selector'   => 'a',
					'attributes' => array(
						'class' => 'button-alt',
					),
				);
				break;
		endswitch;

		return $settings;
	}

	/**
	 * This function adds Hero and Features templates to Note Widgets.
	 *
	 * @param array $templates Widget templates.
	 *
	 * @return array
	 * @access public
	 * @see    Note for configuration details
	 * @since  VisuAlive 1.0.0
	 */
	public function note_widget_templates( $templates ) {
		if ( ! isset( $templates['visualive-hero-1'] ) ) {
			$templates['visualive-hero-1'] = array(
				'label'       => __( 'Hero image 1', 'visualive' ),
				'placeholder' => sprintf( '<h2>%1$s</h2>
                        <p data-note-placeholder="false"><strong data-note-placeholder="false"><span style="font-size: 24px;">%2$s</span></strong></p>
                        <p data-note-placeholder="false"><br data-note-placeholder="false" /></p>
                        <p data-note-placeholder="false"><a href="#" class="button" data-note-placeholder="false">%3$s</a></p>',
					__( 'Hero 1', 'visualive' ),
					__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' ),
					__( 'Button', 'visualive' )
				),
				'type'        => 'visualive-hero',
				'template'    => 'visualive-hero',
				'config'      => array(
					'customize' => array(
						'note_background' => true,
					),
					'type'      => 'visualive-hero',
					'plugins'   => array(
						'note_background',
					),
					'blocks'    => array(
						'note_background',
					),
				),
			);
		}

		if ( ! isset( $templates['visualive-hero-2'] ) ) {
			$templates['visualive-hero-2'] = array(
				'label'       => __( 'Hero image 2', 'visualive' ),
				'placeholder' => sprintf( '<h2 style="text-align: center;">%1$s</h2>
                        <p style="text-align: center;">%2$s</p>
                        <p style="text-align: center;" data-note-placeholder="false"><a href="#" class="button" data-note-placeholder="false">%3$s</a></p>',
					__( 'Hero 2', 'visualive' ),
					__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' ),
					__( 'Button', 'visualive' )
				),
				'type'        => 'visualive-hero',
				'template'    => 'visualive-hero',
				'config'      => array(
					'customize' => array(
						'note_background' => true,
					),
					'type'      => 'visualive-hero',
					'plugins'   => array(
						'note_background',
					),
					'blocks'    => array(
						'note_background',
					),
				),
			);
		}

		if ( ! isset( $templates['visualive-features-1'] ) ) {
			$tmp_features                      = <<<EOM
<h6 style="text-align: center;">%1\$s</h6>
<p style="text-align: center;" data-note-placeholder="false">
	<span style="font-size: 16px;">%2\$s</span>
</p>
<p style="text-align: center;" data-note-placeholder="false">
	<strong data-note-placeholder="false"><span style="font-size: 16px;">%3\$s</span></strong>
</p>
EOM;
			$templates['visualive-features-1'] = array(
				'label'       => __( 'Features 1', 'visualive' ),
				'placeholder' => sprintf(
					'<h2 style="text-align: center;">%1$s</h2><p style="text-align: center;">%2$s</p>',
					__( 'Features', 'visualive' ),
					__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' )
				),
				'type'        => 'visualive-features',
				'template'    => 'visualive-features',
				'config'      => array(
					'customize'   => array(
						'columns' => true,
						'rows'    => true,
					),
					'placeholder' => sprintf(
						$tmp_features,
						__( 'Feature', 'visualive' ),
						__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' ),
						__( 'Read More', 'visualive' )
					),
					'columns'     => array(
						1 => array(
							'placeholder' => sprintf(
								$tmp_features,
								__( 'Feature', 'visualive' ),
								__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' ),
								__( 'Read More', 'visualive' )
							),
						),
						2 => array(
							'placeholder' => sprintf(
								$tmp_features,
								__( 'Feature', 'visualive' ),
								__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' ),
								__( 'Read More', 'visualive' )
							),
						),
						3 => array(
							'placeholder' => sprintf(
								$tmp_features,
								__( 'Feature', 'visualive' ),
								__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' ),
								__( 'Read More', 'visualive' )
							),
						),
						4 => array(
							'placeholder' => sprintf(
								$tmp_features,
								__( 'Feature', 'visualive' ),
								__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros tortor, molestie eget tortor sit amet, feugiat semper ante. Aliquam a pellentesque purus, quis vulputate lacus.', 'visualive' ),
								__( 'Read More', 'visualive' )
							),
						),
					),
				),
			);
		}

		return $templates;
	}

	/**
	 * This function adjusts Note Widget CSS classes based on the widget instance settings.
	 *
	 * @param array  $classes  CSS class names.
	 * @param array  $instance .
	 * @param object $widget   .
	 *
	 * @return array
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function note_widget_css_classes( $classes, $instance, $widget ) {
		if (
			property_exists( $widget, 'templates' )
			&& isset( $instance['template'] )
			&& ! empty( $instance['template'] )
			&& array_key_exists( $instance['template'], $widget->templates )
		) {
			$template = $widget->templates[ $instance['template'] ];

			if (
				( isset( $template['type'] ) && 'visualive-hero' === $template['type'] )
				&& (
					isset( $instance['extras'] )
					&& ( ! isset( $instance['extras']['background_image_attachment_id'] ) || ! $instance['extras']['background_image_attachment_id'] )
				)
			) {
				$classes[] = 'has-default-visualive-hero-image';
			}
		}

		return $classes;
	}

	/**
	 * This function outputs an opening "in" wrapper element before the widget title on Note Widgets that
	 * have a Hero display selected and are set to display the widget title.
	 *
	 * @param array  $instance .
	 * @param array  $args     .
	 * @param object $widget   .
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function note_widget_title_before( $instance, $args, $widget ) {
		$output = null;

		if (
			isset( $instance['hide_title'] )
			&& ! $instance['hide_title']
			&& isset( $instance['template'] )
			&& array_key_exists( $instance['template'], $widget->templates )
		) {
			$template = $widget->templates[ $instance['template'] ];

			if ( isset( $template['type'] ) && 'visualive-hero' === $template['type'] ) {
				$output = '<div class="in note-widget-in note-hero-widget-in note-visualive-hero-in note-visualive-hero-widget-in cf">';
			}
		}

		if ( isset( $output ) ) {
			echo wp_kses_post( $output );
		}
	}

	/**
	 * This function outputs an opening "in" wrapper element before the widget template content
	 * on Note Widgets that have a Hero display selected and are not set to display the widget title.
	 *
	 * @param string $template_name .
	 * @param string $template      .
	 * @param array  $data          .
	 * @param int    $number        Reference to the row/column/content area number that is being displayed.
	 * @param array  $instance      Reference to the widget instance (settings).
	 * @param array  $args          Reference to the widget args.
	 * @param object $widget        Note_Widget.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function note_widget_template_before( $template_name, $template, $data, $number, $instance, $args, $widget ) {
		$output = null;

		if (
			isset( $instance['hide_title'] )
			&& $instance['hide_title']
			&& isset( $instance['template'] )
			&& array_key_exists( $instance['template'], $widget->templates )
		) {
			$widget_template = $widget->templates[ $instance['template'] ];

			if ( isset( $widget_template['type'] ) && 'visualive-hero' === $widget_template['type'] ) {
				$output = '<div class="in note-widget-in note-hero-widget-in note-visualive-hero-in note-visualive-hero-widget-in cf">';
			}
		}

		if ( isset( $output ) ) {
			echo wp_kses_post( $output );
		}
	}

	/**
	 * This function outputs a closing "in" wrapper element after the widget template content
	 * on Note Widgets that have a Hero display selected.
	 *
	 * @param string $template_name .
	 * @param string $template      .
	 * @param array  $data          .
	 * @param int    $number        Reference to the row/column/content area number that is being displayed.
	 * @param array  $instance      Reference to the widget instance (settings).
	 * @param array  $args          Reference to the widget args.
	 * @param object $widget        Note_Widget.
	 *
	 * @access public
	 * @since  VisuAlive 1.0.0
	 */
	public function note_widget_template_after( $template_name, $template, $data, $number, $instance, $args, $widget ) {
		$output = null;

	    if ( isset( $instance['template'] ) && array_key_exists( $instance['template'], $widget->templates ) ) {
		    $widget_template = $widget->templates[ $instance['template'] ];

		    if ( isset( $widget_template['type'] ) && 'visualive-hero' === $widget_template['type'] ) {
			    $output = '</div>';
		    }
	    }

		if ( isset( $output ) ) {
			echo wp_kses_post( $output );
		}
	}
}
