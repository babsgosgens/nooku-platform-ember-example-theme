<?php
/**
 * @package     Nooku_Components
 * @subpackage  Default
 * @copyright   Copyright (C) 2007 - 2012 Johan Janssens. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

use Nooku\Framework;

/**
 * Default Dispatcher
.*
 * @author      Johan Janssens <johan@nooku.org>
 * @package     Nooku_Components
 * @subpackage  Default
 */
class BaseDispatcher extends Framework\DispatcherComponent
{
    /**
     * Dispatch the controller and redirect
     * 
     * Redirect if no view information can be found in the request.
     * 
     * @param   string      The view to dispatch. If null, it will default to retrieve the controller information
     *                      from the request or default to the component name if no controller info can be found.
     *
     * @return  Framework\DispatcherDefault
     */
    protected function _actionDispatch(Framework\CommandContext $context)
    {
        //Redirect if no view information can be found in the request
        if(!$context->request->query->has('view'))
        {
            $url = clone($context->request->getUrl());
            $url->query['view'] = $this->getController()->getView()->getName();

            $context->response->setRedirect($url);
            return false;
        }

        return parent::_actionDispatch($context);
    }
}