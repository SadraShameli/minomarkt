<?php
/**
 * Template: Sitemap switch to SmartCrawl modal body.
 *
 * @package SmartCrawl
 */

?>
<button
	type="button"
	class="sui-button sui-button-ghost"
	data-modal-close
>
	<?php esc_html_e( 'Cancel', 'wds' ); ?>
</button>

<button
	type="button"
	id="wds-switch-to-smartcrawl-button"
	class="sui-button sui-button-blue"
>
	<span class="sui-loading-text">
		<span class="sui-icon-defer" aria-hidden="true"></span>
		<?php esc_html_e( 'Switch', 'wds' ); ?>
	</span>
	<span class="sui-icon-loader sui-loading" aria-hidden="true"></span>
</button>