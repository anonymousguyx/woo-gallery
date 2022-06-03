<?php
defined( 'ABSPATH' ) || exit;
// Template for the Attachment "thumbnails" in the Media Grid.
?>

<script type="text/html" id="tmpl-wvg_media_attachment">
	<# let haveVideoClass = ( data.woo_variation_gallery_video )?'wvg-video':'' #>
	<div class="wvg-attachment-preview {{ haveVideoClass }} attachment-preview js--select-attachment type-{{ data.type }} subtype-{{ data.subtype }} {{ data.orientation }}">

		<div class="wvg-thumbnail-container">
			<div class="thumbnail">
				<# if ( data.uploading ) { #>
				<div class="media-progress-bar">
					<div style="width: {{ data.percent }}%"></div>
				</div>
				<# } else if ( 'image' === data.type && data.size && data.size.url ) { #>
				<div class="centered">
					<img src="{{ data.size.url }}" draggable="false" alt="" />
				</div>
				<# } else { #>
				<div class="centered">
					<# if ( data.image && data.image.src && data.image.src !== data.icon ) { #>
					<img src="{{ data.image.src }}" class="thumbnail" draggable="false" alt="" />
					<# } else if ( data.sizes && data.sizes.medium ) { #>
					<img src="{{ data.sizes.medium.url }}" class="thumbnail" draggable="false" alt="" />
					<# } else { #>
					<img src="{{ data.icon }}" class="icon" draggable="false" alt="" />
					<# } #>
				</div>
				<div class="filename">
					<div>{{ data.filename }}</div>
				</div>
				<# } #>
			</div>
		</div>

		<# if ( data.buttons.close ) { #>
		<button type="button" class="button-link attachment-close media-modal-icon">
			<span class="screen-reader-text"><?php _e( 'Remove' ); ?></span></button>
		<# } #>
	</div>
	<# if ( data.buttons.check ) { #>
	<button type="button" class="check" tabindex="-1">
		<span class="media-modal-icon"></span><span class="screen-reader-text"><?php _e( 'Deselect' ); ?></span>
	</button>
	<# } #>
	<#
	var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly';
	if ( data.describe ) {
	if ( 'image' === data.type ) { #>
	<input type="text" value="{{ data.caption }}" class="describe" data-setting="caption"
		   aria-label="<?php esc_attr_e( 'Caption' ); ?>"
		   placeholder="<?php esc_attr_e( 'Caption&hellip;' ); ?>" {{ maybeReadOnly }} />
	<# } else { #>
	<input type="text" value="{{ data.title }}" class="describe" data-setting="title"
	<# if ( 'video' === data.type ) { #>
	aria-label="<?php esc_attr_e( 'Video title' ); ?>"
	placeholder="<?php esc_attr_e( 'Video title&hellip;' ); ?>"
	<# } else if ( 'audio' === data.type ) { #>
	aria-label="<?php esc_attr_e( 'Audio title' ); ?>"
	placeholder="<?php esc_attr_e( 'Audio title&hellip;' ); ?>"
	<# } else { #>
	aria-label="<?php esc_attr_e( 'Media title' ); ?>"
	placeholder="<?php esc_attr_e( 'Media title&hellip;' ); ?>"
	<# } #> {{ maybeReadOnly }} />
	<# }
	} #>
</script>

