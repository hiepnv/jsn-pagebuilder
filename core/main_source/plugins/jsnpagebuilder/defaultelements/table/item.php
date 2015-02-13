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
 * Table Item shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeTableItem extends IG_Pb_Child {

	/**
	 * Constructor
	 *
	 * @return type
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Include admin scripts
	 * 
	 * @return type
	 */
	public function backend_element_assets() {
		$document = JFactory::getDocument();
		$document->addScript( JSNPB_ELEMENT_URL.'/table/assets/js/table-setting.js', 'text/javascript' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 * 
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_table_item';
		$this->config['exception'] = array(
			'item_text'        => JText::_( '' ),
			'data-modal-title' => JText::_( 'Table Item' ),
			'item_wrapper'     => 'div',
			'action_btn'       => 'edit',
		);
	}

	/**
	 * DEFINE setting options of shortcode
	 */
	public function element_items() {
		$this->items = array(
			'Notab' => array(
				array(
					'name' => JText::_( 'Width' ),
					'type' => array(
						array(
							'id'           => 'width_value',
							'type'         => 'text_number',
							'std'          => '',
							'class'        => 'input-mini',
							'validate'     => 'number',
							'parent_class' => 'combo-item merge-data',
						),
						array(
							'id'           => 'width_type',
							'type'         => 'select',
							'class'        => 'input-mini',
							'options'      => array( '%' => '%', 'px' => 'px' ),
							'std'          => '%',
							'parent_class' => 'combo-item merge-data',
						),
					),
					'container_class' => 'combo-group',
					'tooltip' => JText::_( 'Set the width of a row (px or %)' ),
				),
				array(
					'name'            => JText::_( 'Tag Name' ),
					'id'              => 'tagname',
					'type'            => 'text_field',
					'std'             => 'td',
					'input-type'      => 'hidden',
					'container_class' => 'hidden',
				),
				array(
					'name'     => JText::_( 'Row Span' ),
					'id'       => 'rowspan',
					'type'     => 'text_number',
					'std'      => '1',
					'class'    => 'input-mini positive-val',
					'validate' => 'number',
					'role'     => 'extract',
					'tooltip' => JText::_( 'Enable extending over multiple rows' ),
				),
				array(
					'name'     => JText::_( 'Column Span' ),
					'id'       => 'colspan',
					'type'     => 'text_number',
					'std'      => '1',
					'class'    => 'input-mini positive-val',
					'validate' => 'number',
					'role'     => 'extract',
					'tooltip' => JText::_( 'Enable extending over multiple columns' ),
				),
				array(
					'name'    => JText::_( 'Row Style' ),
					'id'      => 'rowstyle',
					'type'    => 'select',
					'std'     => JSNPagebuilderHelpersType::getFirstOption( JSNPagebuilderHelpersType::getTableRowColor() ),
					'options' => JSNPagebuilderHelpersType::getTableRowColor(),
					'tooltip' => JText::_( 'Select a style for a row' )
				),
				array(
					'name'   => JText::_( 'Content' ),
					'id'     => 'cell_content',
					'role'   => 'content',
					'role_2' => 'title',
					'type'   => 'tiny_mce',
					'std'    => '',
					'tooltip' => JText::_( 'Table content' )
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
		extract( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
		$rowstyle       = ( ! $rowstyle || strtolower( $rowstyle ) == 'default' ) ? '' : $rowstyle;
		if ( in_array( $tagname, array( 'tr_start', 'tr_end' ) ) ) {
			return "$tagname<!--seperate-->";
		}
		$width = ! empty( $width_value ) ? "width='$width_value$width_type'" : '';
		$empty = empty( $content ) ? '<!--empty-->' : '';
		return "<CELL_WRAPPER class='$rowstyle' rowspan='$rowspan' colspan='$colspan' $width>" . JSNPagebuilderHelpersShortcode::removeAutop( $content ) . "</CELL_WRAPPER>$empty<!--seperate-->";
	}

}
