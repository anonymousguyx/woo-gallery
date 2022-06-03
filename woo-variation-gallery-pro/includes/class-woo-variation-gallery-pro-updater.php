<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! class_exists( 'Woo_Variation_Gallery_Pro_Updater', false ) ):

	require_once dirname( __FILE__ ) . '/getwooplugins/class-getwooplugins-plugin-updater.php';

	class Woo_Variation_Gallery_Pro_Updater extends GetWooPlugins_Plugin_Updater {

		protected static $_instance = null;

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$license = sanitize_text_field( get_option( 'woo_variation_gallery_license' ) );
			// $license = woo_variation_gallery()->get_option( 'license' );
			parent::__construct( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE, 1850, $license );
		}

		public function get_plugin_homepage() {
			return 'https://getwooplugins.com/plugins/woocommerce-variation-gallery/';
		}

		public function get_org_plugin_slug() {
			return woo_variation_gallery()->basename();
		}
	}
endif;