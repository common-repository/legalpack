<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

require_once dirname( __FILE__ ) . '/legalpack.php';

// TODO: update according to options
//delete_option( LEGALPACK_OPTION_PREFIX );
delete_option(LEGALPACK_OPTION_PREFIX . 'activated');
flush_rewrite_rules();
