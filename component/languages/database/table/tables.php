<?php
/**
 * Nooku Platform - http://www.nooku.org/platform
 *
 * @copyright	Copyright (C) 2011 - 2014 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		git://git.assembla.com/nooku-framework.git for the canonical source repository
 */

namespace Nooku\Component\Languages;

use Nooku\Library;

/**
 * Tables Database Table
 *
 * @author  Ercan Ozkaya <http://github.com/ercanozkaya>
 * @package Nooku\Component\Languages
 */
class DatabaseTableTables extends Library\DatabaseTableAbstract
{
	protected function _initialize(Library\ObjectConfig $config)
	{
		$config->append(array(
			'behaviors' => array(
                'identifiable',
			)
		));

		parent::_initialize($config);
	}
}
