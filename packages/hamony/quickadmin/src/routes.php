<?php

/**
 * Package routing file specifies all of this package routes.
 */

use Illuminate\Support\Facades\View;
use Hamony\Quickadmin\Models\Menu;

if (Schema::hasTable('menus')) {
    $menus = Menu::with('children')->where('menu_type', '!=', 0)->orderBy('position')->get();
    View::share('menus', $menus);
    if (!empty($menus)) {
        Route::group([
            'middleware' => ['web', 'auth', 'role'],
            'prefix'     => config('quickadmin.route'),
            'namespace'  => 'App\Http\Controllers',
        ], function () use ($menus) {
            foreach ($menus as $menu) {
                switch ($menu->menu_type) {
                    case 1:
                        Route::post(strtolower($menu->name) . '/massDelete', [
                            'as'   => config('quickadmin.route') . '.' . strtolower($menu->name) . '.massDelete',
                            'uses' => 'Admin\\' . ucfirst(camel_case($menu->name)) . 'Controller@massDelete'
                        ]);
                        Route::resource(strtolower($menu->name),
                            'Admin\\' . ucfirst(camel_case($menu->name)) . 'Controller', ['except' => 'show']);
                        break;
                    case 3:
                        Route::controller(strtolower($menu->name),
                            'Admin\\' . ucfirst(camel_case($menu->name)) . 'Controller', [
                                'getIndex' => config('quickadmin.route') . '.' . strtolower($menu->name) . '.index',
                            ]);
                        break;
                }
            }
        });
    }
}

Route::group([
    'namespace'  => 'Hamony\Quickadmin\Controllers',
    'middleware' => ['web', 'auth.admin']
], function () {
    // Dashboard home page route
    Route::get(config('quickadmin.homeRoute'), 'QuickadminController@index');
    Route::group([
        'prefix' => config('quickadmin.route'),
        'middleware' => 'role'
    ], function () {
        // Menu routing
        Route::get('menu', [
            'as'   => 'menu',
            'uses' => 'QuickadminMenuController@index'
        ]);
        Route::post('menu', [
            'as'   => 'menu',
            'uses' => 'QuickadminMenuController@rearrange'
        ]);

        Route::get('menu/edit/{id}', [
            'as'   => 'menu.edit',
            'uses' => 'QuickadminMenuController@edit'
        ]);
        Route::post('menu/edit/{id}', [
            'as'   => 'menu.edit',
            'uses' => 'QuickadminMenuController@update'
        ]);

        Route::get('menu/crud', [
            'as'   => 'menu.crud',
            'uses' => 'QuickadminMenuController@createCrud'
        ]);
        Route::post('menu/crud', [
            'as'   => 'menu.crud.insert',
            'uses' => 'QuickadminMenuController@insertCrud'
        ]);

        Route::get('menu/parent', [
            'as'   => 'menu.parent',
            'uses' => 'QuickadminMenuController@createParent'
        ]);
        Route::post('menu/parent', [
            'as'   => 'menu.parent.insert',
            'uses' => 'QuickadminMenuController@insertParent'
        ]);

        Route::get('menu/custom', [
            'as'   => 'menu.custom',
            'uses' => 'QuickadminMenuController@createCustom'
        ]);
        Route::post('menu/custom', [
            'as'   => 'menu.custom.insert',
            'uses' => 'QuickadminMenuController@insertCustom'
        ]);

        Route::get('actions', [
            'as'   => 'actions',
            'uses' => 'UserActionsController@index'
        ]);
        Route::get('actions/ajax', [
            'as'   => 'actions.ajax',
            'uses' => 'UserActionsController@table'
        ]);
    });
});

// @todo move to default routes.php
Route::group([
    'namespace'  => 'App\Http\Controllers',
    'middleware' => ['web']
], function () {
    // Point to App\Http\Controllers\UsersController as a resource
    Route::group([
        'middleware' => 'role',
        'prefix' => config('quickadmin.route'),
        'namespace' => 'Admin',
    ], function () {
        Route::resource('users', 'UsersController', ['names' => [
            'index' => 'users.index',
            'create' => 'users.create',
            'store' => 'users.store',
            'update' => 'users.update',
            'show' => 'users.show',
            'edit' => 'users.edit',
            'destroy' => 'users.destroy',
        ]]);
        Route::resource('roles', 'RolesController');

        // Password reset link request routes...
        Route::get('password/email', 'Auth\PasswordController@getEmail');
        Route::post('password/email', 'Auth\PasswordController@postEmail');

        // Password reset routes...
        Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
        Route::post('password/reset', 'Auth\PasswordController@postReset');

    });

    Route::group([
        'prefix' => config('quickadmin.route'),
        'namespace' => 'Admin',
    ], function () {
        // Admin Authentication routes...
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');

    });


    // Authentication routes...
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout');

    // Registration routes...
    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');

    // Password reset link request routes...
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    // Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');
});
