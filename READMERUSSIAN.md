
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
    "alexeymezenin/laravel-russian-slugs": "0.*"
}
```

Запустите эту команду для установки пакета:

```
composer update
```

Затем добавьте эти строки в разделы provider и aliases файла `config/app.php`:

```
'providers' => [
    AlexeyMezenin\LaravelRussianSlugs\SlugsServiceProvider::class,

'aliases' => [
    'Slug' => AlexeyMezenin\LaravelRussianSlugs\Facade::class,
```

Наконец, зарегистрируйте конфигурационный файл и команды с помощью:
```
php artisan vendor:publish
```


<a name="Using-slugs"></a>
###Using slugs

Чтобы использовать пакет, добавьте в свои модели трейт:

```
use \AlexeyMezenin\LaravelRussianSlugs\SlugsTrait;

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

Если слаг уже существует и вы хотите сгенерировать его заново, используйте принудительную конвертацию:

```
$article->sluggify('name', true);
```

Как альтернативу, вы можете использовать фасад `Slug` для того, чтобы работать со слагами вручную:
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

С пакетом устанавливаются три команды, облегчающие создание слагов:

`php artisan slug:auto {table} {column}` - эта команда создает и запускает миграцию, а затем автоматически создает слаги в созданной таблице.

`php artisan slug:migration {table}` - эта команда создает миграцию для добавления столбца для слагов.

`php artisan slug:reslug {table} {column}` - эта команда создает или регенерирует слаги в указанном столбце.

###Копирайт

Пакет RussianSeoSlugs был создан Алексеем Мезененым и распространяется по лицензии MIT.