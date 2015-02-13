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
 * Tooltip shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeTooltip extends IG_Pb_Element {

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
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 * 
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_tooltip';
		$this->config['name']      = JText::_( 'Tooltip' );
		$this->config['cat']       = JText::_( 'Typography' );
		$this->config['icon']      = 'icon-tooltip';
		$this->config['description'] = JText::_("Tooltip with flexible setting");
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
					'std'     => JText::_( 'Tooltip PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'name'    => JText::_( 'Text' ),
					'id'      => 'text',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( 'Your text' ),
					'tooltip' => JText::_( 'Text Description' )
				),
				array(
					'name'    => JText::_( 'Tooltip Content' ),
					'id'      => 'tooltip_content',
					'role'    => 'content',
					'type'    => 'tiny_mce',
					'std'     => JText::_( 'Your tooltip content' ),
					'tooltip' => JText::_( 'Tooltip content. Accept HTML tag' ),
					'exclude_quote' => '1'
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_( 'Tooltip Position' ),
					'id'   	  => 'position',
					'type'    => 'select',
					'std' 	  => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getFullPositions() ),
					'options' => JSNPagebuilderHelpersType::getFullPositions(),
					'tooltip' => JText::_( 'Description' )
				),
				array(
					'name'       => JText::_( 'Tooltips In Button' ),
					'id'         => 'tooltips_button',
					'type'       => 'radio',
					'std'        => 'no',
					'options'    => array( 'yes' => JText::_( 'Yes' ), 'no' => JText::_( 'No' ) ),
					'has_depend' => '1',
				),
				array(
					'name'              => JText::_( 'Button Color' ),
					'id'                => 'button_color',
					'type'              => 'select',
					'std'               => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getButtonColor() ),
					'options'           => JSNPagebuilderHelpersType::getButtonColor(),
					'container_class'   => 'color_select2',
					'dependency' => array( 'tooltips_button', '=', 'yes' ),
				),
				array(
					'name'            => JText::_( 'Delay' ),
					'container_class' => 'combo-group',
					'type'            => array(
						array(
							'id'            => 'show',
							'type'          => 'text_append',
							'type_input'    => 'number',
							'class'         => 'input-mini',
							'std'           => '500',
							'append_before' => 'Show',
							'append'        => 'ms',
							'parent_class'  => 'combo-item',
							'validate'      => 'number',
						),
						array(
							'id'            => 'hide',
							'type'          => 'text_append',
							'type_input'    => 'number',
							'class'         => 'input-mini',
							'std'           => '100',
							'append_before' => 'Hide',
							'append'        => 'ms',
							'parent_class'  => 'combo-item',
							'validate'      => 'number',
						),
					),
				),
			)
		);
	}

	/**
	 * DEFINE setting options of shortcode
	 * 
	 * @return type
	 */
	public function element_shortcode( $atts = null, $content = null ) {		
		$document = JFactory::getDocument();
		$document->addStyleSheet( JURI::root(true) . "/plugins/system/jsnframework/assets/3rd-party/jquery-tipsy/tipsy.css", 'text/css' );
		$document->addScript( JURI::root(true) . "/plugins/system/jsnframework/assets/3rd-party/jquery-tipsy/jquery.tipsy.js", 'text/javascript' );
		
		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts );
		extract( $arr_params );
		$random_id  = JSNPagebuilderHelpersShortcode::generateRandomString();
		$tooltip_id = "tooltip_$random_id";

		$button_color = ( ! $button_color || strtolower( $button_color ) == 'default' ) ? '' : $button_color;
		$position     = strtolower( $position );
		$delay_show   = ! empty( $show ) ? $show : 500;
		$delay_hide   = ! empty( $hide ) ? $hide : 100;
		$direction    = array( 'top' => 's', 'bottom' => 'n', 'left' => 'e', 'right' => 'w' );
		$content      = str_replace(array("\n", "\r"), '', $content);
		$script       = "( function ($) {
				$( document ).ready( function ()
				{
					$('#$tooltip_id').click(function(e){
						e.preventDefault();
					});
					$('#$tooltip_id').tipsy({
						fallback: '$content',
						html: true,
						live: true,
						delayIn: $delay_show,
						delayOut: $delay_hide,
						gravity: '{$direction[$position]}'
					});
				});
			} )( JoomlaShine.jQuery );";
		if ( $tooltips_button == 'no' ) {
			$html = "<a id='$tooltip_id' class='pb-label-des-tipsy' original-title='' href='#'>$text</a>";
		} else {
			$html = "<a id='$tooltip_id' class='pb-label-des-tipsy btn {$button_color}' original-title='' href='#'>$text</a>";
		}
		$document->addScriptDeclaration( $script, 'text/javascript' );
		//$html = $html;
		//if ( is_admin() ) {
		//	$custom_style = "style='margin-top: 50px;'";
		//	$html_element = "<center $custom_style>$html</center>";
		//} else
		//	$html_element = $html;

		return $this->element_wrapper( $html, $arr_params );
	}

}
