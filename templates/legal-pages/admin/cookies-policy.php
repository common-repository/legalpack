<?php
if (!defined( 'ABSPATH' )) {
	exit;
}
?>

<div class="legal-pages-form">

    <h1><?php _e( 'Cookies Policy', LEGALPACK_SLUG ); ?></h1>
    
    <div class="promo">
        <p>Use the <a href="https://termsfeed.com/cookies-policy/generator/?utm_source=legalpack-plugin-cookies-policy-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-cookies-policy-page">Cookies Policy Generator from TermsFeed</a> to <strong>create a professional Cookies Policy</strong> with more clauses to protect your website.</p>
        <p><a href="https://termsfeed.com/cookies-policy/generator/?utm_source=legalpack-plugin-cookies-policy-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-cookies-policy-page" class="button button-primary">Visit TermsFeed.com</a></p>
    </div>

    <?php
    use legalpack\admin_form;
    use legalpack\admin_form\Section;
    ?>

    <?php Section::begin('website_url_section', __('What is your website URL?', LEGALPACK_SLUG)); ?>
    <div class="legal-pages-form-text-input">
    <input type="text" name="website_url" class="regular-text" value="<?php echo do_shortcode('[legalpack site_url]'); ?>" placeholder="Enter your website URL" required="required" />
    </div>
    <?php Section::end(); ?>

    <?php Section::begin('website_name_section', __('What is your website name?', LEGALPACK_SLUG)); ?>
    <div class="legal-pages-form-text-input">
    <input type="text" name="website_name" class="regular-text" value="<?php echo do_shortcode('[legalpack site_name]'); ?>" placeholder="Enter your website name" required="required" />
    </div>
    <?php Section::end(); ?>

    <hr />
    
    <?php Section::begin('location_section', __('Enter your country', LEGALPACK_SLUG)); ?>
    <div class="legal-pages-form-text-input">
    <input type="text" name="location" class="regular-text" placeholder="Enter your country" required="required" />
    </div>
    <?php Section::end(); ?>
    
</div>