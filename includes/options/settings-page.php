<?php
namespace legalpack\options {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/page.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/text-option.php';

	class Settings_Page extends Page {

		function define_options () {
			parent::define_options();
			new Text_Option( 'site_name',
				__( 'Website name', LEGALPACK_SLUG ),
				'shortcode-entry-option',
				$this->id(), static::SECTION_ID );
			new Text_Option( 'site_url',
				__( 'Website URL', LEGALPACK_SLUG ),
				'shortcode-entry-option',
				$this->id(), static::SECTION_ID );
			new Text_Option( 'company_name',
				__( 'Company name', LEGALPACK_SLUG ),
				'shortcode-entry-option',
				$this->id(), static::SECTION_ID );
			new Text_Option( 'country',
				__( 'Country', LEGALPACK_SLUG ),
				'shortcode-entry-option',
				$this->id(), static::SECTION_ID );
		}

		public function defaults () {
			return array (
				'site_name' => get_option( 'blogname' ),
				'site_url' => get_option( 'siteurl' ),
				'company_name' => get_option( 'blogname' ),
				'country' => '',
			);
		}

		function register_menu () {
//             add_submenu_page( 'edit.php?post_type=' . LEGALPACK_CPT,
//                 $this->title(),
//                 __( 'Settings', LEGALPACK_SLUG ),
//                 'manage_options',
//                 $this->id(),
//                 array ( $this, 'render' )
//             );
		}
	}
}