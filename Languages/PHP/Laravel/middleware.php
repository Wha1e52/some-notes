<?php

/*

// команда для создания middleware
php artisan make:middleware BanDeleteMethod

// Пример промежуточного ПО, отклоняющего запросы DELETE
...
class BanDeleteMethod
{
    public function handle($request, Closure $next)
    {
        // Проверка метода DELETE
        if ($request->method() === 'DELETE') {
            return response(
                "Get out of here with that delete method",
                405
            );
        }

        $response = $next($request);

        // Добавление cookie-файла в ответ
        $response->cookie('visited-our-site', true);

        // Возврат ответа
        return $response;
    }
}

глобальное промежуточное ПО применяется ко всем маршрутам, а маршрутное — только к некоторым.

// Привязка глобального промежуточного ПО
bootstrap/app.php file:
use App\Http\Middleware\EnsureTokenIsValid;
->withMiddleware(function (Middleware $middleware) {
     $middleware->append(BanDeleteMethod::class);
})

// Применение маршрутного промежуточного ПО в определениях маршрутов
Route::get('contacts', [ContactController::class, 'index'])->middleware('ban-delete');
// Уже действительно имеет смысл для нашего текущего примера...
Route::prefix('api')->middleware('ban-delete')->group(function () {
// Все маршруты, относящиеся к некоторому API
});

// Определение маршрутного промежуточного ПО, принимающего параметры
public function handle(Request $request, Closure $next, $role): Response
{
    if (auth()->check() && auth()->user()->hasRole($role)) {
        return $next($request);
    }
    return redirect('login');
}
Route::get('company', function () {
    return view('company.admin');
})->middleware('auth:owner');
можно добавить больше одного параметра в метод handle() и
передавать несколько параметров в определение маршрута, разделяя их запятыми:
Route::get('company', function () {
    return view('company.admin');
})->middleware('auth:owner,view');

// Ограничение частоты доступа к маршруту с помощью промежуточного ПО
Route::middleware(['auth:api', 'throttle:api'])->group(function () {
    Route::get('/profile', function () {
        //
    });
});

// Ограничение частоты по умолчанию
protected function boot(): void // App\Providers\AppServiceProvider
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });
}
















*/