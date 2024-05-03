<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('loop', function ($expression) {
            return "<?php foreach ($expression): ?>";
        });
         
        Blade::directive('endloop', function ($expression) {
            return "<?php endforeach; ?>";
        });
    }
}
