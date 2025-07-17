=== WooCommerce Shareable Checkout URL Generator ===
Contributors: 2xffwd
Tags: woocommerce, checkout, admin, tools, cart
Requires at least: 6.8.1
Tested up to: 6.8.1
Requires PHP: 8.1
Stable tag: 1.0.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Enables administrators and shop managers to generate shareable checkout URLs from their test carts.

== Description ==

WooCommerce Shareable Checkout URL Generator is a lightweight plugin that adds a convenient "Copy Checkout Link" button to the WordPress admin bar when viewing the cart page. This tool allows store administrators and managers to quickly generate and share pre-populated checkout links with customers.

= Features =

* One-click generation of shareable checkout URLs
* Support for simple and variable products
* Include multiple products with quantities
* Include applied coupon codes
* Copy to clipboard functionality
* Clean, minimal interface
* Full internationalization support
* HPOS compatible
* Security-first approach with nonce verification
* Permission-based access (administrators and shop managers only)

= Requirements =

* WordPress 6.8.1 or higher
* WooCommerce 10.0.0 or higher
* PHP 8.1 or higher
* Modern browser with JavaScript enabled

= URL Format =

Generated URLs follow the WooCommerce 10.0+ shareable checkout format:
`/checkout-link/?products=ID:QTY,ID:QTY&coupon=CODE1,CODE2`

Examples:
* Simple product: `products=123:2`
* Variable product: `products=123_456:1`
* Multiple products: `products=123:2,456:1`
* With coupons: `products=123:1&coupon=SAVE10,WELCOME`

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/woo-shareable-checkout-admin` directory
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Add products to your cart and visit the cart page
4. Click "Copy Checkout Link" in the admin bar
5. Share the generated link with customers

== Frequently Asked Questions ==

= Who can use this feature? =

Only administrators and shop managers can see and use the "Copy Checkout Link" button. The plugin checks for the `manage_woocommerce` capability.

= Does it work with variable products? =

Yes, the plugin fully supports both simple and variable products. Variable products are formatted as `product_id_variation_id`.

= Can I include multiple coupons? =

Yes, all applied coupons in your cart will be included in the generated URL.

= Does it work with HPOS? =

Yes, the plugin is fully compatible with WooCommerce's High-Performance Order Storage (HPOS).

= What browsers are supported? =

The plugin uses modern clipboard API with fallback support for older browsers. It works with all browsers that support JavaScript.

= Is it secure? =

Yes, the plugin implements WordPress security best practices including nonce verification, capability checks, data sanitization, and XSS prevention.

== Screenshots ==

1. Admin bar button on cart page
2. Success message after copying link
3. Generated checkout URL example

== Changelog ==

= 1.0.0 =
* Initial release
* Admin bar integration with cart page detection
* URL generation for simple and variable products
* Coupon code support
* Copy to clipboard functionality with fallback
* Security implementation with nonce verification
* Internationalization support
* HPOS compatibility

== Upgrade Notice ==

= 1.0.0 =
Initial release of the WooCommerce Shareable Checkout URL Generator plugin.

== Developer Notes ==

= Hooks and Filters =

The plugin currently doesn't expose hooks or filters but may add them in future versions for customization.

= Contributing =

Contributions are welcome! Please submit issues and pull requests on the plugin's GitHub repository.

= Support =

For support, please use the WordPress.org support forums or submit an issue on GitHub.