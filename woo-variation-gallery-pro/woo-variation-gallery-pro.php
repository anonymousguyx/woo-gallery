<?php
/**
 * Plugin Name: Additional Variation Images Gallery for WooCommerce - Pro
 * Plugin URI: https://getwooplugins.com/plugins/woocommerce-variation-gallery/
 * Description: Additional Variation Images Gallery for WooCommerce - Pro.
 * Author: Emran Ahmed
 * Version: 1.3.3
 * Domain Path: /languages
 * Requires PHP: 7.0
 * Requires at least: 5.7
 * Tested up to: 6.0
 * WC requires at least: 5.8
 * WC tested up to: 6.5
 * Text Domain: woo-variation-gallery-pro
 * Author URI: https://getwooplugins.com/
 */

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! defined( 'WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE' ) ) {
	define( 'WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'WOO_VARIATION_GALLERY_PRO_PLUGIN_VERSION' ) ) {
	define( 'WOO_VARIATION_GALLERY_PRO_PLUGIN_VERSION', '1.3.3' );
}

// Require woocommerce admin message
function woo_variation_gallery_pro_wc_requirement_notice() {

	if ( ! class_exists( 'WooCommerce' ) ) {
		$text    = esc_html__( 'WooCommerce', 'woo-variation-gallery' );
		$link    = esc_url( add_query_arg( array(
			'tab'       => 'plugin-information',
			'plugin'    => 'woocommerce',
			'TB_iframe' => 'true',
			'width'     => '640',
			'height'    => '500',
		), admin_url( 'plugin-install.php' ) ) );
		$message = wp_kses( __( "<strong>Variation Gallery for WooCommerce</strong> is an add-on of ", 'woo-variation-gallery' ), array( 'strong' => array() ) );

		printf( '<div class="%1$s"><p>%2$s <a class="thickbox open-plugin-details-modal" href="%3$s"><strong>%4$s</strong></a></p></div>', 'notice notice-error', $message, $link, $text );
	}

	if ( ! class_exists( 'Woo_Variation_Gallery' ) ) {

		$text    = esc_html__( 'Variation Gallery for WooCommerce', 'woo-variation-gallery-pro' );
		$link    = esc_url(
			add_query_arg(
				array(
					'tab'       => 'plugin-information',
					'plugin'    => 'woo-variation-gallery',
					'TB_iframe' => 'true',
					'width'     => '640',
					'height'    => '500',
				), admin_url( 'plugin-install.php' )
			)
		);
		$message = wp_kses( __( "<strong>Variation Gallery for WooCommerce - Pro</strong> is an add-on of ", 'woo-variation-gallery' ), array( 'strong' => array() ) );

		printf( '<div class="%1$s"><p>%2$s <a class="thickbox open-plugin-details-modal" href="%3$s"><strong>%4$s</strong></a></p></div>', 'notice notice-error', $message, $link, $text );
	}
}

add_action( 'admin_notices', 'woo_variation_gallery_pro_wc_requirement_notice' );

/**
 * Returns the main instance.
 */

function woo_variation_gallery_pro() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid

	if ( ! class_exists( 'WooCommerce', false ) ) {
		return false;
	}

	// Include the main class.
	if ( ! class_exists( 'Woo_Variation_Gallery_Pro', false ) ) {
		require_once dirname( __FILE__ ) . '/includes/class-woo-variation-gallery-pro.php';
	}

	return Woo_Variation_Gallery_Pro::instance();
}