<?php

namespace AlexeyMezenin\RussianSeoSlugs;

use Illuminate\Database\Eloquent\Model;

trait SlugTrait
{

	public static function findBySlug($slug){
		return self::whereSlug($slug)->first();
	}

	public function scopeWhereSlug($query, $slug){
		return $query->where(config('seoslug.slugColumnName'), $slug);
	}

	public function sluggify($column, $force = false)
	{
		$slugColumn = config('seoslug.slugColumnName');

		// If slug needs to be created
		if (empty($this->$slugColumn) || $force) {
			$this->$slugColumn = Slug::url($this->$column);
		}

		return $this;
	}
}
