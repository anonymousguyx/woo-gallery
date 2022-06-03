<?php
defined( 'ABSPATH' ) || die( 'Keep Quit' );
?>

<script type="text/html" id="tmpl-woo-variation-gallery-slider-template">
	<?php ob_start() ?>
	<# hasVideo = (  data.video_link ) ? 'wvg-gallery-video-slider' : '' #>
	<# thumbnailSrc = (  data.video_link ) ? data.video_thumbnail_src : data.gallery_thumbnail_src #>
	<!--<# videoHeight = ( data.video_height ) ? data.video_height : '100%' #>
	<# videoWidth = ( data.video_width ) ? data.video_width : 'auto' #>-->
	<# videoHeight = ( data.video_height ) ? data.video_height : 1 #>
	<# videoWidth = ( data.video_width ) ? data.video_width : 1 #>
	<# videoRatio = ( data.video_ratio ) ? data.video_ratio : 100 #>
	<div class="wvg-gallery-image {{hasVideo}}">

		<# if( data.video_link && data.video_embed_type==='iframe' ){ #>
		<div class="wvg-single-gallery-iframe-container" style="padding-bottom: {{ videoRatio }}%">
			<iframe loading="lazy" src="{{ data.video_embed_url }}" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		</div>
		<# } #>

		<# if( data.video_link && data.video_embed_type==='video' ){ #>
		<div class="wvg-single-gallery-video-container" style="padding-bottom: {{ videoRatio }}%">
			<video preload="auto" controls controlsList="nodownload" src="{{ data.video_link }}"></video>
		</div>
		<# } #>

		<# if( !data.video_link && data.srcset ){ #>
		<div class="wvg-single-gallery-image-container">
			<img loading="lazy" width="{{data.src_w}}" height="{{data.src_h}}" src="{{data.src}}" alt="{{data.alt}}" title="{{data.title}}" data-caption="{{data.caption}}" data-src="{{data.full_src}}" data-large_image="{{data.full_src}}" data-large_image_width="{{data.full_src_w}}" data-large_image_height="{{data.full_src_h}}" srcset="{{data.srcset}}" sizes="{{data.sizes}}" {{data.extra_params}} />
		</div>
		<# } #>

		<# if( !data.video_link && !data.srcset ){ #>
		<div class="wvg-single-gallery-image-container">
			<img loading="lazy" width="{{data.src_w}}" height="{{data.src_h}}" src="{{data.src}}" alt="{{data.alt}}" title="{{data.title}}" data-caption="{{data.caption}}" data-src="{{data.full_src}}" data-large_image="{{data.full_src}}" data-large_image_width="{{data.full_src_w}}" data-large_image_height="{{data.full_src_h}}" sizes="{{data.sizes}}" {{data.extra_params}} />
		</div>
		<# } #>

	</div>
	<?php echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', ob_get_clean(), 0 ); ?>
</script>


<script type="text/html" id="tmpl-woo-variation-gallery-thumbnail-template">
	<# hasVideo = (  data.video_link ) ? 'wvg-gallery-video-thumbnail' : '' #>
	<div class="wvg-gallery-thumbnail-image {{hasVideo}}">
		<div>
			<img width="{{data.gallery_thumbnail_src_w}}" height="{{data.gallery_thumbnail_src_h}}" src="{{data.gallery_thumbnail_src}}" alt="{{data.alt}}" title="{{data.title}}" />
		</div>
	</div>
</script>