<?php

namespace legalpack\shortcode {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/post-data.php';

	class Post_Link extends Post_Data {
		
		function __construct ( $name ) {
			parent::__construct( $name, 'ID' );
		}

		protected function handle_post ( $post, $values, $content ) {
			$res = parent::handle_post($post, $values, $content);
			if(empty($res)) {
				return $res;
			}
			return esc_url(get_post_permalink( $res ));
		}

	}
}