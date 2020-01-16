<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->servicesDir,
        $config->application->pluginsDir,
        $config->application->libraryDir,
    ]
);

// 注册自动加载器
$loader->register();
