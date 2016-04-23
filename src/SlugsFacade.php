<?php

namespace AlexeyMezenin\LaravelRussianSlugs;

use Illuminate\Support\Facades\Facade;

/**
 * Class SlugsFacade
 *
 * @package AlexeyMezenin\LaravelRussianSlugs
 */
class SlugsFacade extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'slug';
    }
 
}