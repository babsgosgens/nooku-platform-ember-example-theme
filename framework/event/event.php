<?php
/**
 * @package     Koowa_Event
 * @copyright   Copyright (C) 2007 - 2012 Johan Janssens. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

namespace Nooku\Framework;

/**
 * Event Class
 *
 * You can call the method stopPropagation() to abort the execution of further listeners in your event listener.
 *
 * @author      Johan Janssens <johan@nooku.org>
 * @package     Koowa_Event
 */
class Event extends Config implements EventInterface
{
 	/**
     * Priority levels
     */
    const PRIORITY_HIGHEST = 1;
    const PRIORITY_HIGH    = 2;
    const PRIORITY_NORMAL  = 3;
    const PRIORITY_LOW     = 4;
    const PRIORITY_LOWEST  = 5;
 	
 	/**
     * The propagation state of the event
     * 
     * @var boolean 
     */
    protected $_propagate = true;
 	
 	/**
     * The event name
     *
     * @var array
     */
    protected $_name;
    
    /**
     * Target of the event
     *
     * @var ServiceInterface
     */
    protected $_target;
    
    /**
     * Dispatcher of the event
     * 
     * @var EventDispatcher
     */
    protected $_dispatcher;
         
    /**
     * Get the event name
     * 
     * @return string	The event name
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Set the event name
     *
     * @param string	The event name
     * @return Event
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }
    
    /**
     * Get the event target
     *
     * @return object	The event target
     */
    public function getTarget()
    {
        return $this->_target;
    }
    
    /**
     * Set the event target
     *
     * @param object	The event target
     * @return Event
     */
    public function setTarget(ServiceInterface $target)
    {
        $this->_target = $target;
        return $this;
    }
    
    /**
     * Stores the EventDispatcher that dispatches this Event
     *
     * @param EventDispatcher $dispatcher
     * @return Event
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->_dispatcher = $dispatcher;
        return $this;
    }
    
    /**
     * Returns the EventDispatcher that dispatches this Event
     *
     * @return EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->_dispatcher;
    }
    
    /**
     * Returns whether further event listeners should be triggered.
     *
     * @return boolean 	TRUE if the event can propagate. Otherwise FALSE
     */
    public function canPropagate()
    {
        return $this->_propagate;
    }

    /**
     * Stops the propagation of the event to further event listeners.
     *
     * If multiple event listeners are connected to the same event, no
     * further event listener will be triggered once any trigger calls
     * stopPropagation().
     * 
     * @return Event
     */
    public function stopPropagation()
    {
        $this->_propagate = false;
        return $this;
    }
}