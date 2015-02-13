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

include_once(dirname(__FILE__) . '/pricingtable/item.php');
include_once(dirname(__FILE__) . '/pricingtable.php');
class JSNPBShortcodePricingtableItem extends IG_Pb_Parent {

	public function __construct() {
		parent::__construct();

		// Increase index of pricing option
		JSNPBShortcodePricingTable::$index ++;
	}

	/**
	 * Include admin scripts
	 *
	 * @return type
	 */
	public function backend_element_assets() {
		$document = JFactory::getDocument();
		$document->addScript(JSNPB_ELEMENT_URL . '/pricingtable/assets/js/pricingtable-settings.js', 'text/javascript');
		$document->addScript( JSNPB_ELEMENT_URL. '/pricingtable/assets/js/item_pricingtable.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_ELEMENT_URL.'/pricingtable/assets/css/item_pricingtable.css', 'text/css' );
		$document->addScript( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-linktype.js', 'text/javascript' );
	}

	public function element_config() {
		$this->config['shortcode']        = 'pb_pricingtable_item';
		$this->config['has_subshortcode'] = ( __CLASS__ ) . 'Item';
		$this->config['exception']        = array(
			'item_text'        => JText::_( 'Option'),
			'data-modal-title' => JText::_( 'Option'),
		);



	}

	public function element_items() {
		$this->items = array(
			'Notab' => array(
				array(
					'name'    => JText::_( 'Title'),
					'id'      => 'prtbl_item_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'role'    => 'title',
					'std'     => '',
					'tooltip' => JText::_( 'Title')
				),
				array(
					'name'    => JText::_( 'Description'),
					'id'      => 'prtbl_item_desc',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( ''),
					'tooltip' => JText::_( 'Description Tooltip')
				),
				array(
					'name'    => JText::_( 'Image'),
					'id'      => 'prtbl_item_image',
					'type'    => 'select_media',
					'std'     => '',
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => JText::_( 'Image File')
				),
				array(
					'name'    => JText::_( 'Currency'),
					'id'      => 'prtbl_item_currency',
					'type'    => 'text_field',
					'std'     => JText::_( ''),
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => JText::_( 'Currency'),
				),
				array(
					'name'    => JText::_( 'Price'),
					'id'      => 'prtbl_item_price',
					'type'    => 'text_field',
					'std'     => JText::_( ''),
					'class'   => 'jsn-input-large-fluid wr_pb_price',
					'tooltip' => JText::_( 'Price')
				),
				array(
					'name'    => JText::_( 'Time Limits'),
					'id'      => 'prtbl_item_time',
					'type'    => 'text_field',
					'std'     => JText::_( ''),
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => JText::_( 'Time Limits'),
				),
				array(
					'name'    => JText::_( 'Button Text'),
					'id'      => 'prtbl_item_button_text',
					'type'    => 'text_field',
					'class'   => 'jsn-input-large-fluid pb-pb-limit-length',
					'std'     => JText::_( 'Buy now'),
					'tooltip' => JText::_( 'Button Text')
				),
				array(
					'name'       => JText::_( 'Button Link'),
					'id'         => 'link_type',
					'type'       => 'select',
					'std'        => JText::_( 'url'),
					'options'    => JSNPagebuilderHelpersType::getLinkTypes(),
					'tooltip'    => JText::_( 'Button Link'),
					'has_depend' => '1',
				),
				array(
					'name'       => JText::_( 'URL'),
					'id'         => 'button_type_url',
					'type'       => 'text_field',
					'class'      => 'jsn-input-xxlarge-fluid',
					'std'        => 'http://',
					'tooltip'    => JText::_( 'URL'),
					'dependency' => array( 'link_type', '=', 'url' )
				),
				array(
					'name'       => JText::_( 'Open in'),
					'id'         => 'open_in',
					'type'       => 'select',
					'std'        => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getOpenInOptions() ),
					'options'    => JSNPagebuilderHelpersType::getOpenInOptions(),
					'dependency' => array( 'link_type', '!=', 'no_link' )
				),
				array(
					'id'              => 'prtbl_item_attributes',
					'type'            => 'text_field',
					'std'             => '',
					'input-type'      => 'hidden',
					'container_class' => 'hidden',
				),
				array(
					'name'          => JText::_( 'Attributes'),
					'id'            => 'prtbl_attr',
					'type'          => 'group_table',
					'class'         => 'has_childsubmodal unsortable',
					'shortcode'     => $this->config['shortcode'],
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						JSNPBShortcodePricingTable::get_option( 'max_domains', true ),
						JSNPBShortcodePricingTable::get_option( 'storage', true ),
						JSNPBShortcodePricingTable::get_option( 'ssl_support', true ),
					),
					'extract_title' => 'prtbl_item_attr_title',
				),
				array(
					'name'    => JText::_( 'Featured'),
					'id'      => 'prtbl_item_feature',
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array( 'yes' => JText::_( 'Yes'), 'no' => JText::_( 'No') ),
					'tooltip' => 'Featured',
				),
			)
		);

	}

