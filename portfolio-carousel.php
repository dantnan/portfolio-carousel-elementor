<?php
/**
 * Plugin Name: Portfolio Carousel for Elementor
 * Description: A beautiful portfolio carousel widget for Elementor with thumbnails gallery feature.
 * Version:     1.0.0
 * Author:      Antnan Mpekir
 * Author URI:  https://antnan.com
 * Text Domain: portfolio-carousel
 * Domain Path: /languages
 * 
 * Elementor tested up to: 3.14.0
 * Elementor Pro tested up to: 3.14.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Portfolio Carousel Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Portfolio_Carousel {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var Portfolio_Carousel The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return Portfolio_Carousel An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Initialize plugin
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add actions after Elementor is fully initialized
		add_action( 'elementor/init', function() {
			// Load plugin files
			$this->include_files();
			
			// Register widgets
			add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		});
		
		// Register scripts and styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'frontend_scripts' ] );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'portfolio-carousel' ),
			'<strong>' . esc_html__( 'Portfolio Carousel for Elementor', 'portfolio-carousel' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'portfolio-carousel' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'portfolio-carousel' ),
			'<strong>' . esc_html__( 'Portfolio Carousel for Elementor', 'portfolio-carousel' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'portfolio-carousel' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'portfolio-carousel' ),
			'<strong>' . esc_html__( 'Portfolio Carousel for Elementor', 'portfolio-carousel' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'portfolio-carousel' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Include Files
	 *
	 * Load required plugin files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function include_files() {
		// Check if Elementor is fully loaded
		if ( did_action( 'elementor/loaded' ) ) {
			// Include Widget files
			require_once( __DIR__ . '/widgets/portfolio-carousel-widget.php' );
		}
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets( $widgets_manager ) {
		// Make sure the Elementor\Widget_Base class exists before registering widgets
		if ( class_exists( '\Elementor\Widget_Base' ) ) {
			// Register widgets
			$widgets_manager->register( new \Portfolio_Carousel_Widget() );
		}
	}

	/**
	 * Frontend Styles
	 *
	 * Enqueue styles for the frontend.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function frontend_styles() {
		// Register Swiper CSS
		wp_register_style(
			'portfolio-carousel-swiper',
			plugins_url( '/assets/swiper/swiper-bundle.min.css', __FILE__ ),
			[],
			self::VERSION
		);

		// Register plugin CSS
		wp_register_style(
			'portfolio-carousel',
			plugins_url( '/assets/css/portfolio-carousel.css', __FILE__ ),
			['portfolio-carousel-swiper'],
			self::VERSION
		);
	}

	/**
	 * Frontend Scripts
	 *
	 * Enqueue scripts for the frontend.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function frontend_scripts() {
		// Register Swiper JS
		wp_register_script(
			'portfolio-carousel-swiper',
			plugins_url( '/assets/swiper/swiper-bundle.min.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		// Register plugin JS
		wp_register_script(
			'portfolio-carousel',
			plugins_url( '/assets/js/portfolio-carousel.js', __FILE__ ),
			['jquery', 'portfolio-carousel-swiper'],
			self::VERSION,
			true
		);
	}
}

// Initialize Portfolio_Carousel
Portfolio_Carousel::instance();
