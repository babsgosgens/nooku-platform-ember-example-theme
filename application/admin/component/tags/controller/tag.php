<?php
/**
 * Nooku Platform - http://www.nooku.org/platform
 *
 * @copyright	Copyright (C) 2011 - 2014 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		https://github.com/nooku/nooku-platform for the canonical source repository
 */

use Nooku\Library;
use Nooku\Component\Tags;

/**
 * Tag Controller
 *
 * @author  Johan Janssens <http://github.com/johanjanssens>
 * @package Component\Tags
 */
abstract class TagsControllerTag extends Tags\ControllerTag
{ 
    protected function _initialize(Library\ObjectConfig $config)
    {
        $config->append(array(
        	'behaviors' => array(
                'editable', 'persistable',
                'com:activities.controller.behavior.loggable'
            ),
        ));

        //Force the toolbars
        $config->toolbars = array('menubar', 'com:tags.controller.toolbar.tag');
        
        parent::_initialize($config);
    }
}