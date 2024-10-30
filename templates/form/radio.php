<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?><ul class="legal-pages-form-radio">
    <?php
    foreach ($values as $k => $v) {
        $full_id = $control_id . '_' . $k;
        ?>
        <li><input type="radio" name="<?php echo $control_id; ?>" id="<?php echo $full_id; ?>"
                   value="<?php echo $k; ?>" />
            <label for="<?php echo $full_id; ?>"><?php echo $v; ?></label></li>
        <?php
    }
    ?>
</ul>