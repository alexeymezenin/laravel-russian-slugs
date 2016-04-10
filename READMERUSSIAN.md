
###Вступление
Этот пакет позволяет использовать слаги (slugs) аналогичные используемым на сайте Wikipedia: 'Как\_вырастить\_дерево' или транслит по правилам Яндекса: 'kak-vyrastis-derevo', а также их вариации со строчными буквами с использованием различных символов разделения.

* [Установка](#Installation)
* [Использование](#Using-slugs)
* [Конфигурация](#Configuration)
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

Чтобы использовать пакет, добавьте в свои модели трейт:

```
use AlexeyMezenin\RussianSeoSlugs\SlugTrait;

class Articles extends Model
{
    use SlugTrait;
```

Чтобы **создать новый объект** со слагом, используйте метод `sluggity()`. Например, этот код создаст слаг, основанный на колонке `name`:

```
$article = new Article;
$article->name = 'How to grow a tree?';
$article->sluggify('name');
$article->save();
```

Вы можете **добавить слаг к существующей модели**:
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

`findBySlug` позволяет осуществлять поиск по слагу:
```
$slug = 'how-to-grow-a-tree';
$article = Article::findBySlug($slug);
echo $article->name; // Will output "How to grow a tree?"
```


<a name="Configuration"></a>
###Конфигурация

Все настройки пакета находятся в файле `config/seoslugs.php`


<a name="Commands"></a>
###Команды



###Копирайт

Пакет RussianSeoSlugs был создан Алексеем Мезененым и распространяется по лицензии MIT.