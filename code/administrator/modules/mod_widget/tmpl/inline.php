<? /** $Id$ */ ?>
<? defined('KOOWA') or die('Restricted access');

$parts   = $uri->getQuery(true);
$package = substr($parts['option'], 4);
$view    = $parts['view'];

unset($parts['option']);
unset($parts['view']);

$action =  KInflector::isSingular($view) ? 'read' : 'browse';

echo KFactory::tmp('admin::com.'.$package.'.controller.'.KInflector::singularize($view))
	->setRequest($parts)
	->$action();
		