<?php
namespace legalpack\options {

	use legalpack\Options;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/box.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/text-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/checkbox-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/color-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/choices-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/choices-combo-option.php';

	class Links_Box extends Box {

		function define_options ( $page_id, $section_id ) {
			new Checkbox_Option($this->id(), __( 'Enabled', LEGALPACK_SLUG ), $page_id, $section_id);
			new Color_Option($this->id().'_bg_color', __( 'Background color', LEGALPACK_SLUG ), $page_id, $section_id);
			new Choices_Combo_Option($this->id().'_font', __( 'Font', LEGALPACK_SLUG ),
				Options::fonts(), Choices_Combo_Option::TYPE_SELECT, $page_id, $section_id);
			new Choices_Combo_Option($this->id().'_font_size', __( 'Font size', LEGALPACK_SLUG ),
				Options::font_sizes(), Choices_Combo_Option::TYPE_SELECT, $page_id, $section_id);
			new Color_Option($this->id().'_text_color', __( 'Text color', LEGALPACK_SLUG ), $page_id, $section_id);
			new Choices_Option($this->id().'_text_align', __( 'Text alignment', LEGALPACK_SLUG ),
				array(
					' ' => __('default', LEGALPACK_SLUG),
					'center' => __('center', LEGALPACK_SLUG),
					'right' => __('right', LEGALPACK_SLUG),
					'left' => __('left', LEGALPACK_SLUG),
				), Choices_Option::TYPE_SELECT, $page_id, $section_id);
			new Color_Option($this->id().'_links_color', __( 'Links color', LEGALPACK_SLUG ), $page_id, $section_id);
			new Text_Option($this->id().'_separator',
				__( 'Links separator', LEGALPACK_SLUG ),
				Text_Option::TYPE_GENERIC,
				$page_id, $section_id);
		}

		public function defaults() {
			return array(
				$this->id()=>true,
				$this->id().'_bg_color'=>'#ffffff',
				$this->id().'_font'=>'Arial, sans-serif',
				$this->id().'_font_size'=>'14px',
				$this->id().'_text_color'=>'#cccccc',
				$this->id().'_text_align'=>'center',
				$this->id().'_links_color'=>'#000000',
				$this->id().'_separator'=>'-',
			);
		}
	}
}