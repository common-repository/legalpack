<?php
namespace legalpack\options {

	use legalpack\Legalpack;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	abstract class Box {
		protected $_id;
		protected $_title;
		protected $_infotip;

		function __construct ( $id, $title, $infotip ) {
			$this->_id = $id;
			$this->_title = $title;
			$this->_infotip = $infotip;
			add_action( 'wp_ajax_legalpack_' . $this->enable_action_id(), array ( $this, 'toggle_enabled' ) );
		}

		public function enable_action_id () {
			return 'enable_' . $this->id() . '_toggle';
		}

		public function id () {
			return $this->_id;
		}

		public function title () {
			return $this->_title;
		}

		public function infotip () {
			return $this->_infotip;
		}

		protected function _toggle_button_text ( $value ) {
			return $value ? __( 'Disable', LEGALPACK_SLUG ) : __( 'Enable', LEGALPACK_SLUG );
		}

		function render () {
			$v = get_option( $this->_enabled_option(), false );
			Legalpack::template( 'options/box', array (
				'box' => $this,
				'enable_button_text' => $this->_toggle_button_text( $v ),
				// NOTE: keep strings inside __() not to break text-domain parser
				'status_text' => $v ? __( 'Enabled', LEGALPACK_SLUG ) : __( 'Disabled', LEGALPACK_SLUG ),
			) );
		}

		function render_page ( $page ) {
			Legalpack::template( 'options/box-page', array (
				'title' => $this->title(),
				'page_id' => $page->id(),
				'box_id' => $this->id(),
			) );
		}

		protected function _enabled_option () {
			return LEGALPACK_OPTION_PREFIX . $this->id();
		}

		abstract public function defaults();
		
		function toggle_enabled () {
			if (!current_user_can( 'manage_options' )) {
				wp_die( __( 'Restricted', LEGALPACK_SLUG ) );
			}
			check_ajax_referer(LEGALPACK_SLUG . '_toggle_box', 'nonce');
			$option_name = $this->_enabled_option();
			$option = !boolval( get_option( $option_name, false ) );
			update_option( $option_name, $option );

			wp_send_json( array ( 'status' => 'success',
					'message' => '',
					'button_text' => $this->_toggle_button_text( $option ),
					'status_text' => $option ? __( 'Enabled', LEGALPACK_SLUG ) : __( 'Disabled', LEGALPACK_SLUG ),
					'notice_text' => $this->title() . ' ' . ($option ? __( 'enabled.', LEGALPACK_SLUG ) : __( 'disabled.', LEGALPACK_SLUG )),
				)
			);
		}

		abstract function define_options ( $page_id, $section_id );
	}

}
