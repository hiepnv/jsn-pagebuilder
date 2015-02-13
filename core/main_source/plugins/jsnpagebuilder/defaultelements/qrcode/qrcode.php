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
 * QRCode shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeQRCode extends IG_Pb_Element {

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
		$document->addScript( JSNPB_ELEMENT_URL.'/qrcode/assets/js/qrcode-setting.js', 'text/javascript' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 * 
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_qrcode';
		$this->config['name']      = JText::_( 'QR Code' );
		$this->config['cat']       = JText::_( 'Extra' );
		$this->config['icon']      = 'icon-qr-code';
		$this->config['description'] = JText::_("QR code with data setting");
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
					'std'     => JText::_( 'QR Code PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'name'          => JText::_( 'Data' ),
					'id'            => 'qr_content',
					'type'          => 'text_area',
					'class'         => 'jsn-input-xxlarge-fluid',
					'std'           => 'http://www.joomlashine.com',
					'tooltip'       => JText::_( 'Data Description' ),
					'exclude_quote' => '1',
				),
				array(
					'name'    => JText::_( 'Image ALT Text' ),
					'id'      => 'qr_alt',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( 'Joomla templates from www.joomlashine.com' ),
					'tooltip' => JText::_( 'Image ALT Text Description' ),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_( 'Container Style' ),
					'id'      => 'qr_container_style',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getQRContainerStyle() ),
					'options' => JSNPagebuilderHelpersType::getQRContainerStyle(),
					'tooltip' => JText::_( 'Container Style Description' )
				),
				array(
					'name'    => JText::_( 'Alignment' ),
					'id'      => 'qr_alignment',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getTextAlign() ),
					'options' => JSNPagebuilderHelpersType::getTextAlign(),
					'tooltip' => JText::_( 'Alignment Description' )
				),
				array(
					'name'       => JText::_( 'QR Code Sizes' ),
					'id'         => 'qrcode_sizes',
					'type'       => 'text_append',
					'type_input' => 'number',
					'class'      => 'input-mini',
					'std'        => '150',
					'append'     => 'px',
					'validate'   => 'number',
					'tooltip'    => JText::_( 'QR Code Sizes Description' )
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
		$arr_params    = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
		extract( $arr_params );
		$qrcode_sizes  = ( $qrcode_sizes ) ? ( int ) $qrcode_sizes : 0;
		$cls_alignment = '';
		if ( strtolower( $arr_params['qr_alignment'] ) != 'inherit' ) {
			if ( strtolower( $arr_params['qr_alignment'] ) == 'left' )
				$cls_alignment = "class='pull-left'";
			if ( strtolower( $arr_params['qr_alignment'] ) == 'right' )
				$cls_alignment = "class='pull-right'";
			if ( strtolower( $arr_params['qr_alignment'] ) == 'center' )
				$cls_alignment = "class='text-center'";
		}
		$class_img    = ( $qr_container_style != 'no-styling' ) ? "class='{$qr_container_style}'" : '';
		$qr_content   = str_replace( '<pb_quote>', '"', $qr_content );
		$image        = 'https://chart.googleapis.com/chart?chs=' . $qrcode_sizes . 'x' . $qrcode_sizes . '&cht=qr&chld=H|1&chl=' . $qr_content;
		$qr_alt       = ( ! empty( $qr_alt ) ) ? "alt='{$qr_alt}'" : '';
		$html_element = "<img src='{$image}' {$qr_alt} width='{$qrcode_sizes}' height='{$qrcode_sizes}' $class_img />";
		if ($cls_alignment != '')
			$html_element = "<div {$cls_alignment}>{$html_element}</div>";
            $html_element .= '<div style="clear: both"></div>';

		return $this->element_wrapper( $html_element, $arr_params );
	}

}
