<?php

namespace legalpack\options {

	use legalpack\Legalpack;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	abstract class Option {
		protected $_name;
		protected $_section_id;
		protected $_page_id;
		protected $_label;
		protected $_template;
		protected $_dep_source = false;
		protected $_dep_value = false;
		protected $_dep_type = false;

		function __construct ( $name, $label, $page_id, $section_id ) {
			$this->_name = LEGALPACK_OPTION_PREFIX . $name;
			$this->_section_id = $section_id;
			$this->_page_id = $page_id;
			$this->_label = $label;

			add_settings_field( $this->_name,
				$this->_label,
				array ( $this, 'render' ),
				$this->_page_id,
				$this->_section_id );
			register_setting( $this->_page_id, $this->_name, array ( $this, 'sanitize' ) );
		}

		function get_value () {
			return get_option( $this->_name );
		}

		function render () {
			if(!empty($this->_dep_source)) {
				$this->_handle_render( 'options/dependency-begin', array (
					'dep_source' => $this->_dep_source,
					'dep_value' => $this->_dep_value,
					'dep_type' => $this->_dep_type,
				) );
			}
			$this->_handle_render('options/' . $this->_template, array (
				'name' => $this->_name,
				'value' => $this->get_value(),
			));
			if(!empty($this->_dep_source)) {
				$this->_handle_render( 'options/dependency-end', array () );
			}
		}

		protected function _handle_render($template, $args) {
			Legalpack::template( $template, $args );
		}

		abstract function sanitize ( $input );
		
		function set_dependency($source, $value, $type) {
			$this->_dep_source = LEGALPACK_OPTION_PREFIX . $source;
			$this->_dep_value = $value;
			$this->_dep_type = $type;
		}

		public function name () {
			return $this->_name;
		}
	}
}