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

class PagebuilderK2ModelItems extends K2ModelItemlist{

    protected function populateState(){
        $params = JComponentHelper::getParams('com_k2');
        $this->setState('params', $params);
    }

    function getItems($pk){
        $db = JFactory::getDbo();
        $limitstart = JRequest::getInt('limitstart');
        $limit = JRequest::getInt('limit');
        $query = "SELECT i.*, c.name as categoryname, c.id as categoryid";
        $query .= "FROM #__k2_items as i LEFT JOIN #__k2_categories as c ON c.id = i.catid";
        $query .= "WHERE i.intro LIKE '%pb_row%' AND publised != -2";
        $orderby = 'i.id DESC';
        $query .= " ORDER BY ". $orderby;
        $db->setQuery($query, $limitstart, $limit);
        $rows = $db->loadObjectList();
        return $rows;
    }

    public function getPagination(){
        jimport('joomla.html.pagination');
        $app = JFactory::getApplication();
        $limitstart = JRequest::getInt('limitstart');
        $limit = JRequest::getInt('limit');
        return new JPagination($this->getTotal(), $limitstart, $limit);

    }

    function getTotal(){
        $db = JFactory::getDbo();
        $query = "SELECT COUNT(*) FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }
}