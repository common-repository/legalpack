<?php

namespace legalpack\shortcode {

	if (!defined ('ABSPATH')) {
		exit;
	}

	class Shortcode {
		protected $_name;
		protected $_subs = array();
		protected $_default_handler;

		function __construct ($name, $default_handler=false) {
			$this->_name = $name;
			$this->_default_handler = $default_handler;
			add_shortcode ($this->name(), array ($this, 'handle'));
		}

		function handle ($values, $content) {
			if (isset($values[0]) && isset($this->_sub[$values[0]])) {
				return $this->_sub[$values[0]]->handle($values, $content);
			}
			if($this->_default_handler) {
				return $this->_default_handler->handle( $values, $content );
			}
			return '';
		}

		function add_subshortcode ($sub) {
			$this->_sub[$sub->name()] = $sub;
		}

		function remove_subshortcode ($sub) {
			unset($this->_sub[$sub->name ()]);
		}

		function name () {
			return $this->_name;
		}
	}
}