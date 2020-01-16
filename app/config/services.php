<?php
use Dotenv\Dotenv;
use Phalcon\Crypt;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Http\Response\Cookies;
use Phalcon\Logger\Factory as Logger;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Predis\Client as Redis;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    try {
        (new Dotenv(BASE_PATH))->load();
    } catch (InvalidPathException $e) {

    }
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri('/');

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt'  => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath'      => $config->application->cacheDir,
                'compiledSeparator' => '_',
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class,

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class  = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset,
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});

/**
 * mongoDB
 */
$di->setShared('mongo', function () {
    $config = $this->getConfig();

    if (!$config->mongo->username || !$config->mongo->password) {
        $dsn = sprintf(
            'mongodb://%s:%s',
            $config->mongo->host,
            $config->mongo->port
        );
    } else {
        $dsn = sprintf(
            'mongodb://%s:%s@%s:%s',
            $config->mongo->username,
            $config->mongo->password,
            $config->mongo->host,
            $config->mongo->port
        );
    }

    $mongo = new MongoDB\Driver\Manager($dsn);

    return $mongo;
});

/**
 * redis
 */
$di->setShared('redis', function () {
    $config = $this->getConfig();

    $redis = new Redis([
        'scheme' => 'tcp',
        'host'   => $config->redis->host,
        'port'   => $config->redis->port,
    ]);

    return $redis;
});

/**
 * redisGroup
 */
$di->setShared('redisGroup', function () {
    $config = $this->getConfig();

    $redis = new Redis((array) $config->redisGroup, ['cluster' => 'redis']);

    return $redis;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Cookies
 */
$di->setShared('cookies', function () {
    $cookies = new Cookies();

    $cookies->useEncryption(true);

    return $cookies;
});

/**
 * Crypt
 */
$di->setShared('crypt', function () {
    $crypt = new Crypt();
    $key   = 'T5\xb3\x6d\xa9\x78\x520t7w!z%C*F-Ck\x99\x52\x5c';

    $crypt->setCipher('aes-256-ctr');
    $crypt->setKey($key);

    return $crypt;
});

/**
 * Logger
 */
$di->setShared('log', function () {
    $options = [
        'name'    => '../log/log.txt',
        'adapter' => 'file',
    ];

    $logger = Logger::load($options);

    return $logger;
});
