<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$full_id = trim($control_id, '[]') . '_' . $value;
?><input type="checkbox" name="<?php echo $control_id; ?>" id="<?php echo $full_id ?>" value="<?php echo $value; ?>" />
<label for="<?php echo $full_id ?>"><?php echo $label; ?></label>