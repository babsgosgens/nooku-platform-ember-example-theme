<?php
/**
 * @package     Nooku_Components
 * @subpackage  Files
 * @copyright   Copyright (C) 2011 - 2012 Timble CVBA and Contributors. (http://www.timble.net).
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

use Nooku\Framework;

/**
 * File Validator Command Class
 *
 * @author      Ercan Ozkaya <http://nooku.assembla.com/profile/ercanozkaya>
 * @package     Nooku_Components
 * @subpackage  Files
 */
class FilesCommandValidatorFile extends FilesCommandValidatorNode
{
	protected function _databaseBeforeSave(Framework\CommandContext $context)
	{
		$row = $context->getSubject();

		if (is_string($row->file) && !is_uploaded_file($row->file))
		{
			// remote file
			try {
				$file = $this->getService('com://admin/files.database.row.url');
				$file->setData(array('file' => $row->file));
				$file->load();
				$row->contents = $file->contents;

			} catch (FilesDatabaseRowUrlException $e) {
				throw new \RuntimeException($e->getMessage(), $e->getCode());
			}

			if (empty($row->name))
			{
				$uri = $this->getService('lib://nooku/http.url', array('url' => $row->file));
	        	$path = $uri->toString(Framework\HttpUrl::PATH | Framework\HttpUrl::FORMAT);
	        	if (strpos($path, '/') !== false) {
	        		$path = basename($path);
	        	}

	        	$row->name = $path;
			}
		}

		return parent::_databaseBeforeSave($context) && $this->getService('com://admin/files.filter.file.uploadable')->validate($context);

	}
}
