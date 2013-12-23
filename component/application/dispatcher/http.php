<?php
/**
 * Nooku Framework - http://www.nooku.org
 *
 * @copyright	Copyright (C) 2011 - 2013 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		git://git.assembla.com/nooku-framework.git for the canonical source repository
 */

namespace Nooku\Component\Application;

use Nooku\Library;

/**
 * Http Dispatcher
 *
 * @author  Johan Janssens <http://nooku.assembla.com/profile/johanjanssens>
 * @package Component\Application
 */
class DispatcherHttp extends Library\DispatcherAbstract implements Library\ObjectInstantiable
{
    /**
     * The site identifier.
     *
     * @var string
     */
    protected $_site;

    /**
     * Constructor.
     *
     * @param Library\ObjectConfig $config	An optional Library\ObjectConfig object with configuration options.
     */
    public function __construct(Library\ObjectConfig $config)
    {
        parent::__construct($config);

        //Set the base url in the request
        $this->getRequest()->setBaseUrl($config->base_url);

        //Render the page before sending the response
        $this->registerCallback('before.send', array($this, 'renderPage'));

        //Render an exception before sending the response
        $this->registerCallback('before.fail', array($this, 'renderError'));
    }

    /**
     * Initializes the options for the object
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param 	Library\ObjectConfig    $config  An optional Library\ObjectConfig object with configuration options.
     * @return 	void
     */
    protected function _initialize(Library\ObjectConfig $config)
    {
        $config->append(array(
            'controller'        => 'page',
            'base_url'          => '/administrator',
            'event_subscribers' => array('unauthorized'),
        ));

        parent::_initialize($config);
    }

    /**
     * Force creation of a singleton
     *
     * @param 	Library\ObjectConfig            $config	  A ObjectConfig object with configuration options
     * @param 	Library\ObjectManagerInterface	$manager  A ObjectInterface object
     * @return  DispatcherHttp
     */
    public static function getInstance(Library\ObjectConfig $config, Library\ObjectManagerInterface $manager)
    {
        // Check if an instance with this identifier already exists
        if (!$manager->isRegistered('application'))
        {
            $classname = $config->object_identifier->classname;
            $instance  = new $classname($config);
            $manager->setObject($config->object_identifier, $instance);

            //Add the service alias to allow easy access to the singleton
            $manager->registerAlias($config->object_identifier, 'application');
        }

        return $manager->getObject('application');
    }

    /**
     * Render the page
     *
     * @param Library\DispatcherContextInterface $context	A dispatcher context object
     */
    public function renderPage(Library\DispatcherContextInterface $context)
    {
        $request   = $context->request;
        $response  = $context->response;

        //Render the page
        if(!$response->isRedirect() && $request->getFormat() == 'html')
        {
            //Render the page
            $config = array('response' => $response);

            $layout = $request->query->get('tmpl', 'cmd', 'default');
            $this->getObject('com:application.controller.page', $config)
                ->layout($layout)
                ->render();
        }
    }

    /**
     * Render an error
     *
     * @throws \InvalidArgumentException If the action parameter is not an instance of Library\Exception
     * @param Library\DispatcherContextInterface $context	A dispatcher context object
     */
    public function renderError(Library\DispatcherContextInterface $context)
    {
        $request   = $context->request;
        $response  = $context->response;

        if(in_array($request->getFormat(), array('json', 'html')))
        {
            //Check an exception was passed
            if(!isset($context->param) && !$context->param instanceof Library\Exception)
            {
                throw new \InvalidArgumentException(
                    "Action parameter 'exception' [Library\Exception] is required"
                );
            }

            //Get the exception object
            if($context->param instanceof Library\EventException) {
                $exception = $context->param->getException();
            } else {
                $exception = $context->param;
            }

            $config = array(
                'request'  => $this->getRequest(),
                'response' => $this->getResponse()
            );

            $this->getObject('com:application.controller.error',  $config)
                ->layout('default')
                ->render($context->param->getException());

            //User the 'error' application template
            $context->request->query->set('tmpl', 'error');
        }
    }
}
