<?php
/*

!!!!!!!!!!!!!!! Ни в коем случае не сохраняйте что-либо по ключу сессии flash,
поскольку он предназначен для внутреннего использования фреймворком Laravel для
кратковременного хранения данных сессии (доступных только для следующего запроса страницы). !!!!!!!!!!!!!!

// Использование метода session() в объекте Request
Route::get('dashboard', function (Request $request) {
    $request->session()->get('user_id');
});

// Внедрение базового класса сессии
Route::get('dashboard', function (Illuminate\Session\Store $session) {
    return $session->get('user_id');
});

// Использование глобальной вспомогательной функции session()
// Извлечение данных
$value = session()->get('key');
$value = session('key');
// Сохранение данных
session()->put('key', 'value');
session(['key', 'value']);

// Методы, доступные в экземплярах сессий
session()->get($key, $fallbackValue)
    $points = session()->get('points');
    $points = session()->get('points', 0);
    $points = session()->get('points', function () {
        return (new PointGetterService)->getPoints();
    });

session()->put($key, $value)
    session()->put('points', 45);
    $points = session()->get('points');

session()->push($key, $value) // Если определенные значения сессии представляют собой массивы
    session()->put('friends', ['Saúl', 'Quang', 'Mechteld']);
    session()->push('friends', 'Javier');

session()->has($key)
    if (session()->has('points')) {
        // Выполнение некоторых действий
    }
    Вы также можете передать массив ключей. Тогда метод вернет значение true, если заданы значения для всех указанных ключей.

session()->exists($key)
    if (session()->exists('points')) {
        // Вернет значение true, даже если ключу points присвоено значение null
    }

session()->all()
session()->only()

session()->forget($key) и session()->flush()
    session()->put('a', 'awesome');
    session()->put('b', 'bodacious');
    session()->forget('a');
    // Значения с ключом 'a' уже нет;
    // значение с ключом 'b' по-прежнему существует
    session()->flush();
    // Сессия очищена

session()->pull($key, $fallbackValue)
    Как и get(), метод pull() извлекает из сессии значение, но при этом оно удаляется из сессии после извлечения.

session()->regenerate()
    Иногда нужно сгенерировать новый идентификатор сессии

session()->flash($key, $value)
    Метод flash() присваивает ключу сессии указанное значение, которое будет доступно только для следующего запроса страницы

session()->reflash() и session()->keep($key)
    Если нужно, чтобы кратковременное хранилище сессии с данными из предыдущей страницы оставалось
    доступным в течение еще одного запроса










*/