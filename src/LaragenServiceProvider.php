<?php

namespace Radoan\Laragen;

use Illuminate\Support\ServiceProvider;

class LaragenServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views','laragen');
        $this->publishes([
            __DIR__.'/vendor/laragen' => public_path('vendor/laragen'),
        ], 'public');
    }

    public function register()
    {
        //
    }
}
