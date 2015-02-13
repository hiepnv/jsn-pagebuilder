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

// No direct access to this file.
defined('_JEXEC') || die('Restricted access');

/**
 * Divider shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeDivider extends IG_Pb_Element {

	/**
	 * Constructor
	 *
	 * @return type
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Include admin scripts
	 * 
	 * @return type
	 */
	public function backend_element_assets() {
		$document = JFactory::getDocument();
		$document->addScript( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.min.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.css', 'text/css' );
		$document->addScript( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/js/colorpicker.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/css/colorpicker.css', 'text/css' );
		$document->addScript( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-colorpicker.js', 'text/javascript' );
		$document->addScript( JSNPB_ELEMENT_URL.'/divider/assets/js/divider-setting.js', 'text/javascript' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_divider';
		$this->config['name']      = JText::_( 'Divider' );
		$this->config['cat']       = JText::_( 'Extra' );
		$this->config['icon']      = 'icon-divider';
		$this->config['description'] = JText::_("Horizontal line for dividing sections");
	}

	/**
	 * DEFINE setting options of shortcode
	 *
	 * @return type
	 */
	public function element_items() {
		$this->items = array(
			'content' => array(
				array(
					'name'    => JText::_( 'Element Title' ),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( 'Divider PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name' => JText::_( 'Border' ),
					'type' => array(
						array(
							'id'           => 'div_border_width',
							'type'         => 'text_append',
							'type_input'   => 'number',
							'class'        => 'input-mini',
							'std'          => '2',
							'append'       => 'px',
							'validate'     => 'number',
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'div_border_style',
							'type'         => 'select',
							'class'        => 'input-medium',
							'std'          => 'solid',
							'options'      => JSNPagebuilderHelpersType::getBorderStyles(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'div_border_color',
							'type'         => 'color_picker',
							'std'          => '#E0DEDE',
							'parent_class' => 'combo-item',
						),
					),
					'tooltip'         => JText::_( 'Border Description' ),
					'container_class' => 'combo-group',
				),
			)
		);
	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param type $atts
	 * @param type $content
	 *
	 * @return string
	 */
	public function element_shortcode( $atts = null, $content = null ) {
		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts );
		extract( $arr_params );
		$styles = array();
		if ( $div_border_width ) {
			$styles[] = 'border-bottom-width:' . intval( $div_border_width ) . 'px';
		}
		if ( $div_border_style ) {
			$styles[] = 'border-bottom-style:' . $div_border_style;
		}
		if ( $div_border_color ) {
			$styles[] = 'border-bottom-color:' . urldecode( $div_border_color );
		}
		//if ( $div_margin_top ) {
		//	$styles[] = 'margin-top:' . intval( $div_margin_top ) . 'px';
		//}
		//if ( $div_margin_bottom ) {
		//	$styles[] = 'margin-bottom:' . intval( $div_margin_bottom ) . 'px';
		//}
		if ( count( $styles ) > 0 ) {
			$html_element = '<div style="' . implode( ';', $styles ) . '"></div><div style="clear: both"></div>';
		} else {
			$html_element = '';
		}
		return $this->element_wrapper( $html_element, $arr_params );
	}

}
