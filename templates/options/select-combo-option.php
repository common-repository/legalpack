<div class="legalpack-options-select-combo"><select name="<?php echo $name; ?>" id="<?php echo $name; ?>">
	<?php
	$found = false;
	foreach ($values as $k => $v) {
		$k = trim($k);
		if(trim($k) == $value){
			$selected = ' selected="selected"';
			$found = true;
		}else {
			$selected = '';
		}
		?>
		<option value="<?php echo esc_attr( $k ); ?>"<?php echo $selected; ?>><?php echo esc_html( $v ); ?></option>
		<?php
	}
	?>
	<option value="" class="legalpack-custom-value-<?php echo $name; ?>"<?php if(!$found){echo ' selected="selected"';}?>><?php _e('custom...', LEGALPACK_SLUG); ?></option>
</select>
<p><input class="legalpack-hidden" type="text" name="custom_<?php echo $name; ?>" value="<?php if(!$found){ echo $value;} ?>" placeholder="<?php _e('Enter a custom value', LEGALPACK_SLUG);?>" /></p>
</div>