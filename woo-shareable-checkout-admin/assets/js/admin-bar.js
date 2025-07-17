/**
 * WooCommerce Shareable Checkout URL Generator - Admin Bar JS
 *
 * @package WooCommerce_Shareable_Checkout_Admin
 * @since 1.0.0
 */

(function($) {
	'use strict';
	
	// Wait for DOM ready
	$(document).ready(function() {
		
		// Handle copy button click
		$('#wp-admin-bar-wscug-copy-checkout-link').on('click', 'a', function(e) {
			e.preventDefault();
			
			var $button = $(this);
			
			// Disable button
			$button.addClass('wscug-loading');
			
			// Make AJAX request
			$.ajax({
				url: wscug_params.ajax_url,
				type: 'POST',
				data: {
					action: 'wscug_generate_url',
					nonce: wscug_params.nonce
				},
				success: function(response) {
					if (response.success && response.data.url) {
						// Copy to clipboard
						copyToClipboard(response.data.url)
							.then(function() {
								showMessage(wscug_params.i18n.copied, 'success');
							})
							.catch(function() {
								// Fallback method
								fallbackCopyToClipboard(response.data.url);
							});
					} else {
						showMessage(response.data || wscug_params.i18n.error, 'error');
					}
				},
				error: function() {
					showMessage(wscug_params.i18n.error, 'error');
				},
				complete: function() {
					// Re-enable button
					$button.removeClass('wscug-loading');
				}
			});
		});
		
		/**
		 * Copy text to clipboard using modern API
		 *
		 * @since 1.0.0
		 * @param {string} text Text to copy
		 * @return {Promise} Promise that resolves on success
		 */
		function copyToClipboard(text) {
			if (!navigator.clipboard) {
				return Promise.reject('Clipboard API not available');
			}
			
			return navigator.clipboard.writeText(text);
		}
		
		/**
		 * Fallback copy method for older browsers
		 *
		 * @since 1.0.0
		 * @param {string} text Text to copy
		 */
		function fallbackCopyToClipboard(text) {
			var $temp = $('<textarea>');
			$('body').append($temp);
			$temp.val(text).select();
			
			try {
				// Note: execCommand is deprecated but used as fallback for older browsers
				var success = document.execCommand('copy');
				if (success) {
					showMessage(wscug_params.i18n.copied, 'success');
				} else {
					showMessage(wscug_params.i18n.copy_failed, 'error');
				}
			} catch (err) {
				showMessage(wscug_params.i18n.copy_failed, 'error');
			}
			
			$temp.remove();
		}
		
		/**
		 * Show feedback message
		 *
		 * @since 1.0.0
		 * @param {string} message Message text
		 * @param {string} type Message type (success/error)
		 */
		function showMessage(message, type) {
			// Remove existing messages
			$('.wscug-message').remove();
			
			var $message = $('<div class="wscug-message wscug-message-' + type + '">' + message + '</div>');
			$('body').append($message);
			
			// Position near admin bar button
			var $button = $('#wp-admin-bar-wscug-copy-checkout-link');
			var offset = $button.offset();
			
			$message.css({
				top: offset.top + $button.height() + 10,
				left: offset.left
			});
			
			// Fade in
			$message.fadeIn(200);
			
			// Auto-hide after 2 seconds
			setTimeout(function() {
				$message.fadeOut(200, function() {
					$(this).remove();
				});
			}, 2000);
		}
		
	});
	
})(jQuery);