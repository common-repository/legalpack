<?php

namespace legalpack\options {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/option.php';

	class Tag_Option extends Option {

		const TYPE_TAG = 'tag-option';
		protected $_tags;

		function __construct ( $name, $label, $type, $page_id, $section_id ) {
			parent::__construct( $name, $label, $page_id, $section_id );
			$this->_template = $type;
		}

		public function tags () {
			if (empty($this->_tags)) {
				$tags = get_terms( 'post_tag', array ( 'hide_empty' => false ) );
				$this->_tags = array_combine(
					array_map( function ( $x ) {
						return $x->term_id;
					}, $tags ),
					array_map( function ( $x ) {
						return $x->name;
					}, $tags ) );
			}
			return $this->_tags;
		}

		protected function _handle_render ( $template, $args ) {
			$args['values'] = $this->tags();
			parent::_handle_render( $template, $args );
		}

		function sanitize ( $input ) {
			if (!is_array( $input ) || !isset($input[0])) {
				return 0;
			}
			$input[0] = intval( $input[0] );
			if (isset($input[1]) && !empty($input[1]) && ($input[0] == 0)) {
				$input = $input[1];
				$idx = array_search( $input, $this->tags() );
				if ($idx !== false) {
					$input = $idx;
				} else {
					$term = wp_insert_term( $input, 'post_tag' );
					if (is_array( $term )) {
						$input = $term['term_id'];
					} else {
						$input = 0;
					}
				}
			} else {
				if (isset($input[0])) {
					$input = $input[0];
					$tags = $this->tags();
					if (!isset($tags[$input])) {
						$input = 0;
					}
				} else {
					$input = 0;
				}
			}
			return $input;
		}
	}
}