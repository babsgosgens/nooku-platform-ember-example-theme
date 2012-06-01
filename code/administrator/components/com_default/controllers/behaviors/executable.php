<?php
/**
 * @version     $Id$
 * @package     Nooku_Components
 * @subpackage  Default
 * @copyright   Copyright (C) 2007 - 2012 Johan Janssens. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

/**
 * Default Controller Executable Behavior
 *
 * @author      Johan Janssens <johan@nooku.org>
 * @package     Nooku_Components
 * @subpackage  Default
 */
class ComDefaultControllerBehaviorExecutable extends KControllerBehaviorExecutable
{
	/**
     * Command handler
     *
     * @param   string      The command name
     * @param   object      The command context
     * @return  boolean     Can return both true or false.
     * @throws  KControllerException
     */
    public function execute( $name, KCommandContext $context)
    {
        $parts = explode('.', $name);

        if($parts[0] == 'before')
        {
            if(!$this->_authenticateRequest($context))
            {
                $context->setError(new KControllerException(
                	'Invalid token or session time-out', KHttpResponse::FORBIDDEN
                ));

                return false;
            }
        }

        return parent::execute($name, $context);
    }

    /**
     * Generic authorize handler for controller add actions
     *
     * @return  boolean     Can return both true or false.
     */
    public function canAdd()
    {
        $result = false;

        if(parent::canAdd())
        {
            if(version_compare(JVERSION,'1.6.0','ge')) {
                $result = JFactory::getUser()->authorise('core.create') === true;
            } else {
                $result = JFactory::getUser()->get('gid') > 22;
            }
        }

        return $result;
    }

  	/**
     * Generic authorize handler for controller edit actions
     *
     * @return  boolean     Can return both true or false.
     */
    public function canEdit()
    {
        $result = false;

        if(parent::canEdit())
        {
            if(version_compare(JVERSION,'1.6.0','ge')) {
                $result = JFactory::getUser()->authorise('core.edit') === true;
            } else {
                $result = JFactory::getUser()->get('gid') > 22;
            }
        }

        return $result;
    }

    /**
     * Generic authorize handler for controller delete actions
     *
     * @return  boolean     Can return both true or false.
     */
    public function canDelete()
    {
        $result = false;

        if(parent::canDelete())
        {
            if(version_compare(JVERSION,'1.6.0','ge')) {
                $result = JFactory::getUser()->authorise('core.delete') === true;
            } else {
                $result = JFactory::getUser()->get('gid') > 22;
            }
        }

        return $result;
    }

    /**
	 * Check the token to prevent CSRF exploits
	 *
	 * @param   object  The command context
	 * @return  boolean Returns FALSE if the check failed. Otherwise TRUE.
	 */
    protected function _authenticateRequest(KCommandContext $context)
    {
        //Check the token
        if($context->caller->isDispatched())
        {
            $method = KRequest::method();

            //Only check the token for PUT, DELETE and POST requests
            if(($method != KHttpRequest::GET) && ($method != KHttpRequest::OPTIONS))
            {
                //Check referrer
                if(!KRequest::referrer(true)) {
                    return false;
                }

                //Check cookie token
                if(KRequest::token() !== KRequest::get('cookie._token', 'md5')) {
                    return false;
                }

                //Check session token
                if(!JFactory::getUser()->guest)
                {
                    if( KRequest::token() !== $this->getService('session')->getToken()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}