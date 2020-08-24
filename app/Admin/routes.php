<?php

use Dcat\Admin\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.index');
    $router->get('/system/info', 'SystemController@info');

    $router->resource('/schcool', 'SchoolController');
    $router->resource('/user', 'UserController');
    $router->resource('/grade', 'GradeController');
});
