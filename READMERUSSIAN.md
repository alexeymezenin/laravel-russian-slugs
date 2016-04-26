
###Вступление
Пакет позволяет использовать так называемые **слаги** (slugs), аналогичные используемым на сайте Wikipedia: 'Как\_вырастить\_дерево' или созданные с помощью правил транслита Яндекса: 'kak-vyrastis-derevo', а также их вариаций: со строчными буквами и использованием различных символов разделения.

* [Установка](#Installation)
* [Использование](#Using-slugs)
* [Конфигурация](#Configuration)
* [Команды](#Commands)


<a name="Installation"></a>
###Установка

Добавьте в файл composer.json вашего Laravel проекта, в раздел require следующую строку:

```
"require": {
    ....
    "alexeymezenin/laravel-russian-slugs": "0.9.*"
```

Установите пакет:

```
composer update
```

Затем добавьте эти строки в разделы provider и aliases файла `config/app.php`:

```
'providers' => [
    ....
    AlexeyMezenin\LaravelRussianSlugs\SlugsServiceProvider::class,
    

'aliases' => [
    ....
    'Slug' => AlexeyMezenin\LaravelRussianSlugs\SlugsFacade::class,
```

Наконец, зарегистрируйте конфигурационный файл и команды с помощью:
```
php artisan vendor:publish
```


<a name="Using-slugs"></a>
###Использование

Чтобы использовать пакет, добавьте в свои модели трейт:

```
class Articles extends Model
{
    use \AlexeyMezenin\LaravelRussianSlugs\SlugsTrait;
```

Чтобы **создать новый объект** со слагом, используйте метод `reslug()`. Например, этот код создаст слаг, основанный на колонке `name`:

```
$article = new Article;
$article->name = 'Как вырастить дерево?';
$article->reslug('name');
$article->save();
```

Вы можете **добавить слаг** к существующему объекту модели:
```
$article = Article::find(1);
$article->reslug('name');
$article->save();
```

Если слаг уже существует и вы хотите сгенерировать его заново, используйте принудительную конвертацию:

```
$article->reslug('name', true);
```

Как альтернативу, вы можете использовать фасад `Slug` для того, чтобы работать со слагами вручную:
```
$article = Article::find(1);
$article->update([
    'slug' => Slug::build($article->name)
    ]);
```

Метод `findBySlug()` позволяет осуществлять поиск по слагу:
```
$slug = 'как_вырастить_дерево';
$article = Article::findBySlug($slug);
echo $article->name; // Результатом будет "Как вырастить дерево?"
```


<a name="Configuration"></a>
###Конфигурация

Все настройки пакета находятся в файле `config/seoslugs.php`

`delimiter` символ разделения, которым заменяются все пробелы изначальной строки. По умолчанию '_', можно заменить на '-'.

`urlType` типа слага:

По умолчанию **1**. Строит слаги вида `/категория/книги_в_москве`

**2** строит слаги вида `/kategoriya/knigi_v_moskve`, используются правила Яндекса для транслита.

`keepCapitals` по умолчанию `false`. Когда `true`, прописные (большие) буквы не конвертируются в строчные: `/книги_в_Москве`

`slugColumnName` задает имя колонки для слагов в таблице. `slug` по умолчанию.

<a name="Commands"></a>
###Команды

С пакетом устанавливаются три консольные команды, облегчающие работу со слагами:

`php artisan slug:auto {table} {column}` - эта команда создает и запускает миграцию для добавления колонки со слагами, а затем автоматически создает слаги на основе столбца, указанного в {column}.

`php artisan slug:migration {table}` - эта команда создает миграцию для добавления столбца для слагов.

`php artisan slug:reslug {table} {column}` - эта команда создает или пересоздает слаги в указанном столбце.

Команды `slug:auto` и `slug:reslug` пересоздают слаги, даже если они уже существуют (используется принудительный режим).

###Копирайт

Пакет RussianSeoSlugs был создан Алексеем Мезененым и распространяется по лицензии MIT.