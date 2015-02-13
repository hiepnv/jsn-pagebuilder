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
 * Google Map Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeGooglemapItem extends IG_Pb_Child
{

	/**
	 * Constructor
	 *
	 * @return type
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Include admin scripts
	 *
	 * @return type
	 */
	public function backend_element_assets()
	{
		$document = JFactory::getDocument();
		$document->addScript(JSNPB_ELEMENT_URL . '/googlemap/assets/js/googlemap-settings.js', 'text/javascript');
	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config()
	{
		$this->config['shortcode'] = 'pb_googlemap_item';
		$this->config['exception'] = array(
			'item-text'        => JText::_('Marker'),
			'data-modal-title' => JText::_('Google Map Item')
		);
	}

	/**
	 * DEFINE setting options of shortcode
	 *
	 * @return type
	 */
	public function element_items()
	{
		$this->items = array(
			'Notab' => array(
				array(
					'name'    => JText::_('Title'),
					'id'      => 'gmi_title',
					'type'    => 'text_field',
					'role'    => 'title',
					'std'     => JText::_(JSNPagebuilderHelpersPlaceholders::add_palceholder('Marker %s', 'index')),
					'tooltip' => JText::_('Title'),
				),
				array(
					'name'            => JText::_('Description'),
					'id'              => 'gmi_desc_content',
					'role'            => 'content',
					'type'            => 'tiny_mce',
					'std'             => JText::_('Description of marker'),
					'tooltip'         => JText::_('Description'),
					'container_class' => 'pb_tinymce_replace',
				),
				array(
					'name'    => JText::_('Link URL'),
					'id'      => 'gmi_url',
					'type'    => 'text_field',
					'std'     => 'http://',
					'tooltip' => JText::_('Link URL'),
				),
				array(
					'name'        => JText::_('Image'),
					'id'          => 'gmi_image',
					'type'        => 'select_media',
					'std'         => '',
					'class'       => 'jsn-input-large-fluid',
					'tooltip'     => JText::_('Image'),
					'filter_type' => 'image',
				),
				array(
					'name'            => JText::_('Location'),
					'id'              => 'gmi_location',
					'type'            => array(
						array(
							'id'            => 'gmi_lat',
							'type'          => 'text_append',
							'input_type'    => 'number',
							'class'         => 'jsn-input-number input-small input-sm',
							'std'           => rand(0, 10),
							'parent_class'  => 'input-group-inline',
							'append_before' => JText::_('Latitude')
						),
						array(
							'id'            => 'gmi_long',
							'type'          => 'text_append',
							'input_type'    => 'number',
							'class'         => 'jsn-input-number input-small input-sm',
							'std'           => rand(0, 10),
							'parent_class'  => 'input-group-inline',
							'append_before' => JText::_('Longtitude'),
						),
					),
					'tooltip'         => JText::_('Location'),
					'container_class' => 'combo-group',
				),
			),
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
	public function element_shortcode($atts = null, $content = null)
	{
		$params = (JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts));
		extract($params);
		// reassign value for description from content of shortcode
		$params['gmi_desc_content'] = $content;
		$html_element               = "<input type='hidden' value='" . json_encode($params) . "' class='pb-gmi-lat-long' />";
		$html_element .= '<!--seperate-->';

		return $html_element;
	}

}
