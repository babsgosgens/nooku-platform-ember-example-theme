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
 * Default Router
.*
 * @author      Johan Janssens <johan@nooku.org>
 * @package     Nooku_Components
 * @subpackage  Default
 */
class BaseRouter extends Framework\Object implements Framework\ServiceInstantiatable
{
	/**
     * Force creation of a singleton
     *
     * @param 	Framework\ConfigInterface            $config	  A Framework\Config object with configuration options
     * @param 	Framework\ServiceManagerInterface	$manager  A KServiceInterface object
     * @return Framework\DispatcherDefault
     */
    public static function getInstance(Framework\Config $config, Framework\ServiceManagerInterface $manager)
    {
        if (!$manager->has($config->service_identifier))
        {
            $classname = $config->service_identifier->classname;
            $instance  = new $classname($config);
            $manager->set($config->service_identifier, $instance);
        }
        
        return $manager->get($config->service_identifier);
    }

    /**
     * Build the route
     *
     * @param	array	An array of URL arguments
     * @return	array	The URL arguments to use to assemble the subsequent URL.
     */
    public function buildRoute(&$query)
    {
        $segments = array();
        return $segments;
    }

    /**
     * Parse the segments of a URL.
     *
     * @param	array	The segments of the URL to parse.
     * @return	array	The URL attributes to be used by the application.
     */
    public function parseRoute($segments)
    {
        $vars = array();
        return $vars;
    }
}