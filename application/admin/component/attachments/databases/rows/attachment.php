<?php

use Nooku\Framework;

class ComAttachmentsDatabaseRowAttachment extends Framework\DatabaseRowDefault
{
	public function save()
	{
		$return = parent::save();
			
		if ($return && $this->row && $this->table) {
			$relation = $this->getService('com://admin/attachments.database.row.relation');
			$relation->attachments_attachment_id = $this->id;
			$relation->table = $this->table;
			$relation->row = $this->row;

			if(!$relation->load()) {
				$relation->save();
			}
		}
		
		return $return;
	}
	
	public function delete()
	{
		$return = parent::delete();
			
		if ($return)
        {
			$this->getService('com://admin/files.controller.file', array(
				'request' => $this->getService('lib://nooku/controller.request', array(
                                'query' => array('container' => $this->container, 'name' => $this->path)
                            ))
			))->delete();
			
			$relations = $this->getService('com://admin/attachments.database.table.relations')
				->select(array('attachments_attachment_id' => $this->id));
			$relations->delete();
		}

		return $return;
	}
	
	public function __get($name)
	{
	    if($name == 'relation' && !isset($this->relation))
	    {
	        $this->relation = $this->getService('com://admin/attachments.database.table.relations')
	            ->select(array('attachments_attachment_id' => $this->id), Framework\Database::FETCH_ROW);
	    }
        
        if($name == 'file' && !isset($this->file))
	    {
	    	$this->file = $this->getService('com://admin/files.model.files')
	    					->container($this->container)
	    					->folder($this->path)
	    					->name($this->name)
	    					->getRow();
	    }
	    
	    if($name == 'thumbnail' && !isset($this->thumbnail))
	    {
	    	$file = $this->file;
	    	
	    	if($file && $file->isImage())
	    	{
	    		$this->thumbnail = $this->getService('com://admin/files.controller.thumbnail')
	    				->container($this->container)
	    				->filename($this->path)
	    				->read();
	    	}
	    }
	    
	    return parent::__get($name);
	}
}