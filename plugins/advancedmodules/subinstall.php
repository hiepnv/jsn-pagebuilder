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

class PlgJsnPagebuilderK2InstallerScript{

    public function postflight($route, $_this){
        $db = JFactory::getDbo();
        try {
            $query = $db->getQuery(true);
            $query->update('#__extensions');
            $query->set(array('enabled = 1', 'protected = 0'));
            $query->where("element = 'advancedmodules'");
            $query->where("type = 'plugin'", 'AND');
            $query->where("folder = 'jsnpagebuilder'", 'AND');
            $db->setQuery($query);
            $db->query();
        } catch (Exception $e) {
            throw $e;
        }

    }
}