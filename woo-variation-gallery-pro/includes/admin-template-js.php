<?php
	defined( 'ABSPATH' ) or die( 'Keep Quit' );
?>

<script type="text/html" id="tmpl-woo-variation-gallery-image">
    <# hasVideo = (  data.woo_variation_gallery_video == '' ) ? '' : 'video' #>
    <li class="image {{hasVideo}}">
        <input class="wvg_variation_id_input" type="hidden" name="woo_variation_gallery[{{data.product_variation_id}}][]" value="{{data.id}}">
        <img src="{{data.url}}">
        <a href="#" class="delete remove-woo-variation-gallery-image"><span class="dashicons dashicons-dismiss"></span></a>
    </li>
</script>