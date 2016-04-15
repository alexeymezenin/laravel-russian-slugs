<?php

namespace AlexeyMezenin\RussianSeoSlugs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class SlugsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/seoslug.php' => config_path('seoslug.php'),
            ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom( __DIR__.'/Config/seoslug.php', 'seoslug');

        App::bind('slug', function($app, $parameters)
        {
            return new \AlexeyMezenin\RussianSeoSlugs\Slugs($parameters);
        });
    }
}
