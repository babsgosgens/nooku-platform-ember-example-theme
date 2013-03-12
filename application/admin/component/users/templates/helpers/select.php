<?php
/**
 * @category	Nooku
 * @package		Nooku_Server
 * @subpackage	Users
 * @copyright	Copyright (C) 2011 - 2012 Timble CVBA and Contributors. (http://www.timble.net).
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		http://www.nooku.org
 */

use Nooku\Framework;

/**
 * Select Template Helper Class
 *
 * @author      Tom Janssens <http://nooku.assembla.com/profile/tomjanssens>
 * @category	Nooku
 * @package		Nooku_Server
 * @subpackage	Users
 */
class UsersTemplateHelperSelect extends Framework\TemplateHelperSelect
{    
    public function users($config = array())
    {
    	$config = new Framework\Config($config);
    	$config->append(array(
    		'list'      => $this->getService('com://admin/users.model.users')->set('sort', 'name')->getRowset(),
    		'text'		=> 'name'
    	));
    
    	return $this->checklist($config);
    }
}