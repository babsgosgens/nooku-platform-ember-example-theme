<?php
/**
 * @package     Koowa_View
 * @copyright    Copyright (C) 2007 - 2012 Johan Janssens. All rights reserved.
 * @license        GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link         http://www.nooku.org
 */

namespace Nooku\Framework;

/**
 * View Html Class
 *
 * @author        Johan Janssens <johan@nooku.org>
 * @package     Koowa_View
 */
class ViewHtml extends ViewTemplate
{
    /**
     * Initializes the config for the object
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param     object     An optional Config object with configuration options
     * @return  void
     */
    protected function _initialize(Config $config)
    {
        $config->append(array(
            'mimetype'         => 'text/html',
            'template_filters' => array('form'),
        ));

        parent::_initialize($config);
    }

    /**
     * Return the views output
     *
     * This function will always assign the model state to the template. Model data will only be assigned if the
     * auto_assign property is set to TRUE.
     *
     * @return string The output of the view
     */
    public function render()
    {
        $model = $this->getModel();

        //Auto-assign the state to the view
        $this->state = $model->getState();

        //Auto-assign the data from the model
        if ($this->_auto_assign)
        {
            //Get the view name
            $name = $this->getName();

            //Assign the data of the model to the view
            if (Inflector::isPlural($name))
            {
                $this->$name = $model->getRowset();
                $this->total = $model->getTotal();
            }
            else $this->$name = $model->getRow();
        }

        return parent::render();
    }

    /**
     * Get a route based on a full or partial query string.
     *
     * This function force the route to be not fully qualified and not escaped
     *
     * @param    string    The query string used to create the route
     * @param     boolean    If TRUE create a fully qualified route. Default FALSE.
     * @param     boolean    If TRUE escapes the route for xml compliance. Default FALSE.
     * @return     string     The route
     */
    public function getRoute($route = '', $fqr = null, $escape = null)
    {
        //If not set force to false
        if ($fqr === null) {
            $fqr = false;
        }

        return parent::getRoute($route, $fqr, $escape);
    }
}