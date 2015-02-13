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
 * Shortcode controller
 *
 * @package     JSN_PageBuilder
 * @since       1.0.0
 */
class JSNPagebuilderControllerShortcode extends JSNBaseController
{
	/**
	 * Save session for shortcode params
	 * 
	 * @return void
	 */
	public function saveSession()
	{
		// Using $_POST instead JRequest::getVar() because getVar() can't get tinyMCE content has img tag

		$params		    = $_POST['params'];
		$params 		= str_replace( 'PB_INDEX_TRICK', '1', $params );
		$shortcodeName	= JRequest::getVar('shortcode');

		if ($params && $shortcodeName) {
			$session = JFactory::getSession();
			$_SESSION[JSNPB_SHORTCODE_SESSION_NAME][$shortcodeName]['params']	= $params;
			$session->set('JSNPA_SHORTCODEPARAMS', $params);

		}
		exit();
	}
	
	/**
	 * Method to generate HTML content for shortcode
	 * in pagebuilder layout
	 * 
	 * @return string
	 */
	public function generateHolder()
	{
		// Using $_POST instead JRequest::getVar() because getVar() can't get tinyMCE content has img tag
		$params		= $_POST['params'];
		$params		= urldecode($params);
		$shortcode	= JRequest::getVar('shortcode');
		$element_title	= JRequest::getVar('el_title');
		$class		= JSNPagebuilderHelpersShortcode::getShortcodeClass($shortcode);
		$instance	= null;
			global $JSNPbElements;
        	$elements = $JSNPbElements->getElements();
			$instance = isset($elements[strtolower($class)]) ? $elements[strtolower($class)] : null;
			if (!is_object($instance)) {
	            $instance = new $class();
	        }
	        
	        // Process icon prepend title
	        if ( isset( $instance->items ) ) {
	        	$items = array_shift( $instance->items );
	        	foreach( $items as $i => $item ) {
	        		if ( ( isset( $item['role'] ) && isset( $item['role_type'] ) ) && ( $item['role'] == 'title_prepend' && $item['role_type'] == 'icon' ) ) {
	        			$arr_params  = JSNPagebuilderHelpersShortcode::shortcodeParseAtts( $params );
	        			$element     = JSNPagebuilderHelpersShortcode::shortcodeAtts( $instance->config['params'], $arr_params );
	        			if ( isset( $element['icon'] ) ) {
	        				$element_title = '<i class="' . $element['icon'] . '"></i>' . $element_title;
	        			}
	        		}
	        	}
	        }
	        
	        $content	= $instance->element_in_pgbldr('', $params, $element_title);
			echo $content;
		exit();
	}
	
	/**
	 * Method to generate shortcode preview
	 * 
	 * @return string
	 */
	public function preview()
	{
		$session = JFactory::getSession();
		JHtml::_('jquery.framework');
		JHtml::_('bootstrap.framework');
					
		$document = JFactory::getDocument();
				
		$document->addScript( JSNPB_PLG_SYSTEM_ASSETS_URL . 'js/joomlashine.noconflict.js', 'text/javascript');
		$document->addScript( JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/bootstrap3/js/bootstrap.min.js', 'text/javascript' );
		
		$document->addStyleSheet( JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/bootstrap3/css/bootstrap.min.css', 'text/css' );
		$document->addStyleSheet( JSNPB_PLG_SYSTEM_ASSETS_URL . 'css/jsn-gui-frontend.css', 'text/css' );
		$document->addStyleSheet( JSNPB_PLG_SYSTEM_ASSETS_URL . 'css/pagebuilder.css', 'text/css' );
		$document->addStyleSheet( JSNPB_PLG_SYSTEM_ASSETS_URL . 'css/front_end.css', 'text/css' );
		$document->addStyleSheet( JSNPB_PLG_SYSTEM_ASSETS_URL . 'css/front_end_responsive.css', 'text/css' );
		$document->addStyleSheet( JSNPB_ASSETS_URL . 'css/preview.css', 'text/css' );
		
		if (!$_POST['params']) {
			exit (JText::_("can not find input data"));
		}
		
		$shortcode_content	= urldecode($_POST['params']);
		$session->set('JSNPA_SHORTCODECONTENT', $shortcode_content);
		$helper				= new JSNPagebuilderHelpersBuilder();
		$html				=	$helper->generateShortCode($shortcode_content, false, 'frontend');
		echo '<div class="jsn-bootstrap3">' . $html . '</div>';
		
	}
	
	/**
	 * Load custom action for elements
	 * 
	 * @return void
	 */
	public function customAction() {
		$shortcode = isset( $_POST['shortcode'] ) ? $_POST['shortcode'] : '';
		$action = isset( $_POST['action'] ) ? $_POST['action'] : '';
	
		if ( ! empty( $shortcode ) && ! empty( $action ) ) {
			// Check file exists
			if ( file_exists( JPATH_ROOT . "/plugins/pagebuilder/{$shortcode}/helpers/{$action}.php" ) ) {
				require_once JPATH_ROOT . "/plugins/pagebuilder/{$shortcode}/helpers/{$action}.php";
			}
		}
		
		if ( ! empty( $shortcode ) && ! empty( $action ) ) {
			// Check file exists
			if ( file_exists( JPATH_ROOT . "/plugins/jsnpagebuilder/defaultelements/{$shortcode}/helpers/{$action}.php" ) ) {
				require_once JPATH_ROOT . "/plugins/jsnpagebuilder/defaultelements/{$shortcode}/helpers/{$action}.php";
			}
		}
	}
}
