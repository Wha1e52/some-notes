<?php

/*

команда для создания контроллера
php artisan make:controller SomeController

команда для создания контроллера ресурса
php artisan make:controller SomeController --resource

команда для создания контроллера для апи(обычный контроллер ресурсов, за исключением создания и редактирования)
php artisan make:controller SomeController --api



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

        Post::create($request->all());
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




*/