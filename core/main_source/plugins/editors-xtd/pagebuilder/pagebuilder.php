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

include_once(JPATH_ROOT . '/administrator/components/com_pagebuilder/defines.pagebuilder.php');
include_once(JSNPB_ADMIN_PATH . 'helpers/shortcode.php');
include_once(JPATH_ROOT . '/administrator/components/com_pagebuilder/helpers/extensions.php');

/**
 * Plugin button for JSN PageBuilder
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class plgButtonPageBuilder extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 *
	 * @param       object $subject The object to observe
	 * @param       array  $config  An array that holds the plugin configuration
	 *
	 * @since       1.5
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}


	/**
	 * Display the button
	 *
	 * @return
	 */
	function onDisplay($name)
	{
		$isInstalledPbExtension = false;
		$app                    = JFactory::getApplication();
		// Check if JoomlaShine extension framework is enabled?
		$framework = JTable::getInstance('Extension');
		$framework->load(
			array(
				'element' => 'jsnframework',
				'type'    => 'plugin',
				'folder'  => 'system'
			)
		);

		$params = JSNConfigHelper::get('com_pagebuilder');
		$option = JRequest::getVar('option');
		if (is_dir(JPATH_ADMINISTRATOR . '/components/com_advancedmodules'))
		{
			$com_advancedmodules = 'com_advancedmodules';
		}else{
			$com_advancedmodules = '';
		}

		$supported_list = array('com_content', 'com_modules', $com_advancedmodules);

		if (isset($params))
		{
			if ($params->extension_support != '')
			{
				$supported_list = json_decode($params->extension_support);
			}
		}

		$installedPbExtensions = JSNPagebuilderHelpersExtensions::getPbExtensions();

		if (count($installedPbExtensions))
		{
			foreach ($installedPbExtensions as $installedPbExtension)
			{
				if ($option == "com_" . $installedPbExtension->element)
				{
					if (!$installedPbExtension->enabled)
					{
						$app->enqueueMessage(sprintf('Please enable the %s plugin before using. How to enable it, click <a href="%s" target="_blank">here</a>', 'JSN PageBuilder ' . strtoupper($installedPbExtension->element) . ' element', 'index.php?option=com_pagebuilder&view=configuration&s=maintainence&g=extensions'), 'warning');

						return;
					}
					else
					{
						$isInstalledPbExtension = true;
					}

					break;
				}
			}
		}

		if ($isInstalledPbExtension)
		{
			if (!in_array($option, $supported_list))
			{
				$app->enqueueMessage(sprintf('Please enable the JSN PageBuilder %s Extention Support before using. How to enable it, click <a href="%s" target="_blank">here</a>', strtoupper($installedPbExtension->element), 'index.php?option=com_pagebuilder&view=configuration&s=configuration&g=msgs'), 'warning');

				return;
			}
		}


		if ($framework->extension_id && in_array($option, $supported_list))
		{
			// Get PageBuilder configuration

			if (!in_array($option, array('com_content', 'com_modules', $com_advancedmodules)))
			{
				$isInstalled = JSNPagebuilderHelpersExtensions::checkInstalledPlugin(str_replace('com_', '', $option));
				if (!$isInstalled['isInstalled'])
				{
					return;
				}
			}

			// Check if it's enabled or not
			$isEnabled = $params->get('enable_pagebuilder', 1);

			if ($isEnabled)
			{
				$conf   = JFactory::getConfig();
				$editor = $conf->get('editor');

				// Inlcude the entry js file.
				JSNHtmlAsset::addScript(JSNPB_PLG_SYSTEM_ASSETS_URL . 'js/joomlashine.noconflict.js');
				JSNHtmlAsset::addScript(JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/jquery-ui/js/jquery-ui-1.10.3.custom.js');
				JSNHtmlAsset::addScript(JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/jquery-livequery/jquery.livequery.min.js');
				JSNHtmlAsset::addScript(JSNPB_ADMIN_URL . '/assets/js/builder-layout.js');
				JSNHtmlAsset::addScript(JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-modal.js');
				JSNHtmlAsset::addScript(JSNPB_ADMIN_URL . '/assets/js/handle.js');

				// Include supoported editor script
				switch ($editor)
				{
					case 'codemirror':
						JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/editors-xtd/pagebuilder/assets/js/supported-editor/codemirror.js');
						break;
					case 'tinymce':
						JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/editors-xtd/pagebuilder/assets/js/supported-editor/tiny-mce.js');
						break;
					case 'jce':
						JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/editors-xtd/pagebuilder/assets/js/supported-editor/jce.js');
						break;
					case 'jckeditor':
						JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/editors-xtd/pagebuilder/assets/js/supported-editor/jckeditor.js');
						break;
					case 'ckeditor':
						JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/editors-xtd/pagebuilder/assets/js/supported-editor/ckeditor.js');
						break;
					case 'artofeditor':
						JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/editors-xtd/pagebuilder/assets/js/supported-editor/artofeditor.js');
						break;
					default:
						JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/editors-xtd/pagebuilder/assets/js/supported-editor/default.js');
						break;
				}

				// Generate random string to assign to switcher button
				$random_id = JSNPagebuilderHelpersShortcode::generateRandomString();
				JSNHtmlAsset::addScript(JSNPB_ADMIN_URL . '/assets/js/entry.js');
				$js = "
					var Pb_Ajax	= {};
	
					var JSNPbParams = {pbstrings:{}};
					JSNPbParams.rootUrl = '" . JUri::root() . "';
					JSNPbParams.pbstrings.COPY = '" . JText::_('copy') . "';
					JSNPbParams.pbstrings.ALERT_DELETE_ROW = '" . JText::_('Are you sure you want to delete the whole row including all elements it contains?') . "';
					JSNPbParams.pbstrings.ALERT_DELETE_COLUMN = '" . JText::_('Are you sure you want to delete the whole column including all elements it contains?') . "';
					JSNPbParams.pbstrings.ALERT_DELETE_ELEMENT = '" . JText::_('Are you sure you want to delete the element?') . "';
					var pb;
					var pbContentStatus_$random_id	= 'normal';
					
					// Set global pagebuilder instance
					var jsnpb_$random_id;
					
					// Method to switch between Joomla editor and PageBuilder
					function switchPagebuilder(id, status){
						(function ($){
							if (status == 'on') {
								jsnpb_$random_id	= new $.JSNPageBuilder(id);
								pbContentStatus_$random_id  = 'pb';
							}else{
								jsnpb_$random_id.transformToSource();
								pbContentStatus_$random_id  = 'normal';
							}
						})(JoomlaShine.jQuery);
					}
					
					// Entry button group structure which will be appended to the aditor
					var pbEntryButtons	= '<div class=\"jsn-form-bar pb-switcher-group\">'
							+ '<div id=\"pb-editor-switcher\" class=\"btn-group\">'
							+	'<button type=\"button\" class=\"switchmode-button pb-off btn active btn-success\" id=\"pagebuilder-off-$random_id\" >Default Editor</button>'
							+	'<button type=\"button\" class=\"switchmode-button pb-on btn\" id=\"pagebuilder-on-$random_id\" >PageBuilder</button>'
							+'</div>'
						+'</div>';	
						
					(function ($){
						$(window).load(function (){
							 if ($('#jform_module').length)
						   		{
									if ($('#jform_module').val() != 'mod_custom')
									{
									 	return false;
									}
							   }
							var editorHelper_$random_id	= new $.JSNPbEditorHelper();
							var buttonGroups	= editorHelper_$random_id.initEntryButtons('" . $name . "', pbEntryButtons);
							
							//Auto switch to PageBuilder if shortcode structure detected
							var _content	= $('#" . $name . "').val();
							if (_content.indexOf('[pb_row') >= 0) {
								//setTimeout(function (){
									$('.switchmode-button.pb-on', buttonGroups).click();
								//}, 500);
							}
						});
					})(JoomlaShine.jQuery);	
				";


				JSNHtmlAsset::addInlineScript($js);
				JSNHtmlAsset::addStyle(JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-ui/css/ui-bootstrap/jquery-ui-1.9.0.custom.css');
				JSNHtmlAsset::addStyle(JSNPB_FRAMEWORK_ASSETS . '/joomlashine/css/jsn-gui.css');
				JSNHtmlAsset::addStyle(JSNPB_PLG_SYSTEM_ASSETS_URL . 'css/pagebuilder.css');
				JSNHtmlAsset::addStyle(JSNPB_ADMIN_URL . '/assets/css/ig-element-font.css');
			}
		}
	}

}
