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
 * Attach thumbnais to the rows if they are available
 *
 * @author      Ercan Ozkaya <http://nooku.assembla.com/profile/ercanozkaya>
 * @package     Nooku_Components
 * @subpackage  Files
 */
class ComFilesControllerBehaviorThumbnailable extends Framework\ControllerBehaviorAbstract
{
	protected function _afterControllerBrowse(Framework\CommandContext $context)
	{
		if (!$context->request->query->get('thumbnails', 'cmd') || $this->getModel()->container->parameters->thumbnails !== true) {
			return;
		}

		$files = array();
		foreach ($context->result as $row) 
		{
			if ($row->getIdentifier()->name === 'file') {
				$files[] = $row->name;
			}
		}
		
		$folder = $context->request->query->get('folder', 'com://admin/files.filter.path');
		$thumbnails = $this->getService('com://admin/files.controller.thumbnail', array(
			'request' => $this->getService('lib://nooku/controller.request', array(
				'query' => array(
					'container' => $this->getModel()->container,
					'folder' => $folder,
					'filename' => $files,
					'limit' => 0,
					'offset' => 0
				)
			))
		))->browse();
	
		foreach ($thumbnails as $thumbnail) 
		{
			if ($row = $context->result->find($thumbnail->filename)) {
				$row->thumbnail = $thumbnail->thumbnail;
			}
		}
		
		foreach ($context->result as $row) 
		{
			if (!$row->thumbnail) {
				$row->thumbnail = null;
			}
		}
	}
}
