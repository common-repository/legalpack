<?php

namespace legalpack {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/shortcode.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/sub-shortcode.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/last-updated.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/post-data.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/post-link.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/post-links.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcode/post-titles.php';

	abstract class Shortcodes {

		protected static $_root;

		static function init () {
			$default_handler = new shortcode\Option( array ( __CLASS__, 'get_option' ) );
			static::$_root = new shortcode\Shortcode( LEGALPACK_SLUG, $default_handler );
			static::$_root->add_subshortcode( new shortcode\Last_Updated( 'last_updated_date' ) );
			static::$_root->add_subshortcode( new shortcode\Post_Data( 'page_title', 'post_title' ) );
			static::$_root->add_subshortcode( new shortcode\Post_Link( 'page_link' ) );
			static::$_root->add_subshortcode( new shortcode\Post_Titles( 'page_titles' ) );
			static::$_root->add_subshortcode( new shortcode\Post_Links( 'page_links' ) );
		}

		static function get_option ($name) {
			return get_option(LEGALPACK_OPTION_PREFIX . $name);
		}
	}
}