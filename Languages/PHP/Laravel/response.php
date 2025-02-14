<?php

/*

// Простейший HTTP-ответ
Route::get('route', function () {
    return new Illuminate\Http\Response('Hello!');
});
То же самое, но с использованием глобальной функции:
Route::get('route', function () {
    return response('Hello!');
});

// Простой HTTP-ответ с настроенным статусом и заголовками
Route::get('route', function () {
    return response('Error!', 400)
        ->header('X-Header-Name', 'header-value')
        ->cookie('cookie-name', 'cookie-value');
});

// Использование типа ответа view()
Route::get('/', function (XmlGetterService $xml) {
    $data = $xml->get();
    return response()
        ->view('xml-structure', $data)
        ->header('Content-Type', 'text/xml');
});

// Использование типа ответа download()
public function export()
{
    return response()
        ->download('file.csv', 'export.csv', ['header' => 'value']); // путь, как назвать файл, заголовки
}
public function otherExport()
{
    return response()->download('file.pdf');
}
public function export()
{
    return response()
        ->download('file.csv', 'export.csv')
        ->deleteFileAfterSend();
}

// Использование типа ответа file()
public function invoice($id)
{
    return response()->file("./invoices/{$id}.pdf", ['header' => 'value']);
}

// Использование типа ответа json()
public function contacts()
{
    return response()->json(Contact::all());
}
public function jsonpContacts(Request $request)
{
    return response()
        ->json(Contact::all())
        ->setCallback($request->input('callback'));
}
public function nonEloquentContacts()
{
    return response()->json(['Tom', 'Jerry']);
}

// Примеры использования глобальной вспомогательной функции redirect()
return redirect('account/payment');
return redirect()->to('account/payment');
return redirect()->route('account.payment');
return redirect()->action('AccountController@showPayment');
// Если производится перенаправление на внешний домен
return redirect()->away('https://tighten.co');
// Если требуется предоставить параметры для именованного маршрута или контроллера
return redirect()->route('contacts.edit', ['id' => 15]);
return redirect()->action('ContactsController@edit', ['id' => 15]);

// Перенаправление назад с вводом
public function store()
{
    // Если проверка дает отрицательный результат...
    return back()->withInput();
}

// Перенаправление с сохранением данных
Route::post('contacts', function () {
    // Сохранение контакта
    return redirect('dashboard')->with('message', 'Contact created!');
});
Route::get('dashboard', function () {
    // Получение сохраненных данных из сессии — обычно выполняется в шаблоне Blade
    echo session('message');
});

// Создание собственного макроса ответа
...
class AppServiceProvider
{
    public function boot()
    {
        Response::macro('myJson', function ($content) {
            return response(json_encode($content))
            ->withHeaders(['Content-Type' => 'application/json']);
        });
    }
}
После этого данный макрос можно использовать точно так же, как предопределенный макрос json():
return response()->myJson(['name' => 'Sangeetha']);


Если нужно настроить способ отправки ответов, а при этом вам не хватает возможностей макроса в плане объема/организации кода, или если надо, чтобы некоторые из ваших объектов можно было возвращать как «ответ» с их собственной логикой отображения, то можно использовать интерфейс Responsable.
// Создание простого объекта Responsable
...
use Illuminate\Contracts\Support\Responsable;
class MyJson implements Responsable
{
    public function __construct($content)
    {
        $this->content = $content;
    }
    public function toResponse()
    {
        return response(json_encode($this->content))
            ->withHeaders(['Content-Type' => 'application/json']);
    }
}
Затем этот объект можно использовать точно так же, как собственный макрос:
return new MyJson(['name' => 'Sangeetha']);

// Использование интерфейса Responsable для создания объекта представления
...
use Illuminate\Contracts\Support\Responsable;
class GroupDonationDashboard implements Responsable
{
    public function __construct($group)
    {
        $this->group = $group;
    }
    public function budgetThisYear()
    {
        // ...
    }
    public function giftsThisYear()
    {
        // ...
    }
    public function toResponse()
    {
        return view('groups.dashboard')
            ->with('annual_budget', $this->budgetThisYear())
            ->with('annual_gifts_received', $this->giftsThisYear());
    }
}
...
class GroupController
{
    public function index(Group $group)
    {
        return new GroupDonationsDashboard($group);
    }
}



*/