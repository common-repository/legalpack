<?php
echo '<input type="text" name="' . $name . '" id="' . $name . '" value="' . $value . '" />';
echo '<p class="legalpack-shortcode-option">'.__('Short code:', LEGALPACK_SLUG).' [legalpack '.substr($name, strlen(LEGALPACK_OPTION_PREFIX)).']</p>';