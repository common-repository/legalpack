<?php
namespace legalpack\options {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/page.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/links-box.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/endorsements-box.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/update-notice-box.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/cookies-notice-box.php';

	class ComplianceKits_Page extends Page {

		protected $_boxes;
		protected $_box = false;

		function __construct ( $id, $title ) {
			parent::__construct( $id, $title );
			$this->_boxes = array (
				new Links_Box( 'links',
					__( 'Links to Legal Pages', LEGALPACK_SLUG ),
					__( 'Append links to your legal pages in the footer section of your website.', LEGALPACK_SLUG )
				),
				new Update_Notice_Box( 'update_notice',
					__( 'Update Notices of Legal Pages', LEGALPACK_SLUG ),
					__( 'Inform users when your legal pages have been updated.', LEGALPACK_SLUG )
				),
				new Cookies_Notice_Box( 'cookies_notice',
					__( 'Cookies Notice', LEGALPACK_SLUG ),
					__( 'Inform users that you are using cookies through your website.', LEGALPACK_SLUG )
				),
				new Endorsements_Box( 'endorsements',
					__( 'Endorsements', LEGALPACK_SLUG ),
					__( 'Inform users that your website may contain endorsements through disclaimers.', LEGALPACK_SLUG )
				),
			);
			if (isset($_REQUEST['box'])) {
				foreach ($this->boxes() as &$box) {
					if ($box->id() == $_REQUEST['box']) {
						$this->_box = $box;
					}
				}
			}
		}
		
		public function defaults() {
			$ret = array();
			foreach ($this->_boxes as $box) {
				$ret = array_merge($ret, $box->defaults());
			}
			return $ret;
		}

		function enqueue_scripts () {
			if (!$this->_box) {
				wp_enqueue_script( LEGALPACK_SLUG . '_compliancekits_page',
					LEGALPACK_PLUGIN_URL . 'js/compliancekits-page.js',
					false,
					false,
					true );
			} else {
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( LEGALPACK_SLUG . '_box_page',
					LEGALPACK_PLUGIN_URL . 'js/box-page.js',
					array ( 'wp-color-picker' ),
					false,
					true );
			}
		}

		function render () {
			if ($this->_box) {
				$this->_box->render_page( $this );
			} else {
				parent::render();
			}
		}

		function register_menu () {
			add_submenu_page( 'edit.php?post_type=' . LEGALPACK_CPT,
				$this->title(),
				__( 'Compliance Kits', LEGALPACK_SLUG ),
				'manage_options',
				$this->id(),
				array ( $this, 'render' )
			);
		}

		function boxes () {
			return $this->_boxes;
		}

		function define_options () {
			parent::define_options();
			if ($this->_box) {
				$this->_box->define_options( $this->id(), static::SECTION_ID );
			}
		}
	}
}

?>