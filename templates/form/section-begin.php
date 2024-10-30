<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?><div id="<?php echo $section_id; ?>" class="legal-pages-form-section">
    <?php
    if($header !== false) {
    ?>
    <h2 class="legal-pages-form-section-header"><?php echo $header; ?></h2><?php
}
