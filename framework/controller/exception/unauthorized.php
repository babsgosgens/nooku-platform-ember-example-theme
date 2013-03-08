<?php
/**
 * @package     Koowa_Controller
 * @subpackage  Exception
 * @copyright   Copyright (C) 2007 - 2012 Johan Janssens. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

namespace Nooku\Framework;

/**
 * Controller Exception Unauthorized Class
 *
 * @author      Johan Janssens <johan@nooku.org>
 * @package     Koowa_Controller
 * @subpackage  Exception
 */
class ControllerExceptionUnauthorized extends HttpExceptionUnauthorized implements ControllerException {}