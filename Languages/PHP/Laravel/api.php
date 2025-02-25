<?php
/*

// команда для создания контроллера ресурсов апи
php artisan make:controller Api\DogController --api

// Пример контроллера ресурсов API для объекта Dog
...
class DogController extends Controller
{
    public function index()
    {
        return Dog::all();
    }

    public function store(Request $request)
    {
        return Dog::create($request->only(['name', 'breed']));
    }

    public function show($id)
    {
        return Dog::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $dog = Dog::findOrFail($id);
        $dog->update($request->only(['name', 'breed']));
        return $dog;
    }

    public function destroy($id)
    {
        Dog::findOrFail($id)->delete();
    }
}

// Привязка маршрутов к контроллеру ресурсов
// routes/api.php
Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::apiResource('dogs', 'DogController');
});

// Добавление заголовка ответа в Laravel
Route::get('dogs', function () {
    return response(Dog::all())
        ->header('X-Greatness-Index', 12);
});

// Чтение заголовка запроса в Laravel
Route::get('dogs', function (Request $request) {
    var_dump($request->header('Accept'));
});

// Маршрут API с разбивкой на страницы
Route::get('dogs', function () {
    return Dog::paginate(20);
});
GET /dogs - Вернет результаты 1-20
GET /dogs?page=1 - Вернет результаты 1-20
GET /dogs?page=2 - Вернет результаты 21-40

// Использование метода paginate() в вызове генератора запросов
Route::get('dogs', function () {
    return DB::table('dogs')->paginate(20);
});

// Простейшая сортировка API
// Обрабатываем /dogs?sort=name
Route::get('dogs', function (Request $request) {
    // Получаем параметр сортировки (или откатываемся к значению по умолчанию "name")
    $sortColumn = $request->input('sort', 'name');
    return Dog::orderBy($sortColumn)->paginate(20);
});

// Сортировка API по одному столбцу, с контролем над направлением сортировки
// Обрабатываем /dogs?sort=name и /dogs?sort=-name
Route::get('dogs', function (Request $request) {
    // Получаем параметр сортировки (или откатываемся к значению по умолчанию "name")
    $sortColumn = $request->input('sort', 'name');
    // Устанавливаем направление сортировки в зависимости от наличия перед значением ключа знака -, используя функцию starts_with() фреймворка Laravel
    $sortDirection = starts_with($sortColumn, '-') ? 'desc' : 'asc';
    $sortColumn = ltrim($sortColumn, '-');
    return Dog::orderBy($sortColumn, $sortDirection)
        ->paginate(20);
});

// Сортировка в стиле, предписываемом спецификацией JSON API
// Обрабатываем ?sort=name,-weight
Route::get('dogs', function (Request $request) {
    // Получаем параметр запроса и преобразуем его в массив, разделенный запятыми
    $sorts = explode(',', $request->input('sort', ''));
    // Создаем запрос
    $query = Dog::query();
    // Поочередно добавляем элементы массива sorts
    foreach ($sorts as $sortColumn) {
        $sortDirection = starts_with($sortColumn, '-') ? 'desc' : 'asc';
        $sortColumn = ltrim($sortColumn, '-');
        $query->orderBy($sortColumn, $sortDirection);
    }
    // Возвращаем результаты
    return $query->paginate(20);
});

// Одиночный фильтр результатов API
// ?filter=breed:chihuahua
Route::get('dogs', function () {
    $query = Dog::query();
    $query->when(request()->filled('filter'), function ($query) {
        [$criteria, $value] = explode(':', request('filter'));
        return $query->where($criteria, $value);
    });
    return $query->paginate(20);
});

// Множественная фильтрация результатов API
// ?filter=breed:chihuahua,color:brown
Route::get('dogs', function (Request $request) {
    $query = Dog::query();
    $query->when(request()->filled('filter'), function ($query) {
        $filters = explode(',', request('filter'));
        foreach ($filters as $filter) {
            [$criteria, $value] = explode(':', $filter);
            $query->where($criteria, $value);
        }
        return $query;
    });
    return $query->paginate(20);
});
------------------------------------------------------------------------------------------------------------------------
// команда для создания ресурса
php artisan make:resource Dog

// Простой ресурс API для модели Dog
class Dog extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'breed' => $this->breed,
        ];
    }
}

// Использование простого ресурса Dog
use App\Dog;
use App\Http\Resources\Dog as DogResource;
Route::get('dogs/{dogId}', function ($dogId) {
    return new DogResource(Dog::find($dogId));
});

// Использование предлагаемого по умолчанию метода collection() ресурса API
use App\Dog;
use App\Http\Resources\Dog as DogResource;
Route::get('dogs', function () {
    return DogResource::collection(Dog::all());
});

// Команда для создания коллекции ресурсов API:
php artisan make:resource DogCollection

// Простая коллекция ресурсов API для модели Dog
class DogCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => route('dogs.index'),
            ],
        ];
    }
}

// Простой пример вложения отношений API
public function toArray(Request $request): array
{
    return [
        'name' => $this->name,
        'breed' => $this->breed,
        'friends' => DogResource::collection($this->friends),
    ];
}

// Условная загрузка отношений API
public function toArray(Request $request): array
{
    return [
        'name' => $this->name,
        'breed' => $this->breed,
        // Загружаем это отношение, только если оно уже было загружено
        'bones' => BoneResource::collection($this->whenLoaded('bones')),
        // Или загружаем это отношение, только если оно запрашивается в URL
        'bones' => $this->when(
            $request->get('include') == 'bones',
            BoneResource::collection($this->bones)
        ),
    ];
}

// Передача экземпляра разбивщика страниц в API коллекции ресурсов
Route::get('dogs', function () {
    return new DogCollection(Dog::paginate(20));
});

// Условное применение атрибутов
public function toArray(Request $request): array
{
    return [
        'name' => $this->name,
        'breed' => $this->breed,
        'rating' => $this->when(Auth::user()->canSeeRatings(), 12),
    ];
}
------------------------------------------------------------------------------------------------------------------------













*/