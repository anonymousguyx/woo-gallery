<?php
defined( 'ABSPATH' ) or die( 'Keep Quit' );
/**
 * @var $gallery_images
 * @var $variation_id
 */
foreach ( $gallery_images as $image_id ):

	$image = wp_get_attachment_image_src( $image_id );
	$has_video = trim( get_post_meta( $image_id, 'woo_variation_gallery_media_video', true ) );
	$attr_name = sprintf( 'woo_variation_gallery[%d][]', $variation_id );
	?>
	<li class="image <?php echo( $has_video ? 'video' : '' ) ?>">
		<input class="wvg_variation_id_input" type="hidden" name="<?php echo esc_attr( $attr_name ) ?>" value="<?php echo $image_id ?>">
		<img src="<?php echo esc_url( $image[0] ) ?>">
		<a href="#" class="delete remove-woo-variation-gallery-image"><span class="dashicons dashicons-dismiss"></span></a>
	</li>

<?php endforeach; ?>
