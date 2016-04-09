<?php

namespace AlexeyMezenin\RussianSeoSlugs;

use Illuminate\Support\ServiceProvider;

class SlugServiceProvider extends ServiceProvider
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

        $this->app['seoslug'] = $this->app->share(function($app) {
            return new Slug;
        });
    }
}
