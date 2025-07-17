# WooCommerce Shareable Checkout URL Generator

A lightweight WordPress plugin that enables administrators and shop managers to generate shareable checkout URLs from their test carts using WooCommerce 10.0+'s native shareable checkout feature.

## 🚀 Features

- **One-click URL generation** from cart page admin bar
- **Copy to clipboard** with modern browser support and fallback
- **Multi-language support** (English, Spanish, French, German, Italian)
- **HPOS compatible** with WooCommerce High-Performance Order Storage
- **Security-first** approach with nonce verification and capability checks
- **WordPress standards** compliant code

## 📋 Requirements

- WordPress 6.8.1 or higher
- WooCommerce 10.0.0 or higher  
- PHP 8.1 or higher
- Modern browser with JavaScript enabled

## 🔧 Installation

### From GitHub Release

1. Download the latest `woo-shareable-checkout-admin.zip` from [Releases](../../releases)
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Choose the zip file and click "Install Now"
4. Activate the plugin

### Manual Installation

1. Clone this repository
2. Copy the `woo-shareable-checkout-admin` folder to `/wp-content/plugins/`
3. Activate through the WordPress admin

## 🎯 Usage

1. **Add products to your cart** and visit the cart page
2. **Login as Administrator or Shop Manager** 
3. **Look for "Copy Checkout Link"** button in the WordPress admin bar
4. **Click to generate and copy** the shareable checkout URL
5. **Share the URL** with customers for direct checkout

### Generated URL Format

URLs follow WooCommerce 10.0+ format:
```
/checkout-link/?products=ID:QTY,ID:QTY&coupon=CODE1,CODE2
```

**Examples:**
- Simple product: `products=123:2`
- Variable product: `products=123_456:1` 
- Multiple products: `products=123:2,456:1`
- With coupons: `products=123:1&coupon=SAVE10,WELCOME`

## 🌍 Supported Languages

- **English** (default)
- **Spanish** (Neutral - works globally)
- **French** 
- **German**
- **Italian**

## 🔒 Security Features

- ✅ Nonce verification for all AJAX requests
- ✅ Capability checks (`manage_woocommerce` required)
- ✅ Data sanitization and escaping
- ✅ XSS and injection prevention
- ✅ Direct file access protection

## ⚡ Performance

- **Lightweight**: Loads only on cart page for authorized users
- **Minimal footprint**: < 1MB memory usage
- **Fast response**: < 200ms URL generation
- **No database storage**: Completely stateless

## 🛠️ Technical Details

### Plugin Structure
```
woo-shareable-checkout-admin/
├── woo-shareable-checkout-admin.php    # Main plugin file
├── includes/                           # Core classes
│   ├── class-wscug-admin-bar.php      # Admin bar integration
│   ├── class-wscug-url-generator.php  # URL generation logic
│   └── class-wscug-i18n.php           # Internationalization
├── assets/                            # Frontend assets
│   ├── js/admin-bar.js                # Copy-to-clipboard functionality
│   └── css/admin-bar.css              # Admin bar styling
├── languages/                         # Translation files
│   ├── *.pot                          # Translation template
│   └── *.po                           # Language files
├── uninstall.php                      # Clean uninstallation
└── readme.txt                         # WordPress.org documentation
```

### Hooks and Filters

The plugin uses standard WordPress/WooCommerce hooks:
- `before_woocommerce_init` - HPOS compatibility declaration
- `plugins_loaded` - Plugin initialization
- `admin_bar_menu` - Admin bar integration
- `wp_ajax_wscug_generate_url` - AJAX URL generation

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)  
5. Open a Pull Request

## 📝 Changelog

### v1.0.0
- Initial release
- Admin bar integration with cart page detection
- URL generation for simple and variable products
- Coupon code support
- Copy to clipboard functionality with fallback
- Security implementation with nonce verification
- Multi-language support (5 languages)
- HPOS compatibility

## 📄 License

This project is licensed under the GPL v3 License.

## 🙏 Acknowledgments

- Built following WordPress and WooCommerce coding standards
- Uses WooCommerce 10.0+ native shareable checkout URLs
- Internationalization following WordPress i18n best practices

---

**Made with ❤️ for the WooCommerce community**
