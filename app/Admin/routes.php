<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    // 主页
    $router->get('/', 'HomeController@index');
    // 注册 登录 设置 相关
    $router->get('auth/register', 'AuthController@getRegister')->name('register');
    $router->post('auth/register', 'AuthController@postRegister')->name('register');;
    $router->post('auth/captcha', 'AuthController@postCaptcha')->name('captcha');
    $router->get('auth/login', 'AuthController@getLogin')->name('login');
    $router->post('auth/login', 'AuthController@postLogin')->name('login');
    $router->get('auth/logout', 'AuthController@getLogout')->name('logout');
    $router->get('auth/setting', 'AuthController@getSetting')->name('setting');
    $router->put('auth/setting', 'AuthController@putSetting')->name('setting');
    // 系统 菜单 权限 角色 相关
    $router->resource('auth/users', 'AdminUserController');
    $router->resource('auth/menu', 'MenuController', ['except' => ['create', 'show']]);
    $router->resource('auth/roles', 'RoleController');
    $router->resource('auth/permissions', 'PermissionController');
    // 具体业务 相关

    $router->get('/logviewer', 'LogViewerController@index')->name('logviewer');
    $router->get('/logviewer/download', 'LogViewerController@download')->name('logviewer.download');

    $router->resource('/user', 'UserController');
    $router->resource('/school', 'SchoolController');
    $router->resource('/score', 'ScoreController');
    $router->resource('/table', 'TableController');
    $router->resource('/spiderLog', 'SpiderLogController');
});

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    // 插件 相关
    $router->resource('auth/extensions', 'Dcat\Admin\Http\Controllers\ExtensionController', ['only' => ['index', 'store', 'update']]);
    // 开发工具 相关
    if (config('admin.helpers.enable', true) && config('app.debug')) {
        $router->get('helpers/scaffold', 'Dcat\Admin\Http\Controllers\ScaffoldController@index');
        $router->post('helpers/scaffold', 'Dcat\Admin\Http\Controllers\ScaffoldController@store');
        $router->post('helpers/scaffold/table', 'Dcat\Admin\Http\Controllers\ScaffoldController@table');
        $router->get('helpers/icons', 'Dcat\Admin\Http\Controllers\IconController@index');
    }
});