	public function element_shortcode( $atts = null, $content = null ) {
		$arr_params = JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts );
		extract( $arr_params );

		$href = 'href="' .$button_type_url .'"';

		$target = $script = '';
		if ( $open_in ) {
			switch ( $open_in ) {
				case 'current_browser':
					$target = '';
					break;
				case 'new_browser':
					$target = ' target="_blank"';
					break;
				case 'new_window':
					$cls_button_fancy = 'pb-button-new-window';
					break;
				case 'lightbox':
					$cls_button_fancy = 'pb-prtbl-button-fancy';
					break;
			}
		}
		$button_type      = " type='button'";
		$cls_button_fancy = ( ! isset( $cls_button_fancy ) ) ? '' : $cls_button_fancy;
		$script           = ( ! isset( $script ) ) ? '' : $script;

		// Process col title
		$attr_title     .= '<div class="pb-prtbl-title">';
		// Process for image
		$attr_title     .= '[prtbl_item_image]<div class="pb-prtbl-image">';
		if ( $prtbl_item_image ) {
			$pathRoot 	= JURI::root();
			$url_pattern = '/^(http|https)/';
			$image_file = $prtbl_item_image;
			preg_match($url_pattern, $image_file, $m);
			if(count($m)){
				$pathRoot = '';
			}
			$attr_title .= '<img src="' . $pathRoot . $prtbl_item_image . '" />';
		}
		$attr_title     .= '</div>[/prtbl_item_image]';
		// Process for title
		$attr_title     .= '[prtbl_item_title]<h3>' . $prtbl_item_title . '</h3>[/prtbl_item_title]';
		$attr_title     .= '</div>';

		$attr_title     .= '[prtbl_item_meta]<div class="pb-prtbl-meta">';
		$attr_title     .= '[prtbl_item_price]<div class="pb-prtbl-price">';
		if ( $prtbl_item_currency ) {
			$attr_title .= '<sup class="pb-prtbl-currency">' . $prtbl_item_currency . '</sup>';
		}
		$attr_title     .= $prtbl_item_price;
		if ( $prtbl_item_time ) {
			$attr_title .= '<sub class="pb-prtbl-time">' . $prtbl_item_time . '</sub>';
		}
		$attr_title     .= '</div>[/prtbl_item_price]';
		// Process for description
		$attr_title     .= '[prtbl_item_desc]<p class="pb-prtbl-desc">' . $prtbl_item_desc . '</p>[/prtbl_item_desc]';
		$attr_title     .= '</div>[/prtbl_item_meta]';

		$featured = ( $prtbl_item_feature == 'yes' ) ? ' pb-prtbl-cols-featured' : '';
		$pr_tbl_col_html = "<div class='pb-prtbl-cols{$featured}'>";
		$pr_tbl_col_html .= '<div class="pb-prtbl-header">' . $attr_title . '</div>';
		if ( ! empty( $content ) ) {
			$pr_tbl_col_html .= '<ul class="pb-prtbl-features">';
			$pr_tbl_col_html .=  JSNPagebuilderHelpersBuilder::generateShortCode($content, false, 'frontend', true);
			$pr_tbl_col_html .= '</ul>';
		}

		$pr_tbl_col_html .= "[prtbl_item_button]<div class='pb-prtbl-footer'><a class='btn btn-default {$cls_button_fancy}'{$href}{$target}{$button_type}>{$prtbl_item_button_text}</a></div>[/prtbl_item_button]";
		$pr_tbl_col_html .= '</div>';

