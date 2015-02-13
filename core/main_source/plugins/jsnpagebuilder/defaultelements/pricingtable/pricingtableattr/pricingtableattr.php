<?php
/**
 * @version    $Id$
 * @package    JSN_PageBuilder
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

	class JSNPBShortcodePricingtableattrItem extends IG_Pb_Child {

		/**
		 * element constructor
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			parent::__construct();


		}

		/**
		 * element config
		 * @see    WR_Element::element_config()
		 * @access public
		 * @return void
		 */
		public function element_config() {
			$this->config['shortcode'] = 'pb_pricingtableattr_item';
			$this->config['exception'] = array(
				'item_text'                 => JText::_( 'Attribute'),
				'data-modal-title'          => JText::_( 'Attribute'),
				'disable_preview_container' => '1',
				'edit_using_ajax'           => '1'
			);
		}

		/**
		 * element items
		 *
		 * @see    WR_Element::element_items()
		 * @access public
		 * @return array
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
					array(
						'id'              => 'prtbl_item_attr_id',
						'type'            => 'text_field',
						'std'             => 'attr_' . JSNPagebuilderHelpersShortcode::generateRandomString(),
						'input-type'      => 'hidden',
						'container_class' => 'hidden',
					),
					array(
						'name'    => JText::_( 'Title'),
						'id'      => 'prtbl_item_attr_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'role'    => 'title',
						'std'     => JText::_( 'Attribute PB_INDEX_TRICK' ),
						'tooltip' => JText::_( 'Title'),
					),
					array(
						'name'    => JText::_( 'Description'),
						'id'      => 'prtbl_item_attr_desc',
						'type'    => 'text_area',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => '',
						'tooltip' => JText::_( 'Description'),
						'exclude_quote' => '1',
					),
					array(
						'name'    => JText::_( 'Type'),
						'id'      => 'prtbl_item_attr_type',
						'type'    => 'select',
						'class'   => 'input-sm',
						'std'     => '',
						'options' => JSNPagebuilderHelpersType::getSubItemPricingType(),
						'tooltip' => JText::_( 'Type')
					),
				)
			);

		}

		/**
		 * element shortcode
		 *
		 * @see    WR_Element::element_shortcode( $atts, $content )
		 * @access public
		 * @return string
		 */
		public function element_shortcode( $atts = null, $content = null ) {
			$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts );
			extract( $arr_params );

			$html_element = '<li>
				<label data-original-title="' . $prtbl_item_attr_desc . '" class="pb-prtbl-tipsy">' . $prtbl_item_attr_title . '</label>
			</li>';

			return $html_element;
		}

		/**
		 * DEFINE html structure of shortcode in Page Builder area
		 *
		 * @param type $content
		 * @param type $shortcode_data: string stores params ( which is modified default value ) of shortcode
		 * @param type $el_title: Element Title used to identifying elements in Pagebuilder
		 * Ex:  param-tag=h6&param-text=Your+heading&param-font=custom&param-font-family=arial
		 * @return type
		 */
		public function element_in_pgbldr( $content = '', $shortcode_data = '', $el_title = '' ) {
			$html = parent::element_in_pgbldr( $content, $shortcode_data, $el_title );
			return $html;
		}

	}

