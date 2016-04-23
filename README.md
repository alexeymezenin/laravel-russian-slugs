
###Introduction
This package offers easy to use Wikipedia-like Russian slugs like 'Как\_вырастить\_дерево' and Yandex transliterated 'kak-vyrastis-derevo' slugs and their variations with lowercased letters and different separators.

* [Installation](#Installation)
* [Using slugs](#Using-slugs)
* [Configuration](#Configuration)
* [Commands](#Commands)


<a name="Installation"></a>
###Installation

Start with editing your Laravel project's composer.json file to require package:

```
"require": {
    "alexeymezenin/laravel-russian-slugs": "0.*"
}
```

After that update Composer by running this command:

```
composer update
```

Now, add insert these two lines into provider and aliases arrays in `config/app.php`:

```
'providers' => [
    AlexeyMezenin\LaravelRussianSlugs\SlugsServiceProvider::class,

'aliases' => [
    'Slug' => AlexeyMezenin\LaravelRussianSlugs\Facade::class,
```

Finally, you need register config file and slug-related commands:
```
php artisan vendor:publish
```


<a name="Using-slugs"></a>
###Using slugs

To use slugs you need to update your models with `use` clause:

```
use \AlexeyMezenin\LaravelRussianSlugs\SlugsTrait;

class Articles extends Model
{
    use SlugTrait;
```

To **create new model** with a slug use `sluggity()` method. This will add slug to your model, based on `name` column:

```
$article = new Article;
$article->name = 'How to grow a tree?';
$article->sluggify('name');
$article->save();
```

You can **update existing model** and add a slug:
```
$article = Article::find(1);
$article->sluggify('name');
$article->save();
```

If slug already exists, but you need to recreate it, use forced sluggify:

```
$article->sluggify('name', true);
```

Alternatively, you can use `Slug` facade to manually work with slugs:
```
$article = Article::find(1);
$article->update([
    'slug' => Slug::build($article->name)
    ]);
```

`findBySlug()` method allows you to find a model by it's slug:
```
$slug = 'how-to-grow-a-tree';
$article = Article::findBySlug($slug);
echo $article->name; // Will output "How to grow a tree?"
```


<a name="Configuration"></a>
###Configuration

To configure a package you should edit `config/seoslugs.php` file.

`delimiter` is a symbol which replaces all spaces in a string. By default it's '_', but also can be '-'.

`urlType`

Default is **1**. Used for URLs like `/категория/книги_в_москве`

**2** is for traslitterated URLs like `/kategoriya/knigi_v_moskve`, Yandex rules used.

`keepCapitals` is `false` by default. When `true` it keeps capital letters in a string, for example: `/книги_в_Москве`

`slugColumnName` is a name of a slugs column. `slug` by default.

<a name="Commands"></a>
###Commands

There are three commands available with the package:

`php artisan slug:auto {table} {column}` command creates and executes migration, reslugs a table.

`php artisan slug:migration {table}` command creates migration to add a slug column.

`php artisan slug:reslug {table} {column}` command creating or recreating slugs for a specified table

###Copyright

RussianSeoSlugs was written by Alexey Mezenin and released under the MIT License.