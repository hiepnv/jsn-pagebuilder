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
 * Helper type
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPagebuilderHelpersType {
	
	/**
	 * Google map type options
	 *
	 * @return array
	 */
	static function getGmapType() {
		return array(
			'HYBRID'    => JText::_( 'Hybrid' ),
			'ROADMAP'   => JText::_( 'Roadmap' ),
			'SATELLITE' => JText::_( 'Satellite' ),
			'TERRAIN'   => JText::_( 'Terrain' ),
		);
	}
	
	/**
	 * Zoom level options for google element
	 *
	 * @return array
	 */
	static function getZoomLevel() {
		return array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6',
			'7' => '7',
			'8' => '8',
			'9' => '9',
			'10' => '10',
			'11' => '11',
			'12' => '12',
			'13' => '13',
			'14' => '14',
		);
	}
	
	/**
	 * Container style options
	 * 
	 * @return type
	 */
	static function getContainerStyle() {
		return array(
			'no-styling'    => JText::_( 'No Styling' ),
			'img-rounded'   => JText::_( 'Rounded' ),
			'img-circle'    => JText::_( 'Circle' ),
			'img-thumbnail' => JText::_( 'Thumbnail' )
		);
	}
	
	/**
	 * Zoom level options for QRCode element
	 *
	 * @return array
	 */
	static function getQRContainerStyle() {
		return array(
			'no-styling'    => JText::_( 'No Styling' ),
			'img-thumbnail' => JText::_( 'Thumbnail' )
		);
	}
	
	/**
	 * Pricing table design options
	 *
	 * @return array
	 */
	static function getPRTBLDesignOptions() {
		return array(
			'table-style-one'	=> JText::_( 'Design option 1' ),
			'table-style-two'	=> JText::_( 'Design option 2' ),
		);
	}
	
	/**
	 * Table design options
	 *
	 * @return array
	 */
	static function getTableRowColor() {
		return array(
			'default' => JText::_( 'Default' ),
			'active'  => JText::_( 'Active (Grey)' ),
			'success' => JText::_( 'Success (Green)' ),
			'warning' => JText::_( 'Warning (Orange)' ),
			'danger'  => JText::_( 'Danger (Red)' ),
		);
	}
	
	/**
	 * Alert type options
	 *
	 * @return array
	 */
	static function getAlertType() {
		return array(
			'alert-warning' => JText::_( 'Default' ),
			'alert-success' => JText::_( 'Success' ),
			'alert-info'    => JText::_( 'Info' ),
			'alert-danger'  => JText::_( 'Danger' ),
		);
	}
	
	/**
	 * Progress bar color options
	 *
	 * @return array
	 */
	static function getProgressBarColor() {
		return array(
			'default'              => JText::_( 'Default' ),
			'progress-bar-info'    => JText::_( 'Info (Light Blue)' ),
			'progress-bar-success' => JText::_( 'Success (Green)' ),
			'progress-bar-warning' => JText::_( 'Warning (Orange)' ),
			'progress-bar-danger'  => JText::_( 'Danger (Red)' ),
		);
	}
	
	/**
	 * Progress bar style options
	 *
	 * @return array
	 */
	static function getProgressBarStyle() {
		return array(
			'multiple-bars' => JText::_( 'Multiple bars' ),
			'stacked' 		=> JText::_( 'Stacked' ),
		);
	}
	
	/**
	 * Progress bar item options
	 *
	 * @return array
	 */
	static function getProgressBarItemStyle() {
		return array(
			'solid'   => JText::_( 'Solid' ),
			'striped' => JText::_( 'Striped' ),
		);
	}
	

	/**
	 * Static function to get button color Options
	 *
	 * @return array
	 */
	static function getButtonColor() {
		return array(
			'btn-default' => JText::_( 'Default' ),
			'btn-primary' => JText::_( 'Primary (Dark Blue)' ),
			'btn-info'    => JText::_( 'Info (Light Blue)' ),
			'btn-success' => JText::_( 'Success (Green)' ),
			'btn-warning' => JText::_( 'Warning (Orange)' ),
			'btn-danger'  => JText::_( 'Danger (Red)' ),
			'btn-link'    => JText::_( 'Link' )
		);
	}
	
	/**
	 * Button size options
	 * 
	 * @return type
	 */
	static function getButtonSize() {
		return array(
			'default' => JText::_( 'Default' ),
			'btn-xs'  => JText::_( 'Mini' ),
			'btn-sm'  => JText::_( 'Small' ),
			'btn-lg'  => JText::_( 'Large' )
		);
	}
	
	/**
	 * "Open in" option for anchor
	 * 
	 * @return type
	 */
	static function getOpenInOptions() {
		return array(
			'current_browser' => JText::_( 'Current Browser' ),
			'new_browser' 	  => JText::_( 'New Browser' ),
			'lightbox' 		  => JText::_( 'Lightbox' ),
		);
	}
	
	/**
	 * Icon position for List shortcode
	 * 
	 * @return type
	 */
	static function getIconPosition() {
		return array(
			'left'  => JText::_( 'Left' ),
			'right' => JText::_( 'Right' ),
            'center' => JText::_( 'Center' ),
		);
	}

	/**
	 * Position options
	 * 
	 * @return type
	 */
	static function getFullPositions() {
		return array(
			'top'    => JText::_( 'Top' ),
			'bottom' => JText::_( 'Bottom' ),
			'left'   => JText::_( 'Left' ),
			'right'  => JText::_( 'Right' ),
		);
	}
	
	/**
	 * Icon size options
	 * 
	 * @return type
	 */
	static function getIconSizes() {
		return array(
			'16' => '16',
			'24' => '24',
			'32' => '32',
			'48' => '48',
			'64' => '64',
		);
	}
	
	/**
	 * Icon style for List shortcode
	 * 
	 * @return type
	 */
	static function getIconBackground() {
		return array(
			'circle' => JText::_( 'Circle' ),
			'square' => JText::_( 'Square' )
		);
	}
	
	/**
	 * Font options
	 * 
	 * @return array
	 */
	static function getFonts() {
		return array(
			'standard fonts' => JText::_( 'Standard fonts' ),
			'google fonts'   => JText::_( 'Google fonts' )
		);
	}
	
	/**
	 * Text align options
	 *
	 * @return array
	 */
	static function getTextAlign() {
		return array(
			'inherit' => JText::_( 'Inherit' ),
			'left'    => JText::_( 'Left' ),
			'center'  => JText::_( 'Center' ),
			'right'   => JText::_( 'Right' )
		);
	}
	
	/**
	 * Font size options
	 * 
	 * @return type
	 */
	static function getFontSizeTypes() {
		return array(
			'px'   => 'px',
			'em'   => 'em',
			'inch' => 'inch',
		);
	}
	
	/**
	 * Border style options
	 *
	 * @return array
	 */
	static function getBorderStyles() {
		return array(
			'solid'  => JText::_( 'Solid' ),
			'dotted' => JText::_( 'Dotted' ),
			'dashed' => JText::_( 'Dashed' ),
			'double' => JText::_( 'Double' ),
			'groove' => JText::_( 'Groove' ),
			'ridge'  => JText::_( 'Ridge' ),
			'inset'  => JText::_( 'Inset' ),
			'outset' => JText::_( 'Outset' )
		);
	}
	
	/**
	 * Font style options
	 * 
	 * @return type
	 */
	static function getFontStyles() {
		return array(
			'inherit' => JText::_( 'Inherit' ),
			'italic'  => JText::_( 'Italic' ),
			'normal'  => JText::_( 'Normal' ),
			'bold'    => JText::_( 'Bold' )
		);
	}
	
	/**
	 * Dummy content
	 * 
	 * @return type
	 */
	static function loremText( $wordcount = 50 ) {
		$lorem = new JSNPagebuilderHelpersLorem;
		$str   = $lorem->get_text( $wordcount, false );
		return ucfirst( ltrim( $str ) );
	}
	
	/**
	 * Link type options
	 *
	 * @return multitype:
	 */
	static function getLinkTypes() {
		$arr = array(
			'no_link' => JText::_( 'No Link' ),
			'url' => JText::_( 'URL' ),
		);
		return $arr;
	}
	
	/**
	 * Image link type options
	 *
	 * @return array
	 */
	static function getImageLinkTypes() {
		$imageLinkType                = array();
		$linkTypes                    = self::getLinkTypes();
		$imageLinkType                = array_slice( $linkTypes, 0, 1 );
		//$imageLinkType['large_image'] = JText::_( 'Large Image' );
		$imageLinkType                = array_merge( $imageLinkType, array_slice( $linkTypes, 1 ) );
		return $imageLinkType;
	}
	
	/**
	 * Get 1st option of array
	 * 
	 * @param type $arr
	 * 
	 * @return type
	 */
	static function getFirstOption( $arr ) {
		foreach ( $arr as $key => $value ) {
			if ( ! is_array( $key ) )
				return $key;
		}
	}
	
	/**
	 * Static function to get pricing type of sub items
	 *
	 * @return array
	 */
	static function getSubItemPricingType() {
		return array(
			'text' 		=> JText::_( 'Free text' ),
			'checkbox' 	=> JText::_( 'Yes / No' )
		);
	}

	/**
	 * Image Size options
	 *
	 * @return array
	 */
	static function getImageSize() {
		return array(
			'thumbnail' => JText::_( 'Thumbnail' ),
			'medium'    => JText::_( 'Medium' ),
			'large'		=> JText::_( 'Large' ),
			'fullsize'  => JText::_( 'Fullsize' )
		);
	}

    /**
     * Animation options
     *
     * @return array
     */
    static function getAnimation(){
        return array(
            '0' => JText::_('None'),
            'slide_from_top' => JText::_('Slide From Top'),
            'slide_from_right' => JText::_('Slide From Right'),
            'slide_from_bottom' => JText::_('Slide From Bottom'),
            'slide_from_left' => JText::_('Slide From Left'),
            'fade_in' => JText::_('Fade '),
        );
    }
}