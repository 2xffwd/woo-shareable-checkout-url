<?php
/**
 * Admin Bar functionality
 *
 * @package WooCommerce_Shareable_Checkout_Admin
 * @subpackage Admin_Bar
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * WSCUG_Admin_Bar class
 *
 * Handles admin bar integration and AJAX functionality.
 *
 * @since 1.0.0
 */
class WSCUG_Admin_Bar {
	
	/**
	 * Initialize the admin bar functionality
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_item' ), 100 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_wscug_generate_url', array( $this, 'ajax_generate_url' ) );
	}
	
	/**
	 * Add admin bar item
	 *
	 * @since 1.0.0
	 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance
	 */
	public function add_admin_bar_item( $wp_admin_bar ) {
		// Check if on cart page and user has permission
		if ( ! is_cart() || ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		
		// Check if cart has items
		if ( WC()->cart->is_empty() ) {
			return;
		}
		
		$args = array(
			'id'    => 'wscug-copy-checkout-link',
			'title' => '<span class="ab-icon dashicons dashicons-admin-links"></span>' . 
			          __( 'Copy Checkout Link', 'woo-shareable-checkout-admin' ),
			'href'  => '#',
			'meta'  => array(
				'class' => 'wscug-copy-checkout-link',
				'title' => __( 'Generate and copy shareable checkout URL', 'woo-shareable-checkout-admin' ),
			),
		);
		
		$wp_admin_bar->add_node( $args );
	}
	
	/**
	 * Enqueue scripts and styles
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		// Only on cart page
		if ( ! is_cart() || ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		
		wp_enqueue_script(
			'wscug-admin-bar',
			WSCUG_PLUGIN_URL . 'assets/js/admin-bar.js',
			array( 'jquery' ),
			WSCUG_VERSION,
			true
		);
		
		wp_localize_script( 'wscug-admin-bar', 'wscug_params', array(
			'ajax_url'    => admin_url( 'admin-ajax.php' ),
			'nonce'       => wp_create_nonce( 'wscug-generate-url' ),
			'i18n'        => array(
				'copied'      => __( 'Checkout link copied!', 'woo-shareable-checkout-admin' ),
				'copy_failed' => __( 'Failed to copy link. Please try again.', 'woo-shareable-checkout-admin' ),
				'empty_cart'  => __( 'Cart is empty. Add products to generate a link.', 'woo-shareable-checkout-admin' ),
				'error'       => __( 'An error occurred. Please try again.', 'woo-shareable-checkout-admin' ),
			),
		) );
		
		wp_enqueue_style(
			'wscug-admin-bar',
			WSCUG_PLUGIN_URL . 'assets/css/admin-bar.css',
			array( 'dashicons' ),
			WSCUG_VERSION
		);
	}
	
	/**
	 * AJAX handler for URL generation
	 *
	 * @since 1.0.0
	 */
	public function ajax_generate_url() {
		// Verify nonce
		if ( ! check_ajax_referer( 'wscug-generate-url', 'nonce', false ) ) {
			wp_send_json_error( __( 'Security check failed.', 'woo-shareable-checkout-admin' ) );
		}
		
		// Check permissions
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( __( 'Insufficient permissions.', 'woo-shareable-checkout-admin' ) );
		}
		
		// Generate URL
		$generator = new WSCUG_URL_Generator();
		$url = $generator->generate_url();
		
		if ( ! $url ) {
			wp_send_json_error( __( 'Failed to generate URL.', 'woo-shareable-checkout-admin' ) );
		}
		
		wp_send_json_success( array( 'url' => $url ) );
	}
}