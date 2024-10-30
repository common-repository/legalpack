<?php
/*

Plugin Name: Legalpack by TermsFeed
Plugin URI: https://termsfeed.com
Description: Create Terms & Conditions, Privacy Policy for your WordPress. Add disclaimers for affiliate links. And more.
Author: TermsFeed
Author URI: https://termsfeed.com/
Version: 1.0.2
License: GPLv2 or later
Text Domain: legalpack
*/

/*

Copyright 2016-2017 TermsFeed

*/

/*

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

namespace legalpack {

	use legalpack\options\Cookies_Notice;
	use legalpack\options\Update_Notice;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	define( 'LEGALPACK_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
	define( 'LEGALPACK_PLUGIN_DIR', dirname( __FILE__ ) . '/' );
	define( 'LEGALPACK_TAG', 'legalpack' );
	define( 'LEGALPACK_SLUG', 'legalpack' );
	define( 'LEGALPACK_OPTION_PREFIX', LEGALPACK_SLUG . '_options_' );
	define( 'LEGALPACK_LEGAL_PAGES_DIR', 'legal-pages/' );

	if (defined( 'WP_UNINSTALL_PLUGIN' )) {
		return;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/shortcodes.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/cpt.php';

	abstract class Legalpack {

		const version = '1.0';
		protected static $_legal_pages;

		static function init () {
			static::$_legal_pages = array (
				'terms-and-conditions' => __( 'Terms and Conditions', LEGALPACK_SLUG ),
				'privacy-policy' => __( 'Privacy Policy', LEGALPACK_SLUG ),
				'cookies-policy' => __( 'Cookies Policy', LEGALPACK_SLUG ),
			);
			add_action( 'init', array ( __CLASS__, 'action_init' ) );
			add_action( 'plugins_loaded', array ( __CLASS__, 'init_translations' ), 5 );
			register_deactivation_hook( __FILE__, 'deactivate' );
			CPT::init();
			Shortcodes::init();
			if (is_admin()) {
				return;
			}
			add_action( 'wp_enqueue_scripts', array ( __CLASS__, 'enqueue_scripts' ) );
			add_action( 'wp_print_styles', array ( __CLASS__, 'print_styles' ) );
			add_action( 'the_content', array ( __CLASS__, 'append_disclaimer' ) );
			add_action( 'wp_head', array ( __CLASS__, 'head' ), 100002 );
			add_action( 'wp_footer', array ( __CLASS__, 'footer' ), 100002 );
			require_once LEGALPACK_PLUGIN_DIR . 'includes/update-notice.php';
			new Update_Notice();
			require_once LEGALPACK_PLUGIN_DIR . 'includes/cookies-notice.php';
			new Cookies_Notice();
		}

		static function get_legal_pages () {
			return static::$_legal_pages;
		}

		static function init_translations () {
			load_plugin_textdomain( LEGALPACK_SLUG,
				false,
				LEGALPACK_PLUGIN_DIR . 'languages/' );
		}


		static function action_init () {
			CPT::register();
			if (!get_option( LEGALPACK_OPTION_PREFIX . 'activated' )) {
				flush_rewrite_rules();
				update_option( LEGALPACK_OPTION_PREFIX . 'activated', true );
			}
			if (!is_admin()) {
				return;
			}
			require_once LEGALPACK_PLUGIN_DIR . 'includes/admin.php';
			Admin::init();
		}

		static function enqueue_scripts () {
			wp_register_style( LEGALPACK_SLUG . '_css',
				LEGALPACK_PLUGIN_URL . 'css/legalpack.css',
				false );
			wp_enqueue_style( LEGALPACK_SLUG . '_css' );
		}

		static function template ( $__template, $args = array (), $__to_buffer = false ) {

			if (!$__template) {
				return false;
			}

			extract( $args );
			$__path = LEGALPACK_PLUGIN_DIR . 'templates/' . $__template . '.php';

			if ($__to_buffer) {
				ob_start();
			}
			include $__path;
			if ($__to_buffer) {
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}

			return true;
		}

		static function deactivate () {
			update_option( LEGALPACK_OPTION_PREFIX . 'activated', false );
			flush_rewrite_rules();
		}

		static function head () {
			ob_start();
		}

		static function footer () {
			$c = ob_get_contents();
			preg_match( '/(.*<\s*body[^>]*>)(.*)/is', $c, $m );
			ob_end_clean();
			if (count( $m ) < 3) {
				// NOTE: HTML is not well formed, we can only detect a closing body
				echo $c;
				static::top_container();
				static::bottom_container();
				return;
			}
			echo $m[1];
			static::top_container();
			echo $m[2];
			static::links_box();
			static::bottom_container();
		}

		static protected function container ( $where, $type ) {
			ob_start();
			do_action( LEGALPACK_SLUG . '_container', $where, $type );
			$c = ob_get_contents();
			ob_end_clean();
			if (!empty( $c )) {
				echo '<div id="legalpack-' . $where . '-' . $type . '-container">' . $c . '</div>';
			}
		}

		static protected function top_container () {
			static::container( 'top', 'static' );
			static::container( 'top', 'fixed' );
		}

		static protected function bottom_container () {
			static::container( 'bottom', 'fixed' );
			static::container( 'bottom', 'static' );
		}

		static protected function links_box () {
			if (!get_option( LEGALPACK_OPTION_PREFIX . 'links' )) {
				return;
			}
			static::template( 'links' );
		}

		static function print_styles () {
			if (!get_option( LEGALPACK_OPTION_PREFIX . 'links' )) {
				return;
			}
			// TODO: refactor
			$footer_style = '';
			$style = '';
			$separator_style = '';

			$font_size = get_option( LEGALPACK_OPTION_PREFIX . 'links_font_size' );
			$font = get_option( LEGALPACK_OPTION_PREFIX . 'links_font' );
			$text_color = get_option( LEGALPACK_OPTION_PREFIX . 'links_text_color' );
			$links_color = get_option( LEGALPACK_OPTION_PREFIX . 'links_links_color' );
			$bg_color = get_option( LEGALPACK_OPTION_PREFIX . 'links_bg_color' );
			$align = get_option( LEGALPACK_OPTION_PREFIX . 'links_text_align' );

			if (!empty( $bg_color )) {
				$footer_style .= 'background-color:' . $bg_color . ' !important;';
			}
			if (!empty( $align )) {
				$footer_style .= 'text-align:' . $align . ' !important;';
			}
			if (!empty( $font )) {
				$style .= 'font-family:' . $font . ' !important;';
				$separator_style .= 'font-family:' . $font . ' !important;';
			}
			if (!empty( $font_size )) {
				$style .= 'font-size:' . $font_size . ' !important;';
				$separator_style .= 'font-size:' . $font_size . ' !important;';
			}
			if (!empty( $text_color )) {
				$separator_style .= 'color:' . $text_color . ' !important;';
			}
			if (!empty( $links_color )) {
				$style .= 'color:' . $links_color . ' !important;';
			}

			if (empty( $footer_style ) && empty( $style ) && empty( $separator_style )) {
				return;
			}

			echo "<style type=\"text/css\" media=\"all\">\n";
			if (!empty( $footer_style )) {
				?>
                .legalpack-footer {
				<?php echo esc_js( $footer_style ); ?>

                }
				<?php
			}
			if (!empty( $style )) {
				?>
                .legalpack-footer a {
				<?php echo esc_js( $style ); ?>

                }
				<?php
			}
			if (!empty( $separator_style )) {
				?>
                .legalpack-footer .separator{
				<?php echo esc_js( $separator_style ); ?>

                }
				<?php
			}
			echo "</style>\n";
		}

		static function append_disclaimer ( $content ) {
			if (!is_singular( 'post' )) {
				return $content;
			}
			$post = get_post();
			if (empty( $post )) {
				return $content;
			}
			if (!get_option( LEGALPACK_OPTION_PREFIX . 'endorsements' )) {
				return $content;
			}
			$when = get_option( LEGALPACK_OPTION_PREFIX . 'endorsements_when' );
			if ($when == 'never') {
				return $content;
			}
			$where = get_option( LEGALPACK_OPTION_PREFIX . 'endorsements_where' );
			if ($when == 'if_tag') {
				$tag = get_option( LEGALPACK_OPTION_PREFIX . 'endorsements_tag' );
				$tags = wp_get_object_terms( $post->ID, 'post_tag' );
				$tags = array_map( function ( $x ) {
					return $x->term_id;
				}, $tags );
				if (!in_array( $tag, $tags )) {
					return $content;
				}
			}
			$message = get_option( LEGALPACK_OPTION_PREFIX . 'endorsements_message' );
			if ($where == 'bottom') {
				return $content . $message;
			}
			return $message . $content;
		}

	}

	Legalpack::init();
}