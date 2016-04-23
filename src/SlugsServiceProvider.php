<?php

namespace AlexeyMezenin\LaravelRussianSlugs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

/**
 * Class SlugsServiceProvider
 * @package AlexeyMezenin\LaravelRussianSlugs
 */
class SlugsServiceProvider extends ServiceProvider
{
    /**
     * @var array List of commands to register.
     */
    protected $commands = [
        'Vendor\Package\Commands\MyCommand',
        'Vendor\Package\Commands\FooCommand',
        'Vendor\Package\Commands\BarCommand',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/seoslug.php' => config_path('seoslug.php'),
            ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/../config/seoslug.php', 'seoslug');

        App::bind('slug', function($app, $parameters)
        {
            return new \AlexeyMezenin\LaravelRussianSlugs\Slugs($parameters);
        });

        // Register commands.
        $this->commands($this->commands);
    }
}
