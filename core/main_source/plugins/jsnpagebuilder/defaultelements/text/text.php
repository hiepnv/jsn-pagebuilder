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
 * Text shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeText extends IG_Pb_Element
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
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-fontselector.js', 'text/javascript');
		$document->addScript(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/js/colorpicker.js', 'text/javascript');
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/css/colorpicker.css', 'text/css');
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-colorpicker.js', 'text/javascript');
		$document->addScript(JSNPB_ELEMENT_URL . '/text/assets/js/text-setting.js', 'text/javascript');
	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	function element_config()
	{
		$this->config['shortcode']   = 'pb_text';
		$this->config['name']        = "Text";
		$this->config['cat']         = JText::_('Typography');
		$this->config['icon']        = "icon-text";
		$this->config['description'] = JText::_("Simple text");

		$this->config['exception'] = array(
			'default_content' => JText::_('Text')
		);
	}

	/**
	 * DEFINE setting options of shortcode
	 *
	 * @return type
	 */
	function element_items()
	{
		$this->items = array(
			'content' => array(
				array(
					"name"    => JText::_("Element Title"),
					"id"      => "el_title",
					"type"    => "text_field",
					"class"   => "jsn-input-xxlarge-fluid",
					"std"     => JText::_('Text PB_INDEX_TRICK'),
					"role"    => "title",
					"tooltip" => JText::_("Set title for current element for identifying easily")
				),
				array(
					'name' => JText::_('Text Content'),
					'desc' => JText::_('Enter some content for this textblock'),
					'id'   => 'text',
					'type' => 'tiny_mce',
					'role' => 'content',
					'std'  => JSNPagebuilderHelpersType::loremText(),
					'rows' => 15
				),
			),
			'styling' => array(
				array(
					'type' => 'preview'
				),
				array(
					'name'            => JText::_('Width'),
					'type'            => array(
						array(
							'id'           => 'width_value',
							'type'         => 'text_number',
							'std'          => '',
							'class'        => 'input-mini',
							'validate'     => 'number',
							'parent_class' => 'combo-item merge-data',
						),
						array(
							'id'           => 'width_unit',
							'type'         => 'select',
							'options'      => array('%' => '%', 'px' => 'px'),
							'std'          => '%',
							'class'        => 'input-mini',
							'parent_class' => 'combo-item merge-data',
						),
					),
					'container_class' => 'combo-group',
					'tooltip'         => JText::_('Set the width of a row (px or %)')

				),
				array(
					'name'       => JText::_('Enable Dropcap'),
					'id'         => 'enable_dropcap',
					'type'       => 'radio',
					'std'        => 'no',
					'options'    => array('yes' => JText::_('Yes'), 'no' => JText::_('No')),
					'tooltip'    => JText::_('Enable Dropcap Description'),
					'has_depend' => '1'
				),
				array(
					'name'            => JText::_('Font Face'),
					'id'              => 'dropcap_font_family',
					'type'            => array(
						array(
							'id'           => 'dropcap_font_face_type',
							'type'         => 'jsn_select_font_type',
							'class'        => 'input-medium',
							'std'          => 'standard fonts',
							'options'      => JSNPagebuilderHelpersType::getFonts(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'dropcap_font_face_value',
							'type'         => 'jsn_select_font_value',
							'class'        => 'input-medium',
							'std'          => 'Verdana',
							'options'      => '',
							'parent_class' => 'combo-item',
						),
					),
					'dependency'      => array('enable_dropcap', '=', 'yes'),
					'tooltip'         => JText::_('Font Face Description'),
					'container_class' => 'combo-group',
				),
				array(
					'name'            => JText::_('Font Attributes'),
					'type'            => array(
						array(
							'id'           => 'dropcap_font_size',
							'type'         => 'text_append',
							'type_input'   => 'number',
							'class'        => 'input-mini',
							'std'          => '64',
							'append'       => 'px',
							'validate'     => 'number',
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'dropcap_font_style',
							'type'         => 'select',
							'class'        => 'input-medium',
							'std'          => 'bold',
							'options'      => JSNPagebuilderHelpersType::getFontStyles(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'dropcap_font_color',
							'type'         => 'color_picker',
							'std'          => '#000000',
							'parent_class' => 'combo-item',
						),
					),
					'dependency'      => array('enable_dropcap', '=', 'yes'),
					'tooltip'         => JText::_('Font Attribute Description'),
					'container_class' => 'combo-group',
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
	function element_shortcode($atts = null, $content = null)
	{
		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts);
		if (empty($content) && isset($atts['text']))
		{
			$content = $atts['text'];
		}
		extract($arr_params);

		$html_element = $html_style = $html_width = '';
		if (isset($enable_dropcap) && $enable_dropcap == 'yes')
		{
			if ($content)
			{
				$styles = array();
				if ($dropcap_font_face_type == 'google fonts' AND $dropcap_font_face_value != '')
				{
					$document = JFactory::getDocument();
					$document->addStyleSheet("http://fonts.googleapis.com/css?family={$dropcap_font_face_value}", 'text/css');
					$styles[] = 'font-family:' . $dropcap_font_face_value;
				}
				elseif ($dropcap_font_face_type == 'standard fonts' AND $dropcap_font_face_value)
				{
					$styles[] = 'font-family:' . $dropcap_font_face_value;
				}

				if (intval($dropcap_font_size) > 0)
				{
					$styles[] = 'font-size:' . intval($dropcap_font_size) . 'px';
					$styles[] = 'line-height:' . intval($dropcap_font_size) . 'px';
				}
				switch ($dropcap_font_style)
				{
					case 'bold':
						$styles[] = 'font-weight:700';
						break;
					case 'italic':
						$styles[] = 'font-style:italic';
						break;
					case 'normal':
						$styles[] = 'font-weight:normal';
						break;
				}

				if (strpos($dropcap_font_color, '#') !== false)
				{
					$styles[] = 'color:' . $dropcap_font_color;
				}

				if (count($styles))
				{
					$html_style .= 'div.pb-element-text p.dropcap:first-letter { float:left;';
					$html_style .= implode(';', $styles);
					$html_style .= '}';
				}

				$html_element .= "<p class='dropcap'>{$content}</p>";
			}
		}
		else
		{
			$html_element .= '<p>' . $content . '</p>';
		}
		if ($width_value)
		{
			$width_style = 'width:' . $width_value . $width_unit;
		}
		if (!empty($width_style))
		{
			$html_width .= 'div.pb-element-text{margin:0 auto;';
			$html_width .= $width_style;
			$html_width .= '}';
		}
		$document = JFactory::getDocument();
		if ($html_style)
		{
			$document->addStyleDeclaration($html_style, 'text/css');
		}
		if ($html_width)
		{
			$document->addStyleDeclaration($html_width, 'text/css');
		}

		return $this->element_wrapper($html_element, $arr_params);
	}

}
