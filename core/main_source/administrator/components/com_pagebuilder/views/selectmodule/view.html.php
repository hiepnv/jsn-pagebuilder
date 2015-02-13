<?php

/** 
 *  @version    $Id$
 *  @package    JSN_PageBuilder
 *  @author     JoomlaShine Team <support@joomlashine.com>
 *  @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 *  @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * 
 *  Websites: http://www.joomlashine.com
 *  Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */


// No direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class JSNPagebuilderViewSelectmodule extends JViewLegacy{
	
	protected $state;
	protected $items;
	protected $pagination;
	
	public function display($tpl = null){
		$state = $this->get('State');
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
                //check for errors
		if(count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->assignRef('state', $state);
		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
                return parent::display();
	}
}