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
 * Testimonial Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeTestimonialItem extends IG_Pb_Child
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
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-fonticomoon.css', 'text/css');
		$document->addScript(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/js/colorpicker.js', 'text/javascript');
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/css/colorpicker.css', 'text/css');
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-colorpicker.js', 'text/javascript');
		$document->addScript(JSNPB_ELEMENT_URL . '/testimonial/assets/js/testimonial-settings.js', 'text/javascript');

	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config()
	{
		$this->config['shortcode'] = 'pb_testimonial_item';
		$this->config['exception'] = array(
			'item-text'        => JText::_('Testimonial Item'),
			'data-modal-title' => JText::_('Testimonial Item')
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
					'name' => JText::_('Title'),
					'id'   => 'elm_title',
					'type' => 'text_field',
					'role' => 'title',
					'std'  => JText::_(JSNPagebuilderHelpersPlaceholders::add_palceholder('Testimonial Item %s', 'index')),
				),
				array(
					'name'            => JText::_('Client\'s Name'),
					'type'            => array(
						array(
							'id'           => 'name',
							'type'         => 'text_field',
							'std'          => '',
							'placeholder'  => 'John Doe',
							'parent_class' => 'combo-item input-append-inline',
						),
						array(
							'id'           => 'name_height',
							'type'         => 'text_append',
							'type_input'   => 'number',
							'class'        => 'input-mini',
							'std'          => '12',
							'append'       => 'px',
							'validate'     => 'number',
							'parent_class' => 'combo-item input-append-inline',
						),
						array(
							'id'           => 'name_color',
							'type'         => 'color_picker',
							'std'          => '#000000',
							'parent_class' => 'combo-item',
						),
					),
					'tooltip'         => JText::_('Client\'s Name Description'),
					'container_class' => 'combo-group',
				),
				array(
					'name'        => JText::_('Client\'s Position'),
					'id'          => 'job_title',
					'type'        => 'text_field',
					'std'         => '',
					'tooltip'     => JText::_('Client\'s Position Description'),
					'placeholder' => 'CEO',
				),
				array(
					'name' => JText::_('Feedback Content'),
					'id'   => 'body',
					'role' => 'content',
					'type' => 'tiny_mce',
					'std'  => JSNPagebuilderHelpersType::loremText(),
				),
				array(
					'name'    => JText::_('Country'),
					'id'      => 'country',
					'type'    => 'text_field',
					'std'     => '',
					'tooltip' => JText::_('Country Description'),
				),
				array(
					'name'    => JText::_('Company'),
					'id'      => 'company',
					'type'    => 'text_field',
					'std'     => '',
					'tooltip' => JText::_('Company Description'),
				),
				array(
					'name'    => JText::_('Website URL'),
					'id'      => 'web_url',
					'type'    => 'text_field',
					'std'     => JText::_('http://'),
					'tooltip' => JText::_('Website URL Description'),
				),
				array(
					'name'    => JText::_('Avatar'),
					'id'      => 'image_file',
					'type'    => 'select_media',
					'std'     => '',
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => JText::_('Country Description'),
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
		$atts['testimonial_content'] = $content;

		
		return serialize($atts) . '<!--seperate-->';
		extract(JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts));
		$img = !empty($image_file) ? "<img class='pb-testimonial-image {style}' src='{$image_file}' />" : '';

		return "";

	}

}
