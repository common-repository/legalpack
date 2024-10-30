<?php

namespace legalpack\options {

	if (!defined ('ABSPATH')) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/option.php';

	class Text_Option extends Option {
		const TYPE_GENERIC = 'text-option';
		const TYPE_TEXTAREA = 'textarea-option';
		function __construct ( $name, $label, $type, $page_id, $section_id ) {
			parent::__construct( $name, $label, $page_id, $section_id );
			$this->_template = $type;
		}

		function sanitize ( $input ) {
			return trim(strval($input));
		}
	}
}