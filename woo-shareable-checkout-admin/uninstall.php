<?php
/**
 * Uninstall script
 *
 * Handles plugin uninstallation and cleanup.
 *
 * @package WooCommerce_Shareable_Checkout_Admin
 * @since 1.0.0
 */

// Exit if uninstall not called from WordPress
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Clean up any plugin data if needed
// Note: This plugin doesn't store any data in the database
// All functionality is transient and doesn't require cleanup

// If we had stored options, transients, or other data, we would clean them up here:
// delete_option( 'wscug_option_name' );
// delete_transient( 'wscug_transient_name' );

// Clear any plugin-related cache if necessary
wp_cache_flush();