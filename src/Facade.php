<?php

namespace AlexeyMezenin\RussianSeoSlugs;
 
use Illuminate\Support\Facades\Facade;
 
class Facade extends Facade {
 
    protected static function getFacadeAccessor() { return 'seoslug'; }
 
}