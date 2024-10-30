<?php

namespace legalpack\shortcode {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/sub-shortcode.php';

	class Post_Titles extends Sub_Shortcode {

		function handle ( $values, $content ) {
			global $legalpack_posts;
			if (empty($legalpack_posts)) {
				return '';
			}

			$titles = array();
			foreach ($legalpack_posts as $post) {
				$titles[] = esc_html($post->post_title);
			}

			return join(', ', $titles);
		}

	}
}