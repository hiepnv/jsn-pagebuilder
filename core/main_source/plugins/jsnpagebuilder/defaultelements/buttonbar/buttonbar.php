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
 * Buttonbar shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeButtonbar extends IG_Pb_Element {

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
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-fonticomoon.css', 'text/css' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_buttonbar';
		$this->config['name']      = JText::_( 'Button Bar' );
		$this->config['cat']       = JText::_( 'Typography' );
		$this->config['icon']      = 'icon-button-bar';
		$this->config['description'] = JText::_("Bar of buttons");
		$this->config['has_subshortcode'] = __CLASS__ . 'Item';
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
					'std'     => JText::_( 'Button Bar PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'id' => 'buttonbar_items',
					'name' => JText::_( 'ButtonBar Items' ),
					'type' => 'group',
					'shortcode' => $this->config['shortcode'],
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items' => array(
						array( 'std' => '' ),
						array( 'std' => '' ),
						array( 'std' => '' ),
					),
					'label_item'    => JText::_( 'ButtonBar Item' )
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_( 'Alignment' ),
					'id'      => 'buttonbar_alignment',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getTextAlign() ),
					'options' => JSNPagebuilderHelpersType::getTextAlign(),
					'tooltip' => JText::_( 'Alignment Description' )
				),
				array(
					'name'    => JText::_( 'Show Title' ),
					'id'      => 'buttonbar_show_title',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( 'yes' => JText::_( 'Yes' ), 'no' => JText::_( 'No' ) ),
					'tooltip' => JText::_( 'Show Title Description' )
				),
				array(
					'name'    => JText::_( 'Show Icon' ),
					'id'      => 'buttonbar_show_icon',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( 'yes' => JText::_( 'Yes' ), 'no' => JText::_( 'No' ) ),
					'tooltip' => JText::_( 'Show Icon Description' )
				),
				array(
					'name'    => JText::_( 'Group Buttons' ),
					'id'      => 'buttonbar_group',
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array( 'yes' => JText::_( 'Yes' ), 'no' => JText::_( 'No' ) ),
					'tooltip' => JText::_( 'Group Button Description' )
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
		JSNPagebuilderHelpersFunctions::loadFancyboxJS();
		$document = JFactory::getDocument();
		$document->addScript( JSNPB_ELEMENT_URL.'/buttonbar/assets/js/buttonbar.js', 'text/javascript'  );
		$document->addStyleSheet( JSNPB_ELEMENT_URL.'/buttonbar/assets/css/buttonbar.css', 'text/css' );
		
		$arr_params    = JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts );
		$html_element  = '';
		$sub_shortcode = empty($content) ? JSNPagebuilderHelpersShortcode::removeAutop($content) : JSNPagebuilderHelpersBuilder::generateShortCode($content, false, 'frontend', true);
		$items         = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		$initial_open  = ( ! isset( $initial_open ) || $initial_open > count( $items ) ) ? 1 : $initial_open;
		foreach ( $items as $idx => $item ) {
			$open        = ( $idx + 1 == $initial_open ) ? 'in' : '';
			$items[$idx] = $item;
		}
		$sub_htmls     = implode( '', $items );
		if ( $arr_params['buttonbar_show_title'] == 'no' ) {
			$pattern   = '\\[(\\[?)(title)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
			$sub_htmls = preg_replace( '/'. $pattern .'/s', '', $sub_htmls );
		} else {
			$sub_htmls = str_replace( '[title]', '', $sub_htmls );
			$sub_htmls = str_replace( '[/title]', '', $sub_htmls );
		}
		if ( $arr_params['buttonbar_show_icon'] == 'no' ) {
			$pattern   = '\\[(\\[?)(icon)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
			$sub_htmls = preg_replace( '/' . $pattern . '/s', '', $sub_htmls );
		} else {
			$sub_htmls = str_replace( '[icon]', '', $sub_htmls );
			$sub_htmls = str_replace( '[/icon]', '', $sub_htmls );
		}
		if ( $arr_params['buttonbar_group'] == 'no' ) {
			$html_element = $sub_htmls;
		} else {
			$html_element = "<div class='btn-group' style='float: none;'>" . $sub_htmls . '</div>';
		}

		$cls_alignment = '';
		if ( strtolower( $arr_params['buttonbar_alignment'] ) != 'inherit' ) {
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'left' )
				$cls_alignment = 'pull-left';
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'right' )
				$cls_alignment = 'pull-right';
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'center' )
				$cls_alignment = 'text-center';
		}
        $html_element .= '<div style="clear: both"></div>';
		$html_element = "<div class='btn-toolbar {$cls_alignment}'>{$html_element}</div>";
        $html_element .= '<div style="clear: both"></div>';

		return $this->element_wrapper( $html_element, $arr_params );
	}

}
