<?php

namespace legalpack\options {

	if (!defined ('ABSPATH')) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/option.php';

	class Checkbox_Option extends Option {
		function __construct ( $name, $label, $page_id, $section_id ) {
			parent::__construct( $name, $label, $page_id, $section_id );
			$this->_template = 'checkbox-option';
		}

		function sanitize ( $input ) {
			return boolval($input);
		}
	}
}