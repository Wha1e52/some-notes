<?php
/*

// Фасад Cookie
Cookie::get($key)
Cookie::has($key)
Cookie::make(...параметры)
    Параметры метода make() — в порядке их следования — включают в себя следующее:
    $name — имя cookie-файла;
    $value — содержимое cookie-файла;
    $minutes — срок хранения cookie-файла;
    $path — путь, для которого будет действителен cookie-файл;
    $domain — список доменов, для которых должен использоваться cookie-файл;
    $secure указывает, должен ли cookie-файл передаваться только через защищенное соединение (HTTPS);
    $httpOnly указывает, будет ли cookie-файл доступен только по протоколу HTTP;
    $raw указывает, должен ли cookie-файл отправляться без URL-кодирования;
    $sameSite указывает, следует ли предоставлять доступ к cookie-файлу для межсайтовых запросов; возможны варианты lax, strict и null.
Cookie::queue(cookie-файл || параметры)
    тот же синтаксис, что и метод Cookie::make(), но
    при этом созданный cookie-файл помещается в очередь для автоматического прикрепления к ответу с помощью промежуточного ПО.

// Глобальная вспомогательная функция cookie()
$cookie = cookie('dismissed-popup', true, 15);

// Работа с cookie-файлами в объектах Request и Response

// Чтение cookie-файлов из объекта Request
Route::get('dashboard', function (Illuminate\Http\Request $request) {
    $userDismissedPopup = $request->cookie('dismissed-popup', false);
});

// Установка cookie-файла в объекте Response
Route::get('dashboard', function () {
    $cookie = cookie('saw-dashboard', true);
    return Response::view('dashboard')
        ->cookie($cookie);
});










/*