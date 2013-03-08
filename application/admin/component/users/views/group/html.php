<?php
/**
 * @category    Nooku
 * @package     Nooku_Server
 * @subpackage  Users
 * @copyright   Copyright (C) 2011 - 2012 Timble CVBA and Contributors. (http://www.timble.net).
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

use Nooku\Framework;

/**
 * Group HTML view class.
 *
 * @author     Tom Janssens <http://nooku.assembla.com/profile/tomjanssens>
 * @category   Nooku
 * @package    Nooku_Server
 * @subpackage Users
 */
class ComUsersViewGroupHtml extends ComDefaultViewHtml
{
    public function render()
    {
        $group = $this->getModel()->getRow();

        $this->users = $this->getService('com://admin/users.model.groups_users')->group_id($group->id)->getRowset()->user_id;
        
        return parent::render();
    }
}