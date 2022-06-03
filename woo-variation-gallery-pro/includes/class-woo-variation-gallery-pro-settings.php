<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

if ( ! class_exists( 'Woo_Variation_Gallery_Pro_Settings' ) ):

	class Woo_Variation_Gallery_Pro_Settings extends Woo_Variation_Gallery_Settings {

		public function __construct() {
			parent::__construct();
			$this->license_notices();
		}

		protected function get_own_sections() {

			$sections = parent::get_own_sections();

			$sections['license']['url'] = true;

			return $sections;
		}

		protected function get_settings_for_license_section() {

			$settings = array(

				array(
					'name' => esc_html__( 'License Section', 'woo-variation-gallery-pro' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'license_section',
				),

				array(
					'title'      => esc_html__( 'License key', 'woo-variation-gallery-pro' ),
					'type'       => 'text',
					'default'    => '',
					'desc'       => esc_html__( 'License key', 'woo-variation-gallery-pro' ),
					'id'         => 'license',
					'standalone' => true,
				),

				array(
					'type' => 'sectionend',
					'id'   => 'license_section'
				),
			);

			return $settings;
		}

		protected function license_notices() {
			$license = sanitize_text_field( get_option( 'woo_variation_gallery_license' ) );
			if ( $this->is_current_tab() && empty( $license ) ) {
				GetWooPlugins_Admin_Settings::add_notice( esc_html__( 'Add Gallery Pro license key to get automatic update.', 'woo-variation-gallery-pro' ) );
			}
		}
	}
endif;
