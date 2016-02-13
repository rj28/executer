<?php

define('APP_START_TIME', microtime(true));
define('DOCROOT', dirname(__FILE__) . '/');

require_once DOCROOT . '../vendor/autoload.php';

class_alias('Rj\\TestView124', 'TestView');

$loader = new Phalcon\Loader();
$loader->registerDirs([
	__DIR__ . '/models',
	__DIR__ . '/classes',
	__DIR__ . '/controllers',
    __DIR__ . '/forms',
	__DIR__ . '/tasks',
]);
$loader->register();

if ( ! isset($di)) {
	$di = new Phalcon\DI\FactoryDefault\CLI();
}

\Phalcon\Mvc\Model::setup([
    'notNullValidations' => false,
]);

$di->set('config', function() {
	/** @var Phalcon\Config $default */
	$config = require __DIR__ . '/config/config.default.php';
	$config->merge(require __DIR__ . '/config/config.php');
	return $config;
}, true);

function logException(Exception $e, $mail = true) {
	Logger::messages()->exception($e);

	if (Config::instance()->production) {
		if (Phalcon\DI::getDefault()->has('request')) {

			/** @var \Phalcon\Http\Request $request */
			$request = Phalcon\DI::getDefault()->getShared('request');

			$message = sprintf(
				"%s %s: %s\n"
				. "UserAgent: %s\n"
				. "HTTP Referer: %s\n"
				. "%s URL: %s://%s\n"
				. "LoggedUser: %s\n"
				. "%s",
				date('Y-m-d H:i:s'), get_class($e), $e->getMessage(),
				$request->getUserAgent(),
				urldecode($request->getHTTPReferer()),
				$request->getClientAddress(), $request->getScheme(), $request->getHttpHost()
				. urldecode(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '<!undefined>'),
				Person::getLogged() ? Person::getLogged()->person_id . ' ' . Person::getLogged()->getFullName() : 'none',
				$e->getTraceAsString()
			);

		} else {
			$message = date('Y-m-d H:i:s') . ' ' . $e->getMessage() . "\n"
				. "There is no request object\n"
				. $e->getTraceAsString();
		}

		switch (true) {
//			case $e instanceof PageNotFound:
//			case $e instanceof Phalcon\Mvc\Dispatcher\Exception:
//				break;

			default:
				if (Config::instance()->mail_exceptions && $mail)
					MailQueue::push2admin('Exception', $message);
				break;
		}

	} else {
		throw $e;
	}
}


set_exception_handler(function(Exception $e) {
	logException($e);

	if ( ! Config::instance()->production || PHP_SAPI == 'cli') {
		throw $e;

	} else {
		$app = new Phalcon\Mvc\Application(Phalcon\DI::getDefault());

		switch (true) {
			case $e instanceof PageNotFound:
			case $e instanceof Phalcon\Mvc\Dispatcher\Exception:
				header('HTTP/1.1 404 Not Found');
				header('Status: 404 Not Found');
				$app->di->set('last_exception', $e);
				exit($app->handle('/error/show404')->getContent());

			default:
				header('HTTP/1.1 503 Service Temporarily Unavailable');
				header('Status: 503 Service Temporarily Unavailable');
				header('Retry-After: 3600');
				exit($app->handle('/error/show503')->getContent());
		}
	}
});

set_error_handler(function($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_USER_NOTICE:
		case E_STRICT:
			break;

		default:
			Rj\Logger::messages()->error(sprintf("Error: #%d %s at %s:%d", $errno, $errstr, $errfile, $errline));
	}
});

$di->set('db', function() use ($di) {
	$db = new Phalcon\Db\Adapter\Pdo\Mysql($di->getShared('config')->database->toArray());
	return $db;
}, true);

$di->set('Mailer', Config::instance()->mailer, true);

$frontCache = new Phalcon\Cache\Frontend\Data([ 'lifetime' => 206400 * 3 ]);
$di->set('cache', function() use ($frontCache) {
	if ($host = Config::instance()->memcached_addr) {
		try {
			$redis = new Redis();
			$redis->connect(Config::instance()->memcached_addr);

			return new Rj\Cache\Backend\Redis($frontCache, [
				'redis' => $redis,
			]);

		} catch (Exception $e) {
			Rj\Logger::messages()->error("Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
		}
	}

	return new Phalcon\Cache\Backend\File($frontCache, [ 'cacheDir' => Config::instance()->cache_dir ]);
});

//$di->set('modelsMetadata', function() use ($di) {
//	return new Phalcon\Mvc\Model\MetaData\Files([
//		'metaDataDir' => DOCROOT . '/../app/cache/metadata/',
//	]);
//});

$di->set('filter', function() {
	$filter = new Phalcon\Filter();
	$filter->add('string', function($value) { return '' . $value; /* is_string($value) ? $value : ''; */ });
	$filter->add('uint', function($value) { return is_scalar($value) && preg_match('/^[0-9]+$/iD', $value) && $value >= 0 ? $value : 0; });
	$filter->add('array', function($value) { return is_array($value) ? $value : []; });
	$filter->add('intbool', function($value) { return empty($value) ? 0 : 1; });
	return $filter;
}, true);

date_default_timezone_set(Config::instance()->timezone);
error_reporting(Config::instance()->error_reporting);
ini_set('display_errors', Config::instance()->display_errors);

function _d($str) {
	return date('d.m.Y', strtotime($str));
}

function _dt($str, $sec = true) {
	return $sec ? date('d.m.Y H:i:s', strtotime($str)) : date('d.m.Y H:i', strtotime($str));
}
