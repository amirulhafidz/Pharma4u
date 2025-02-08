<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot()
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Comment out the following lines if you don't need API routes.
            // Route::prefix('api')
            //     ->middleware('api')
            //     ->group(base_path('routes/api.php'));
        });
    }
}
