<?php

namespace legalpack {
	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/admin-columns.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options.php';

	abstract class Admin {
		static function init () {
			add_action( 'add_meta_boxes', array ( __CLASS__, 'add_meta_boxes' ) );
			add_action( 'admin_enqueue_scripts', array ( __CLASS__, 'enqueue_scripts' ) );
			add_filter( 'post_row_actions', array ( __CLASS__, 'row_actions' ), 10, 2 );
			add_filter( 'get_sample_permalink_html', array ( __CLASS__, 'remove_permalink' ), 10, 5 );
			add_action( 'edit_form_top', array ( __CLASS__, 'edit_form_top' ) );
			add_action( 'save_post', array ( __CLASS__, 'save_post' ) );

			Admin_Columns::init();
			Options::init();
		}

		static function add_meta_boxes () {
			global $post;

			if (empty($post) || ($post->post_type != LEGALPACK_CPT)) {
				return;
			}

			remove_meta_box( 'slugdiv', $post->post_type, 'normal' );

			if ($post->post_status == 'auto-draft') {

			}
		}

		static function remove_permalink ( $permalink, $post_id, $new_title, $new_slug, $post ) {
			if ($post->post_type != LEGALPACK_CPT) {
				return $permalink;
			}

			return '';
		}

		static function edit_form_top ( $post ) {
			if ($post->post_type != LEGALPACK_CPT) {
				return;
			}

			if ($post->post_status == 'auto-draft') {
				global $wpdb;
				$cpt = LEGALPACK_CPT;
				$cases = '';
				foreach (Legalpack::get_legal_pages() as $k => $v) {
					$cases[] = "SUM(CASE WHEN $wpdb->posts.post_name LIKE '$k%' THEN 1 ELSE 0 END) as '$k'";
				}
				$cases = join( ',', $cases );
				$query = "SELECT $cases FROM $wpdb->posts WHERE $wpdb->posts.post_type = '$cpt'";
				$pages_by_type = $wpdb->get_results( $query, ARRAY_A );
				$pages_by_type = $pages_by_type[0];
				Legalpack::template( 'auto-draft', compact( 'pages_by_type' ) );
			}
		}

		static function row_actions ( $actions, $post ) {

			if ((LEGALPACK_CPT == get_post_type( $post )) && ($post->post_status == 'publish')) {
				$link = get_post_permalink( $post->ID );
				$short_link = preg_replace( '/https?:\/\//i', '', trim( $link, '/' ) );
				$info = '<a href="' . $link . '">' . $short_link . '</a>';
				array_unshift( $actions, '<div class="inline-row-action-summary">' . $info . '</div>' );
			}

			return $actions;
		}

		static function enqueue_scripts ( $page ) {
			if ($page == 'edit.php') {
				global $post;
				if (!empty($post) && ($post->post_type == LEGALPACK_CPT)) {
					wp_enqueue_script( LEGALPACK_SLUG . '_row_actions',
						LEGALPACK_PLUGIN_URL . 'js/row-actions.js',
						false,
						false,
						true );
				}
			}
			$prefix = LEGALPACK_SLUG . '_';
			if (strncmp( $page, $prefix, strlen( $prefix ) ) != 0) {
				return;
			}
			wp_register_style( LEGALPACK_SLUG . '_admin_css',
				LEGALPACK_PLUGIN_URL . 'css/admin.css',
				false );
			wp_enqueue_style( LEGALPACK_SLUG . '_admin_css' );

		}

		static function sanitize ( $s ) {
			if (!is_array( $s )) {
				return sanitize_text_field( $s );
			}
			$r = array ();
			foreach ($s as $k => $v) {
				// NOTE: forbid nested arrays
				if (is_array( $v )) {
					$r[$k] = '';
				} else {
					$r[$k] = sanitize_text_field( $v );
				}
			}
			return $r;
		}

		static function save_post ( $post_id ) {
			$post = get_post( $post_id );
			if ((LEGALPACK_CPT != $post->post_type) || !isset($_POST['legal_page'])) {
				return;
			}
			$pages = Legalpack::get_legal_pages();
			$legal_page = sanitize_text_field( $_POST['legal_page'] );
			if (!isset($pages[$legal_page])) {
				return;
			}
			$args = array_map( function ( $v ) {
				if ($v == 'legal-page-radio-yes') {
					return true;
				} else {
					if ($v == 'legal-page-radio-no') {
						return false;
					}
				}

				return Admin::sanitize( $v );
			}, $_POST );
			$content = Legalpack::template( 'legal-pages/pages/' . $legal_page, $args, true );
			remove_action( 'save_post', array ( __CLASS__, 'save_post' ) );
			wp_update_post( array (
				'ID' => $post_id,
				'post_content' => $content,
				'post_title' => $pages[$legal_page],
				'post_name' => $legal_page,
			) );
		}
	}
}