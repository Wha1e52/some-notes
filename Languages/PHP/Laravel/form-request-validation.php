<?php

/*

// команда для создания
php artisan make:request StorePostRequest


// необязательный. Если возвращает true, то пользователь авторизован для выполнения этого запроса,
а если false, обращение пользователя отклоняется
public function authorize(): bool
{
    $comment = Comment::find($this->route('comment'));

    return $comment && $this->user()->can('update', $comment);
}


// должен возвращать массив правил проверки для этого запроса
public function rules(): array
{
    return [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
    ];
}

public function messages(): array
{
    return [
        'title.required' => 'A title is required',
        'body.required' => 'A message is required',
    ];
}



// some controller
public function store(StorePostRequest $request): RedirectResponse
{
    // The incoming request is valid...

    // Retrieve the validated input data...
    $validated = $request->validated();

    // Retrieve a portion of the validated input data...
    $validated = $request->safe()->only(['name', 'email']);
    $validated = $request->safe()->except(['name', 'email']);

    // Store the blog post...

    return redirect('/posts');
}




class CreateCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $blogPostId = $this->route('blogPost');
        return auth()->check() && BlogPost::where('id', $blogPostId)
            ->where('user_id', auth()->id())->exists();
    }
    public function rules(): array
    {
        return [
            'body' => 'required|max:1000',
        ];
    }
}
------------------------------------------------------------------------------------------------------------------------

// some controller
request()->validate([
    'title' => ['required', 'max:255'],
    'body' => ['required'],
    'password' => ['confirmed'], // для confirmed в форме должно быть второе поле с 1name_confirmation для сравнения
])
в случае ошибки валидации происходит автоматически редирект на предыдущую страницу

в шаблоне
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
либо
@error('title')
    <div class="alert alert-danger">{{ $message }}</div> // $message маг.переменная доступная только внутри @error
@enderror

// Отсутствие переменной $errors
Маршруты, не входящие в группу промежуточного программного обеспечения web,
не будут иметь соответствующей сессии. Им будет недоступна переменная $errors.
------------------------------------------------------------------------------------------------------------------------

// app/Http/Controllers/RecipesController.php
class RecipesController extends Controller
{
    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:recipes|max:125',
            'body' => 'required'
    ]);
        // Рецепт действителен; продолжить, чтобы сохранить его
    }
}
Если данные допустимы, validate() завершается и мы можем передать их методу контроллера, чтобы сохранить или сделать что-то еще.
Но если данные недействительны, то генерируется исключение ValidationException.
В нем содержатся инструкции для маршрутизатора, как обрабатывать это исключение.
Если запрос отправлен из JavaScript (или если он запрашивает JSON в качестве ответа),
исключение создаст ответ JSON, содержащий описание ошибок.
В противном случае исключение вернет перенаправление на предыдущую страницу
вместе со всеми пользовательскими данными и сообщениями об ошибках.
Это прекрасно подходит для повторного заполнения недействительной формы и отображения некоторых ошибок.

синтаксис с вертикальной чертой: 'fieldname': 'rule|otherRule|anotherRule'.
Но вы также можете использовать синтаксис массивов: 'fieldname': ['rule', 'otherRule', 'anotherRule'].

// несколько наиболее распространенных правил и соответствующие функции.
Обязательные поля:
•required; required_if:anotherField,equalToThisValue;
•required_unless:anotherField,equalToThisValue.
Поле должно быть исключено из запроса:
•exclude_if:anotherField,equalToThisValue;
•exclude_unless:anotherField,equalToThisValue.
Поле должно содержать определенные типы символов: alpha; alpha_dash; alpha_num; numeric; integer.
Поле должно содержать определенные шаблоны: email; active_url; ip.
Даты: after:date; before:date (date может быть любой допустимой строкой, которую может обработать strtotime()).
Числа: between:min,max; min:num; max:num; size:num (size проверяет длину для строк, значение для целых чисел, count для массивов или размер в килобайтах для файлов).
Размеры изображения: dimensions:min_width=XXX. Может также использоваться вместе или комбинироваться с max_width, min_height, max_height, width, height и ratio.
Базы данных: exists:tableName; unique:tableName. Ожидается, что поиск будет производиться в том же столбце таблицы, что и имя поля. Можете также указать модель Eloquent вместо имени таблицы в правилах проверки базы данных

// Валидация вручную (а нахуя)
Route::post('recipes', function (Illuminate\Http\Request $request) {
    $validator = Validator::make($request->all(), [
        'title' => 'required|unique:recipes|max:125',
        'body' => 'required'
    ]);
    if ($validator->fails()) {
        return redirect('recipes/create')
                ->withErrors($validator)
                ->withInput();
    }
    // Рецепт действителен; продолжить, чтобы сохранить его
});

// Использование проверенных данных
Извлечение проверенных данных с помощью validated()
$validated = $request->validated();
$validated = $validator->validated();
Метод safe(), с другой стороны, возвращает объект, который дает вам доступ к методам all(), only() и except()
Получение проверенных данных с помощью функции safe()
$validated = $request->safe()->only(['name', 'email']);
$validated = $request->safe()->except(['password']);
$validated = $request->safe()->all();

// Объекты пользовательских правил
Если нужное правило валидации отсутствует в Laravel, можно создать свое.

php artisan make: rule RuleName,
а затем отредактируйте файл app/Rules/{RuleName}.php.

// Пример пользовательского правила
class AllowedEmailDomain implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(! in_array(Str::after($value, '@'), ['tighten.co'])){
            $fail('The :attribute field is not from an allowed email provider.');
        }
    }
}

$request->validate([
    'email' => new AllowedEmailDomain,
]);

// Отображение сообщений об ошибках валидации
Метод validate() для запросов (и метод withErrors() для перенаправлений, на которые он полагается)
отображает любые ошибки сессии. Они доступны в представлении, куда производится перенаправление, в переменной $errors.
Laravel гарантирует доступность переменной $errors в любом загружаемом представлении, даже если она пустая.
Поэтому не нужно проверять ее существование с помощью isset().



























*/