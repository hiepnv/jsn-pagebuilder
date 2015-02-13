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
 * Accordion Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeAccordionItem extends IG_Pb_Child {

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
		$this->config['shortcode'] = 'pb_accordion_item';
		$this->config['exception'] = array(
			'data-modal-title' 	=> JText::_('Accordion Item')
		);
		$this->config['shortcode_structure']	= '';
	}

	/**
	 * DEFINE setting options of shortcode
	 * 
	 * @return type
	 */
	public function element_items() {
		$this->items = array(
			"Notab" => array(
				array(
					"name" => JText::_("Heading"),
					"id" => "heading",
					"type" => "text_field",
					"class" => "jsn-input-xxlarge-fluid",
					"role" => "title",
					"std" => JText::_('Accordion Item PB_INDEX_TRICK')
				),
				array(
					"name" => JText::_("Body"),
					"id" => "body",
					"role" => "content",
					"type" => "tiny_mce",
					"std" => JSNPagebuilderHelpersType::loremText()
				),
				array(
					"name" => JText::_("Icon"),
					"id" => "icon",
					"type" => "icons",
					"std" => "",
					"role" => "title_prepend",
					"role_type" => "icon"
				),
				array(
					"name" => JText::_("Tag"),
					"id" => "tag",
					"type" => "tag",
					"std" => ""
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
	public function element_shortcode($atts = null, $content = null) {
		extract(JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts));

		// tag1,tag2 => tag1 tag2 , to filter
		$tag = str_replace(" ", "_", $tag);
		$tag = str_replace(",", " ", $tag);
		return "
			<div class='panel panel-default' data-tag='$tag'>
				<div class='panel-heading'>
					<h4 class='panel-title'>
						<a data-toggle='collapse' data-parent='#accordion_{ID}' href='#collapse{index}'>
						<i class='$icon'></i>$heading
						</a>
					</h4>
				</div>
				<div id='collapse{index}' class='panel-collapse collapse {show_hide}'>
				  <div class='panel-body'>
				  " . JSNPagebuilderHelpersShortcode::removeAutop($content) . "
				  </div>
				</div>
			</div><!--seperate-->";
		
	}
}