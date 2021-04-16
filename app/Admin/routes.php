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

    $router->get('auth/register', 'AuthController@getRegister')->name('register');
    $router->post('auth/register', 'AuthController@postRegister')->name('register');;
    $router->post('auth/captcha', 'AuthController@postCaptcha')->name('captcha');
    $router->get('auth/login', 'AuthController@getLogin')->name('login');
    $router->post('auth/login', 'AuthController@postLogin')->name('login');
    $router->get('auth/logout', 'AuthController@getLogout')->name('logout');
    $router->get('auth/setting', 'AuthController@getSetting')->name('setting');
    $router->put('auth/setting', 'AuthController@putSetting')->name('setting');

    $router->get('/', 'HomeController@index');

    $router->resource('/user', 'UserController', [
        'names' => ['index' => 'user'],
    ]);

    $router->resource('/school', 'SchoolController', [
        'names' => ['index' => 'school'],
    ]);

    $router->resource('/score', 'ScoreController', [
        'names' => ['index' => 'score'],
    ]);

    $router->resource('/table', 'TableController', [
        'names' => ['index' => 'table'],
    ]);
});
