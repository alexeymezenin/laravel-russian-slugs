
###Introduction
This package offers easy to use cyrillic slugs like 'Как\_вырастить\_дерево' and Yandex transliterated 'kak-vyrastis-derevo' slugs and their variations with lowercased letters and different separators.

* [Installation](#Installation)
* [Using slugs](#Using-slugs)
* [Manual slug creation](#Manual-slug-creation)
* [Configuration](#Configuration)
* [Commands](#Commands)


<a name="Installation"></a>
###Installation

Start with editing your Laravel project's composer.json file to require package:

```
"require": {
    ....
    "alexeymezenin/laravel-russian-slugs": "0.9.*"
```

After that run this command to install package:

```
composer update
```

Now, insert these two lines into provider and aliases arrays in `config/app.php`:

```
'providers' => [
    ....
    AlexeyMezenin\LaravelRussianSlugs\SlugsServiceProvider::class,
    

'aliases' => [
    ....
    'Slug' => AlexeyMezenin\LaravelRussianSlugs\SlugsFacade::class,
```

Finally, you need to register config file and slugs-related commands by running:
```
php artisan vendor:publish
```

<a name="Using-slugs"></a>
###Using slugs

To use package, you need to update your models with this`use` clause:

```
class Articles extends Model
{
    use \AlexeyMezenin\LaravelRussianSlugs\SlugsTrait;
```

To use **auto slug creation** feature add `slugFrom` property to your model:

```
protected $slugFrom = 'article_name';
```

In this case, every time when you're saving data to a DB, package tries to create (but not recreate) a new slug and save it:

```
$article = Article::create(['article_name' => 'Как вырастить дерево?']);
```

Of course, that doesn't work with mass inserts and updates when you're updating multiple rows with one query.

<a name="Manual-slug-creation"></a>
###Manual slug creation

To **create new record** with a slug use `reslug()` method. This will add slug, based on `name` column:

```
$article = new Article;
$article->name = 'How to grow a tree?';
$article->reslug('name');
$article->save();
```

You can **update existing record** and add a slug:
```
$article = Article::find(1);
$article->reslug('name');
$article->save();
```

If slug already exists, but you need to recreate it, use forced reslug:

```
$article->reslug('name', true);
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

`urlType` is a type of slug:

Default is **1**. Used for URLs like `/категория/книги_в_москве`

**2** is for traslitterated URLs like `/kategoriya/knigi_v_moskve`, Yandex rules used to transliterate URL.

`keepCapitals` is `false` by default. When `true` it keeps capital letters in a slug, for example: `/книги_в_Москве`

`slugColumnName` sets the name of a slug column. `slug` by default.

<a name="Commands"></a>
###Commands

There are three console commands available in the package:

`php artisan slug:auto {table} {column}` command creates and executes migration, reslugs a table (creates slugs for all rows) using {column} as source.

`php artisan slug:migration {table}` command creates migration to add a slug column.

`php artisan slug:reslug {table} {column}` command creates or recreates slugs for a specified table.

Commands `slug:auto` and `slug:reslug` will recreate all slugs, even if they are already exist (forced reslug used).

###Copyright

RussianSeoSlugs was written by Alexey Mezenin and released under the MIT License.