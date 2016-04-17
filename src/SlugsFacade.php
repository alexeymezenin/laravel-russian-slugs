<?php

namespace AlexeyMezenin\RussianSeoSlugs;

use Illuminate\Support\Facades\Facade;

/**
 * Class SlugsFacade
 *
 * @package AlexeyMezenin\RussianSeoSlugs
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