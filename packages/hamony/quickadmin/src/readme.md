## Requirements
* Laravel `^5.2` - Because of changed routing middleware and unsupported package `illuminate/html`

### Laravel 5.1.11 users info!
To use Quickadmin with Laravel Laravel 5.1.11 use branch `0.4.x`

## Quick Admin installation

###Please note: QuickAdmin requires fresh Laravel installation

1. Install the package via `composer require hamony/adminlte`.
2. Add `Hamony\Adminlte\AdminlteServiceProvider::class,` to your `\config\app.php` providers **after `App\Providers\RouteServiceProvider::class,`** otherwise you will not be able to add new ones to freshly generated controllers.
3. Configure your .env file with correct database information
4. Run `php artisan adminlte:install` and fill the required information.
5. Register middleware `'role'       => \Hamony\Admnilte\Middleware\HasPermissions::class,` in your `App\Http\Kernel.php` at `$routeMiddleware`
6. Access QuickAdmin panel by visiting `http://yourdomain/admin`.

## More information and detailed description
[http://laraveldaily.com/packages/quickadmin/](http://laraveldaily.com/packages/quickadmin/)

## License
The MIT License (MIT). Please see [License File](license.md) for more information.