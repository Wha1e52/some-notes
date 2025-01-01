<?php

/*
В приложении Laravel вы будете определять свои веб-маршруты в файле routes/web.php,
а API-маршруты — в файле routes/api.php.

чем конкретнее маршрут, тем выше он должен располагаться

пример рута с контроллером и конкретным действием в нем, которое отрабатывает
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
Вы также можете сделать параметры маршрута необязательными, добавив знак вопроса (?) после имени параметра {id?}
В этом случае вы должны указать значение по умолчанию для соответствующей переменной.
для получения маршрута из алиаса:
route('user.show')
Обращение к маршруту в представлении с помощью функции route():
<a href="<?php echo route('user.show', ['id' => 14]); ?>">

// users/userId/comments/commentId
route('users.comments.show', ['userId' => 1, 'commentId' => 2, 'opt' => 'a'])
// http://myapp.com/users/1/comments/2?opt=a

Хотя маршрут можно назвать как угодно, общепринятая практика — составное имя,
включающее в себя название ресурса во множественном числе, точку и наименование действия.


чтобы динамически создать все руты контроллера
Route::resource('posts', PostController::class);
можно немного управлять через
->only(['index', 'show'])
->except(['destroy', 'update']);


динамический рут
Route::get('/posts/{id}/comments/{comment}', function ($id, $comment_id) {
    return view('welcome', ['id' => $id, 'comment_id' => $comment_id]);
})->where(['id' => '[0-9]+', 'comment' => '[A-Za-z]+']);

чтобы не проверять в каждом руте тип, можно объявить глобально в App\Providers\AppServiceProvider:
public function boot(): void {
    Route::pattern('id', '[0-9]+');
}

чтобы исключить проверку на csrf по конкретным рутам, можно добавить в routes/web.php
return Application::configure(basePath: dirname(__DIR__))
  ...
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'наш ендпоинт/*',
        ]);
    })
    ...
    })->create();

Route::redirect('/here', '/there', 302) // редериктим с одного эндпоинта на другой, можем указать еще и код

группировка маршрутов по префиксу:
Route::prefix('admin')->group(function () {
    Route::get('/users', 'AdminController@users'); // строковый синтаксис(старый), тоже что и [AdminController::class, 'users']
    Route::get('/posts', 'AdminController@posts');
    Route::get('/comments', 'AdminController@comments');
});
можно группировать и без префикса

в случае если ендпоинта нет и мы не хотим выбрасывать 404, то будет отрабатывать fallback
определяем самым последним в файле
Route::fallback(function () {
    return 'такого эндпоинта нет';
})
можно так же и статус определить, если захотим определить кастомный 404
Route::fallback(function () {
    return response('такого эндпоинта нет', 404);
    либо
    return response()->json(['message' => 'такого эндпоинта нет'], 404);
    есть еще
    abort(404, 'такого эндпоинта нет'); // по типу die и exit
})



Route::get('/', function () {
    return 'Hello, World!';
});
Route::post('/', function () {
    // Обслуживаем запрос POST, отправленный на этот маршрут
});
Route::put('/', function () {
    // Обслуживаем запрос PUT, отправленный на этот маршрут
});
Route::delete('/', function () {
    // Обслуживаем запрос DELETE, отправленный на этот маршрут
});
Route::any('/', function () {
    // Обслуживаем запрос любого типа, отправленный на этот маршрут
});
Route::match(['get', 'post'], '/', function () {
    // Обслуживаем запросы GET или POST, отправленные на этот маршрут
});

Вспомогательные методы для ограничения выбора маршрутов с помощью регулярных выражений
Route::get('users/{id}/friends/{friendname}', function ($id, $friendname) {
//
})->whereNumber('id')->whereAlpha('friendname');
Route::get('users/{name}', function ($name) {
//
})->whereAlphaNumeric('name');
Route::get('users/{id}', function ($id) {
//
})->whereUuid('id');
Route::get('users/{id}', function ($id) {
//
})->whereUlid('id');
Route::get('friends/types/{type}', function ($type) {
//
})->whereIn('type', ['acquaintance', 'bestie', 'frenemy']);














*/