<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woo_Variation_Gallery_Pro_Frontend' ) ) :

	class Woo_Variation_Gallery_Pro_Frontend extends Woo_Variation_Gallery_Frontend {

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

		protected function includes() {
			parent::includes();
			require_once dirname( __FILE__ ) . '/class-woo-variation-gallery-pro-compatibility.php';
		}

		protected function init() {
			Woo_Variation_Gallery_Pro_Compatibility::instance();
		}

		public function slider_template_js() {
			ob_start();
			require_once dirname( __FILE__ ) . '/slider-template-js.php';
			$data = ob_get_clean();
			echo apply_filters( 'woo_variation_gallery_slider_template_js', $data );
		}

		public function get_product_attachment_props( $attachment_id, $product_id = false ) {
			$props      = array(
				'image_id'                => '',
				'title'                   => '',
				'caption'                 => '',
				'url'                     => '',
				'alt'                     => '',
				'full_src'                => '',
				'full_src_w'              => '',
				'full_src_h'              => '',
				'full_class'              => '',
				//'full_srcset'              => '',
				//'full_sizes'               => '',
				'gallery_thumbnail_src'   => '',
				'gallery_thumbnail_src_w' => '',
				'gallery_thumbnail_src_h' => '',
				'gallery_thumbnail_class' => '',
				//'gallery_thumbnail_srcset' => '',
				//'gallery_thumbnail_sizes'  => '',
				'archive_src'             => '',
				'archive_src_w'           => '',
				'archive_src_h'           => '',
				'archive_class'           => '',
				//'archive_srcset'           => '',
				//'archive_sizes'            => '',
				'src'                     => '',
				'class'                   => '',
				'src_w'                   => '',
				'src_h'                   => '',
				'srcset'                  => '',
				'sizes'                   => '',
				'video_link'              => '',
			);
			$attachment = get_post( $attachment_id );


			if ( $attachment ) {

				$props['image_id'] = $attachment_id;
				$props['title']    = _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true );
				$props['caption']  = _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true );
				$props['url']      = wp_get_attachment_url( $attachment_id );

				// Alt text.
				$alt_text = array(
					trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
					$props['caption'],
					wp_strip_all_tags( $attachment->post_title )
				);

				if ( $product_id ) {
					$product    = wc_get_product( $product_id );
					$alt_text[] = wp_strip_all_tags( get_the_title( $product->get_id() ) );
				}

				$alt_text     = array_filter( $alt_text );
				$props['alt'] = isset( $alt_text[0] ) ? $alt_text[0] : '';

				// Large version.
				$full_size           = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
				$full_size_src       = wp_get_attachment_image_src( $attachment_id, $full_size );
				$props['full_src']   = esc_url( $full_size_src[0] );
				$props['full_src_w'] = esc_attr( $full_size_src[1] );
				$props['full_src_h'] = esc_attr( $full_size_src[2] );

				$full_size_class = $full_size;
				if ( is_array( $full_size_class ) ) {
					$full_size_class = implode( 'x', $full_size_class );
				}

				$props['full_class'] = "attachment-$full_size_class size-$full_size_class";
				//$props[ 'full_srcset' ] = wp_get_attachment_image_srcset( $attachment_id, $full_size );
				//$props[ 'full_sizes' ]  = wp_get_attachment_image_sizes( $attachment_id, $full_size );


				// Gallery thumbnail.
				$gallery_thumbnail                = wc_get_image_size( 'gallery_thumbnail' );
				$gallery_thumbnail_size           = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
					$gallery_thumbnail['width'],
					$gallery_thumbnail['height']
				) );
				$gallery_thumbnail_src            = wp_get_attachment_image_src( $attachment_id, $gallery_thumbnail_size );
				$props['gallery_thumbnail_src']   = esc_url( $gallery_thumbnail_src[0] );
				$props['gallery_thumbnail_src_w'] = esc_attr( $gallery_thumbnail_src[1] );
				$props['gallery_thumbnail_src_h'] = esc_attr( $gallery_thumbnail_src[2] );

				$gallery_thumbnail_class = $gallery_thumbnail_size;
				if ( is_array( $gallery_thumbnail_class ) ) {
					$gallery_thumbnail_class = implode( 'x', $gallery_thumbnail_class );
				}

				$props['gallery_thumbnail_class'] = "attachment-$gallery_thumbnail_class size-$gallery_thumbnail_class";
				//$props[ 'gallery_thumbnail_srcset' ] = wp_get_attachment_image_srcset( $attachment_id, $gallery_thumbnail );
				//$props[ 'gallery_thumbnail_sizes' ]  = wp_get_attachment_image_sizes( $attachment_id, $gallery_thumbnail );


				// Archive/Shop Page version.
				$thumbnail_size         = apply_filters( 'woocommerce_thumbnail_size', 'woocommerce_thumbnail' );
				$thumbnail_size_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
				$props['archive_src']   = esc_url( $thumbnail_size_src[0] );
				$props['archive_src_w'] = esc_attr( $thumbnail_size_src[1] );
				$props['archive_src_h'] = esc_attr( $thumbnail_size_src[2] );

				$archive_thumbnail_class = $thumbnail_size;
				if ( is_array( $archive_thumbnail_class ) ) {
					$archive_thumbnail_class = implode( 'x', $archive_thumbnail_class );
				}

				$props['archive_class'] = "attachment-$archive_thumbnail_class size-$archive_thumbnail_class";
				//$props[ 'archive_srcset' ] = wp_get_attachment_image_srcset( $attachment_id, $thumbnail_size );
				//$props[ 'archive_sizes' ]  = wp_get_attachment_image_sizes( $attachment_id, $thumbnail_size );


				// Image source.
				$image_size     = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
				$src            = wp_get_attachment_image_src( $attachment_id, $image_size );
				$props['src']   = esc_url( $src[0] );
				$props['src_w'] = esc_attr( $src[1] );
				$props['src_h'] = esc_attr( $src[2] );

				$image_size_class = $image_size;
				if ( is_array( $image_size_class ) ) {
					$image_size_class = implode( 'x', $image_size_class );
				}
				$props['class']  = "wp-post-image wvg-post-image attachment-$image_size_class size-$image_size_class ";
				$props['srcset'] = wp_get_attachment_image_srcset( $attachment_id, $image_size );
				$props['sizes']  = wp_get_attachment_image_sizes( $attachment_id, $image_size );


				// Video
				$has_video = trim( get_post_meta( $attachment_id, 'woo_variation_gallery_media_video', true ) );

				if ( ! empty( $has_video ) ) {

					$type = wp_check_filetype( $has_video );

					$mime_support = apply_filters( 'woo_variation_gallery_supported_html_video_mime', array(
						'video/mp4',
						'video/ogg',
						'video/webm'
					), $attachment );

					$video_width  = absint( trim( get_post_meta( $attachment_id, 'woo_variation_gallery_media_video_width', true ) ) );
					$video_height = absint( trim( get_post_meta( $attachment_id, 'woo_variation_gallery_media_video_height', true ) ) );

					$props['video_link'] = $has_video;

					if ( ! empty( $type['type'] ) && in_array( $type['type'], $mime_support ) ) {
						$props['video_embed_type'] = 'video';
					} else {
						$props['video_embed_type'] = 'iframe';
						$props['video_embed_url']  = $this->get_embed_url( $has_video );
					}

					$props['video_width']  = $video_width ? $video_width : 1;
					$props['video_height'] = $video_height ? $video_height : 1;
					$props['video_ratio']  = ( $props['video_height'] / $props['video_width'] ) * 100;
				}

				// End Video

				$props['extra_params'] = wc_implode_html_attributes( apply_filters( 'woo_variation_gallery_image_extra_params', array(), $props, $attachment_id, $product_id ) );

			}

			return apply_filters( 'woo_variation_gallery_get_image_props', $props, $attachment_id, $product_id );
		}

	}
endif;