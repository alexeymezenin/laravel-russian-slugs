<?php

namespace AlexeyMezenin\RussianSeoSlugs;

class Slug
{
    public $slug;

    private $delimiter;

    private $urlType;

    private $keepCapitals;

    public function __construct($stringToSlug, $delimiter = null, $urlType = null, $keepCapitals = null)
    {
        $this->slug = $stringToSlug;
        $this->delimiter = is_null($delimiter) ? config('seoslug.delimiter') : $delimiter;
        $this->urlType = is_null($urlType) ? config('seoslug.urlType') : $urlType;
        $this->keepCapitals = is_null($keepCapitals) ? config('seoslug.keepCapitals') : $keepCapitals;
    }

    // Building a slug
	public static function getSlug($stringToSlug, $delimiter = null, $urlType = null, $keepCapitals = null)
    {
        $obj = new self($stringToSlug, $delimiter, $urlType, $keepCapitals);

        $obj->replaceSpacesWithDelimiter()
            ->removeInappropriateSymbols()
            ->toLower()
            ->toTranslit();

        return $obj->slug;
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
            "я" => "ya",
            "А" => "A",   "Б" => "B",   "В" => "V",   "Г" => "G",
            "Д" => "D",   "Е" => "E",   "Ё" => "E",   "Ж" => "Zh",
            "З" => "Z",   "И" => "I",   "Й" => "I",   "К" => "K",
            "Л" => "L",   "М" => "M",   "Н" => "N",   "О" => "O",
            "П" => "P",   "Р" => "R",   "С" => "S",   "Т" => "T",
            "У" => "U",   "Ф" => "F",   "Х" => "Kh",  "Ц" => "Ts",
            "Ч" => "Ch",  "Ш" => "Sh",  "Щ" => "Sch", "Ъ" => "",
            "Ы" => "Y",   "Ь" => "",    "Э" => "E",   "Ю" => "Yu",
            "Я" => "Ya",
        );

        $this->slug = iconv("UTF-8","UTF-8//IGNORE", strtr($this->slug, $replace));

        return $this;
    }

}
