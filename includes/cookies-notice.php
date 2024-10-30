<?php
namespace legalpack\options {

	use legalpack\Legalpack;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/base-notice.php';

	class Cookies_Notice extends Base_Notice {

		function __construct () {
			parent::__construct( 'cookies_notice', 'legalpack-cookies-notice-container', 'legalpack-cookies-notice' );
		}

		protected function print_box () {
			$cookie = 'legalpack-cookies-notice';
			if(!isset($_COOKIE[$cookie])) {
				Legalpack::template( 'cookies-notice', array (
					'cookie_name' => $cookie,
					'cookie_value' => 1,
					'message' => do_shortcode( $this->_message ),
					'close' => $this->_close_message,
				) );
			}
		}

		protected function get_data () {
			return true;
		}
	}
}
