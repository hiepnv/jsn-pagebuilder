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
 * Progress Circle shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeProgresscircle extends IG_Pb_Element
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
		$document->addScript(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/js/colorpicker.js', 'text/javascript');
		$document->addStyleSheet(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/css/colorpicker.css', 'text/css');
		$document->addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-colorpicker.js', 'text/javascript');
		$document->addScript(JSNPB_ELEMENT_URL . '/progresscircle/assets/js/progresscircle-settings.js', 'text/javascript');
	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config()
	{
		$this->config['shortcode']        = 'pb_progresscircle';
		$this->config['name']             = JText::_('Progress Circle');
		$this->config['cat']              = JText::_('Typography');
		$this->config['icon']             = 'icon-progress-circle';
		$this->config['description']      = JText::_("Animated progress bar");
		$this->config['has_subshortcode'] = __CLASS__ . 'Item';
		$this->config['exception']        = array(
			'default_content'  => JText::_('Progress Circle'),
			'data-modal-title' => JText::_('Progress Circle')
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
			'content' => array(
				array(
					'name'    => JText::_('Element Title'),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_('Progress Circle PB_INDEX_TRICK'),
					'role'    => 'title',
					'tooltip' => JText::_('Set title for current element for identifying easily'),
				),
				array(
					'name' => JText::_('Text'),
					'id'   => 'text',
					'type' => 'text_field',
					'role' => 'content',
					'std'  => JText::_('Circle'),
				),
				array(
					'name' => JText::_('Description'),
					'id'   => 'description',
					'type' => 'text_field',
					'std'  => JText::_('The Circle Information'),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'       => JText::_('Percenttage'),
					'id'         => 'percent',
					'type'       => 'text_append',
					'type_input' => 'number',
					'class'      => 'input-mini',
					'std'        => '15',
					'append'     => '%',
					'validate'   => 'number',
				),
				array(
					'name' => JText::_('Foreground Color'),
					'id'   => 'fg_color',
					'type' => 'color_picker',
					'std'  => '#556b2f',
				),
				array(
					'name' => JText::_('Background Color'),
					'id'   => 'bg_color',
					'type' => 'color_picker',
					'std'  => '#eeeeee',
				),
				array(
					'name'       => JText::_('Use Fill Color'),
					'id'         => 'use_fill',
					'type'       => 'radio',
					'std'        => 'no',
					'has_depend' => '1',
					'options'    => array('yes' => JText::_('Yes'), 'no' => JText::_('No')),
				),
				array(
					'name'       => JText::_('Fill color'),
					'id'         => 'fill_color',
					'type'       => 'color_picker',
					'std'        => '#ffffff',
					'dependency' => array('use_fill', '=', 'yes'),
				),
				array(
					'name'       => JText::_('Circle Thickness'),
					'id'         => 'width',
					'type'       => 'text_append',
					'type_input' => 'number',
					'class'      => 'input-mini',
					'std'        => '15',
					'append'     => 'px',
					'validate'   => 'number',
				),
				array(
					'name'       => JText::_('Dimension'),
					'id'         => 'dimension',
					'type'       => 'text_append',
					'type_input' => 'number',
					'class'      => 'input-mini',
					'std'        => '200',
					'append'     => 'px',
					'validate'   => 'number',
					'tooltip'    => JText::_('Size of process circle, calculated by its diameter'),
				),
				array(
					'name'       => JText::_('Font Size'),
					'id'         => 'font_size',
					'type'       => 'text_append',
					'type_input' => 'number',
					'class'      => 'input-mini',
					'std'        => '15',
					'append'     => 'px',
					'validate'   => 'number',
				),
				array(
					'name'               => JText::_('Icon'),
					'id'                 => 'icon',
					'type'               => 'icons',
					'std'                => '',
					'title_prepend_type' => 'icon',
				),
				array(
					'name'    => JText::_('Show half'),
					'id'      => 'is_half',
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array('yes' => JText::_('Yes'), 'no' => JText::_('No')),
				),
				array(
					'name'                 => JText::_('Margin'),
					'id'                   => 'circle_margin',
					'container_class'      => 'combo-group',
					'type'                 => 'margin',
					'extended_ids'         => array('circle_margin_top', 'circle_margin_bottom', 'circle_margin_left', 'circle_margin_right'),
					'circle_margin_top'    => array('std' => '10'),
					'circle_margin_bottom' => array('std' => '10'),
					'tooltip'              => JText::_('External spacing width other elements'),
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
		$document = JFactory::getDocument();
		$document->addStyleSheet(JSNPB_ELEMENT_URL . '/progresscircle/assets/3rd-party/jquery-circliful/css/jquery.circliful.css', 'text/css');
		$document->addStyleSheet(JSNPB_ELEMENT_URL . '/progresscircle/assets/css/progresscircle.css', 'text/css');
		$document->addScript(JSNPB_ELEMENT_URL . '/progresscircle/assets/js/progresscircle.js', 'text/javascript');
		$document->addScript(JSNPB_ELEMENT_URL . '/progresscircle/assets/3rd-party/jquery-circliful/js/jquery.circliful.min.js', 'text/javascript');
		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts);
		extract($arr_params);
		if (isset($circle_margin_left))
		{
			$circle_styles[] = "margin-left:{$circle_margin_left}px";
		}
		if (isset($circle_margin_right))
		{
			$circle_styles[] = "margin-right:{$circle_margin_right}px";
		}
		if (isset($circle_margin_top))
		{
			$circle_styles[] = "margin-top:{$circle_margin_top}px";
		}
		if (isset($circle_margin_bottom))
		{
			$circle_styles[] = "margin-bottom:{$circle_margin_bottom}px";
		}
		$styles = (count($circle_styles)) ? ' style="' . implode(';', $circle_styles) . '"' : '';
		$html = '<div class="pb-progress-circle" ';
		$html .= (!empty($content)) ? 'data-text="' . $content . '"' : '';
		$html .= (!empty($description)) ? 'data-info="' . $description . '"' : '';
		$html .= (!empty($dimension)) ? 'data-dimension="' . $dimension . '"' : '';
		$html .= (!empty($width)) ? 'data-width="' . $width . '"' : '';
		$html .= (!empty($font_size)) ? 'data-fontsize="' . $font_size . '"' : '';
		$html .= (!empty($percent)) ? 'data-percent="' . $percent . '"' : '';
		$html .= (!empty($fg_color)) ? 'data-fgcolor="' . $fg_color . '"' : '';
		$html .= (!empty($bg_color)) ? 'data-bgcolor="' . $bg_color . '"' : '';

		if ($use_fill == 'yes')
		{
			$html .= (!empty($fill_color)) ? 'data-fill="' . $fill_color . '"' : '';
		}
		if ($is_half == 'yes')
		{
			$html .= 'data-type="half"';
		}
		$html .= (!empty($icon)) ? 'data-icon="' . $icon . '"' : '';
		$html .= $styles . '></div>';

		return $this->element_wrapper($html, $arr_params);
	}

}
