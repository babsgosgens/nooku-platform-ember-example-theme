<?php
/** 
 * @version		$Id$
 * @package		Profiles
 * @copyright	Copyright (C) 2009 Nooku. All rights reserved.
 * @license 	GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Person Controller
 *
 * @package		Profiles
 */
class ComProfilesControllerPerson extends ComProfilesControllerDefault
{
	public function __construct(array $options = array())
	{
		parent::__construct($options);
		
		//Only load enabled items
		KRequest::set('get.enabled', 1);
	}
	
	/**
	 * Display a single item
	 *
	 * @return KDatabaseRow	A row object containing the selected row
	 */
	protected function _actionRead()
	{		
		$row = parent::_actionRead();
		$row->hit();
			
		return $row;
	}
}