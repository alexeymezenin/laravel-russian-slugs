
###Вступление
Этот пакет позволяет использовать слаги (slugs) аналогичные используемым на сайте Wikipedia: 'Как\_вырастить\_дерево' или транслит по правилам Яндекса: 'kak-vyrastis-derevo', а также их вариации со строчными буквами с использованием различных символов разделения.

* [Установка](#Installation)
* [Использование](#Using-slugs)
* [Настройка](#Configuration)
* [Команды](#Commands)


<a name="Installation"></a>
###Установка

Добавьте в файл composer.json вашего Laravel проекта в раздел require следующую строку:

```
"require": {
    "alexeymezenin/russianseoslugs": "1.*"
}
```

Запустите эту команду для установки пакета:

```
composer update
```

Затем добавьте эти строки в разделы provider и aliases файла `config/app.php`:

```
'providers' => [
    AlexeyMezenin\RussianSeoSlugs\SlugServiceProvider::class,

'aliases' => [
    'Slug' => AlexeyMezenin\RussianSeoSlugs\Facade::class,
```

Наконец, зарегистрируйте конфигурационный файл и команды с помощью:
```
php artisan vendor:publish
```


<a name="Using-slugs"></a>
###Using slugs

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
###Configuration

To configure a package you should edit `config/seoslugs.php`


<a name="Commands"></a>
###Commands



###Copyright

RussianSeoSlugs was written by Alexey Mezenin and released under the MIT License.