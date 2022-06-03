<?php
defined( 'ABSPATH' ) or die( 'Keep Quit' );
/**
 * @var $template_id
 * @var $title
 * @var $body
 * @var $footer
 */
$template_id = sprintf( 'tmpl-%s', esc_attr( $template_id ) );
?>

<script type="text/template" id="<?php echo esc_attr( $template_id ) ?>">
	<div class="gwp-backbone-modal gwp-pro-dialog">
		<div class="gwp-backbone-modal-content">
			<section class="gwp-backbone-modal-main" role="main">
				<header class="gwp-backbone-modal-header">
					<h1><?php echo esc_html( $title ); ?></h1>
					<button class="modal-close modal-close-link dashicons dashicons-no-alt">
						<span class="screen-reader-text"><?php esc_html_e( 'Close modal panel', 'woo-variation-gallery' ); ?></span>
					</button>
				</header>
				<article>
					<div class="gwp-dialog-form-body">
						<!--
						USE video-wrapper for iframe video like: youtube / vimeo
						<div class="video-wrapper">
						<iframe src="..."></iframe>
						</div>
						-->
						<?php echo wp_kses_post( $body ); // WPCS: XSS ok. ?>
					</div>
				</article>
				<?php if ( ! empty( $demo_link ) || ! empty( $buy_link ) ): ?>
					<footer>
						<div class="inner">
							<?php if ( ! empty( $demo_link ) ): ?>
								<div class="gwp-action-button-group">
									<a target="_blank" href="<?php echo esc_url( $demo_link ) ?>" class="button button-primary"><?php esc_html_e( 'See demo', 'woo-variation-gallery' ) ?></a>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $buy_link ) ): ?>
								<a target="_blank" href="<?php echo esc_url( $buy_link ) ?>"><?php esc_html_e( 'Buy Now', 'woo-variation-gallery' ) ?></a>
							<?php endif; ?>
						</div>
					</footer>
				<?php endif; ?>
			</section>
		</div>
	</div>
	<div class="gwp-backbone-modal-backdrop modal-close"></div>
</script>