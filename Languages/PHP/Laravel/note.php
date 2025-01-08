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


маршруты доступны для текущего приложения
php artisan route:list --except-vendor

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


*/