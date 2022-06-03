<?php

defined( 'ABSPATH' ) || die( 'Keep Silent' );

if ( ! class_exists( 'Woo_Variation_Gallery_Pro', false ) ) :

	class Woo_Variation_Gallery_Pro extends Woo_Variation_Gallery {

		protected static $_instance = null;

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			parent::__construct();
		}

		public function includes() {
			parent::includes();
			require_once dirname( __FILE__ ) . '/class-woo-variation-gallery-pro-frontend.php';
			require_once dirname( __FILE__ ) . '/class-woo-variation-gallery-pro-backend.php';
		}

		public function get_backend() {
			return Woo_Variation_Gallery_Pro_Backend::instance();
		}

		public function get_frontend() {
			return Woo_Variation_Gallery_Pro_Frontend::instance();
		}

		public function version() {
			return esc_attr( WOO_VARIATION_GALLERY_PRO_PLUGIN_VERSION );
		}

		public function language() {
			parent::language();
			load_plugin_textdomain( 'woo-variation-gallery-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		public function pro_basename() {
			return basename( dirname( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE ) );
		}

		public function pro_plugin_basename() {
			return plugin_basename( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE );
		}

		public function pro_plugin_dirname() {
			return dirname( plugin_basename( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE ) );
		}

		public function pro_plugin_path() {
			return untrailingslashit( plugin_dir_path( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE ) );
		}

		public function pro_plugin_url() {
			return untrailingslashit( plugins_url( '/', WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE ) );
		}

		public function pro_images_url( $file = '' ) {
			return untrailingslashit( plugin_dir_url( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE ) . 'images' ) . $file;
		}

		public function pro_assets_url( $file = '' ) {
			return untrailingslashit( plugin_dir_url( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE ) . 'assets' ) . $file;
		}

		public function pro_assets_path( $file = '' ) {
			return $this->pro_plugin_path() . '/assets' . $file;
		}

		public function pro_assets_version( $file ) {
			return filemtime( $this->pro_assets_path( $file ) );
		}

		public function is_pro() {
			return true;
		}
	}
endif;