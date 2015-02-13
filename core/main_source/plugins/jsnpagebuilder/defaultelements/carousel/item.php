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
 * Carousel Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeCarouselItem extends IG_Pb_Child
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
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-iconselector.js', 'text/javascript');
		$document->addScript(JSNPB_ELEMENT_URL . '/carousel/assets/js/carousel-setting.js', 'text/javascript');
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-general.css', 'text/css');
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-fonticomoon.css', 'text/css');
	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config()
	{
		$this->config['shortcode'] = 'pb_carousel_item';
		$this->config['exception'] = array(
			'data-modal-title' => JText::_('Carousel Item')
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
					'name'    => JText::_('Image File'),
					'id'      => 'image_file',
					'type'    => 'select_media',
					'std'     => '',
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => JText::_('Select background image for item')
				),
				array(
					'name'    => JText::_('Heading'),
					'id'      => 'heading',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'role'    => 'title',
					'std'     => JText::_('Carousel Item PB_INDEX_TRICK'),
					'tooltip' => JText::_('Set the text of your heading items'),
				),
				array(
					'name'    => JText::_('Body'),
					'id'      => 'body',
					'role'    => 'content',
					'type'    => 'tiny_mce',
					'std'     => JSNPagebuilderHelpersType::loremText(),
					'tooltip' => JText::_('Set content of element'),
				),
				array(
					'name'      => JText::_('Icon'),
					'id'        => 'icon',
					'type'      => 'icons',
					'std'       => '',
					'role'      => 'title_prepend',
					'role_type' => 'icon',
					'tooltip'   => JText::_('Select an icon'),
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
	public function element_shortcode($atts = null, $content = null)
	{
		extract(JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts));
		$content_class = !empty($image_file) ? 'carousel-caption' : 'carousel-content';
		$pathRoot 	= JURI::root();
		$url_pattern = '/^(http|https)/';
		preg_match($url_pattern, $image_file, $m);
		if(count($m)){
			$pathRoot = '';
		}
		$hidden        = (empty($heading) && empty($content)) ? 'style="display:none"' : '';
		$img           = !empty($image_file) ? "<img  src='{$pathRoot}{$image_file}'>" : '';
		$icon          = !empty($icon) ? "<i class='$icon'></i>" : '';
		$inner_content = JSNPagebuilderHelpersShortcode::removeAutop($content);
		if (empty($hidden) && empty($inner_content))
		{
			$html_content = "";
		}
		else
		{
			$html_content = "<div class='$content_class' $hidden>";
			$html_content .= "<h4>{$icon}{$heading}</h4>";
			$html_content .= "<p>{$inner_content}</p></div>";
		}

		return "<div class='{active} item'>{$img}{$html_content}</div><!--seperate-->";
	}

}
