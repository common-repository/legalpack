<?php

namespace legalpack\shortcode {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	abstract class Post_Base extends Sub_Shortcode {

		function handle ( $values, $content ) {
			global $legalpack_post;
			if (!empty($legalpack_post)) {
				return $this->handle_post( $legalpack_post, $values, $content );
			}
			global $post;
			if (empty($post)) {
				return '';
			}
			return $this->handle_post( $post, $values, $content );
		}

		abstract protected function handle_post ( $post, $values, $content );
	}
}
