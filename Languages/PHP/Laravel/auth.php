<?php
/*

// возвращает значение true, если текущий пользователь вошел в систему;
auth()->check()

// возвращает значение true, если пользователь не вошел в систему
auth()->guest()

// получить имя текущего вошедшего в систему пользователя
auth()->user()
// получить только идентификатор
auth()->id()
оба метода возвращают значение null при отсутствии вошедших в систему пользователей

// в контроллере
public function dashboard()
{
    if (auth()->guest()) {
        return redirect('sign-up');
    }
    return view('dashboard')
        ->with('user', auth()->user());
}

// Попытка выполнить аутентификацию пользователя
if (auth()->attempt([
    'email' => request()->input('email'),
    'password' => request()->input('password'),
])) {
    // Обработка успешного входа
}

// Если нужно, чтобы фреймворк Laravel сохранял эти регистрационные данные неопределенно долго с помощью cookie-файлов (пока пользователь использует один и тот же компьютер и не выходит из системы), вы можете передать методу auth()->attempt() логическое значение true во втором параметре
// Попытка выполнить аутентификацию пользователя с проверкой флажка «Запомнить меня»
if (auth()->attempt([
    'email' => request()->input('email'),
    'password' => request()->input('password'),
]), request()->filled('remember')) {
    // Обработка успешного входа
}

// осуществить аутентификацию пользователя
auth()->loginUsingId(5);
auth()->login($user);
// только для текущего запроса
auth()->once(['username' => 'mattstauffer']);
auth()->onceUsingId(5);

// выход пользователя из системы
auth()->logout();

// Аннулирование сессий на других устройствах
auth()->logoutOtherDevices($password);

// Пример ограничения доступа к маршрутам с помощью auth
Route::middleware('auth')->group(function () {
    Route::get('account', [AccountController::class, 'dashboard']);
});
Route::get('login', [LoginController::class, 'getLogin'])->middleware('guest');
Route::middleware('auth:trainees')->group(function () {
    // Маршруты, доступные только для спортсменов
});

//Проверка статуса аутентификации в шаблонах с использованием конкретного охранника аутентификации
@auth('trainees')
    // Пользователь аутентифицирован
@endauth
@guest('trainees')
    // Пользователь не аутентифицирован
@endguest

// Изменение охранника по умолчанию
Охранники определены в файле config/auth.php.
'defaults' => [
    'guard' => 'web', // Измените указанное здесь значение по умолчанию
    'passwords' => 'users',
],

// При необходимости можно использовать другого охранника, не назначая его охранником по умолчанию
$apiUser = auth()->guard('api')->user();

// Добавление нового охранника
'guards' => [
    'trainees' => [
        'driver' => 'session',
        'provider' => 'trainees',
    ],
],
Свойству driver можно присвоить одно из двух значений: token и session.

// Определение охранника на основе замыкания запроса
public function boot() // AuthServiceProvider
{
    Auth::viaRequest('token-hash', function ($request) {
        return User::where('token-hash', $request->token)->first();
    });
}

// Создание собственного провайдера пользователей
Доступные провайдеры определяются в файле config/auth.php в разделе auth.providers, расположенном непосредственно под определением охранников. Создадим новый провайдер с именем trainees:
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\User::class,
    ],
    'trainees' => [
            'driver' => 'eloquent',
            'model' => App\Trainee::class,
        ],
],

// Генерируемые фреймворком события аутентификации
protected $listen = [
    'Illuminate\Auth\Events\Attempting' => [],
    'Illuminate\Auth\Events\Authenticated' => [],
    'Illuminate\Auth\Events\CurrentDeviceLogout' => [],
    'Illuminate\Auth\Events\Failed' => [],
    'Illuminate\Auth\Events\Lockout' => [],
    'Illuminate\Auth\Events\Login' => [],
    'Illuminate\Auth\Events\Logout' => [],
    'Illuminate\Auth\Events\OtherDeviceLogout' => [],
    'Illuminate\Auth\Events\PasswordReset' => [],
    'Illuminate\Auth\Events\Registered' => [],
    'Illuminate\Auth\Events\Validated' => [],
    'Illuminate\Auth\Events\Verified' => [],
];

// Простейший пример использования фасада Gate
if (Gate::denies('edit-contact', $contact)) {
    abort(403);
}
if (! Gate::allows('create-contact', Contact::class)) {
    abort(403);
}

// Пример способности обновления контакта
class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('update-contact', function ($user, $contact) {
            return $user->id == $contact->user_id;
        });
    }
}
имена соответствуют принятому в Laravel формату {команда}-{имяМодели}: create-contact, update-contact и т. д.

// Простейший способ использования фасада Gate
if (Gate::allows('update-contact', $contact)) {
    // Обновление контакта
}
или
if (Gate::denies('update-contact', $contact)) {
    abort(403);
}

// Способности с несколькими параметрами
// Определение
Gate::define('add-contact-to-group', function ($user, $contact, $group) {
    return $user->id == $contact->user_id && $user->id == $group->user_id;
});
// Использование
if (Gate::denies('add-contact-to-group', [$contact, $group])) {
    abort(403);
}

// Указание пользователя для фасада Gate
if (Gate::forUser($user)->denies('create-contact')) {
    abort(403);
}

// Метод resource() позволяет применить к одному ресурсу сразу четыре часто используемых шлюза
— view (просмотр), create (создание), update (обновление) и delete (удаление).
Gate::resource('photos', 'App\Policies\PhotoPolicy');
Данный код эквивалентен следующим четырем строкам:
Gate::define('photos.view', 'App\Policies\PhotoPolicy@view');
Gate::define('photos.create', 'App\Policies\PhotoPolicy@create');
Gate::define('photos.update', 'App\Policies\PhotoPolicy@update');
Gate::define('photos.delete', 'App\Policies\PhotoPolicy@delete');

// Использование Authorize
Route::get('people/create', function () {
    // Создание пользователя
})->middleware('can:create-person');
Route::get('people/{person}/edit', function () {
    // Редактирование пользователя
})->middleware('can:edit,person');

// Упрощение авторизации внутри контроллера с помощью метода authorize()
// Исходный вариант:
public function edit(Contact $contact)
{
    if (Gate::cannot('update-contact', $contact)) {
        abort(403);
    }
    return view('contacts.edit', ['contact' => $contact]);
}
// Упрощенный вариант:
public function edit(Contact $contact)
{
    $this->authorize('update-contact', $contact);
    return view('contacts.edit', ['contact' => $contact]);
}

// Проверка на предмет авторизации с помощью экземпляра класса User
$user = User::find(1);
if ($user->can('create-contact')) {
    // Выполнение некоторых действий
}

// Использование Blade-директивы @can
<nav>
    <a href="/">Home</a>
    @can('edit-contact', $contact)
        <a href="{{ route('contacts.edit', [$contact->id]) }}">Edit This Contact</a>
    @endcan
</nav>

// Использование Blade-директивы @cannot
<h1>{{ $contact->name }}</h1>
@cannot('edit-contact', $contact)
    LOCKED
@endcannot

// Переопределение проверок фасада Gate с помощью метода before() (В классе AuthServiceProvider)
Gate::before(function ($user, $ability) {
    if ($user->isOwner()) {
        return true;
    }
});

// Проверка на предмет авторизации на основе политики
// Gate
if (Gate::denies('update', $contact)) {
    abort(403);
}
// Gate при отсутствии явного экземпляра
if (! Gate::check('create', Contact::class)) {
    abort(403);
}
// User
if ($user->can('update', $contact)) {
    // Выполнение определенных действий
}
// Blade
@can('update', $contact)
    // Выполнение определенных действий
@endcan
//
if (policy($contact)->update($user, $contact)) {
    // Выполнение определенных действий
}

























*/