<?php

namespace AlexeyMezenin\RussianSeoSlugs;

class Slug
{
    private $url;

    private $delimiter;

    private $urlType;

    private $keepCapitals;

    public function __construct($url, $delimiter = null, $urlType = null, $keepCapitals = null)
    {
        $this->slug = $url;
        $this->delimiter = is_null($delimiter) ? config('seoslug.delimiter') : $delimiter;
        $this->urlType = is_null($urlType) ? config('seoslug.urlType') : $urlType;
        $this->keepCapitals = is_null($keepCapitals) ? config('seoslug.keepCapitals') : $keepCapitals;
    }

    // Building a slug
	public static function url(
        $url,
        $delimiter    = null,
        $urlType      = null,
        $keepCapitals = null
    ) {
        self::__construct($url, $delimiter, $urlType, $keepCapitals);

        $this->slug->removeInappropriateSymbols()
                   ->replaceSpacesWithDelimiter()
                   ->toLower()
                   ->toTranslit();

//        // Cleaning URL from inapropriate symbols
//        $slug = preg_replace("/[^0-9а-яёa-z_-]/iu", '', $slug);
//        $slug = str_replace(' ', $delimilter, $url);
//
//        // Building slug based on configuration
//        $slug = ($keepCapitals == false) ? mb_strtolower($slug) : $slug;
//        $slug = ($urlType == 2) ? self::toTranslit($slug) : $slug;

        return $this->slug;
    }

    public function removeInappropriateSymbols(){
        $this->slug = preg_replace("/[^0-9а-яёa-z_-]/iu", '', $this->slug);

        return $this;
    }

    public function replaceSpacesWithDelimiter(){
        $this->slug = str_replace(' ', $this->delimiter, $this->slug);

        return $this;
    }

    public function toLower(){
        if($this->keepCapitals === false){
            $this->slug = mb_strtolower($this->slug);
        }

        return $this;
    }


    // Converts string to translit using Yandex rules
    public function toTranslit()
    {
        // if slug doesn't need to be transliterated
        if($this->urlType === 1) {
            return $this;
        }

        $replace = array(
            "а" => "a",   "б" => "b",   "в" => "v",   "г" => "g",
            "д" => "d",   "е" => "e",   "ё" => "e",   "ж" => "zh",
            "з" => "z",   "и" => "i",   "й" => "i",   "к" => "k",
            "л" => "l",   "м" => "m",   "н" => "n",   "о" => "o",
            "п" => "p",   "р" => "r",   "с" => "s",   "т" => "t",
            "у" => "u",   "ф" => "f",   "х" => "kh",  "ц" => "ts",
            "ч" => "ch",  "ш" => "sh",  "щ" => "sch", "ъ" => "",
            "ы" => "y",   "ь" => "",    "э" => "e",   "ю" => "yu",
            "я" => "ya"
        );

        $this->slug = iconv("UTF-8","UTF-8//IGNORE", strtr($this->slug, $replace));

        return $this;
    }

}
