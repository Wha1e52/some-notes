<?php

/*

Различные способы вернуть перенаправление

// Использование глобальной вспомогательной функции
// для генерации ответа перенаправления
Route::get('redirect-with-helper', function () {
    return redirect()->to('login');
});

// Перенаправление redirect()->route() с параметрами (Метод route() аналогичен to(),
но вместо конкретного пути при его вызове нужно указать имя маршрута)
Route::get('redirect', function () {
    return redirect()->route('conferences.show', ['conference' => 99]);
});

// Использование глобальной вспомогательной функции с сокращенной формой
Route::get('redirect-with-helper-shortcut', function () {
    return redirect('login');
});

// Использование фасада для генерации ответа перенаправления
Route::get('redirect-with-facade', function () {
    return Redirect::to('login');
});

// для перенаправления пользователя на ту страницу, с которой он пришел.
redirect()->back()

// Использование сокращенной формы Route::redirect
Route::redirect('redirect-by-route', 'login');

// редериктим с одного эндпоинта на другой, можем указать еще и код
Route::redirect('/here', '/there', 302)

Другие методы перенаправления
Сервис перенаправления предоставляет другие методы, используемые не так часто.
refresh()::. Перенаправляет на ту же страницу, на которой сейчас находится пользователь.
away()::. Позволяет перенаправить на внешний URL без проверки по умолчанию.
secure(). Подобен to() с параметром secure, имеющим значение "true".
action(). Осуществляет привязку к контроллеру и методу одним из двух способов: в виде строки
(redirect()->action('MyController@myMethod')) или кортежа (redirect()->action([MyController::class, 'myMethod'])).
guest(). Используется внутренней системой аутентификации; когда пользователь посещает маршрут,
не пройдя необходимую для этого аутентификацию, метод захватывает «предполагаемый» маршрут
и затем перенаправляет пользователя (обычно на страницу авторизации).
intended(). Также используется внутри системы аутентификации; после успешной аутентификации
метод получает «заданный» URL, сохраненный методом guest(), и перенаправляет туда пользователя.

Перенаправление с данными
Route::get('redirect-with-key-value', function () {
    return redirect('dashboard')
        ->with('error', true);
});
Route::get('redirect-with-array', function () {
    return redirect('dashboard')
        ->with(['error' => true, 'message' => 'Whoops!']);
});

Перенаправление в форму с прежде введенными данными
Route::get('form', function () {
    return view('form');
});
Route::post('form', function () {
    return redirect('form')
        ->withInput()
        ->with(['error' => true, 'message' => 'Whoops!']);
});
воспользуемся функцией old(), чтобы получить все прежде введенные данные
<input name="username" value="<?=
    old('username', 'Default username instructions here');
?>">

Перенаправление с ошибками
Route::post('form', function (Illuminate\Http\Request $request) {
    $validator = Validator::make($request->all(), $this->validationRules);
    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }
});

*/