		return $pr_tbl_col_html . $script;
	}

	/**
	 * Over write parent method, set this element as Child element
	 *
	 * @param string $content
	 * @param string $shortcode_data
	 * @param string $el_title
	 *
	 * @return string
	 */

	public function element_in_pgbldr( $content = '', $shortcode_data = '', $el_title = '') {
		$this->config['sub_element'] = true;
		$html =  parent::element_in_pgbldr( $content, $shortcode_data, $el_title);
		return $html;
	}

	/**
	 * Filter sub shortcodes content
	 *
	 * @param array        $sub_sc_data        The array of (sub shortcodes content) attributes of a pricing option
	 * @param string       $shortcode          The shortcode name
	 * @param string|array $attributes_content The Attributes list of Pricing Table
	 */
	public static function _sub_items_filter( $sub_sc_data, $shortcode, $attributes_content ) {

		if ( $shortcode != 'pb_pricingtable_item' ) {
			return $sub_sc_data;
		}

		// Get array of "pricing Attributes"
		if ( is_string( $attributes_content ) ) {
			$attributes_content = stripslashes( $attributes_content );
			$attributes         = explode( '--[pb_seperate_sc]--', $attributes_content );
		} else if ( is_array( $attributes_content ) ) {
			$attributes = $attributes_content;
		}


		// Key parameter to check relationship between "Attribute in Pricing Item" and "pricing Attribute"
		$key_parameter = 'prtbl_item_attr_id';

		// List of parameter id to sync between "Attribute in Pricing Item" and "pricing Attribute"
		$param_to_sync = array( $key_parameter, 'prtbl_item_attr_title', 'prtbl_item_attr_type' );

		// Store updated shortcode content
		$result = array();

		// Start updating shortcode content
		foreach ( $sub_sc_data as $sc_class => $sub_sc_data_ ) {

			// Update array of Attributes in this Pricing Item, add value of $key_parameter as key
			$sub_sc_data_new = array();
			foreach ( $sub_sc_data_ as $value ) {
				$params               = JSNPagebuilderHelpersShortcode::shortcodeParseAtts( $value );
				$id                   = $params[$key_parameter];
				$sub_sc_data_new[$id] = $value;
			}

			// Save all exist/new attributes
			$updated_sc_attrs = array();

			foreach ( $attributes as $attribute ) {
				$attr_params = JSNPagebuilderHelpersShortcode::shortcodeParseAtts( $attribute );

				$id          = $attr_params[$key_parameter];

				// Get "Attribute in Pricing Item" relates to this "pricing Attribute"
				$is_new_attr = 0;

				if ( isset ( $sub_sc_data_new[$id] ) ) {
					$related_attr = $sub_sc_data_new[$id];
				} else {
					// if attribute is not existed, get the first attribute in $sub_sc_data_
					$related_attr = reset( $sub_sc_data_ );
					$is_new_attr  = 1;
				}

				// Extract parameters
				$params_of_attr = JSNPagebuilderHelpersShortcode::shortcodeParseAtts( $related_attr );

				// Get real attributes ( remove first & last element in array: [0] => "[shortcode_tag" ; [1] => "][/shortcode_tag]" )
				$params_of_attr_real = $params_of_attr;
				if ( is_array( $params_of_attr_real ) ) {
					unset ( $params_of_attr_real[0] );
					unset ( $params_of_attr_real[1] );
				}

				// Update parameter's value from "pricing Attribute" to "Attribute in Pricing Item"
				foreach ( $param_to_sync as $parameter ) {
					$params_of_attr_real[$parameter] = isset ( $attr_params[$parameter] ) ? $attr_params[$parameter] : '';
				}

				// Reset parameters of new Attribute which is not in array $param_to_sync
				if ( $is_new_attr ) {
					foreach ( $params_of_attr_real as $parameter_name => $value ) {
						if ( ! in_array( $parameter_name, $param_to_sync ) ) {
							$params_of_attr_real[$parameter_name] = '';
						}
					}
				}

				// Join parametes to creating shortcode content
				$sc_content = $params_of_attr[0];

				foreach ( $params_of_attr_real as $parameter_name => $value ) {
					$sc_content .= " $parameter_name=\"$value\"";
				}

				$sc_content .= $params_of_attr[1];

				$updated_sc_attrs[] = $sc_content;
			}


			$result[$sc_class] = $updated_sc_attrs;
		}

		return $result;
	}

}

