<?php
/*

curl -s https://laravel.build/example-app | bash
cd example-app
./vendor/bin/sail up
./vendor/bin/sail artisan migrate


Обращаться к переменной конфигурации с помощью выражения config('services.sparkpost.secret').
доступ к элементам осуществляется по конфигурационному ключу, состоящему из имени файла и всех ключей-потомков,
разделенных точками (.).

php artisan key:generate - для генерации APP_KEY в .env

По умолчанию фреймворк добавляет PHPUnit в качестве зависимости и настроен на запуск тестов,
содержащихся в любом файле, который размещен в каталоге tests и имеет окончание Test.php(например, tests/UserTest.php).
И самый простой способ запуска — выполнить в командной строке команду
./vendor/bin/phpunit (находясь в корневой папке проекта).
------------------------------------------------------------------------------------------------------------------------
// маршруты доступны для текущего приложения
php artisan route:list --except-vendor
------------------------------------------------------------------------------------------------------------------------
Добавление привязки модели маршрута
Чтобы вручную настроить привязку модели маршрута, добавьте в метод boot() в App\Providers\RouteServiceProvider.
public function boot() {
    // Выполняем привязку
    Route::model('event', Conference::class);
}
Этот код указывает, что всякий раз, когда в определении маршрута присутствует параметр с именем {event},
локатор маршрута вернет экземпляр класса Conference с идентификатором этого параметра URL.
Route::get('events/{event}', function (Conference $event) {
    return view('events.show')->with('event', $event);
});

Кэширование маршрутов
Если приложение не использует замыкания маршрутов, вы можете выполнить команду
php artisan route:cache
Для удаления кэша следует выполнить команду
php artisan route:clear
используйте кэширование маршрутов только на эксплуатационном сервере и выполняйте команду php artisan route:cache
при каждом развертывании нового кода

Подмена HTTP-метода в HTML-формах
Чтобы сообщить Laravel, что отправляемая вами в настоящее время форма должна рассматриваться как нечто отличное от POST,
добавьте скрытую переменную с именем _method и значением "PUT", "PATCH" или "DELETE". Фреймворк передаст
форму по заданному маршруту так, словно она действительно была отправлена запросом с указанной командой.
<form action="/tasks/5" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <!-- или: -->
    @method('DELETE')
</form>

Токены CSRF
<form action="/tasks/5" method="POST">
    @csrf
</form>

Наиболее распространенное решение для сайтов, использующих JavaScript-фреймворки,
— сохранение токена на каждой странице в теге <meta> следующего вида:
<meta name="csrf-token" content="<?php echo csrf_token(); ?>">
// В jQuery:
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
Начальная загрузка токена CSRF в Vue Resource выглядит несколько иначе, чем в случае Laravel;
примеры см. в документации по Vue Resource (https://oreil.ly/YT0Nb).

// запросы к API
Http::get('https://jsonplaceholder.typicode.com/todos/1')->json();

В Laravel есть функция now(), которая выполняет то же, что и метод Carbon::now() — возвращает экземпляр объекта Carbon в его текущем виде.
Carbon — это включенная в состав Laravel библиотека для работы с датой и временем.

// скопировать файлы для ручного редактирования из асетов
php artisan vendor:publish
и теперь в boot методе App\Providers\AppServiceProvider можно например поменять шаблон пагинации
Paginator::useBootstrapFive();

// чтобы привязать кнопку в форме к другой форме, используем атрибут form="#another-form-id"

// в форме вставляем старые данные
<input name="name" :value="old('name')" />
------------------------------------------------------------------------------------------------------------------------
// объявляем врата (в сервис провайдере в boot)
Gate::define('update-post', function (User $user, Post $post) {
    return $post->user->is($user);
});

// запускаем врата
Gate::authorize('update-post', $post);

// если нужно вручную обрабатывать исключения а выбрасывать 403 поумолчанию
if (Gate::denies('update-post', $post)) {
    do something
}
------------------------------------------------------------------------------------------------------------------------
// собрать файлы для доставки в прод окружение или для локального тестирования
npm run build / npm run dev
Собранные файлы будут помещены в папку public/build/assets вместе с файлом public/build/manifest.json
------------------------------------------------------------------------------------------------------------------------
// Строковые вспомогательные функции и множественность
Глобальные функции, str_ и array_, были удалены из Laravel версии 6 и перенесены в отдельный пакет laravel/helpers.
При желании его можно установить с помощью Composer: composer require laravel/helpers.
e() // Краткое обозначение для html_entities(). В целях безопасности экранирует все сущности HTML.

Str::startsWith(), Str::endsWith(), Str::contains()
Str::is()
Str::slug()
Str::plural(word, count), Str::singular()
Str::camel(), Str::kebab(), Str::snake(), Str::studly(), Str::title()
Str::after(), Str::before(), Str::limit()
Str::markdown(string, options)
Str::replace(search, replace, subject, caseSensitive)
------------------------------------------------------------------------------------------------------------------------
Задать локаль можно вызовом App::setLocale($localeName) и, скорее всего, вы поместите его в сервис-провайдер.
В config/app.php есть специальный ключ fallback_locale, с помощью которого можно определить резервную локаль.
Это язык по умолчанию для приложения, который Laravel будет использовать, если не найдет перевод для запрошенной локали

// опубликовать файлы lang для модификации
php artisan lang:publish

Далее нужно создать файл lang/en/navigation.php, в котором будут определяться строки для перевода,
связанные с навигацией, и заставить его возвращать массив PHP с указанным в нем ключом back (пример 6.10).
<?php
return [
    'back' => 'Return to dashboard',
];
Теперь добавим перевод, для чего создадим каталог es в lang с собственным файлом navigation.php
<?php
return [
    'back' => 'Volver al panel',
];

Использование перевода
// routes/web.php
Route::get('/es/contacts/show/{id}', function () {
    // В этом примере локаль устанавливается вручную, а не в сервис-провайдере
    App::setLocale('es');
    return view('contacts.show');
});
// resources/views/contacts/show.blade.php
<a href="/contacts">{{ __('navigation.back') }}</a>

// lang/en/navigation.php
return [
'back' => 'Back to :section dashboard',
];
// resources/views/contacts/show.blade.php
{{ __('navigation.back', ['section' => 'contacts']) }}

// Определение простого перевода с поддержкой множественного числа
// lang/en/messages.php
return [
'task-deletion' => 'You have deleted a task|You have successfully deleted tasks',
];
// resources/views/dashboard.blade.php
@if ($numTasksDeleted > 0)
{{ trans_choice('messages.task-deletion', $numTasksDeleted) }}
@endif

// Использование компонента Symfony Translation
// lang/en/messages.php
return [
    'task-deletion' => "{0} You didn't manage to delete any tasks.|" .
    "[1,4] You deleted a few tasks.|" .
    "[5,Inf] You deleted a whole ton of tasks.",
];

// Использование JSON-переводов и функции __()
// В Blade
{{ __('View friends list') }}
// lang/es.json
{
'View friends list': 'Ver lista de amigos'
}
------------------------------------------------------------------------------------------------------------------------
// включить сервер дампа, который будет перехватывать обращения к dump() и отображать вывод в консоли вместо страницы.
php artisan dump-server
------------------------------------------------------------------------------------------------------------------------
// объект PARAMETERBAG
Используя фреймворк Laravel, вы иногда будете сталкиваться с объектом ParameterBag.
Этот класс представляет собой нечто вроде ассоциативного массива.
Вы можете получить значение определенного ключа с помощью метода get():
echo $bag->get('name');
Можно воспользоваться методом has() для проверки на наличие в массиве определенного ключа,
all() для получения массива, содержащего все ключи и значения,
count() для подсчета количества элементов и keys() для получения массива, содержащего только ключи.
------------------------------------------------------------------------------------------------------------------------






















*/