<?php
/**
 * URL Generator functionality
 *
 * @package WooCommerce_Shareable_Checkout_Admin
 * @subpackage URL_Generator
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * WSCUG_URL_Generator class
 *
 * Handles generation of shareable checkout URLs from cart data.
 *
 * @since 1.0.0
 */
class WSCUG_URL_Generator {
	
	/**
	 * Generate shareable checkout URL
	 *
	 * @since 1.0.0
	 * @return string|false The generated URL or false on failure
	 */
	public function generate_url() {
		// Get cart data
		$cart_data = $this->get_cart_data();
		
		if ( empty( $cart_data['items'] ) ) {
			return false;
		}
		
		// Build URL parameters
		$params = array();
		
		// Format products
		$products = $this->format_products( $cart_data['items'] );
		if ( ! empty( $products ) ) {
			$params['products'] = $products;
		}
		
		// Format coupons
		$coupons = $this->format_coupons( $cart_data['coupons'] );
		if ( ! empty( $coupons ) ) {
			$params['coupon'] = $coupons;
		}
		
		// Build final URL
		$base_url = home_url( '/checkout-link/' );
		$url = add_query_arg( $params, $base_url );
		
		return esc_url_raw( $url );
	}
	
	/**
	 * Get cart data
	 *
	 * @since 1.0.0
	 * @return array Cart items and coupons
	 */
	private function get_cart_data() {
		$cart = WC()->cart;
		$data = array(
			'items'   => array(),
			'coupons' => array(),
		);
		
		// Get cart items
		foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
			$product = $cart_item['data'];
			$product_id = $cart_item['product_id'];
			$variation_id = $cart_item['variation_id'];
			$quantity = $cart_item['quantity'];
			
			// Skip if product doesn't exist
			if ( ! $product || ! $product->exists() ) {
				continue;
			}
			
			$data['items'][] = array(
				'product_id'   => $product_id,
				'variation_id' => $variation_id,
				'quantity'     => $quantity,
			);
		}
		
		// Get applied coupons
		$data['coupons'] = $cart->get_applied_coupons();
		
		return $data;
	}
	
	/**
	 * Format products for URL
	 *
	 * @since 1.0.0
	 * @param array $items Cart items array
	 * @return string Formatted products string
	 */
	private function format_products( $items ) {
		$products = array();
		
		foreach ( $items as $item ) {
			$id = $item['product_id'];
			
			// Add variation ID if exists
			if ( ! empty( $item['variation_id'] ) ) {
				$id .= '_' . $item['variation_id'];
			}
			
			$products[] = $id . ':' . absint( $item['quantity'] );
		}
		
		return implode( ',', $products );
	}
	
	/**
	 * Format coupons for URL
	 *
	 * @since 1.0.0
	 * @param array $coupons Applied coupon codes
	 * @return string Formatted coupons string
	 */
	private function format_coupons( $coupons ) {
		if ( empty( $coupons ) ) {
			return '';
		}
		
		// Sanitize coupon codes
		$sanitized = array_map( 'sanitize_text_field', $coupons );
		
		return implode( ',', $sanitized );
	}
}