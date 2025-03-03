<?php

/*

команда для создания контроллера
php artisan make:controller SomeController

команда для создания контроллера ресурса
php artisan make:controller SomeController --resource

команда для создания контроллера для апи(обычный контроллер ресурсов, за исключением создания и редактирования)
php artisan make:controller SomeController --api

Маршрутизатор Laravel в конечном итоге преобразует все возвращаемые маршруты в строку, но есть хитрый прием.
Если вернуть результат вызова Eloquent в контроллере, он будет автоматически преобразован в строку и,
следовательно, возвращен как JSON.
Возврат JSON из маршрутов напрямую
// routes/web.php
Route::get('api/contacts', function () {
    return Contact::all();
});
Route::get('api/contacts/{id}', function ($id) {
    return Contact::findOrFail($id);
});





class SomeController extends Controller
{
    public function show(): string
    {
        return 'some text';
    }
}



class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin-auth')
            ->only('editUsers');
        $this->middleware('team-member')
            ->except('editUsers');
    }
}

Используем функцию request() для представления HTTP-запроса и его метод only() для извлечения из
пользовательского ввода только полей заголовка title и описания description.
...
public function store() {
    Task::create(request()->only(['title', 'description']));
    return redirect('tasks');
}

Метод request()->only() принимает ассоциативный массив имен полей ввода и возвращает их содержимое:
request()->only(['title', 'description']);
// возвращает:
[
    'title' => 'Whatever title the user typed on the previous page',
    'description' => 'Whatever description the user typed on the previous page',
]

request()->all() // возвращает все данные ввода

Actions Handled by Resource Controllers
| Verb       | URI                  | Action   | Route Name       |
| ---------- | -------------------- | -------- | ---------------- |
| GET        | /photos              | index    | photos.index     |
| GET        | /photos/create       | create   | photos.create    |
| POST       | /photos              | store    | photos.store     |
| GET        | /photos/{photo}      | show     | photos.show      |
| GET        | /photos/{photo}/edit | edit     | photos.edit      |
| PUT/PATCH  | /photos/{photo}      | update   | photos.update    |
| DELETE     | /photos/{photo}      | destroy  | photos.destroy   |


создать контроллер, обслуживающий единственный маршрут
class SomeController extends Controller
{
    public function __invoke() {
    //
    }
}


class SomeController extends Controller
{
    public function store(Request $request): string
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:table_name',
            'description' => 'required',
            'category_id' => ['required', 'exists:table_name,column_name'],
        ])

        Post::create($validated);
        return 'success';
    }

    public function update(Request $request): string
    {
        $post = Post::findOrFail($request->id);
        $post->update($request->all());
        return 'success';
    }

    public function destroy(Request $request): string
    {
        Post::destroy($request->id);
    }
}

// ContactController
public function show($contactId)
{
    return view('contacts.show')
        ->with('contact', Contact::findOrFail($contactId));
}


//
class SomeController extends Controller
{
    public function store(Request $request): string
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
        ])

        $user = User::create($validated);
        Auth::login($user);
        return redirect('/');
    }
}

// SessionController
class SessionController extends Controller
{
    public function store(Request $request): string
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
           throw ValidationException::withMessages('email' => ['The provided credentials do not match.']);
        }

        request()->session()->regenerate();
        return redirect('/');
    }


    public function destroy(Request $request): string
    {
        Auth::logout();
        return redirect('/');
    }
}


*/