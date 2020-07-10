<?php
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'debug'       => env('APP_DEBUG', false),
    // mysql数据库配置
    'database'    => [
        'adapter'  => env('DB_ADAPTER', 'Mysql'),
        'host'     => env('DB_HOST', '127.0.0.1'),
        'port'     => env('DB_PORT', '3306'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'root'),
        'dbname'   => env('DB_DATABASE', 'test'),
        'charset'  => env('DB_CHARSET', 'utf8'),
    ],
    // mongo数据库配置
    'mongo'       => [
        'host'     => env('MONGO_HOST', '127.0.0.1'),
        'port'     => env('MONGO_PORT', '27017'),
        'username' => env('MONGO_USERNAME', 'root'),
        'password' => env('MONGO_PASSWORD', 'root'),
        'database' => env('MONGO_DATABASE', 'test'),
    ],
    // redis缓存配置
    'redis'       => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', '6379'),
    ],
    // redis集群缓存配置
    'redisGroup'  => [
        'tcp://127.0.0.1:6001',
        'tcp://127.0.0.1:6002',
        'tcp://127.0.0.1:6003',
        'tcp://127.0.0.1:6004',
        'tcp://127.0.0.1:6005',
        'tcp://127.0.0.1:6006',
    ],
    // 项目应用基础配置
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'servicesDir'    => APP_PATH . '/services/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'fontsDir'       => BASE_PATH . '/public/fonts/',
        'imagesDir'      => BASE_PATH . '/public/images/',
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ],
]);
