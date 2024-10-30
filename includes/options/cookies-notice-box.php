<?php
namespace legalpack\options {

	use legalpack\Legalpack;
	use legalpack\Options;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/box.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/text-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/checkbox-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/color-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/choices-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/text-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/tag-option.php';

	class Cookies_Notice_Box extends Box {

		function empty_buttons ( $buttons ) {
			return array ();
		}

		function limited_buttons ( $buttons ) {
			return array (
				'bold',
				'italic',
				'underline',
				'bullist',
				'numlist',
				'link',
				'unlink',
			);
		}

		function shortcodes ( $option ) {
			Legalpack::template( 'shortcodes', array (
				'shortcodes' => array (
					__( 'site name', LEGALPACK_SLUG ) => '[legalpack site_name]',
					__( 'website URL', LEGALPACK_SLUG ) => '[legalpack site_url]',
					__( 'company name', LEGALPACK_SLUG ) => '[legalpack company_name]',
					__( 'country', LEGALPACK_SLUG ) => '[legalpack country]',
				),
				'option' => $option,
			) );
		}

		function define_options ( $page_id, $section_id ) {
			new Checkbox_Option( $this->id(), __( 'Enabled', LEGALPACK_SLUG ), $page_id, $section_id );
			new Choices_Option( $this->id().'_bar_position', __( 'Announcement bar position', LEGALPACK_SLUG ),
				array (
					'top' => __( 'top', LEGALPACK_SLUG ),
					'bottom' => __( 'bottom', LEGALPACK_SLUG ),
				), Choices_Option::TYPE_SELECT, $page_id, $section_id );
			new Choices_Option( $this->id().'_bar_type', __( 'Announcement bar type', LEGALPACK_SLUG ),
				array (
					'static' => __( 'static', LEGALPACK_SLUG ),
					'fixed' => __( 'fixed', LEGALPACK_SLUG ),
				), Choices_Option::TYPE_SELECT, $page_id, $section_id );
			/*
			new Choices_Combo_Option($this->id().'_offset', __( 'Announcement bar offset', LEGALPACK_SLUG ),
				array(
					' ' => __('default', LEGALPACK_SLUG),
					'5px' => '5px',
					'10px' => '10px',
					'15px' => '15px',
					'20px' => '20px',
					'25px' => '25px',
				), Choices_Combo_Option::TYPE_SELECT, $page_id, $section_id);
			*/
			new Choices_Option( $this->id().'_disable_logged', __( 'Disable for logged-in users', LEGALPACK_SLUG ),
				array (
					'yes' => __( 'yes', LEGALPACK_SLUG ),
					'no' => __( 'no', LEGALPACK_SLUG ),
				), Choices_Option::TYPE_SELECT, $page_id, $section_id );
			new Editor_Option( $this->id().'_message', __( 'Message', LEGALPACK_SLUG ),
				array (
					'drag_drop_upload' => false,
					'media_buttons' => false,
					'editor_height' => 150,
					'filters' => array (
						'mce_buttons' => array ( $this, 'limited_buttons' ),
						'mce_buttons_2' => array ( $this, 'empty_buttons' ),
						'mce_buttons_3' => array ( $this, 'empty_buttons' ),
						'mce_buttons_4' => array ( $this, 'empty_buttons' ),
						'legalpack_post_editor' => array ( $this, 'shortcodes' ),
					),
					'tinymce' => array (
						'resize' => false,
					),
				), $page_id, $section_id );
			new Text_Option( $this->id().'_close_message', __( 'Message for close button', LEGALPACK_SLUG ),
				Text_Option::TYPE_GENERIC, $page_id, $section_id );
			new Color_Option( $this->id().'_bg_color', __( 'Background color', LEGALPACK_SLUG ), $page_id, $section_id );
			new Choices_Combo_Option( $this->id().'_font', __( 'Font', LEGALPACK_SLUG ),
				Options::fonts(), Choices_Combo_Option::TYPE_SELECT, $page_id, $section_id );
			new Choices_Combo_Option( $this->id().'_font_size', __( 'Font size', LEGALPACK_SLUG ),
				Options::font_sizes(), Choices_Combo_Option::TYPE_SELECT, $page_id, $section_id );
			new Color_Option( $this->id().'_text_color', __( 'Text color', LEGALPACK_SLUG ), $page_id, $section_id );
			new Color_Option( $this->id().'_links_color', __( 'Links color', LEGALPACK_SLUG ), $page_id, $section_id );
		}

		public function defaults() {
			return array(
				$this->id()=>false,
				$this->id().'_bar_position'=>'top',
				$this->id().'_bar_type'=>'static',
				$this->id().'_disable_logged'=>'yes',
				$this->id().'_message'=>__('We use cookies to ensure that we give you the best experience on our website', LEGALPACK_SLUG),
				$this->id().'_close_message'=>__('Close', LEGALPACK_SLUG),
				$this->id().'_bg_color'=>'',
				$this->id().'_font'=>'',
				$this->id().'_font_size'=>'',
				$this->id().'_text_color'=>'',
				$this->id().'_links_color'=>'',
			);
		}
	}
}