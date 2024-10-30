<select name="<?php echo $name; ?>" id="<?php echo $name; ?>">
	<?php
	foreach ($values as $k => $v) {
		$k = trim($k);
		if(trim($k) == $value){
			$selected = ' selected="selected"';
		}else {
			$selected = '';
		}
		?>
		<option value="<?php echo esc_attr( $k ); ?>"<?php echo $selected; ?>><?php echo esc_html( $v ); ?></option>
		<?php
	}
	?>
</select>
