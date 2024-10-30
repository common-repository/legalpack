<?php
// TODO: use nonce
?>
<div class="postbox legalpack-options-box">
	<h3><?php echo $box->title(); ?></h3>

	<div class="inside">
		<p class="box-infotip"><?php echo $box->infotip(); ?></p>
		<p class="box-status <?php echo str_replace('.', '', strtolower($status_text)); ?>" id="status_<?php echo LEGALPACK_SLUG . '_' . $box->enable_action_id(); ?>"><?php echo $status_text; ?></p>
	</div>
	<div class="legalpack-box-enable-button">
		<a class="button" href="javascript:void(0);"
		   id="<?php echo LEGALPACK_SLUG . '_' . $box->enable_action_id(); ?>">
			<?php echo $enable_button_text; ?>
		</a>
	</div>
	<div class="legalpack-box-configure-button">
		<a class="button button-primary"
		   href="edit.php?post_type=<?php echo LEGALPACK_CPT; ?>&page=legalpack_compliancekits&box=<?php echo $box->id(); ?>">
			Configure
		</a>
	</div>
</div>