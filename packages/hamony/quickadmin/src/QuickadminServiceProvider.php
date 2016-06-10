<?php

namespace Hamony\Quickadmin;

use Illuminate\Support\ServiceProvider;
use Hamony\Quickadmin\Commands\QuickAdminConfig;
use Hamony\Quickadmin\Commands\QuickAdminInstall;

class QuickadminServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register vendor translations
        $this->loadTranslationsFrom(base_path('resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'hamony' . DIRECTORY_SEPARATOR),
            'quickadmin');
        // Register vendor views
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'qa', 'qa');
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'templates', 'tpl');
        /* Publish master templates */
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'quickadmin.php'                                            => config_path('quickadmin.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'admin'                                                      => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'auth'                                                       => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'auth'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'emails'                                                     => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'emails'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Translations'                                                                               => base_path('resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'hamony'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Public' . DIRECTORY_SEPARATOR . 'quickadmin'                                                => base_path('public' . DIRECTORY_SEPARATOR . 'quickadmin'),
            /* Admin Controller */
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'UsersController'    => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'UsersController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'RolesController'    => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'RolesController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'PasswordController' => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'PasswordController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'AuthController'     => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'AuthController.php'),
            /* End Admin Controller */
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'UsersController'    => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'UsersController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'RolesController'    => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'RolesController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'Controller'         => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Controller.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'PasswordController' => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'PasswordController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'AuthController'     => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'AuthController.php'),

            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'FileUploadTrait'    => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Traits' . DIRECTORY_SEPARATOR . 'FileUploadTrait.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'Role'                    => app_path('Role.php'),
        ], 'quickadmin');

        // Register commands
        $this->app->bind('quickadmin:install', function ($app) {
            return new QuickAdminInstall();
        });
        $this->commands([
            'quickadmin:install'
        ]);
        // Routing
        include __DIR__ . DIRECTORY_SEPARATOR . 'routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register main classes
        $this->app->make('Hamony\Quickadmin\Controllers\QuickadminController');
        $this->app->make('Hamony\Quickadmin\Controllers\UserActionsController');
        $this->app->make('Hamony\Quickadmin\Controllers\QuickadminMenuController');
        $this->app->make('Hamony\Quickadmin\Cache\QuickCache');
        $this->app->make('Hamony\Quickadmin\Builders\MigrationBuilder');
        $this->app->make('Hamony\Quickadmin\Builders\ModelBuilder');
        $this->app->make('Hamony\Quickadmin\Builders\RequestBuilder');
        $this->app->make('Hamony\Quickadmin\Builders\ControllerBuilder');
        $this->app->make('Hamony\Quickadmin\Builders\ViewsBuilder');
        $this->app->make('Hamony\Quickadmin\Events\UserLoginEvents');

        // Register dependency packages
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Yajra\Datatables\DatatablesServiceProvider');
        $this->app->register('Bican\Roles\RolesServiceProvider');

        // Register dependancy aliases
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('HTML', 'Collective\Html\HtmlFacade');
        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('Image', 'Intervention\Image\Facades\Image');
        $loader->alias('Datatables', 'Yajra\Datatables\Datatables');
    }

}
