<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// Admin::routes();

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['web', 'admin'],
    'as'         => 'admin',
], function (Router $router) {

    // 后台Auth相关路由
    $router->namespace('App\\Admin\\Controllers\\Auth')->group(function ($router) {

        $router->get('auth/login', 'AuthController@getLogin');
        $router->post('auth/login', 'AuthController@postLogin');
        $router->get('auth/logout', 'AuthController@getLogout');
        $router->get('auth/setting', 'AuthController@getSetting');
        $router->put('auth/setting', 'AuthController@putSetting');

        $router->resource('auth/users', 'UserController');
        $router->resource('auth/menu', 'MenuController', ['except' => ['create', 'show']]);
        $router->resource('auth/logs', 'LogController', ['only' => ['index', 'destroy']]);

        if (config('admin.permission.enable')) {
            $router->resource('auth/roles', 'RoleController');
            $router->resource('auth/permissions', 'PermissionController');
        }

    });

    // 后台业务相关路由
    $router->namespace('App\\Admin\\Controllers')->group(function ($router) {

        $router->get('/', 'HomeController@index')->name('.index');
        $router->get('/system/info', 'SystemController@info');

        $router->resource('/schcool', 'SchoolController');
        $router->resource('/user', 'UserController');
        $router->resource('/grade', 'GradeController');
        $router->resource('/task', 'TaskController');
    });
});
