<?php
namespace legalpack {

	use legalpack\options\ComplianceKits_Page;
	use legalpack\options\Settings_Page;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/settings-page.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/compliancekits-page.php';

	abstract class Options {

		static protected $_pages;
		const PAGE_PREFIX = 'legalpack_';

		static function font_sizes () {
			return array (
				' ' => __( 'default', LEGALPACK_SLUG ),
				'12px' => __( '12px', LEGALPACK_SLUG ),
				'13px' => __( '13px', LEGALPACK_SLUG ),
				'14px' => __( '14px', LEGALPACK_SLUG ),
				'15px' => __( '15px', LEGALPACK_SLUG ),
				'16px' => __( '16px', LEGALPACK_SLUG ),
			);
		}

		static function fonts () {
			return array (
				' ' => __( 'default', LEGALPACK_SLUG ),
				'Arial, sans-serif' => __( 'Arial, sans-serif', LEGALPACK_SLUG ),
				'Georgia, serif' => __( 'Georgia, serif', LEGALPACK_SLUG ),
			);
		}

		static function init () {
			static::$_pages = array (
				new ComplianceKits_Page( 'compliancekits', __( 'Compliance Kits', LEGALPACK_SLUG ) ),
				new Settings_Page( 'settings', __( 'Settings', LEGALPACK_SLUG ) ),
			);
			if(!get_option( LEGALPACK_OPTION_PREFIX . 'options_activated' )) {
				foreach (static::$_pages as $page) {
					foreach ($page->defaults() as $k=>$v) {
						add_option(LEGALPACK_OPTION_PREFIX . $k, $v);
					}
				}
				update_option( LEGALPACK_OPTION_PREFIX . 'options_activated', true );
			}
			add_action( 'admin_init', array ( __CLASS__, 'register_settings' ) );
			add_action( 'admin_menu', array ( __CLASS__, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array ( __CLASS__, 'enqueue_scripts' ) );
		}

		static function register_settings () {
			foreach (static::$_pages as $page) {
				$page->define_options();
			}
		}

		static function admin_menu () {
			foreach (static::$_pages as $page) {
				$page->register_menu();
			}
		}

		static function enqueue_scripts ( $page ) {
			$prefix = LEGALPACK_CPT . '_page_';
			if (0 != strncmp( $page, $prefix, strlen( $prefix ) )) {
				return;
			}
			$page = substr( $page, strlen( $prefix ) );
			foreach (static::$_pages as $p) {
				if ($p->id() == $page) {
					$p->enqueue_scripts();
				}
			}
		}
	}
}