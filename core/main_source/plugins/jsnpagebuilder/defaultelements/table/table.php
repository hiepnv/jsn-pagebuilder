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
 * Table shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeTable extends IG_Pb_Element {

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
		$document->addStyleSheet( JSNPB_ELEMENT_URL.'/table/assets/css/table.css', 'text/css' );
		$template = self::generateTableItemRowTemplate();
		$script = '
		var JSNPbParams = JSNPbParams || {pbstrings:{}};				
		JSNPbParams.tpml_table_item = \'' . addslashes( $template ) . '\';
		JSNPbParams.pbstrings.ROW_SPAN = \'' . JText::_( "Row span/Column span can\'t be negative" ) . '\';
		JSNPbParams.pbstrings.TABLE_COLUMNS = \'' . JText::_( "A table must has atleast 1 columns. You can\'t remove this column" ) . '\';
		JSNPbParams.pbstrings.TABLE_ROWS = \'' . JText::_( "A table must has atleast 2 rows. You can\'t remove this row" ) . '\';';
		
		$document->addScriptDeclaration( $script, 'text/javascript' );
		$document->addScript( JSNPB_ELEMENT_URL.'/table/assets/js/table-setting.js', 'text/javascript' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 * 
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode']        = 'pb_table';
		$this->config['name']             = JText::_( 'Table' );
		$this->config['cat']              = JText::_( 'Typography' );
		$this->config['icon']             = 'icon-table';
		$this->config['description'] 	  = JText::_("Simple table with flexible setting");
		$this->config['has_subshortcode'] = __CLASS__ . 'Item';
	}

	/**
	 * DEFINE setting options of shortcode
	 * 
	 * @return type
	 */
	public function element_items() {
		$this->items = array(
			'content' => array(
				array(
					'name'    => JText::_( 'Element Title' ),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( 'Table PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'name'          => JText::_( 'Table Content' ),
					'id'            => 'table_',
					'type'          => 'table',
					'shortcode'     => $this->config['shortcode'],
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => '[pb_table_item tagname="tr_start" ][/pb_table_item]' ),
						array( 'std' => '[pb_table_item width_value="" width_type="%" tagname="td" rowspan="1" colspan="1" rowstyle="default" ][/pb_table_item]' ),
						array( 'std' => '[pb_table_item width_value="" width_type="%" tagname="td" rowspan="1" colspan="1" rowstyle="default" ][/pb_table_item]' ),
						array( 'std' => '[pb_table_item tagname="tr_end" ][/pb_table_item]' ),
						array( 'std' => '[pb_table_item tagname="tr_start" ][/pb_table_item]' ),
						array( 'std' => '[pb_table_item width_value="" width_type="%" tagname="td" rowspan="1" colspan="1" rowstyle="default" ][/pb_table_item]' ),
						array( 'std' => '[pb_table_item width_value="" width_type="%" tagname="td" rowspan="1" colspan="1" rowstyle="default" ][/pb_table_item]' ),
						array( 'std' => '[pb_table_item tagname="tr_end" ][/pb_table_item]' ),
					),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => JText::_( 'Style' ),
					'id'      => 'tb_style',
					'type'    => 'select',
					'options' => array( 'table-default' => JText::_( 'Default' ), 'table-striped' => JText::_( 'Striped' ), 'table-bordered' => JText::_( 'Bordered' ), 'table-hover' => JText::_( 'Hover' ) ),
					'std'     => 'default',
					'tooltip' => JText::_( 'Select table style' ),
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
		$arr_params    = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );

		$sub_shortcode = empty($content) ? JSNPagebuilderHelpersShortcode::removeAutop($content) : JSNPagebuilderHelpersBuilder::generateShortCode($content, false, 'frontend', true);
		// seperate by cell
		$items_html    = explode( '<!--seperate-->', $sub_shortcode );

		// remove empty element
		$items_html    = array_filter( $items_html );
		$row           = 0;
		$not_empty     = 0;
		$updated_html  = array();
		foreach ( $items_html as $item ) {
			$cell_html = '';
			$cell_wrap = ( $row == 0 ) ? 'th' : 'td';
			if ( strpos( $item, 'CELL_WRAPPER' ) === false ) {
				$cell_html .= ( $item == 'tr_start' ) ? '<tr>' : '</tr>';
				if ( strip_tags( $item ) == 'tr_end' )
					$row++;
			}
			else {
				if ( strpos( $item, '<!--empty-->' ) !== false )
					$item = str_replace( '<!--empty-->', '', $item );
				else
					$not_empty++;
				$cell_html .= str_replace( 'CELL_WRAPPER', $cell_wrap, $item );
			}
			$updated_html[] = $cell_html;
		}
		$sub_shortcode = implode( '', $updated_html );
		if ( $not_empty == 0 )
			$sub_shortcode = '';

		$html_element = "<table class='table {$arr_params['tb_style']}'>" . $sub_shortcode . '</table>';
        $html_element .='<div class="clear:both"></div>';
		return $this->element_wrapper( $html_element, $arr_params );
	}
	
	/**
	 * Generate Table Item Row Template
	 * 
	 * @return string
	 */
	private static function generateTableItemRowTemplate() {
		$html = "<div class='jsn-item jsn-element ui-state-default jsn-iconbar-trigger shortcode-container' data-modal-title='Table Item' data-el-type='element' data-name='Table Item' _IG_STYLE_>";
		$html .= "	<textarea class='hidden shortcode-content' shortcode-name='pb_table_item' data-sc-info='shortcode_content' name='shortcode_content[]' >[pb_table_item width_value=\"\" width_type=\"%\" tagname=\"td\" rowspan=\"1\" colspan=\"1\" rowstyle=\"default\" ][/pb_table_item]</textarea>";
		$html .= "		<div class='jsn-item-content'></div>";
		$html .= "		<div class='jsn-iconbar'><a href=\"#\" onclick=\"return false;\" title=\"Edit element\" data-shortcode=\"pb_table_item\" class=\"element-edit\"><i class=\"icon-pencil\"></i></a></div>";
		$html .= "		<div class=\"shortcode-preview-container\" style=\"display: none\">";
		$html .= "		<div class=\"shortcode-preview-fog\"></div>";
		$html .= "		<div class=\"jsn-overlay jsn-bgimage image-loading-24\"></div>";
		$html .= "	</div>";
		$html .= "</div>";
		
		return $html;
	}
	
}
