<p><?php _e( 'Choose a tag from your current list of tags:', LEGALPACK_SLUG ); ?></p>
<select class="legalpack-options-select-tag" name="<?php echo $name; ?>[]" id="<?php echo $name; ?>[]">
	<?php
	$found = false;
	foreach ($values as $k => $v) {
		$k = trim( $k );
		if (trim( $k ) == $value) {
			$selected = ' selected="selected"';
			$found = true;
		} else {
			$selected = '';
		}
		?>
		<option value="<?php echo esc_attr( $k ); ?>"<?php echo $selected; ?>><?php echo esc_html( $v ); ?></option>
		<?php
	}
	?>
	<option value="0"><?php _e( 'new tag...', LEGALPACK_SLUG ); ?></option>
</select>
<div class="legalpack-options-new-tag legalpack-hidden" id="new-tag-<?php echo $name; ?>[]">
	<p><?php _e( 'Add a new tag:', LEGALPACK_SLUG ); ?></p>
	<p><input type="text" name="<?php echo $name; ?>[]" id="<?php echo $name; ?>[]" value=""
			  placeholder="<?php _e( 'Enter new tag', LEGALPACK_SLUG ); ?>"/></p>
</div>