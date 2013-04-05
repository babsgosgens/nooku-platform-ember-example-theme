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
 * Folder Uploadable Filter
 *
 * @author  Ercan Ozkaya <http://nooku.assembla.com/profile/ercanozkaya>
 * @package Nooku\Component\Files
 */
class FilterFolderUploadable extends Library\FilterAbstract
{
	protected $_walk = false;

	public function __construct(Library\Config $config)
	{
		parent::__construct($config);

		$this->addFilter($this->getService('com:files.filter.folder.name'), Library\Command::PRIORITY_HIGH);
	}

	protected function _validate($context)
	{

	}

	protected function _sanitize($context)
	{

	}
}
