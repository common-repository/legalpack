<?php
namespace legalpack\options {

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	abstract class Base_Notice {

		protected $_where;
		protected $_type;
		protected $_message;
		protected $_close_message;
		protected $_skip;
		protected $_id;
		protected $_tag;
		protected $_container;
		protected $_element;

		function __construct ( $id, $container_class, $element_class ) {
			$this->_id = $id;
			$this->_tag = str_replace( '_', '-', $this->_id );
			$this->_container = $container_class;
			$this->_element = $element_class;
			if (!get_option( LEGALPACK_OPTION_PREFIX . $this->_id )) {
				return;
			}
			$this->_skip = false;
			add_action( 'wp_head', array ( $this, 'head' ) );
			add_action( 'wp_print_styles', array ( $this, 'print_styles' ) );
			add_action( 'wp_enqueue_scripts', array ( $this, 'enqueue_scripts' ) );
			add_action( LEGALPACK_SLUG . '_container', array ( $this, 'container' ), 10, 2 );

			$this->_type = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_bar_type' );
			$this->_where = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_bar_position' );
			$this->_message = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_message' );
			$this->_close_message = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_close_message',
				__( 'Close', LEGALPACK_SLUG ) );
		}

		function enqueue_scripts () {
			if ($this->_skip) {
				return;
			}
			wp_enqueue_script( LEGALPACK_SLUG . '_js',
				LEGALPACK_PLUGIN_URL . 'js/legalpack.js',
				false,
				false,
				true );
		}

		abstract protected function get_data ();

		function head () {
			$disable_logged = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_disable_logged' );
			if (($disable_logged == 'yes') && \is_user_logged_in()) {
				$this->_skip = true;
				return;
			}

			if (!$this->get_data()) {
				$this->_skip = true;
			}
		}

		function print_styles () {
			if ($this->_skip) {
				return;
			}
			// TODO: refactor
			$font_size = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_font_size' );
			$font = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_font' );
			$text_color = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_text_color' );
			$links_color = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_links_color' );
			$bg_color = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_bg_color' );
/*
			$offset = get_option( LEGALPACK_OPTION_PREFIX . $this->_id . '_offset' );
			if (empty($offset)) {
				$offset = '0';
			}
*/
			$style = '';
			$links_style = '';

			if (!empty($bg_color)) {
				$style .= 'background-color:' . $bg_color . ' !important;';
			}
			if (!empty($font)) {
				$style .= 'font-family:' . $font . ' !important;';
				$links_style .= 'font-family:' . $font . ' !important;';
			}
			if (!empty($font_size)) {
				$style .= 'font-size:' . $font_size . ' !important;';
				$links_style .= 'font-size:' . $font_size . ' !important;';
			}
			if (!empty($text_color)) {
				$style .= 'color:' . $text_color . ' !important;';
			}
			if (!empty($links_color)) {
				$links_style .= 'color:' . $links_color . ' !important;';
			}
			if (empty($container_style) && empty($links_style) && empty($style)) {
				return;
			}

			echo "<style type=\"text/css\" media=\"all\">\n";
			if (!empty($container_style)) {
				?>
				.<?php echo esc_attr( $this->_container ); ?> {
				<?php echo esc_js( $container_style ); ?>

				}
				<?php
			}
			if (!empty($links_style)) {
				?>
				.<?php echo esc_attr( $this->_element ); ?> a {
				<?php echo esc_js( $links_style ); ?>

				}
				<?php
			}
			if (!empty($style)) {
				?>
				.<?php echo esc_attr( $this->_element ); ?> {
				<?php echo esc_js( $style ); ?>

				}
				<?php
			}
			echo "</style>\n";
		}

		function container ($where, $type) {
			if($this->_skip) {
				return;
			}
			if (($this->_where == $where) && ($this->_type == $type)) {
				$this->print_box();
			}
		}

		abstract protected function print_box ();
	}
}
