<?php

namespace legalpack\shortcode {

	if (!defined ('ABSPATH')) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/post-base.php';

	class Last_Updated extends Post_Base {
		
		protected function handle_post ( $post, $values, $content ) {
			return esc_html(get_post_modified_time( get_option( 'date_format' ), false, $post, true ));
		}
	}
}