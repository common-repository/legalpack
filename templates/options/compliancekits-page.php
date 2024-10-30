<?php

if (!defined( 'ABSPATH' )) {
	exit;
}
?>
<div class="wrap">
	<h2><?php echo $page->title(); ?></h2>
	<?php settings_errors(); ?>
	<div id="legalpack_notice"></div>
	<div id="poststuff">

		<div class="postbox-container">
			<?php foreach ($page->boxes() as $box) {
				$box->render();
			}
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var LEGALPACK_TOGGLE_NONCE="<?php echo esc_js(wp_create_nonce(LEGALPACK_SLUG . '_toggle_box')); ?>";
</script>
