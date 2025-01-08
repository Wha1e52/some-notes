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


// компоновщики представлений
Sharing Data With All Views
add them to the App\Providers\AppServiceProvider class or generate a separate service provider to house them
public function boot(): void
{
    View::share('key', 'value');
}
либо через composer
можете передать массив имен представлений, чтобы привязать его к нескольким представлениям.
Можно также использовать звездочку в пути представления, например, partials.* или tasks.*:
Facades\View::composer('*', function (View $view) {
    $view->with('recentPosts', Post::recent());
});
Использование view()->share() делает переменную доступной для каждого представления во всем приложении, но это может быть излишним.
либо класс, создадим App\Http\ViewComposers\RecentPostsComposer
class RecentPostsComposer
{
    public function compose(View $view)
    {
        $view->with('recentPosts', Post::recent());
    }
}

public function boot()
{
    view()->composer('partials.sidebar', \App\Http\ViewComposers\RecentPostsComposer::class);
}


Подобно компоновщикам представлений, механизм внедрения сервисов в Blade позволяет сделать конкретные данные
или функциональные возможности доступными для каждого экземпляра представления без необходимости
каждый раз внедрять их через определение маршрута.
@inject('analytics', 'App\Services\Analytics')

Тестирование передачи определенного содержимого представлению
// EventsTest.php
public function test_list_page_shows_all_events()
{
    $event1 = Event::factory()->create();
    $event2 = Event::factory()->create();
    $response = $this->get('events');
    $response->assertViewHas('events', Event::all());
    $response->assertViewHasAll([
        'events' => Event::all(),
        'title' => 'Events Page',
    ]);
    $response->assertViewMissing('dogs');
}





*/