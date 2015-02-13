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
defined('_JEXEC') or die('Restricted access');

/**
 * Button shortcode element
 *
 * @package JSN_PageBuilder
 * @since   1.0.4
 **/
class JSNPBShortcodeButton extends IG_Pb_Element
{

	/**
	 * Constructor
	 *
	 * @return  type
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
		$document->addScript(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.min.js', 'text/javascript');
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.css', 'text/css');
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-linktype.js', 'text/javascript');
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-iconselector.js', 'text/javascript');
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
		$this->config['shortcode']   = 'pb_button';
		$this->config['name']        = JText::_('Button');
		$this->config['cat']         = JText::_('Typography');
		$this->config['icon']        = 'icon-button';
		$this->config['description'] = JText::_("Eye catching button for hyperlinks");
	}

	/**
	 * DEFINE setting options of shortcode
	 *
	 * @return type
	 */
	public function element_items()
	{
		$this->items = array(
			'content' => array(
				array(
					'name'                      => JText::_('Element Title'),
					'id'                        => 'el_title',
					'type'                      => 'text_field',
					'class'                     => 'jsn-input-xxlarge-fluid',
					'std'                       => JText::_('Button PB_INDEX_TRICK'),
					'role'                      => 'title',
					'tooltip'                   => JText::_('Set title for current element'),
				),
				array(
					'name'    => JText::_('Text'),
					'id'      => 'button_text',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_('Button'),
					'role'    => 'title',
					'tooltip' => JText::_('Text Button Description')
				),
				array(
					'name'       => JText::_('Link Type'),
					'id'         => 'link_type',
					'type'       => 'select',
					'std'        => 'url',
					'options'    => JSNPagebuilderHelpersType::getLinkTypes(),
					'tooltip'    => JText::_('Link Type Description'),
					'has_depend' => '1',
				),
				array(
					'name'       => JText::_('URL'),
					'id'         => 'button_type_url',
					'type'       => 'text_field',
					'class'      => 'jsn-input-xxlarge-fluid',
					'std'        => 'http://',
					'tooltip'    => JText::_('URL Description'),
					'dependency' => array('link_type', '=', 'url')
				),
				array(
					'name'       => JText::_('Open in'),
					'id'         => 'open_in',
					'type'       => 'select',
					'std'        => JSNPagebuilderHelpersType::getFirstOption(JSNPagebuilderHelpersType::getOpenInOptions()),
					'options'    => JSNPagebuilderHelpersType::getOpenInOptions(),
					'tooltip'    => JText::_('Open in Description'),
					'dependency' => array('link_type', '!=', 'no_link')
				),
				array(
					'name'      => JText::_('Icon'),
					'id'        => 'icon',
					'type'      => 'icons',
					'std'       => '',
					'role_type' => 'icon',
					'tooltip'   => JText::_('Icon Description')
				),
			),

			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_('Alignment'),
					'id'      => 'button_alignment',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption(JSNPagebuilderHelpersType::getTextAlign()),
					'options' => JSNPagebuilderHelpersType::getTextAlign(),
					'tooltip' => JText::_('Alignment Description')
				),
				array(
					'name'    => JText::_('Size'),
					'id'      => 'button_size',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption(JSNPagebuilderHelpersType::getButtonSize()),
					'options' => JSNPagebuilderHelpersType::getButtonSize(),
					'tooltip' => JText::_('Button Size Description')
				),
				array(
					'name'            => JText::_('Color'),
					'id'              => 'button_color',
					'type'            => 'select',
					'std'             => JSNPagebuilderHelpersType::getFirstOption(JSNPagebuilderHelpersType::getButtonColor()),
					'options'         => JSNPagebuilderHelpersType::getButtonColor(),
					'tooltip'         => JText::_('Button Color Description'),
					'container_class' => 'color_select2',
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
		JSNPagebuilderHelpersFunctions::loadFancyboxJS();
		$document = JFactory::getDocument();
		$document->addScript( JSNPB_ELEMENT_URL.'/button/assets/js/button.js', 'text/javascript'  );
		$document->addStyleSheet( JSNPB_ELEMENT_URL.'/button/assets/css/button.css', 'text/css' );
		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts);
		extract($arr_params);
		$button_text = (!$button_text) ? '' : $button_text;
		$button_icon = (!$icon) ? '' : "<i class='{$icon}'></i>";
		$tag         = 'a';
		$href        = '';
		$script      = '';
		$single_item = explode('__#__', $single_item);
		$single_item = $single_item[0];
		if (!empty($link_type))
		{
			switch ($link_type)
			{
				case 'no_link':
					$tag = 'button';
					break;
				case 'url':
					$href = (!$button_type_url) ? ' href="#"' : " href='{$button_type_url}'";
					break;
			}
		}
		$target = '';
		if ($open_in)
		{
			switch ($open_in)
			{
				case 'current_browser':
					$target = '';
					break;
				case 'new_browser':
					$target = ' target="_blank"';
					break;
				case 'lightbox':
					$cls_button_fancy = ' pb-button-fancy';
					break;
			}
		}
		$button_type      = ($tag == 'button') ? " type='button'" : '';
		$cls_button_fancy = (!isset($cls_button_fancy)) ? '' : $cls_button_fancy;
		$script           = (!isset($script)) ? '' : $script;
		$cls_alignment    = $custom_style = '';
		if (strtolower($arr_params['button_alignment']) != 'inherit')
		{
			if (strtolower($arr_params['button_alignment']) == 'left')
				$cls_alignment = 'pull-left';
			if (strtolower($arr_params['button_alignment']) == 'right')
				$cls_alignment = 'pull-right';
			if (strtolower($arr_params['button_alignment']) == 'center')
				$cls_alignment = 'text-center';
		}


		$html_element = $script . "<div class='pb-element-button {$cls_alignment}'><{$tag} class='btn {$cls_alignment} {$button_size} {$button_color} {$cls_button_fancy}'{$href}{$target}{$button_type}>{$button_icon}{$button_text}</{$tag}></div>";

		return $this->element_wrapper($html_element, $arr_params, null, $custom_style);
	}
}