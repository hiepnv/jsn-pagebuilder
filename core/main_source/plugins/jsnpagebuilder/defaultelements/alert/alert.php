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
 * Alert shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeAlert extends IG_Pb_Element {

	/**
	 * Constructor
	 *
	 * @return type
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_alert';
		$this->config['name']      = JText::_( 'Alert' );
		$this->config['cat']       = JText::_( 'Typography' );
		$this->config['icon']      = 'icon-alert';
		$this->config['description'] = JText::_("Multiple Alert message box types");
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
					'std'     => JText::_( 'Alert PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'name'  => JText::_( 'Alert Content' ),
					'id'    => 'alert_content',
					'type'  => 'tiny_mce',
					'role'  => 'content',
					'rows'  => '12',
					'std'   => JSNPagebuilderHelpersType::loremText()
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_( 'Style' ),
					'id'      => 'alert_style',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getAlertType() ),
					'options' => JSNPagebuilderHelpersType::getAlertType(),
					'tooltip' => JText::_( 'Style Description' )
				),
				array(
					'name'		=> JText::_( 'Allow to close' ),
					'id'		=> 'alert_close',
					'type'		=> 'radio',
					'std'		=> 'no',
					'options'	=> array( 'yes' => JText::_( 'Yes' ), 'no' => JText::_( 'No' ) ),
					'tooltip'	=> 'Allow to close Description',
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
		$html_element  = '';
		$arr_params	   = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
		extract( $arr_params );
		$alert_style   = ( ! $arr_params['alert_style'] ) ? '' : $arr_params['alert_style'];
		$alert_close   = ( ! $arr_params['alert_close'] || $arr_params['alert_close'] == 'no' ) ? '' : '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		$alert_dismis  = ( ! $arr_params['alert_close'] || $arr_params['alert_close'] == 'no' ) ? '' : ' alert-dismissable';
		$content      = ( ! $content ) ? $alert_content : $content;
		$html_element .= "<div class='alert {$alert_style}{$alert_dismis}'>";
		$html_element .= $alert_close;
		$html_element .= $content;
		$html_element .= '</div>';
        $html_element .= '<div style="clear: both"></div>';
		return $this->element_wrapper( $html_element, $arr_params );
	}

}
