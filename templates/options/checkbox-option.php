<?php
$value = $value ? 'checked="checked"' : '';
echo '<input type="checkbox" name="' . $name . '" id="' . $name . '" ' . $value . ' />';
