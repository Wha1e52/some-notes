<?php

/*

команда для создания представления
php artisan make:view someView

Route::get('/', function () {
    return view('greeting', ['name' => 'James']);
});

use Illuminate\Support\Facades\View;
return View::make('greeting', ['name' => 'James']);

return view('greetings', ['name' => 'Victoria']);
либо
return view('greeting')
            ->with('name', 'Victoria')
            ->with('occupation', 'Astronaut');

Sharing Data With All Views
add them to the App\Providers\AppServiceProvider class or generate a separate service provider to house them
public function boot(): void
{
    View::share('key', 'value');
}
либо через composer
Facades\View::composer('*', function (View $view) {
    // ...
});




*/