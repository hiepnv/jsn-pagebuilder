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
 * Tab Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeTabItem extends IG_Pb_Child {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Include admin scripts
	 */
	public function backend_element_assets() {
		$document = JFactory::getDocument();
		$document->addScript( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-iconselector.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-general.css', 'text/css' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-fonticomoon.css', 'text/css' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_tab_item';
		$this->config['exception'] = array(
			'data-modal-title' => JText::_( 'Tab Item' )
		);
	}

	/**
	 * DEFINE setting options of shortcode
	 */
	public function element_items() {
		$this->items = array(
			'Notab' => array(
				array(
					'name'  => JText::_( 'Heading' ),
					'id'    => 'heading',
					'type'  => 'text_field',
					'class' => 'jsn-input-xxlarge-fluid',
					'role'  => 'title',
					'std'   => JText::_( 'Tab Item PB_INDEX_TRICK' )
				),
				array(
					'name' => JText::_( 'Body' ),
					'id'   => 'body',
					'role' => 'content',
					'type' => 'tiny_mce',
					'std'  => JSNPagebuilderHelpersType::loremText()
				),
				array(
					'name'      => JText::_( 'Icon' ),
					'id'        => 'icon',
					'type'      => 'icons',
					'std'       => '',
					'role'      => 'title_prepend',
					'role_type' => 'icon',
				),
			)
		);
	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param type $atts
	 * @param type $content
	 */
	public function element_shortcode( $atts = null, $content = null ) {
		extract( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
		$inner_content = JSNPagebuilderHelpersShortcode::removeAutop( $content );
		return "
			<div id='pane_{index}' class='tab-pane {active} {fade_effect}' STYLE>
				{$inner_content}
			</div><!--seperate-->";
	}

}
