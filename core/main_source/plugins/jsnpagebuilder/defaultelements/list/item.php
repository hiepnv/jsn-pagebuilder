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
 * List Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeListItem extends IG_Pb_Child {

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
		$document->addScript( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-iconselector.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-general.css', 'text/css' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-fonticomoon.css', 'text/css' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 * 
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_list_item';
		$this->config['exception'] = array(
			'data-modal-title' => JText::_( 'List Item' )
		);
	}

	/**
	 * DEFINE setting options of shortcode
	 * 
	 * @return type
	 */
	public function element_items() {
		$this->items = array(
			'Notab' => array(
				array(
					'name'    => JText::_( 'Heading' ),
					'id'      => 'heading',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'role'    => 'title',
					'std'     => JText::_( 'List Item PB_INDEX_TRICK' ),
					'tooltip' => JText::_( 'Heading Description' )
				),
				array(
					'name'    => JText::_( 'Body' ),
					'id'      => 'body',
					'role'    => 'content',
					'type'    => 'tiny_mce',
					'std'     => JSNPagebuilderHelpersType::loremText(),
					'tooltip' => JText::_( 'Body Description' )
				),
				array(
					'name'      => JText::_( 'Icon' ),
					'id'        => 'icon',
					'type'      => 'icons',
					'std'       => '',
					'role'      => 'title_prepend',
					'role_type' => 'icon',
					'tooltip'   => JText::_( 'Icon Description' )
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
		extract( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
		return "
		<li>
			[icon]<div class='pb-sub-icons' style='pb-styles'>
				<i class='$icon'></i>
			</div>[/icon]
			<div class='pb-list-content-wrap'>
				[heading]<h4 style='pb-list-title'>$heading</h4>[/heading]
				<div class='pb-list-content'>
					$content
				</div>
			</div>
		</li><!--seperate-->";
	}

}
