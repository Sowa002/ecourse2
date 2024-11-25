<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register middleware
        $this->app->router->aliasMiddleware('role', RoleMiddleware::class);
        $this->app->router->aliasMiddleware('permission', PermissionMiddleware::class);
        $this->app->router->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
        $this->app->router->pushMiddlewareToGroup('api', EnsureFrontendRequestsAreStateful::class);
        $this->app->router->pushMiddlewareToGroup('api', \Illuminate\Routing\Middleware\ThrottleRequests::class.':api');
        $this->app->router->pushMiddlewareToGroup('api', \Illuminate\Routing\Middleware\SubstituteBindings::class);
    }

    public function boot()
    {
        //
    }
}
