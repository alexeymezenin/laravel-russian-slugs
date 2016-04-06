<?php

namespace AlexeyMezenin\RussianSeoSlugs;

class Slug
{
	public static function url($url)
    {
        
        $slug = str_replace(' ', config('seoslug.delimiter'), $url);
        $slug = preg_replace("/[^0-9а-яёa-z_-]/iu", '', $slug);
        
        // Keep capital letters or modify slug to lowercase
        $slug = config('seoslug.keepCapitals') ? $slug : $slug = mb_strtolower($slug);
        
        // Keep russian letters or modify create translit slug
        return config('seoslug.urlType') === 2 ? self::toTranslit($slug) : $slug;
    }

    public static function toTranslit($string)
    {
        $replace = array(
            "а" => "a",   "б" => "b",   "в" => "v",   "г" => "g",
            "д" => "d",   "е" => "e",   "ж" => "zh",  "з" => "z",
            "и" => "i",   "й" => "i",   "к" => "k",   "л" => "l",
            "м" => "m",   "н" => "n",   "о" => "o",   "п" => "p",
            "р" => "r",   "с" => "s",   "т" => "t",   "у" => "u",
            "ф" => "f",   "х" => "kh",  "ц" => "ts",  "ч" => "ch",
            "ш" => "sh",  "щ" => "sch", "ъ" => "",    "ы" => "y",
            "ь" => "",    "э" => "e",   "ю" => "yu",  "я" => "ya"
        );

        return $str = iconv("UTF-8","UTF-8//IGNORE", strtr($string, $replace));
    }

}
