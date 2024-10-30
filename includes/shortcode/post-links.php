<?php

namespace legalpack\shortcode {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/sub-shortcode.php';

	class Post_Links extends Sub_Shortcode {

		function handle ( $values, $content ) {
			global $legalpack_posts;
			if (empty($legalpack_posts)) {
				return '';
			}

			$links = array();
			foreach ($legalpack_posts as $post) {
				$links[] = '<a href="'.esc_url(get_post_permalink($post->ID)).'">'.
					esc_html($post->post_title).'</a>';
			}

			return join(', ', $links);
		}

	}
}