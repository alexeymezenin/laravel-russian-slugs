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
	 * Create or recreate slugs in a column.
	 *
	 * @param $fromColumn Column to work with. String from this column will be converted to a slug.
	 * @param bool $force When true, forces recreation of a slug, even if it exists.
	 * @return $this
	 */
	
	public function reslug($fromColumn = $this->slugFrom, $force = false)
	{
		$slugColumn = config('seoslug.slugColumnName');

		// If slug needs to be created or recreated
		if (empty($this->$slugColumn) || $force) {
			$this->$slugColumn = \Slug::build($this->$fromColumn);
		}

		return $this;
	}
}
