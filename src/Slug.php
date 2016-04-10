<?php

namespace AlexeyMezenin\RussianSeoSlugs;

class Slug
{

    // Building a slug
	public static function url($url)
    {
        // Cleaning URL from inapropriate symbols
        $slug = preg_replace("/[^0-9а-яёa-z_-]/iu", '', $slug);
        $slug = str_replace(' ', config('seoslug.delimiter'), $url);

        // Building slug based on configuration
        $slug = (config('seoslug.keepCapitals') == false) ? mb_strtolower($slug) : $slug;
        $slug = (config('seoslug.urlType') == 2) ? self::toTranslit($slug) : $slug;

        return $slug;
    }

    // Converts string to translit using Yandex rules
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
