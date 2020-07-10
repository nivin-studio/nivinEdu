<?php

use Dotenv\Dotenv;
use Phalcon\Di\FactoryDefault;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require '../vendor/autoload.php';

$dotenv = new Dotenv(BASE_PATH);
$dotenv->load();

env('APP_DEBUG') ? error_reporting(E_ALL) : error_reporting(0);

$di = new FactoryDefault();

/**
 * 处理路由
 */
include APP_PATH . '/config/router.php';

/**
 * 注册服务
 */
include APP_PATH . '/config/services.php';

/**
 * 获取配置
 */
$config = $di->getConfig();

/**
 * 自动加载器
 */
include APP_PATH . '/config/loader.php';

/**
 * Handle the request
 */
$application = new \Phalcon\Mvc\Application($di);

echo str_replace(["\n", "\r", "\t"], '', $application->handle()->getContent());
