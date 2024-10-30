<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="legal-pages-form">

    <h1><?php _e('Terms and Conditions', LEGALPACK_SLUG); ?></h1>
    
    <div class="promo">
        <p>Use the <a href="https://termsfeed.com/terms-conditions/generator/?utm_source=legalpack-plugin-terms-and-conditions-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-terms-and-conditions-page">Terms &amp; Conditions Generator from TermsFeed</a> to <strong>create a professional Terms &amp; Conditions</strong> with more clauses to protect your website.</p>
        <p><a href="https://termsfeed.com/terms-conditions/generator/?utm_source=legalpack-plugin-terms-and-conditions-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-terms-and-conditions-page" class="button button-primary">Visit TermsFeed.com</a></p>
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
    
    <hr />
    
    <?php Section::begin('user_accounts_section', __('Can users create an account on your website?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'user_accounts', array (
        'Yes' => __( 'Yes, users can create an account', LEGALPACK_SLUG ),
        'No' => __( 'No', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>

    <hr />

    <?php Section::begin('ip_rights_section', __('Do you want to make it clear that your own content and trademarks are your exclusive property?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'ip_rights', array (
        'Yes' => __( 'Yes, our own content (logo, visual design etc.) and trademarks is our exclusive property', LEGALPACK_SLUG ),
        'No' => __( 'No', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>

    <hr />

    <?php Section::begin('terminate_access_seciton', __('Do you want to be able to terminate access to certain users, if these users abuse your website?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'terminate_access', array (
        'Yes' => __( 'Yes', LEGALPACK_SLUG ),
        'No' => __( 'No', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>

    <hr />

    <?php Section::begin('effective_notice_section', __('For any material changes to the Terms and Conditions, you should notify users in advance. How many days notice you will provide before the new Terms and Conditions become effective?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'effective_notice', array (
        '15' => __( '15 days notice', LEGALPACK_SLUG ),
        '30' => __( '30 days notice (recommended)', LEGALPACK_SLUG ),
        '60' => __( '60 days notice', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>

    <hr />

    <?php Section::begin('limit_liability_section', __('Do you want to limit your liability by providing your website on an "AS IS" and "AS AVAILABLE" basis?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'limit_liability', array (
        'Yes' => __( 'Yes, please include a "Disclaimer" disclosure in the legal page', LEGALPACK_SLUG ),
        'No' => __( 'No', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>

</div>