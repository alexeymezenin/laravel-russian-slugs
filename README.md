
####Introduction
This package offers easy to use russian Wikipedia-like slugs 'как\_вырастить\_дерево' and Yandex transliterated 'kak-vyrastis-derevo' slugs.

* [Installation](#Installation)
* [Using slugs](#Using-slugs)
* [Configuration](#Configuration)
* [Commands](#Commands)

<a name="Installation"></a>
####Installation

Start with editing your Laravel project's composer.json file to require package:

```
"require": {
    "alexeymezenin/russianseoslugs": "1.*"
}
```

After that update Composer by running this command:

```
composer update
```

Now, add insert these two lines into provider and aliases arrays of `config/app.php`:

```
'providers' => [
    AlexeyMezenin\RussianSeoSlugs\SlugServiceProvider::class,

'aliases' => [
    'Slug' => AlexeyMezenin\RussianSeoSlugs\Facade::class,
```

Finally, you need register config file and slug-related commands:
```
php artisan vendor:publish
```

<a name="Using-slugs"></a>
####Using slugs

To use slugs you need to update your models with `use` clause:

```
use AlexeyMezenin\RussianSeoSlugs\SlugTrait;

class Articles extends Model
{
    use SlugTrait;
```

To **create new object** with a slug use `sluggity()` methof will add slug to your model, based on `name` column:

```
$article = new Article;
$article->name = 'How to grow a tree?';
$article->sluggify('name');
$article->save();
```

You can **update existing object** and add a slug:
```
$article = Article::find(1);
$article->sluggify('name');
$article->save();
```

Alternatively, you can use `Slug` facade to manually work with slugs:
```
$article = Article::find(1);
$article->update([
    'slug' => Slug::url($article->name)
    ]);
```

`findBySlug` allows you to find a model by slugs:
```
$slug = 'how-to-grow-a-tree';
$article = findBySlug($slug);
echo $article->name; // Will output "How to grow a tree?"
```

<a name="Configuration"></a>
####Configuration

To configure a package you should edit `config/seoslugs.php`

<a name="Commands"></a>
####Commands



####Copyright

RussianSeoSlugs was written by Alexey Mezenin and released under the MIT License.