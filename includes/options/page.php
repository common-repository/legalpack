<?php
namespace legalpack\options {

	use legalpack\Legalpack;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	abstract class Page {
		const SECTION_ID = 'section';

		private $_id;
		protected $_title;
		protected $_options;
		
		function __construct ($id, $title) {
			$this->_id = $id;
			$this->_title = $title;
		}

		function define_options(){
			add_settings_section( static::SECTION_ID,
				false,
				false,
				$this->id() );
		}

		abstract public function register_menu();
		
		abstract public function defaults();

		function enqueue_scripts() {}

		function render() {
			Legalpack::template('options/'.$this->_id.'-page', array(
				'page' => $this,
			));
		}

		public function title () {
			return $this->_title;
		}

		public function id () {
			// TODO: move out prefixing
			return LEGALPACK_SLUG . '_' . $this->_id;
		}
	}

}
