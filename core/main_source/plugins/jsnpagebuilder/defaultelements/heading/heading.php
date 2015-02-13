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
 * Heading shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeHeading extends IG_Pb_Element {

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
		$document->addScript( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-fontselector.js', 'text/javascript' );
		$document->addScript( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/js/colorpicker.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/css/colorpicker.css', 'text/css' );
		$document->addScript( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-colorpicker.js', 'text/javascript' );
		$document->addScript( JSNPB_ELEMENT_URL.'/heading/assets/js/heading-setting.js', 'text/javascript' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 * 
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_heading';
		$this->config['name']      = JText::_( 'Heading' );
		$this->config['cat']       = JText::_( 'Typography' );
		$this->config['icon']      = 'icon-heading';
		$this->config['description'] = JText::_("Heading tags for text");
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
					'std'     => JText::_( 'Heading PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'name'    => JText::_( 'Tag' ),
					'id'      => 'tag',
					'type'    => 'select',
					'std'     => 'h1',
					'options' => array( 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6' ),
					'tooltip' => JText::_( 'Tag Description' )
				),
				array(
					'name'    => JText::_( 'Text' ),
					'id'      => 'text',
					'type'    => 'text_field',
					'role'    => 'content',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( 'Your heading text' ),
					'tooltip' => JText::_( 'Text Description' )
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_( 'Alignment' ),
					'id'      => 'text_align',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getTextAlign() ),
					'options' => JSNPagebuilderHelpersType::getTextAlign(),
					'tooltip' => JText::_( 'Alignment Description' )
				),
				array(
					'name'       => JText::_( 'Font' ),
					'id'         => 'font',
					'type'       => 'select',
					'std'        => 'inherit',
					'options'    => array( 'inherit' => JText::_( 'Inherit' ), 'custom' => JText::_( 'Custom' ) ),
					'has_depend' => '1',
					'class'      => 'input-medium',
					'tooltip'    => JText::_( 'Font Description' )
				),
				array(
					'name' => JText::_( 'Font Face' ),
					'id'   => 'font_family',
					'type' => array(
						array(
							'id'           => 'font_face_type',
							'type'         => 'jsn_select_font_type',
							'class'        => 'input-medium',
							'std'          => 'standard fonts',
							'options'      => JSNPagebuilderHelpersType::getFonts(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'font_face_value',
							'type'         => 'jsn_select_font_value',
							'class'        => 'input-medium',
							'std'          => 'Verdana',
							'options'      => '',
							'parent_class' => 'combo-item',
						),
					),
					'dependency'      => array( 'font', '=', 'custom' ),
					'tooltip'         => JText::_( 'Font Face Description' ),
					'container_class' => 'combo-group',
				),
				array(
					'name' => JText::_( 'Font Attributes' ),
					'type' => array(
						array(
							'id'           => 'font_size_value_',
							'type'         => 'text_append',
							'type_input'   => 'number',
							'class'        => 'input-mini',
							'std'          => '',
							'append'       => 'px',
							'validate'     => 'number',
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'font_style',
							'type'         => 'select',
							'class'        => 'input-medium',
							'std'          => 'bold',
							'options'      => JSNPagebuilderHelpersType::getFontStyles(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'color',
							'type'         => 'color_picker',
							'std'          => '#000000',
							'parent_class' => 'combo-item',
						),
					),
					'dependency'      => array( 'font', '=', 'custom' ),
					'tooltip'         => JText::_( 'Font Attribute Description' ),
					'container_class' => 'combo-group',
				),
				array(
					'name' => JText::_( 'Bottom Border' ),
					'type' => array(
						array(
							'id'           => 'border_bottom_width_value_',
							'type'         => 'text_append',
							'type_input'   => 'number',
							'class'        => 'input-mini',
							'std'          => '',
							'append'       => 'px',
							'validate'     => 'number',
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'border_bottom_style',
							'type'         => 'select',
							'class'        => 'input-medium',
							'std'          => 'solid',
							'options'      => JSNPagebuilderHelpersType::getBorderStyles(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'border_bottom_color',
							'type'         => 'color_picker',
							'std'          => '#000000',
							'parent_class' => 'combo-item',
						),
					),
					'tooltip'         => JText::_( 'Bottom Border Description' ),
					'container_class' => 'combo-group',
				),
				array(
					'name' => JText::_( 'Bottom Padding' ),
					'type' => array(
						array(
							'id'         => 'padding_bottom_value_',
							'type'       => 'text_append',
							'type_input' => 'number',
							'class'      => 'input-mini',
							'std'        => '',
							'append'     => 'px',
							'validate'   => 'number',
						),
					),
					'tooltip' => JText::_( 'Bottom Padding Description' )
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
		if ( ! empty( $atts ) AND is_array( $atts ) ) {
			if ( ! isset( $atts['border_bottom_width_value_'] ) ) {
				$atts['border_bottom_width_value_'] = '';
				$atts['border_bottom_style']        = '';
				$atts['border_bottom_color']        = '';
			}
			if ( ! isset( $atts['padding_bottom_value_'] ) ) {
				$atts['padding_bottom_value_']      = '';
			}
			if ( ! isset( $attrs['font_size_value_'] ) ) {
				$attrs['font_size_value_']          = '';
			}
		}
		// reload shortcode params: because we get Heading Text from "text" param
		JSNPagebuilderHelpersShortcode::generateShortcodeParams( $this->items, NULL, $atts );

		$arr_params = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );

		$style = array();
		$exclude_params = array( 'tag', 'text', 'preview' );
		$stylesheet = $font_style = '';

		// Override custom style
		if ( ! empty( $arr_params ) AND is_array( $arr_params ) ) {
			if ( $arr_params['font'] == 'inherit' || $arr_params['font'] == 'Inherit' ) {
				unset( $arr_params['font'] );
				unset( $arr_params['font_face_type'] );
				unset( $arr_params['font_face_value'] );
				unset( $arr_params['font_size_value_'] );
				unset( $arr_params['font_style'] );
				unset( $arr_params['color'] );
			}
			if ( isset( $arr_params['font'] ) && $arr_params['font'] == 'custom' ) {
				unset( $arr_params['font'] );
				if ( isset( $arr_params['font_style'] ) && strtolower( $arr_params['font_style'] ) == 'bold' ) {
					$arr_params['font_weight'] = '700';
					unset( $arr_params['font_style'] );
				}
				if ( isset( $arr_params['font_style'] ) && strtolower( $arr_params['font_style'] ) == 'normal' ) {
					$arr_params['font_weight'] = 'normal';
					unset( $arr_params['font_style'] );
				}
			}
			if ( isset( $arr_params['font_size_value_'] ) && $arr_params['font_size_value_'] == '' ) {
				unset( $arr_params['font_size_value_'] );
			}

			if ( $arr_params['border_bottom_width_value_'] == '' ) {
				unset( $arr_params['border_bottom_width_value_'] );
				unset( $arr_params['border_bottom_style'] );
				unset( $arr_params['border_bottom_color'] );
			}
			if ( $arr_params['padding_bottom_value_'] == '' ) {
				unset( $arr_params['padding_bottom_value_'] );
			}
			if ( $arr_params['text_align'] == 'inherit' || $arr_params['text_align'] == 'Inherit' ) {
				unset( $arr_params['text_align'] );
			}
		}

		foreach ( $arr_params as $key => $value ) {
			if ( $value != '' ) {
				if ( $key == 'font_face_type' ) {
					if ( $value == JText::_( 'Standard fonts' ) || $value == 'standard fonts' ) {
						$font_style = 'font-family:' . $arr_params['font_face_value'];
					} else if ( $value == JText::_( 'Google fonts' ) || $value == 'google fonts' ) {
						$document = JFactory::getDocument();
						$document->addStyleSheet( "http://fonts.googleapis.com/css?family={$arr_params['font_face_value']}", 'text/css' );
						$font_style = 'font-family:' . $arr_params['font_face_value'];
					}
				} else if ( $key != 'font_face_value' ) {
					$key = JSNPagebuilderHelpersShortcode::removeTag( $key );
					if ( ! in_array( $key, $exclude_params ) ) {
						switch ( $key ) {
							case 'border_bottom_width_value_':
								$style[$key] = 'border-bottom-width:' . $value . 'px';
								break;
							case 'text_align':
								$style[$key] = 'text-align:' . $value;
								break;
							case 'font_size_value_':
								$style[$key] = 'font-size:' . $value . 'px';
								break;
							case 'font_style':
								$style[$key] = 'font-style:' . $value;
								break;
							case 'border_bottom_style':
								$style[$key] = 'border-bottom-style:' . $value;
								break;
							case 'border_bottom_color':
								$style[$key] = 'border-bottom-color:' . $value;
								break;
							case 'padding_bottom_value_':
								$style[$key] = 'padding-bottom:' . $value . 'px';
								break;
							case 'font_weight':
								$style[$key] = 'font-weight:' . $value;
								break;
							case 'color':
								$style[$key] = 'color:' . $value;
								break;
						}
					}
				}
			}
		}
		$style = implode( ';', $style );
		$style .= ';' . $font_style;
		$style = ( $style == ';' ) ? '' : $style;
		$true_element = "<{$arr_params['tag']} style='{$style}'>" . JSNPagebuilderHelpersShortcode::removeAutop( $content ) . "</{$arr_params['tag']}>";
		$true_element .= '';
		
		return $this->element_wrapper( $true_element, $arr_params );
	}

}
