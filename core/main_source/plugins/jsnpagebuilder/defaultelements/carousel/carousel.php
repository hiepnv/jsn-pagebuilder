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
 * Carousel shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeCarousel extends IG_Pb_Element
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
	}

	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config()
	{
		$this->config['shortcode']        = 'pb_carousel';
		$this->config['name']             = JText::_('Carousel');
		$this->config['cat']              = JText::_('Typography');
		$this->config['icon']             = 'icon-carousel';
		$this->config['description']      = JText::_("Rotating circular content with text and images");
		$this->config['has_subshortcode'] = __CLASS__ . 'Item';
	}

	/**
	 * DEFINE setting options of shortcode
	 *
	 * @return type
	 */
	public function element_items()
	{
		$this->items = array(
			'action'  => array(
				array(
					'id'      => 'btn_convert',
					'type'    => 'button_group',
					'bound'   => 0,
					'actions' => array(
						array(
							'std'         => JText::_('Tab'),
							'action_type' => 'convert',
							'action'      => 'carousel_to_tab',
						),
						array(
							'std'         => JText::_('Accordion'),
							'action_type' => 'convert',
							'action'      => 'carousel_to_accordion',
						),
						array(
							'std'         => JText::_('List'),
							'action_type' => 'convert',
							'action'      => 'carousel_to_list',
						),
					)
				),
			),
			'content' => array(
				array(
					'name'    => JText::_('Element Title'),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_('Carousel PB_INDEX_TRICK'),
					'role'    => 'title',
					'tooltip' => JText::_('Set title for current element for identifying easily')
				),
				array(
					'id'            => 'carousel_items',
					'name'          => JText::_('Carousel Items'),
					'type'          => 'group',
					'shortcode'     => $this->config['shortcode'],
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array('std' => ''),
						array('std' => ''),
					),
					'label_item'    => JText::_('Carousel Item'),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_('Alignment'),
					'id'      => 'align',
					'type'    => 'select',
					'std'     => 'center',
					'options' => JSNPagebuilderHelpersType::getTextAlign(),
					'tooltip' => JText::_('Setting position: right, left, center, inherit parent style')
				),
				array(
					'name'                 => JText::_('Dimension'),
					'container_class'      => 'combo-group',
					'id'                   => 'dimension',
					'type'                 => 'dimension',
					'extended_ids'         => array('dimension_width', 'dimension_height', 'dimension_width_unit'),
					'dimension_width'      => array('std' => ''),
					'dimension_height'     => array('std' => ''),
					'dimension_width_unit' => array(
						'options' => array('px' => 'px', '%' => '%'),
						'std'     => 'px',
					),
					'tooltip'              => JText::_('Set width and height of element'),
				),
				array(
					'name'    => JText::_('Show Indicator'),
					'id'      => 'show_indicator',
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array('yes' => JText::_('Yes'), 'no' => JText::_('No')),
					'tooltip' => JText::_('Show/hide navigation buttons inside your carousel'),
				),
				array(
					'name'    => JText::_('Show Arrows'),
					'id'      => 'show_arrows',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array('yes' => JText::_('Yes'), 'no' => JText::_('No')),
					'tooltip' => JText::_('Show/hide arrow buttons'),
				),
				array(
					'name'       => JText::_('Automatic Cycling'),
					'id'         => 'automatic_cycling',
					'type'       => 'radio',
					'std'        => 'no',
					'options'    => array('yes' => JText::_('Yes'), 'no' => JText::_('No')),
					'has_depend' => '1',
					'tooltip'    => JText::_('Whether to running your carousel automatically or not'),
				),
				array(
					'name'       => JText::_('Cycling Interval'),
					'type'       => array(
						array(
							'id'         => 'cycling_interval',
							'type'       => 'text_append',
							'type_input' => 'number',
							'class'      => 'input-mini',
							'std'        => '5',
							'append'     => 'second(s)',
							'validate'   => 'number',
						),
					),
					'dependency' => array('automatic_cycling', '=', 'yes'),
					'tooltip'    => JText::_('Set interval for each cycling'),
				),
				array(
					'name'       => JText::_('Pause on mouse over'),
					'id'         => 'pause_mouseover',
					'type'       => 'radio',
					'std'        => 'yes',
					'options'    => array('yes' => JText::_('Yes'), 'no' => JText::_('No')),
					'dependency' => array('automatic_cycling', '=', 'yes'),
					'tooltip'    => JText::_('Pause cycling on mouse over'),
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
		$document = JFactory::getDocument();
		$document->addStyleSheet(JSNPB_ELEMENT_URL . '/carousel/assets/css/carousel.css', 'text/css');
		$document->addStyleSheet(JSNPB_ELEMENT_URL . '/carousel/assets/css/carousel-responsive.css', 'text/css');
		$document->addScriptDeclaration("if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined' ) {
										    Element.implement({
										        slide: function(how, mode){
										            return this;
										        }
										    });

										}", 'text/javascript');

		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts($this->config['params'], $atts);
		extract($arr_params);
		$random_id   = JSNPagebuilderHelpersShortcode::generateRandomString();
		$carousel_id = "carousel_$random_id";

		// Set fixed stylesheet
		$document->addStyleDeclaration("#$carousel_id .item{
			width: 100% !important;
			margin: 0;
		}", 'text/css');

		$interval_time = !empty($cycling_interval) ? intval($cycling_interval) * 1000 : 5000;
		$interval      = ($automatic_cycling == 'yes') ? $interval_time : 'false';
		$pause         = ($pause_mouseover == 'yes') ? 'pause : "hover"' : 'pause : "false"';
		$script        = "<script type='text/javascript'>
			(function ($){ 
				$( document ).ready(function(){
					if( $( '#$carousel_id' ).length ){ 
						$( '#$carousel_id' ).carousel( {interval: $interval,$pause} );
						
						$( '#$carousel_id .carousel-indicators li' ).each(function (i) {
							$(this).on('click', function () {
								$('#$carousel_id').carousel(i);
							});
						});
					}
				});
			} )( JoomlaShine.jQuery );
		</script>";

		$styles = array();
		if (!empty($dimension_width))
			$styles[] = "width : {$dimension_width}{$dimension_width_unit};";
		if (!isset($atts['dimension_height']))
		{
			$styles[] = "min-height : 0px;";
		}
		else if (!empty($dimension_height))
		{
			$styles[] = "min-height : {$dimension_height}px;";
		}
		if (in_array($align, array('left', 'right', 'inherit')))
		{
			$styles[] = 'float : ' . $align . ';';
		}
		else if ($align == 'center')
			$styles[] = 'margin : 0 auto;';

		$styles = trim(implode(' ', $styles));
		$styles = !empty($styles) ? "style='$styles'" : '';

		$carousel_indicators   = array();
		$carousel_indicators[] = '<ol class="carousel-indicators">';

		$sub_shortcode = empty($content) ? JSNPagebuilderHelpersShortcode::removeAutop($content) : JSNPagebuilderHelpersBuilder::generateShortCode($content, false, 'frontend', true);
		$items         = explode('<!--seperate-->', $sub_shortcode);
		$items         = array_filter($items);
		$initial_open  = isset($initial_open) ? (($initial_open > count($items)) ? 1 : $initial_open) : 1;
		foreach ($items as $idx => $item)
		{
			$active                = ($idx + 1 == $initial_open) ? 'active' : '';
			$item                  = str_replace('{active}', $active, $item);
			$item                  = str_replace('{WIDTH}', (!empty($dimension_width)) ? 'width : ' . $dimension_width . $dimension_width_unit . ';' : '', $item);
			$item                  = str_replace('{HEIGHT}', (!empty($dimension_height)) ? 'height : ' . $dimension_height . 'px;' : '', $item);
			$items[$idx]           = $item;
			$active_li             = ($idx + 1 == $initial_open) ? "class='active'" : '';
			$carousel_indicators[] = "<li data-target='#$carousel_id' $active_li></li>";
		}
		$carousel_content = "<div class='carousel-inner'>" . implode('', $items) . '</div>';

		$carousel_indicators[] = '</ol>';
		$carousel_indicators   = implode('', $carousel_indicators);

		if ($show_indicator == 'no')
			$carousel_indicators = '';

		$carousel_navigator = '';
		if ($show_arrows == 'yes')
			$carousel_navigator = "<a class='left carousel-control' href='#$carousel_id' data-slide='prev'><span class='icon-arrow-left'></span></a><a class='right carousel-control' href='#$carousel_id' data-slide='next'><span class='icon-arrow-right'></span></a>";

		$html = "<div class='carousel slide' $styles id='$carousel_id'>$carousel_indicators $carousel_content $carousel_navigator</div><div style=\"clear: both\"></div>";

		return $this->element_wrapper($html . $script, $arr_params);
	}

}
