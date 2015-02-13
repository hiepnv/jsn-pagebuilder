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
 * Tab shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeTab extends IG_Pb_Element {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Include admin scripts
	 */
	public function backend_element_assets() {
		$document = JFactory::getDocument();
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-fonticomoon.css', 'text/css' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 */
	public function element_config() {
		$this->config['shortcode']        = 'pb_tab';
		$this->config['name']             = JText::_( 'Tab' );
		$this->config['cat']              = JText::_( 'Typography' );
		$this->config['icon']             = 'icon-tab';
		$this->config['description'] 	  = JText::_("Tabbed content");
		$this->config['has_subshortcode'] = __CLASS__ . 'Item';
	}

	/**
	 * DEFINE setting options of shortcode
	 */
	public function element_items() {
		$this->items = array(
			'action' => array(
				array(
					'id'      => 'btn_convert',
					'type'    => 'button_group',
					'bound'   => 0,
					'actions' => array(
						array(
							'std'         => JText::_( 'Accordion' ),
							'action_type' => 'convert',
							'action'      => 'tab_to_accordion',
						),
						array(
							'std'         => JText::_( 'Carousel' ),
							'action_type' => 'convert',
							'action'      => 'tab_to_carousel',
						),
						array(
							'std'         => JText::_( 'List' ),
							'action_type' => 'convert',
							'action'      => 'tab_to_list',
						),
					)
				),
			),
			'content' => array(
				array(
					'name'    => JText::_( 'Element Title' ),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( 'Tab PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'id'            => 'tab_items',
					'name'          => JText::_( 'Tab Items' ),
					'type'          => 'group',
					'shortcode'     => $this->config['shortcode'],
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => '' ),
						array( 'std' => '' ),
					),
					'label_item' => JText::_( 'Tab Item' ),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'     => JText::_( 'Initial Open' ),
					'id'       => 'initial_open',
					'type'     => 'text_number',
					'std'      => '1',
					'class'    => 'input-mini',
					'validate' => 'number',
				),
				array(
					'name'       => JText::_( 'Fade Effect' ),
					'id'         => 'fade_effect',
					'type'       => 'radio',
					'std'        => 'no',
					'options'    => array( 'yes' => JText::_( 'Yes' ), 'no' => JText::_( 'No' )),
					'tooltip'    => 'Make Tab Fade In',
					'has_depend' => '1',
				),
				array(
					'name'    => JText::_( 'Tab Position' ),
					'id'      => 'tab_position',
					'type'    => 'select',
					'std'     => 'top',
					'options' => array( 'top' => JText::_( 'Top' ), 'bottom' => JText::_( 'Bottom' ), 'left' => JText::_( 'Left' ), 'right' => JText::_( 'Right' ) ),
				),
			)
		);
	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param type $atts
	 * @param type $content
	 */
	public function element_shortcode( $atts = null, $content = null ) {
		$document = JFactory::getDocument();
		$document->addStyleSheet( JSNPB_ELEMENT_URL.'/tab/assets/css/tab.css', 'text/css' );
		
		$arr_params   = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
		extract( $arr_params );
		$initial_open = intval( $initial_open );
		$tab_position = ( $tab_position );

		$random_id    = JSNPagebuilderHelpersShortcode::generateRandomString();
		$tab_navigator   = array();
		$tab_navigator[] = '<ul class="nav nav-tabs">';

		// extract icons of tab items
		$sub_sc_data = JSNPagebuilderHelpersShortcode::extractSubShortcode( $content );
		$sub_sc_data = $sub_sc_data[$this->config['has_subshortcode']];
		$items_data  = array('icons' => array(), 'heading' => array());
		foreach ( $sub_sc_data as $idx => $shortcode ) {
			$extract_params          = JSNPagebuilderHelpersShortcode::shortcodeParseAtts( $shortcode );
			$items_data['icons'][]   = ! empty( $extract_params['icon'] ) ? "<i class='{$extract_params['icon']}'></i>&nbsp;" : '';
			$items_data['heading'][] = isset( $extract_params['heading'] ) ? $extract_params['heading'] : '';
		}

		$sub_shortcode = empty($content) ? JSNPagebuilderHelpersShortcode::removeAutop($content) : JSNPagebuilderHelpersBuilder::generateShortCode($content, false, 'frontend', true);
		$items         = explode( '<!--seperate-->', $sub_shortcode );
		$items         = array_filter( $items );
		$initial_open  = ( $initial_open > count( $items ) ) ? 1 : $initial_open;
		if ( $fade_effect == 'yes' ) {
			$fade_effect = 'fade in';
		} else {
			$fade_effect = '';
		}
		foreach ( $items as $idx => $item ) {
			$active          = ( $idx + 1 == $initial_open ) ? 'active' : '';
			$item            = str_replace( '{index}', $random_id .'_'. $idx, $item );
			$item            = str_replace( '{active}', $active, $item );
			$item            = str_replace( '{fade_effect}', $fade_effect, $item );
			$items[ $idx ]   = $item;
			$active_li       = ( $idx + 1 == $initial_open ) ? "class='active'" : '';
			$href 			 = "#pane_". $random_id .'_'. $idx;
			$tab_navigator[] = "<li $active_li><a href='$href' data-toggle='tab'>{$items_data['icons'][$idx]}{$items_data['heading'][$idx]}</a></li>";
		}
		$sub_shortcode = implode( '', $items );
		$tab_content   = "<div class='tab-content'>$sub_shortcode</div>";
		// update min-height of each tab content in case tap position is left/right
		if ( in_array( $tab_position, array( 'left', 'right' ) ) ) {
			$min_height  = 36 * count( $items );
			$tab_content = str_replace( 'STYLE', "style='min-height: {$min_height}px'", $tab_content );
		}

		$tab_navigator[] = '</ul>';

		$tab_positions   = array( 'top' => '', 'left' => 'tabs-left', 'right' => 'tabs-right', 'bottom' => 'tabs-below' );
		$extra_class     = $tab_positions[ $tab_position ];
		if ( $tab_position == 'bottom' ) {
			$tab_content .= implode( '', $tab_navigator );
		} else {
			$tab_content = implode( '', $tab_navigator ) . $tab_content;
		}

		$html_element = "<div style='clear: both'></div> <div class='tabbable $extra_class' id='tab_{ID}'>$tab_content</div><div style='clear: both'></div>";
		$html_element = str_replace( '{ID}', "$random_id", $html_element );

		return $this->element_wrapper( $html_element, $arr_params );
	}

}
