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
 * Image shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeImage extends IG_Pb_Element
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
		$document->addScript(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.min.js', 'text/javascript');
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.css', 'text/css');
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-linktype.js', 'text/javascript');
		$document->addScript(JSNPB_ELEMENT_URL . '/image/assets/js/image-setting.js', 'text/javascript');
	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config()
	{
		$this->config['shortcode']   = 'pb_image';
		$this->config['name']        = JText::_('Image');
		$this->config['cat']         = JText::_('Media');
		$this->config['icon']        = 'icon-image';
		$this->config['description'] = JText::_("Simple image with animation");
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
					'name'    => JText::_('Element Title'),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_('Image PB_INDEX_TRICK'),
					'role'    => 'title',
					'tooltip' => JText::_('Set title for current element for identifying easily')
				),
				array(
					'name'    => JText::_('Image File'),
					'id'      => 'image_file',
					'type'    => 'select_media',
					'std'     => '',
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => JText::_('Image File Description')
				),
				array(
					'name'    => JText::_('Alt Text'),
					'id'      => 'image_alt',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => '',
					'tooltip' => JText::_('Alt Text Description')
				),
				array(
					'name'    => JText::_('Image Site'),
					'id'      => 'image_size',
					'type'    => 'select',
					'std'     => 'fullsize',
					'options' => JSNPagebuilderHelpersType::getImageSize(),
					'tooltip' => JText::_('Image Size Description')
				),
				array(
					'name'       => JText::_('Link Type'),
					'id'         => 'link_type',
					'type'       => 'select',
					'std'        => JSNPagebuilderHelpersType::getFirstOption(JSNPagebuilderHelpersType::getImageLinkTypes()),
					'options'    => JSNPagebuilderHelpersType::getImageLinkTypes(),
					'tooltip'    => JText::_('Link Type Description'),
					'has_depend' => '1',
				),
				array(
					'name'       => JText::_('URL'),
					'id'         => 'image_type_url',
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
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_('Container Style'),
					'id'      => 'image_container_style',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption(JSNPagebuilderHelpersType::getContainerStyle()),
					'options' => JSNPagebuilderHelpersType::getContainerStyle(),
					'tooltip' => JText::_('Container Style Description')
				),
				array(
					'name'    => JText::_('Alignment'),
					'id'      => 'image_alignment',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption(JSNPagebuilderHelpersType::getTextAlign()),
					'options' => JSNPagebuilderHelpersType::getTextAlign(),
					'tooltip' => JText::_('Alignment Description')
				),
				array(
					'name'            => JText::_('Margin'),
					'container_class' => 'combo-group',
					'id'              => 'image_margin',
					'type'            => 'margin',
					'extended_ids'    => array('image_margin_top', 'image_margin_right', 'image_margin_bottom', 'image_margin_left'),
					'tooltip'         => JText::_('Margin Description')
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
		// Load js and style sheet for frontend
		JSNPagebuilderHelpersFunctions::loadFancyboxJS();
		$document = JFactory::getDocument();
		$document->addScript(JSNPB_ELEMENT_URL . '/image/assets/jquery-lazyload/jquery.lazyload.js');
		$document->addScript(JSNPB_ELEMENT_URL . '/image/assets/js/image.js');

		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts);
		extract($arr_params);
		$html_elemments = '';
		$alt_text       = ($image_alt) ? " alt='{$image_alt}'" : '';
		$image_styles   = array();
		if ($image_margin_top)
			$image_styles[] = "margin-top:{$image_margin_top}px";
		if ($image_margin_bottom)
			$image_styles[] = "margin-bottom:{$image_margin_bottom}px";
		if ($image_margin_right)
			$image_styles[] = "margin-right:{$image_margin_right}px";
		if ($image_margin_left)
			$image_styles[] = "margin-left:{$image_margin_left}px";
		$styles    = (count($image_styles)) ? ' style="' . implode(';', $image_styles) . '"' : '';
		$class_img = ($image_container_style != 'no-styling') ? $image_container_style : '';
		$class_img = (!empty($class_img)) ? ' class="' . $class_img . '"' : '';

		if (strtolower($image_size) != 'fullsize')
		{
			if (strtolower($image_size) == 'thumbnail')
				$img_width = 'width="150"';
			if (strtolower($image_size) == 'medium')
				$img_width = 'width="300"';
			if (strtolower($image_size) == 'large')
				$img_width = 'width="450"';
		}
		else
		{
			$img_width = '';
		}
		if ($image_file)
		{
			$pathRoot 	= JURI::root();
			$url_pattern = '/^(http|https)/';
			$image_file = $image_file;
			preg_match($url_pattern, $image_file, $m);
			if(count($m)){
				$pathRoot = '';
			}
			$html_elemments .= "<img src='{$pathRoot}{$image_file}'{$alt_text}{$styles}{$class_img}{$img_width}/>";
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
						$cls_button_fancy = ' pb-image-fancy';
						break;
				}
			}

			$class = (!empty($cls_button_fancy)) ? "class='{$cls_button_fancy}'" : '';

			if ($link_type == 'url')
			{
				$html_elemments = "<a href='{$image_type_url}'{$target}{$class}>" . $html_elemments . '</a>';
			}

			if (strtolower($image_alignment) != 'inherit')
			{
				if (strtolower($image_alignment) == 'left')
					$cls_alignment = 'pull-left';
				if (strtolower($image_alignment) == 'right')
					$cls_alignment = 'pull-right';
				if (strtolower($image_alignment) == 'center')
					$cls_alignment = 'text-center';
				$html_elemments = "<div class='{$cls_alignment}'>" . $html_elemments . '</div><div style="clear: both"></div>';

			}
		}

		return $this->element_wrapper($html_elemments, $arr_params);
	}

}
