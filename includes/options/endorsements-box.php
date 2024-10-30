<?php
namespace legalpack\options {

	use legalpack\Legalpack;

	if (!defined( 'ABSPATH' )) {
		exit;
	}

	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/box.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/text-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/checkbox-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/color-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/choices-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/editor-option.php';
	require_once LEGALPACK_PLUGIN_DIR . 'includes/options/tag-option.php';

	class Endorsements_Box extends Box {

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
        
        function disclaimer_promo_link() {
            echo '<br />';
            echo '<p>Use the <a href="https://termsfeed.com/disclaimer/generator/?utm_source=legalpack-plugin-disclaimer-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-disclaimer-page">Disclaimer Generator from TermsFeed</a> to <strong>create a professional Disclaimer</strong> with more clauses to protect your website.</p>';
            echo '<p><a href="https://termsfeed.com/disclaimer/generator/?utm_source=legalpack-plugin-disclaimer-page&utm_campaign=legalpack-plugin&utm_medium=legalpack-plugin-dashboard-page&utm_content=dashboard-disclaimer-page" class="button">Visit TermsFeed.com</a></p>';
            echo '<br />';
        }

		function define_options ( $page_id, $section_id ) {
			new Checkbox_Option( $this->id(), __( 'Enabled', LEGALPACK_SLUG ), $page_id, $section_id );
			new Editor_Option( $this->id() . '_message', __( 'Disclaimer message', LEGALPACK_SLUG ),
				array (
					'drag_drop_upload' => false,
					'media_buttons' => false,
					'editor_height' => 150,
					'filters' => array (
						'mce_buttons' => array ( $this, 'limited_buttons' ),
						'mce_buttons_2' => array ( $this, 'empty_buttons' ),
						'mce_buttons_3' => array ( $this, 'empty_buttons' ),
						'mce_buttons_4' => array ( $this, 'empty_buttons' ),
                        // 'legalpack_post_editor' => array ( $this, 'shortcodes' ),
                        'legalpack_post_editor' => array($this, 'disclaimer_promo_link'),
					),
					'tinymce' => array (
						'resize' => false,
					),
				), $page_id, $section_id );
			new Choices_Option( $this->id() . '_when', __( 'When to insert the disclaimer note', LEGALPACK_SLUG ),
				array (
					' ' => __( 'always', LEGALPACK_SLUG ),
					'if_tag' => __( 'if tag exists on a post', LEGALPACK_SLUG ),
				), Choices_Option::TYPE_SELECT, $page_id, $section_id );

			$t = new Tag_Option( $this->id() . '_tag', '',
				Tag_Option::TYPE_TAG, $page_id, $section_id );
			$t->set_dependency( $this->id() . '_when', 'if_tag', 'show' );

			new Choices_Option( $this->id().'_where', __( 'Where to insert the disclaimer note', LEGALPACK_SLUG ),
				array (
					' ' => __( 'at the top of the post (before post content)', LEGALPACK_SLUG ),
					'bottom' => __( 'at the bottom of the post (after post content)', LEGALPACK_SLUG ),
				), Choices_Option::TYPE_SELECT, $page_id, $section_id );
		}

		public function defaults () {
			return array (
				$this->id() => false,
				$this->id() . '_message' => '',
				$this->id() . '_when' => '',
				$this->id() . '_tag' => '',
				//$this->id().'_where'=>'',
			);
		}
	}
}