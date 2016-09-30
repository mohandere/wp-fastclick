<?php
/**
 * Plugin Name: Wp FastClick
 * Plugin URI: https://github.com/mohandere/wp-fastclick
 * Description: Wp FastClick plugin remove click delays on browsers with touch UIs.
 * Version: 1.0.0
 * Author: Mohan Dere
 * Author URI: https://geekymohan.wordpress.com/
 * Requires at least: 4.0.0
 * Tested up to: 4.0.0
 *
 * @package wp-fastclick
 * @category Core
 * @author Mohan Dere
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of WP_FastClick to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object WP_FastClick
 */
function WP_FastClick() {
	return WP_FastClick::instance();
} // End WP_FastClick()

add_action( 'plugins_loaded', 'WP_FastClick' );

/**
 * Main WP_FastClick Class
 *
 * @class WP_FastClick
 * @version	1.0.0
 * @since 1.0.0
 * @package	WP_FastClick
 * @author Mohan Dere
 */
final class WP_FastClick {
	/**
	 * WP_FastClick The single instance.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * The plugin directory URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_url;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 */
	public function __construct () {
		$this->token 			= 'wp-fastclick';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		register_activation_hook( __FILE__, array( $this, 'install' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	} // End __construct()

	/**
	 * Main WP_FastClick Instance
	 *
	 * Ensures only one instance of WP_FastClick is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WP_FastClick()
	 * @return Main WP_FastClick instance
	 */
	public static function instance () {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()


	/**
	 * Cloning is forbidden.
	 * @access public
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 * @access public
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __wakeup()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	} // End _log_version_number()

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	 public function enqueue_scripts() {
		 wp_enqueue_script( $this->token, plugin_dir_url( __FILE__ ) . 'assets/js/dest/wp-fastclick.min.js', array( 'jquery' ), $this->version, false );
	 }

} // End Class
