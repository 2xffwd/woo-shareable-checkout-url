<?php
/**
 * Internationalization functionality
 *
 * @package WooCommerce_Shareable_Checkout_Admin
 * @subpackage Internationalization
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * WSCUG_i18n class
 *
 * Handles plugin internationalization and text domain loading.
 *
 * @since 1.0.0
 */
class WSCUG_i18n {
	
	/**
	 * Load the plugin text domain for translation
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'woo-shareable-checkout-admin',
			false,
			dirname( WSCUG_PLUGIN_BASENAME ) . '/languages'
		);
	}
}