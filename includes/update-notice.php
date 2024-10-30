<?php
namespace legalpack\options {

	use legalpack\Legalpack;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/base-notice.php';

	class Update_Notice extends Base_Notice {

		protected $_duration;
		protected $_posts;
		protected $_message_multiple;

		function __construct () {
			parent::__construct( 'update_notice', 'legalpack-update-notice-container', 'legalpack-update-notice' );
			$this->_message_multiple = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_message_multiple' );

		}

		protected function get_posts () {
			$args = array (
				'post_type' => LEGALPACK_CPT,
				'post_status' => 'publish',
				'orderby' => 'post_modified',
				'date_query' => array (
					'column' => 'post_modified',
					'after' => '-' . $this->_duration . ' days',
				),
			);

			$posts = get_posts( $args );
			$this->_posts = array ();
			foreach ($posts as $post) {
				if ($post->post_modified == $post->post_date) {
					continue;
				}
				$t = get_post_modified_time( get_option( 'date_format' ), false, $post, true );
				if (!isset($this->_posts[$t])) {
					$this->_posts[$t] = array ();
				}
				$this->_posts[$t][] = $post;
			}
		}

		protected function print_box () {
			if (empty($this->_posts)) {
				return;
			}
			global $legalpack_post;
			global $legalpack_posts;
			foreach ($this->_posts as $date => $posts) {
				if (count( $posts ) > 1) {
					$legalpack_posts = array ();
					$legalpack_post = $posts[0];
					$cookie = array();
					$values = array();
					foreach ($posts as $post) {
						$modified = strtotime($post->post_modified);
						$tmp_cookie = 'legalpack-update-notice-' . $post->ID;
						if (!isset($_COOKIE[$tmp_cookie]) || ($_COOKIE[$tmp_cookie] != $modified)) {
							$cookie[] = $tmp_cookie;
							$values[] = $modified;
							$legalpack_posts[] = $post;
						}
					}
					if(!empty($legalpack_posts)) {
						Legalpack::template( 'update-notice', array (
							'cookie_name' => join(',', $cookie),
							'cookie_value' => join(',', $values),
							'message' => do_shortcode( $this->_message_multiple ),
							'close' => $this->_close_message,
						) );
					}
				} else if (count($posts)) {
					$post = $posts[0];
					$modified = strtotime($post->post_modified);
					$cookie = 'legalpack-update-notice-' . $post->ID;
					if (!isset($_COOKIE[$cookie]) || ($_COOKIE[$cookie] != $modified)) {
						$legalpack_post = $post;
						Legalpack::template( 'update-notice', array (
							'cookie_name' => $cookie,
							'cookie_value' => $modified,
							'message' => do_shortcode( $this->_message ),
							'close' => $this->_close_message,
						) );
					}
				}
			}
		}

		protected function get_data () {
			$this->_duration = intval( get_option( LEGALPACK_OPTION_PREFIX . 'update_notice_duration' ) );
			static::get_posts();
			if (empty($this->_posts)) {
				return false;
			}
			return true;
		}
	}
}
