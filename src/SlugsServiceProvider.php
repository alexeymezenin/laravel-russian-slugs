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
        'AlexeyMezenin\LaravelRussianSlugs\AutoCommand',
        'AlexeyMezenin\LaravelRussianSlugs\CreateSlugMigrationCommand',
        'AlexeyMezenin\LaravelRussianSlugs\ReslugTableCommand',
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
        $this->handleConfig();

        $this->registerEvents();

        App::bind('slug', function($app, $parameters)
        {
            return new \AlexeyMezenin\LaravelRussianSlugs\Slugs($parameters);
        });
    }

    /**
     * Register console commands.
     */
    private function registerCommands()
    {
        $this->commands($this->commands);
    }

    /**
     * Register Eloquent events.
     */
    private function registerEvents()
    {
        $this->app['events']->listen('eloquent.saving*', function ($model) {
            $slugColumn = config('seoslug.slugColumnName');

            if (property_exists($model, $model->$slugColumn)) {
                $model->reslug();
            }
        });
    }

    /**
     * Handle config.
     */
    private function handleConfig()
    {
        $this->mergeConfigFrom( __DIR__.'/../config/seoslug.php', 'seoslug');
    }
}
