<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database'    => [
        'adapter'  => env('DB_ADAPTER', 'Mysql'),
        'host'     => env('DB_HOST', '172.0.0.1'),
        'port'     => env('DB_PORT', '3306'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'root'),
        'dbname'   => env('DB_DATABASE', 'test'),
        'charset'  => env('DB_CHARSET', 'utf8'),
    ],
    'mongo'       => [
        'host'     => env('MONGO_HOST', '172.0.0.1'),
        'port'     => env('MONGO_PORT', '27017'),
        'username' => env('MONGO_USERNAME', 'root'),
        'password' => env('MONGO_PASSWORD', 'root'),
        'database' => env('MONGO_DATABASE', 'test'),
    ],
    'redis'       => [
        'host' => env('REDIS_HOST', '172.0.0.1'),
        'port' => env('REDIS_PORT', '6379'),
    ],
    'redisGroup'  => [
        'tcp://127.0.0.1:6001',
        'tcp://127.0.0.1:6002',
        'tcp://127.0.0.1:6003',
        'tcp://127.0.0.1:6004',
        'tcp://127.0.0.1:6005',
        'tcp://127.0.0.1:6006',
    ],
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

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ],
    'fonts'       => BASE_PATH . '/public/fonts/',
]);
