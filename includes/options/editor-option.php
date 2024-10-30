<?php

namespace legalpack\options {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/option.php';

	class Editor_Option extends Option {

		protected $_settings;

		function __construct ( $name, $label, $settings, $page_id, $section_id ) {
			parent::__construct( $name, $label, $page_id, $section_id );
			$this->_settings = $settings;
		}

		function sanitize ( $input ) {
			return trim( strval( $input ) );
		}

		function render () {
			if (isset($this->_settings['filters'])) {
				foreach ($this->_settings['filters'] as $k => $v) {
					add_filter($k, $v);
				}
			}
			do_action("legalpack_pre_editor", $this);
			wp_editor( $this->get_value(), $this->_name, $this->_settings );
			do_action("legalpack_post_editor", $this);
			if (isset($this->_settings['filters'])) {
				foreach ($this->_settings['filters'] as $k => $v) {
					remove_filter($k, $v);
				}
			}
		}
	}
}