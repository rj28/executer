<?php

require_once __DIR__ . '/../app/bootstrap.php';

$di->set('filter', function() {
	$filter = new Phalcon\Filter();
	$filter->add('string', function($value) { return '' . $value; /* is_string($value) ? $value : ''; */ });
	$filter->add('uint', function($value) { return is_scalar($value) && preg_match('/^[0-9]+$/iD', $value) && $value >= 0 ? $value : 0; });
	$filter->add('array', function($value) { return is_array($value) ? $value : []; });
	$filter->add('intbool', function($value) { return empty($value) ? 0 : 1; });
	return $filter;
}, true);

$di->set('request', new Phalcon\Http\Request());

$di->set('router', function() use ($di) {
	$router = new \Phalcon\Mvc\Router();
	return $router;
}, true);

$di->set('flash', function() {
    return new Phalcon\Flash\Session([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ]);
});

$di->set('session', function() use ($di) {
	$class = Config::instance()->session->class;

	session_name(Config::instance()->session->name);
	session_set_cookie_params(0, '/', Config::instance()->cookie_domain);

	/** @var Phalcon\Session\AdapterInterface $session */
    $session = new $class([
		'path'     => Config::instance()->session->save_path,
		'lifetime' => Config::instance()->session->lifetime,
	]);
    $session->start();

	return $session;
}, true);

$di->set('view', function() { return new TestView(); }, true);

$di->set('dispatcher', function() use ($di) { return new Phalcon\Mvc\Dispatcher(); }, true);

$di->set('url', function() use ($di) {
	$url = new Phalcon\Mvc\Url();
	//$url->setBaseUri($di['config']->base_uri);
	return $url;
}, true);

$di->set('response', new Phalcon\Http\Response());


$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
if (false !== ($pos = strpos($requestUri, '?'))) {
    $requestUri = substr($requestUri, 0, $pos);
}

$requestUri = rtrim($requestUri, '/');

if (strlen($requestUri) == 0 || $requestUri[0] != '/') {
    $requestUri = '/';
}

$app = new Phalcon\Mvc\Application($di);
$di->set('request_uri', function() use ($requestUri) { return urldecode($requestUri); });
echo $app->handle($di['request_uri'])->getContent();
