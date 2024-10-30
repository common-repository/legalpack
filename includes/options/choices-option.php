<?php

namespace legalpack\options {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/option.php';

	class Choices_Option extends Option {
		protected $_values;

		const TYPE_SELECT = 'select-option';

		function __construct ( $name, $label, $values, $type, $page_id, $section_id ) {
			parent::__construct( $name, $label, $page_id, $section_id );
			$this->_values = $values;
			$this->_template = $type;
		}

		protected function _handle_render($template, $args) {
			$args['values'] = $this->_values;
			parent::_handle_render($template, $args);
		}

		function sanitize ( $input ) {
			if(!isset($this->_values[$input])) {
				return trim(reset(array_keys($this->_values)));
			}
			return $input;
		}
	}
}