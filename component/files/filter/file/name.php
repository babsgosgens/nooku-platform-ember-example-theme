<?php
/**
 * Nooku Framework - http://www.nooku.org
 *
 * @copyright	Copyright (C) 2011 - 2013 Timble CVBA and Contributors. (http://www.timble.net)
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		git://git.assembla.com/nooku-framework.git
 */

namespace Nooku\Component\Files;

use Nooku\Library;

/**
 * File Name Filter
 *
 * @author  Ercan Ozkaya <http://nooku.assembla.com/profile/ercanozkaya>
 * @package Nooku\Component\Files
 */
class FilterFileName extends Library\FilterRecursive
{
	protected $_traverse = false;

	protected function _validate($context)
	{
		$value = $this->_sanitize($context->getSubject()->name);

		if ($value == '') {
			$context->setError(\JText::_('Invalid file name'));
			return false;
		}
	}

	protected function _sanitize($value)
	{
		return $this->getService('com:files.filter.path')->sanitize($value);
	}
}