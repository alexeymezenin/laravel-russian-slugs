<?php

namespace AlexeyMezenin\RussianSeoSlugs;
 
use Illuminate\Support\Facades\Facade;
 
class SlugsFacade extends Facade {
 
    protected static function getFacadeAccessor()
    {
        return 'slug';
    }
 
}