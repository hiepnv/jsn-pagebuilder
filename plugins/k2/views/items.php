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

$this->lists['order_Dir'] = $this->escape($this->state->get('list.direction'));
$this->lists['order'] = $this->escape($this->state->get('list.ordering'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_pagebuilder&view=manager'); ?>" method="post" name="adminForm" id="adminForm">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th class="title">
                <?php echo JHTML::_('grid.sort', 'K2_TITLE', 'i.title', @$this->lists['order_Dir'], @$this->lists['order']); ?>
            </th>
            <th>
                <?php echo JHTML::_('grid.sort', 'K2_CATEGORY', 'category', @$this->lists['order_Dir'], @$this->lists['order']); ?>
            </th>
            <th>
                <?php echo JHTML::_('grid.sort', 'K2_ID', 'i.id', @$this->lists['order_Dir'], @$this->lists['order']); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="15">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($this->items as $key => $row): ?>
            <tr class="row<?php echo ($key%2); ?>">
                <td>
                    <?php
                    if (JTable::isCheckedOut($this->user->get('id'), $row->checked_out )): ?>
                        <?php echo $row->title; ?>
                    <?php else: ?>
                        <?php if(!$this->filter_trash): ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_k2&view=item&cid='.$row->id); ?>"><?php echo $row->title; ?></a>
                        <?php else: ?>
                            <?php echo $row->title; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td class="center">
                    <?php echo ($this->filter_trash) ? strip_tags(JHTML::_('grid.published', $row, $key ),'<img>') : JHTML::_('grid.published', $row, $key ); ?>
                </td>
                <td class="center">
                    <a href="<?php echo JRoute::_('index.php?option=com_k2&view=category&cid='.$row->catid); ?>"><?php echo $row->category; ?></a>
                </td>
                <td class="center">
                    <?php echo $row->id; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_('form.token'); ?>
</form>