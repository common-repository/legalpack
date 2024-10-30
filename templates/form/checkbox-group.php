<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use legalpack\Legalpack;

?><ul class="legal-pages-form-checkbox-group">
    <?php
    $control_id .= '[]';
    foreach ($values as $value => $label) {
        ?><li><?php Legalpack::template('form/checkbox',
            compact('control_id', 'label', 'value')); ?></li>
        <?php
    }
    ?>
</ul>