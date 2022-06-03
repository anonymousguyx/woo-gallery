<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woo_Variation_Gallery_Pro_Compatibility' ) ) :

	class Woo_Variation_Gallery_Pro_Compatibility extends Woo_Variation_Gallery_Compatibility {

		protected static $_instance = null;

		protected function __construct() {
			parent::__construct();
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function dokan_footer() {
			if ( class_exists( 'WeDevs_Dokan' ) && current_user_can( 'dokan_edit_product' ) ) {
				woo_variation_gallery()->get_backend()->admin_template_js();
				woo_variation_gallery()->get_backend()->print_media_template();
			}
		}
	}
endif;