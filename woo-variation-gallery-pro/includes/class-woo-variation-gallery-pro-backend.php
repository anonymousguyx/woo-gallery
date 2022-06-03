<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woo_Variation_Gallery_Pro_Backend' ) ) :

	class Woo_Variation_Gallery_Pro_Backend extends Woo_Variation_Gallery_Backend {

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

		public function hooks() {
			parent::hooks();

			add_action( 'admin_init', array( $this, 'updater_init' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'print_media_templates', array( $this, 'print_media_template' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_product_images_meta_box' ), 40 );

			add_filter( 'admin_post_thumbnail_html', array( $this, 'admin_post_thumbnail_html' ), 10, 3 );
			add_filter( 'attachment_fields_to_edit', array( $this, 'attachment_fields_to_edit' ), 10, 2 );
			add_filter( 'attachment_fields_to_save', array( $this, 'attachment_fields_to_save' ), 10, 2 );
			add_filter( 'wp_prepare_attachment_for_js', array( $this, 'wp_prepare_attachment_for_js' ), 10, 3 );

			add_filter( 'plugin_action_links_' . plugin_basename( WOO_VARIATION_GALLERY_PRO_PLUGIN_FILE ), array(
				$this,
				'plugin_action_links'
			) );
		}

		public function includes() {
			parent::includes();
			require_once dirname( __FILE__ ) . '/class-woo-variation-gallery-pro-updater.php';
		}

		// start

		public function updater_init() {
			Woo_Variation_Gallery_Pro_Updater::instance();
		}

		public function load_settings() {

			include_once woo_variation_gallery()->include_path() . '/class-woo-variation-gallery-settings.php';
			require_once dirname( __FILE__ ) . '/class-woo-variation-gallery-pro-settings.php';

			return new Woo_Variation_Gallery_Pro_Settings();
		}

		public function attachment_fields_to_edit( $form_fields, $post ) {
			$form_fields['woo_variation_gallery_media_title'] = array(
				'tr' => sprintf( '<hr><h2>%s</h2>', __( 'Variation Gallery Video', 'woo-variation-gallery-pro' ) )
			);

			$form_fields['woo_variation_gallery_media_video'] = array(
				'label' => esc_html__( 'Video URL', 'woo-variation-gallery-pro' ),
				'input' => 'text',
				//'show_in_edit' => false,
				'value' => esc_url( get_post_meta( $post->ID, 'woo_variation_gallery_media_video', true ) )
			);

			$form_fields['woo_variation_gallery_media_video_popup'] = array(
				'label' => '',
				'input' => 'html',
				//'show_in_edit' => false,
				'html'  => '<a class="woo_variation_gallery_media_video_popup_link" href="#"><span class="dashicons dashicons-video-alt3"></span></a>',
			);

			$form_fields['woo_variation_gallery_media_video_width'] = array(
				'label' => esc_html__( 'Width', 'woo-variation-gallery-pro' ),
				'input' => 'text',
				//'show_in_edit' => false,
				'value' => absint( get_post_meta( $post->ID, 'woo_variation_gallery_media_video_width', true ) ),
				'helps' => esc_html__( 'Actual Video Width or Width Ratio. Empty for default', 'woo-variation-gallery-pro' )
			);

			$form_fields['woo_variation_gallery_media_video_height'] = array(
				'label' => esc_html__( 'Height', 'woo-variation-gallery-pro' ),
				'input' => 'text',
				//'show_in_edit' => false,
				'value' => absint( get_post_meta( $post->ID, 'woo_variation_gallery_media_video_height', true ) ),
				'helps' => esc_html__( 'Actual Video Height or Height Ratio. Empty for default', 'woo-variation-gallery-pro' )
			);

			return $form_fields;
		}

		public function attachment_fields_to_save( $post, $attachment ) {

			if ( isset( $attachment['woo_variation_gallery_media_video'] ) ) {
				update_post_meta( $post['ID'], 'woo_variation_gallery_media_video', esc_url( trim( $attachment['woo_variation_gallery_media_video'] ) ) );
			}

			if ( isset( $attachment['woo_variation_gallery_media_video_width'] ) ) {
				update_post_meta( $post['ID'], 'woo_variation_gallery_media_video_width', absint( trim( $attachment['woo_variation_gallery_media_video_width'] ) ) );
			}

			if ( isset( $attachment['woo_variation_gallery_media_video_height'] ) ) {
				update_post_meta( $post['ID'], 'woo_variation_gallery_media_video_height', absint( trim( $attachment['woo_variation_gallery_media_video_height'] ) ) );
			}

			return $post;
		}

		public function wp_prepare_attachment_for_js( $attachment_data, $attachment, $meta ) {

			$id        = absint( $attachment->ID );
			$has_video = trim( get_post_meta( $id, 'woo_variation_gallery_media_video', true ) );

			$attachment_data['woo_variation_gallery_video'] = $has_video;

			return $attachment_data;
		}

		public function admin_template_js() {
			ob_start();
			require_once dirname( __FILE__ ) . '/admin-template-js.php';
			$data = ob_get_clean();
			echo apply_filters( 'woo_variation_gallery_admin_template_js', $data );
		}

		public function admin_enqueue_scripts() {

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_style( 'woo-variation-gallery-admin', esc_url( woo_variation_gallery()->assets_url( "/css/admin{$suffix}.css" ) ), array(), woo_variation_gallery()->assets_version( "/css/admin{$suffix}.css" ) );

			wp_enqueue_style( 'woo-variation-gallery-admin-pro', esc_url( woo_variation_gallery()->pro_assets_url( "/css/admin{$suffix}.css" ) ), array( 'dashicons' ), woo_variation_gallery()->pro_assets_version( "/css/admin{$suffix}.css" ) );

			wp_enqueue_script( 'woo-variation-gallery-admin-pro', esc_url( woo_variation_gallery()->pro_assets_url( "/js/admin{$suffix}.js" ) ), array(
				'jquery',
				'jquery-ui-sortable',
				'wp-util'
			), woo_variation_gallery()->pro_assets_version( "/js/admin{$suffix}.js" ), true );

			wp_localize_script( 'woo-variation-gallery-admin-pro', 'woo_variation_gallery_admin', array(
				'choose_video' => esc_html__( 'Choose Video', 'woo-variation-gallery-pro' ),
				'choose_image' => esc_html__( 'Choose Image', 'woo-variation-gallery-pro' ),
				'add_image'    => esc_html__( 'Add Images', 'woo-variation-gallery-pro' ),
				'add_video'    => esc_html__( 'Add Video', 'woo-variation-gallery-pro' ),
				'update_image' => esc_html__( 'Update Images', 'woo-variation-gallery-pro' )
			) );

			do_action( 'woo_variation_gallery_pro_admin_enqueue_scripts', $this );
		}

		public function print_media_template() {
			ob_start();
			include dirname( __FILE__ ) . '/media-template.php';
			echo ob_get_clean();
		}

		public function meta_box_product_images( $post ) {
			global $thepostid, $product_object;

			$thepostid      = $post->ID;
			$product_object = $thepostid ? wc_get_product( $thepostid ) : new WC_Product();
			wp_nonce_field( 'woocommerce_save_data', 'woocommerce_meta_nonce' );
			?>
			<div id="product_images_container">
				<ul class="product_images">
					<?php
					$product_image_gallery = $product_object->get_gallery_image_ids( 'edit' );

					$attachments         = array_filter( $product_image_gallery );
					$update_meta         = false;
					$updated_gallery_ids = array();

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							$attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );


							$video     = trim( get_post_meta( $attachment_id, 'woo_variation_gallery_media_video', true ) );
							$has_video = empty( $video ) ? 'image' : 'image video';

							// if attachment is empty skip.
							if ( empty( $attachment ) ) {
								$update_meta = true;
								continue;
							}
							?>
							<li class="<?php echo esc_attr( $has_video ); ?>" data-attachment_id="<?php echo esc_attr( $attachment_id ); ?>">
								<?php echo $attachment; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<ul class="actions">
									<li>
										<a href="#" class="delete tips" data-tip="<?php esc_attr_e( 'Delete image', 'woocommerce' ); ?>"><?php esc_html_e( 'Delete', 'woocommerce' ); ?></a>
									</li>
								</ul>
								<?php
								// Allow for extra info to be exposed or extra action to be executed for this attachment.
								do_action( 'woocommerce_admin_after_product_gallery_item', $thepostid, $attachment_id );
								?>
							</li>
							<?php

							// rebuild ids to be saved.
							$updated_gallery_ids[] = $attachment_id;
						}

						// need to update product meta to set new gallery ids
						if ( $update_meta ) {
							update_post_meta( $post->ID, '_product_image_gallery', implode( ',', $updated_gallery_ids ) );
						}
					}
					?>
				</ul>

				<input type="hidden" id="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( implode( ',', $updated_gallery_ids ) ); ?>" />

			</div>
			<p class="add_product_images hide-if-no-js">
				<a href="#" data-choose="<?php esc_attr_e( 'Add images to product gallery', 'woocommerce' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'woocommerce' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'woocommerce' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'woocommerce' ); ?>"><?php esc_html_e( 'Add product gallery images', 'woocommerce' ); ?></a>
			</p>
			<?php
		}

		public function add_product_images_meta_box() {
			remove_meta_box( 'woocommerce-product-images', 'product', 'side' );
			add_meta_box( 'woocommerce-product-images', __( 'Product gallery', 'woocommerce' ), array(
				$this,
				'meta_box_product_images'
			), 'product', 'side', 'low' );

		}

		public function admin_post_thumbnail_html( $content, $post_id, $thumbnail_id ) {
			if ( get_post_type( $post_id ) === 'product' ) {
				$has_video = trim( get_post_meta( $thumbnail_id, 'woo_variation_gallery_media_video', true ) );
				if ( ! empty( $has_video ) ) {
					$pattern = '/^<p class="hide-if-no-js">/';
					$replace = '<p class="hide-if-no-js wvg-admin-video-preview">';
					$content = preg_replace( $pattern, $replace, $content );
				}
			}

			return $content;
		}

		public function gallery_admin_html( $loop, $variation_data, $variation ) {
			$variation_id   = absint( $variation->ID );
			$gallery_images = get_post_meta( $variation_id, 'woo_variation_gallery_images', true );
			?>
			<div data-product_variation_id="<?php echo esc_attr( $variation_id ) ?>" class="form-row form-row-full woo-variation-gallery-wrapper">
				<div class="woo-variation-gallery-postbox">
					<div class="postbox-header">
						<h2><?php esc_html_e( 'Variation Product Gallery', 'woo-variation-gallery' ) ?></h2>
						<button type="button" class="handle-div" aria-expanded="true">
							<span class="toggle-indicator" aria-hidden="true"></span>
						</button>
					</div>

					<div class="woo-variation-gallery-inside">
						<div class="woo-variation-gallery-image-container">
							<ul class="woo-variation-gallery-images">
								<?php
								if ( is_array( $gallery_images ) && ! empty( $gallery_images ) ) {
									include dirname( __FILE__ ) . '/admin-template.php';
								}
								?>
							</ul>
						</div>
						<div class="add-woo-variation-gallery-image-wrapper hide-if-no-js">
							<a href="#" data-product_variation_loop="<?php echo absint( $loop ) ?>" data-product_variation_id="<?php echo esc_attr( $variation_id ) ?>" class="button-primary add-woo-variation-gallery-image"><?php esc_html_e( 'Add Variation Gallery Images or Videos', 'woo-variation-gallery' ) ?></a>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		public function plugin_row_meta( $links, $file ) {


			$plugins   = array();
			$plugins[] = woo_variation_gallery()->plugin_basename();
			$plugins[] = woo_variation_gallery()->pro_plugin_basename();

			if ( ! in_array( $file, $plugins ) ) {
				return $links;
			}

			$report_url = 'https://getwooplugins.com/tickets/';

			$documentation_url = 'https://getwooplugins.com/documentation/woocommerce-variation-gallery/';

			$row_meta['docs']    = sprintf( '<a target="_blank" href="%1$s" title="%2$s">%2$s</a>', esc_url( $documentation_url ), esc_html__( 'View documentation', 'woo-variation-gallery-pro' ) );
			$row_meta['support'] = sprintf( '<a target="_blank" href="%1$s">%2$s</a>', esc_url( $report_url ), esc_html__( 'Help &amp; Support', 'woo-variation-gallery-pro' ) );

			return array_merge( $links, $row_meta );

		}
	}
endif;