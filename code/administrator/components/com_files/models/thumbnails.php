<?php
/**
 * @version     $Id$
 * @category	Nooku
 * @package     Nooku_Server
 * @subpackage  Files
 * @copyright   Copyright (C) 2011 - 2012 Timble CVBA and Contributors. (http://www.timble.net).
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

/**
 * Thumbnails Model Class
 *
 * @author      Ercan Ozkaya <http://nooku.assembla.com/profile/ercanozkaya>
 * @category	Nooku
 * @package     Nooku_Server
 * @subpackage  Files
 */
class ComFilesModelThumbnails extends ComDefaultModelDefault
{
	public function __construct(KConfig $config)
	{
		parent::__construct($config);

		$this->getState()
			->insert('container', 'com://admin/files.filter.container', null)
			->insert('folder', 'com://admin/files.filter.path')
			->insert('filename', 'com://admin/files.filter.path', null, true, array('container'))
			->insert('files', 'com://admin/files.filter.path', null)
			->insert('source', 'raw', null, true);
		
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'state' => new ComFilesConfigState()
		));
		
		parent::_initialize($config);
	}

	public function getItem()
	{
		$item = parent::getItem();

		if ($item) {
			$item->source = $this->getState()->source;
		}

		return $item;
	}

	protected function _buildQueryColumns(KDatabaseQuerySelect $query)
    {
    	parent::_buildQueryColumns($query);
    	$state = $this->getState();
    	
    	if ($state->source instanceof KDatabaseRowInterface || $state->container) {
    		$query->columns(array('container' => 'containers.slug'));
    	}
    }
	
	protected function _buildQueryJoins(KDatabaseQuerySelect $query)
    {
    	parent::_buildQueryJoins($query);
    	$state = $this->getState();
    	
    	if ($state->source instanceof KDatabaseRowInterface || $state->container) {
    		$query->join(array('containers' => 'files_containers'), 'containers.files_container_id = tbl.files_container_id');
    	}
    }

	protected function _buildQueryWhere(KDatabaseQuerySelect $query)
    {
        $state = $this->getState();
        
		if ($state->source instanceof KDatabaseRowInterface) {
			$source = $state->source;

			$query->where('tbl.files_container_id = :container_id')
				->where('tbl.filename = :filename')
				->bind(array('container_id' => $source->container->id, 'filename' => $source->name));

			if ($source->folder) {
				$query->where('tbl.folder = :folder')->bind(array('folder' => $source->folder));
			}
		}
		elseif (!empty($state->files)) {
			$query->where('tbl.filename '.(is_array($state->files) ? 'IN' : '=').' :files')->bind(array('files' => $state->files));
		}
		else {
		    if ($state->container) {
		        $query->where('tbl.files_container_id = :container_id')->bind(array('container_id' => $state->container->id));
		    }
		    
		    if ($state->folder !== false) {
		    	$query->where('tbl.folder = :folder')->bind(array('folder' => ltrim($state->folder, '/')));
		    }

		    if ($state->filename) {
		        $query->where('tbl.filename = :filename')->bind(array('filename' => $state->filename));
		    }
		}
	}
}
