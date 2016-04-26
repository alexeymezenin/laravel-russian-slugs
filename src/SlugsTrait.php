<?php

namespace AlexeyMezenin\LaravelRussianSlugs;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SlugTrait
 *
 * @package AlexeyMezenin\LaravelRussianSlugs
 */
trait SlugsTrait
{
	/**
	 * Find a model by slug.
	 *
	 * @param $slug
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public static function findBySlug($slug){
		return self::whereSlug($slug)->first();
	}

	/**
	 * Query scope for finding a model by slug.
	 *
	 * @param $query
	 * @param $slug
	 * @return mixed
	 */
	public function scopeWhereSlug($query, $slug){
		return $query->where(config('seoslug.slugColumnName'), $slug);
	}

	/**
	 * Create or recreates slugs in a column.
	 *
	 * @param $column Column to work with. String from this column will be converted to a slug.
	 * @param bool $force When true, forces recreation of a slug, even if it exists.
	 * @return $this
	 */
	public function sluggify($column, $force = false)
	{
		$slugColumn = config('seoslug.slugColumnName');

		// If slug needs to be created
		if (empty($this->$slugColumn) || $force) {
			$this->$slugColumn = Slug::build($this->$column);
		}

		return $this;
	}
}
