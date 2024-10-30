<?php

namespace legalpack\shortcode {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/post-base.php';

	class Post_Data extends Post_Base {
		protected $_data;
		function __construct ( $name, $data ) {
			parent::__construct( $name );
			$this->_data = $data;
		}

		protected function handle_post ( $post, $values, $content ) {
			$name = $this->_data;
			if(!isset($post->$name)) {
				return '';
			}
			return esc_html($post->$name);
		}

	}
}