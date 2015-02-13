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

defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');
include_once JPATH_ROOT . '/administrator/components/com_pagebuilder/extensions/extensions.php';

class plgJsnpagebuiderK2 extends  plgJsnpagebuilderExtensions{

    public static function checkSupportedVersion(){

    }

    public static function addConfiguration(){
        $config = array();
        $config = array(
            'tab'=> array(
                'com_k2_items' => array(
                    'title' => 'K2 Items',
                    'path'  => JPATH_ROOT . '/plugins/pagebuilder/k2',
                    'modelfile' => 'models/items.php',
                    'viewfile' => 'views/items.php',
                    'modelname' => 'PagebuilderModelK2Items',
                    'order' => 'i.id'
                )
            )
        );
        return $config;
    }
}