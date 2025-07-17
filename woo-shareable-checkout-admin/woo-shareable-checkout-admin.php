<?php
/**
 * Plugin Name: WooCommerce Shareable Checkout URL Generator
 * Plugin URI: https://github.com/2xffwd/woo-shareable-checkout-url/
 * Description: Enables administrators and shop managers to generate shareable checkout URLs from their test carts.
 * Version: 1.0.0
 * Requires at least: 6.8.1
 * Requires PHP: 8.1
 * Author: 2xffwd
 * Author URI: https://github.com/2xffwd/woo-shareable-checkout-url/
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: woo-shareable-checkout-admin
 * Domain Path: /languages
 * WC requires at least: 10.0.0
 * WC tested up to: 10.0.2
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Define plugin constants
define( 'WSCUG_VERSION', '1.0.0' );
define( 'WSCUG_PLUGIN_FILE', __FILE__ );
define( 'WSCUG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WSCUG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WSCUG_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Declare compatibility with WooCommerce High-Performance Order Storage (HPOS)
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * Plugin activation hook
 */
function wscug_activate() {
	// Check WooCommerce is active
	if ( ! class_exists( 'WooCommerce' ) ) {
		deactivate_plugins( WSCUG_PLUGIN_BASENAME );
		wp_die( __( 'WooCommerce Shareable Checkout URL Generator requires WooCommerce to be installed and active.', 'woo-shareable-checkout-admin' ) );
	}
	
	// Check WooCommerce version
	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '10.0.0', '<' ) ) {
		deactivate_plugins( WSCUG_PLUGIN_BASENAME );
		wp_die( __( 'WooCommerce Shareable Checkout URL Generator requires WooCommerce 10.0.0 or higher.', 'woo-shareable-checkout-admin' ) );
	}
}
register_activation_hook( __FILE__, 'wscug_activate' );

/**
 * Plugin deactivation hook
 */
function wscug_deactivate() {
	// Clean up any transients or scheduled tasks if needed
}
register_deactivation_hook( __FILE__, 'wscug_deactivate' );

if ( ! class_exists( 'WSCUG_Main' ) ) :
	/**
	 * Main plugin class
	 */
	class WSCUG_Main {
		
		/**
		 * The single instance of the class
		 *
		 * @var WSCUG_Main
		 */
		protected static $_instance = null;
		
		/**
		 * Main Instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		/**
		 * Constructor
		 */
		protected function __construct() {
			$this->includes();
			$this->init_hooks();
		}
		
		/**
		 * Include required files
		 */
		private function includes() {
			require_once WSCUG_PLUGIN_DIR . 'includes/class-wscug-i18n.php';
			require_once WSCUG_PLUGIN_DIR . 'includes/class-wscug-admin-bar.php';
			require_once WSCUG_PLUGIN_DIR . 'includes/class-wscug-url-generator.php';
		}
		
		/**
		 * Initialize hooks
		 */
		private function init_hooks() {
			// Initialize internationalization
			$i18n = new WSCUG_i18n();
			add_action( 'plugins_loaded', array( $i18n, 'load_plugin_textdomain' ) );
			
			// Initialize admin bar
			$admin_bar = new WSCUG_Admin_Bar();
			$admin_bar->init();
		}
		
		/**
		 * Cloning is forbidden
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'woo-shareable-checkout-admin' ), '1.0.0' );
		}
		
		/**
		 * Unserializing instances is forbidden
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances is forbidden.', 'woo-shareable-checkout-admin' ), '1.0.0' );
		}
	}
endif;

/**
 * Initialize the plugin
 */
function wscug_initialize() {
	// Check if WooCommerce is active
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'wscug_woocommerce_missing_notice' );
		return;
	}
	
	$GLOBALS['wscug'] = WSCUG_Main::instance();
}
add_action( 'plugins_loaded', 'wscug_initialize', 11 );

/**
 * WooCommerce missing notice
 */
function wscug_woocommerce_missing_notice() {
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'WooCommerce Shareable Checkout URL Generator requires WooCommerce to be installed and active.', 'woo-shareable-checkout-admin' ); ?></p>
	</div>
	<?php
}
