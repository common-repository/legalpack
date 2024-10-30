<?php

namespace legalpack\options {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/option.php';

	class Color_Option extends Option {
		function __construct ( $name, $label, $page_id, $section_id ) {
			parent::__construct( $name, $label, $page_id, $section_id );
			$this->_template = 'color-option';
		}

		function sanitize ( $input ) {
			if (!preg_match( '/(\#[\dabcdef]{1,6})/i', $input, $matches )) {
				return '';
			}
			return $matches[0];
		}
	}
}