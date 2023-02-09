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

        Blade::aliasComponent('components.badge','badge');
        Blade::aliasComponent('components.updated','updated');
        Blade::aliasComponent('components.card','card');


        Blade::if('disk', function ($value) {
            return config('filesystems.default') === $value;
        });

        Blade::if('admin', function () {
            return 1 == 2;
        });



    }
}
