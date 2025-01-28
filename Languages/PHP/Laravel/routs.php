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

// Генерирование подписанной ссылки
URL::signedRoute('invitations', ['invitation' => 12345, 'answer' => 'yes']);

// Генерирование подписанной ссылки с ограниченным сроком действия (временной)
URL::temporarySignedRoute(
    'invitations',
    now()->addHours(4),
    ['invitation' => 12345, 'answer' => 'yes']
);
// Сгенерировав ссылку для подписанного маршрута, необходимо также предотвратить доступ к нему без подписи
Route::get('invitations/{invitation}/{answer}', 'InvitationController::class')
    ->name('invitations')
    ->middleware('signed');

------------------------------------------------------------------------------------------------------------------------
// чтобы динамически создать все руты контроллера ресурса
Route::resource('posts', PostController::class);
можно немного управлять через
->only(['index', 'show'])
->except(['destroy', 'update']);

// чтобы динамически создать все руты контроллера апи
Route::apiResource('tasks', TaskController::class);
------------------------------------------------------------------------------------------------------------------------
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

группировка маршрутов по префиксу:
Route::prefix('admin')->group(function () {
    Route::get('/users', 'AdminController@users'); // строковый синтаксис(старый), тоже что и [AdminController::class, 'users']
    Route::get('/posts', 'AdminController@posts');
    Route::get('/comments', 'AdminController@comments');
});
можно группировать и без префикса

Запрещение доступа к группе маршрутов для пользователей, не прошедших аутентификацию
Route::middleware('auth')->group(function() {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::get('account', function () {
        return view('account');
    });
});

Поддоменная маршрутизация
Route::domain('api.myapp.com')->group(function () {
    Route::get('/', function () {
        //
    });
});

Префиксы имен для групп маршрутов
Route::name('users.')->prefix('users')->group(function () {
    Route::name('comments.')->prefix('comments')->group(function () {
        Route::get('{id}', function () {
            // ...
        })->name('show');
        Route::destroy('{id}', function () {})->name('destroy');
    });
});

Контроллеры групп маршрутов
Route::controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
});
------------------------------------------------------------------------------------------------------------------------
будет перехватывать запросы, не соответствующие ни одному из предшествующих маршрутов
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

// отправит файл file501751.pdf и переименует его при отправке в myFile.pdf.
return response()->download('file501751.pdf', 'myFile.pdf')
Чтобы отобразить тот же файл в браузере (если это PDF-файл, изображение или что-то еще,
что может обрабатывать браузер), используйте взамен
response()->file()
Потоковая загрузка с внешних серверов
return response()->streamDownload(function () {
    echo DocumentService::file('myFile')->getContent();
}, 'myFile.pdf');


Отмена с кодом состояния 403 Forbidden (Доступ запрещен)
Route::post('something-you-cant-do', function (Illuminate\Http\Request $request) {
    abort(403, 'You cannot do that!');
    abort_unless($request->has('magicToken'), 403);
    abort_if($request->user()->isBanned, 403);
});

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

Передача переменных в представления
Route::get('tasks', function () {
    return view('tasks.index')->with('tasks', Task::all());
});

// сокращенная запись возврата представления
Route::view('/tasks', 'tasks.index')->with('tasks', Task::all());

------------------------------------------------------------------------------------------------------------------------
Привязка модели маршрута
Route::get('conferences/{conference}', function (Conference $conference) {
    return view('conferences.show')->with('conference', $conference);
});
вместо
Route::get('conferences/{id}', function ($id) {
    $conference = Conference::findOrFail($id);
    return view('conferences.show')->with('conference', $conference);
});

Настройка ключа маршрута для конкретного маршрута (в каком столбце искать в бд) двоеточие и имя столбца
Route::get('conferences/{conference:slug}', function (Conference $conference) {
    return view('conferences.show')->with('conference', $conference);
});

Если в URL есть два динамических сегмента (например, organizers/{organizer}/conferences/{conference:slug}),
то фреймворк Laravel автоматически попытается ограничить запросы второй модели только теми, которые связаны с первой.
Поэтому он проверит модель Organizer на наличие связи с conferences и, если она существует, вернет только те
экземпляры Conferences, которые связаны с Organizer, найденным в результате поиска по первому сегменту
Route::get('organizers/{organizer}/conferences/{conference:slug}', function (Organizer $organizer, Conference $conference) {
    return $conference;
});
------------------------------------------------------------------------------------------------------------------------
// ограничиваем доступ к редактированию поста через auth и gate
Route::get('posts/{post}/edit', [PostController::class, 'edit'])
    ->middleware(['auth', 'can:namefromgate,post']);
либо
Route::get('posts/{post}/edit', [PostController::class, 'edit'])
    ->middleware('auth')
    ->can('namefromgate or policy', 'post');




*/