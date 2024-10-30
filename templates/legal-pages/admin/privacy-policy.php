<?php
if (!defined( 'ABSPATH' )) {
	exit;
}
?>

<div class="legal-pages-form">

    <h1><?php _e( 'Privacy Policy', LEGALPACK_SLUG ); ?></h1>
    
    <div class="promo">
        <p>Use the <a href="https://termsfeed.com/privacy-policy/generator/?utm_source=legalpack-plugin-privacy-policy-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-privacy-policy-page">Privacy Policy Generator from TermsFeed</a> to <strong>create a professional Privacy Policy</strong> with more clauses to protect your website.</p>
        <p><a href="https://termsfeed.com/privacy-policy/generator/?utm_source=legalpack-plugin-privacy-policy-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-privacy-policy-page" class="button button-primary">Visit TermsFeed.com</a></p>
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
    
    <?php Section::begin( 'kind_personal_information_section', __( 'What kind of personal information you collect from users?', LEGALPACK_SLUG ) ); ?>
    <?php
    admin_form\checkbox_group( 'kind_personal_information', array (
    	'name' => __( 'Name (first and last name)', LEGALPACK_SLUG ),
    	'telephone' => __( 'Telephone number', LEGALPACK_SLUG ),
    	'address' => __( 'Address (postal address)', LEGALPACK_SLUG ),
    ) );
    ?>
    <?php Section::end(); ?>
    
    <hr />
    
    <?php Section::begin('show_ads_google_asense_section', __('Do you show ads with Google AdSense on your website?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'show_ads_google_adsense', array (
        'Yes' => __( 'Yes, ads are being served on our website with Google AdSense', LEGALPACK_SLUG ),
        'No' => __( 'No', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>
    
    <hr />
    
    <?php Section::begin('use_remarketing_section', __('Do you use remarketing services for advertising purposes?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'use_remarketing', array (
        'Yes' => __( 'Yes, we use remarketing services for our advertising purposes', LEGALPACK_SLUG ),
        'No' => __( 'No', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>
    
    <hr />
    
    <?php Section::begin('disclose_personal_information_law_section', __('If required by law or subpoena, will you disclose personal information of users to law enforcement agents?', LEGALPACK_SLUG)); ?>
    <?php
    admin_form\radio( 'disclose_personal_information_law', array (
        'Yes' => __( 'Yes, if required by law or by a subpoena', LEGALPACK_SLUG ),
        'No' => __( 'No', LEGALPACK_SLUG ),
    ));
    ?>
    <?php Section::end(); ?>

</div>