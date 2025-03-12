<?php
/*

Arr::first($array, $callback, $default = null)
Возвращает первое значение в массиве, удовлетворяющее условию, определенному в замыкании обратного вызова.
В необязательном третьем параметре можно передать значение по умолчанию. Вот пример:
$people = [
    [
        'email' => 'm@me.com',
        'name' => 'Malcolm Me'
    ],
    [
        'email' => 'j@jo.com',
        'name' => 'James Jo'
    ],
];
$value = Arr::first($people, function ($person, $key) {
    return $person['email'] == 'j@jo.com';
});

Arr::get($array, $key, $default = null)
Позволяет легко извлекать значения из массива, предоставляя два дополнительных преимущества:
не выдает сообщение об ошибке, когда запрашивается несуществующий ключ
(возвращая значение по умолчанию, переданное в третьем параметре), и
дает использовать точечную нотацию для обхода вложенных массивов. Например:
$array = ['owner' => ['address' => ['line1' => '123 Main St.']]];
$line1 = Arr::get($array, 'owner.address.line1', 'No address');
$line2 = Arr::get($array, 'owner.address.line2');

Arr::has($array, $keys)
Позволяет проверить наличие конкретного значения в массиве, используя точечную нотацию для обхода вложенных массивов.
Параметр $keys может быть как единичным элементом, так и массивом элементов,
тогда проверяется наличие в массиве каждого из этих элементов:
$array = ['owner' => ['address' => ['line1' => '123 Main St.']]];
if (Arr::has($array, 'owner.address.line2')) {
    // Выполнение определенных действий
}

Arr::hasAny($array, $keys)
Позволяет проверить наличие в массиве любого из указанных ключей с использованием точечной нотации
для обхода вложенных массивов. Параметр $keys может быть как единичным ключом, так и массивом ключей.
В последнем случае проверяется наличие в массиве каждого из них:
$array = ['owner' => ['address' => ['line1' => '123 Main St.']]];
if (Arr::hasAny($array, ['owner.address', 'default.address'])) {
    // Выполнение определенных действий
}

Arr::pluck($array, $value, $key = null)
Возвращает массив значений, соответствующих предоставленному ключу:
$array = [
    ['owner' => ['id' => 4, 'name' => 'Tricia']],
    ['owner' => ['id' => 7, 'name' => 'Kimberly']],
];
$array = Arr::pluck($array, 'owner.name');
// Возвращает ['Tricia', 'Kimberly'];
Если нужно, чтобы в возвращаемом массиве в качестве ключа использовалось другое значение исходного массива,
то передайте ссылку на него в третьем параметре, применяя точечную нотацию:
$array = Arr::pluck($array, 'owner.name', 'owner.id');
// Возвращает [4 => 'Tricia', 7 => 'Kimberly'];

Arr::join($array, $glue, $finalGlue='')
Объединяет элементы $array в строку, добавляя между ними $glue. Если указан параметр $finalGlue,
его значение будет добавлено перед последним элементом массива вместо $glue:
$array = ['Malcolm', 'James', 'Tricia', 'Kimberly'];
Arr::join($array, ', ');
// Malcolm, James, Tricia, Kimberly
Arr::join($array, ', ', ', and');
// Malcolm, James, Tricia, and Kimberly
------------------------------------------------------------------------------------------------------------------------
e($string)
Псевдоним для метода htmlentities().
Подготавливает строку (часто предоставленную пользователем) для безопасного вывода на HTML-странице. Например:
e('<script>do something nefarious</script>');
// Возвращает &lt;script&gt;do something nefarious&lt;/script&gt;

str($string)
Используется для приведения данных к строковому типу; является псевдонимом для Str::of($string):
str('http') === Str::of('http');
// true

Str::startsWith($haystack, $needle), Str::endsWith($haystack, $needle) и Str::contains($haystack, $needle, $ignoreCase)
Возвращают логическое значение, указывающее, начинается ли строка $haystack со строки $needle,
заканчивается ли она этой строкой и есть ли в ней вообще эта строка:
if (Str::startsWith($url, 'https')) {
// Выполнение некоторых действий
}
if (Str::endsWith($abstract, '...')) {
// Выполнение некоторых действий
}
if (Str::contains($description, '1337 h4x0r')) {
// Выполнение некоторых действий
}

Str::limit($value, $limit = 100, $end = '...')
Ограничивает длину строки указанным количеством символов. Если длина строки меньше указанного предела,
просто возвращает строку. Если же она превышает предел, обрезает строку до указанного количества символов,
добавляя в конце ... или строку, указанную в параметре $end. Например:
$abstract = Str::limit($loremIpsum, 30);
// Возвращает "Lorem ipsum dolor sit amet, co..."
$abstract = Str::limit($loremIpsum, 30, "&hellip;");
// Возвращает "Lorem ipsum dolor sit amet, co&hellip;"

Str::words($value, $words=100, $end='...')
Ограничивает длину строки указанным количеством слов. Если в строке меньше слов, то просто возвращает строку;
если больше, то обрезает строку до заданного количества, добавляя в конце ...
или строку, определенную в параметре $end. Например:
$abstract = Str::words($loremIpsum, 3);
// Вернет "Lorem ipsum dolor..."
$abstract = Str::words($loremIpsum, 5, " &hellip;");
// Вернет "Lorem ipsum dolor sit amet, &hellip;"

Str::before($subject, $search), Str::after($subject, $search), Str::beforeLast($subject, $search), Str::afterLast($subject, $search)
Возвращают сегменты строки до или после другой строки или последний экземпляр другой строки. Например:
Str::before('Nice to meet you!', 'meet you');
// Вернет "Nice to "
Str::after('Nice to meet you!', 'Nice');
// Вернет " to meet you!"
Str::beforeLast('App\Notifications\WelcomeNotification', '\\');
// Вернет "App\Notifications"
Str::afterLast('App\Notifications\WelcomeNotification', '\\');
// Вернет "WelcomeNotification"

Str::is($pattern, $value)
Возвращает логическое значение — признак соответствия строки заданному шаблону.
В качестве шаблона используется регулярное выражение, в котором символы звездочки обозначают любое количество произвольных символов:
Str::is('*.dev', 'myapp.dev'); // true
Str::is('*.dev', 'myapp.dev.co.uk'); // false
Str::is('*dev*', 'myapp.dev'); // true
Str::is('*myapp*', 'www.myapp.dev'); // true
Str::is('my*app', 'myfantasticapp'); // true
Str::is('my*app', 'myapp'); // true

Str::isUuid($value)
Определяет, является ли значение допустимым UUID:
Str::isUuid('33f6115c-1c98-49f3-9158-a4a4376dfbe1'); // Вернет true
Str::isUuid('laravel-up-and-running'); // Вернет false

Str::random($length = n)
Возвращает случайную последовательность из указанного числа буквенно-цифровых символов как верхнего, так и нижнего регистра:
$hash = str_random(64);
// Пример результата:
// J40uNWAvY60wE4BPEWxu7BZFQEmxEHmGiLmQncj0ThMGJK7O5Kfgptyb9ul wspmh

Str::slug($title, $separator = '-', $language = 'en')
Возвращает URL-совместимый слаг на основе строки — часто используется при создании сегмента URL-адреса для названия/заголовка:
Str::slug('How to Win Friends and Influence People');
// Возвращает 'how-to-win-friends-and-influence-people'

Str::plural($value, $count = n)
Преобразует строку в форму множественного числа. На данный момент поддерживает только английский язык:
Str::plural('book');
// Возвращает books
Str::plural('person');
// Возвращает people
Str::plural('person', 1);
// Возвращает person

__($key, $replace = [], $locale = null)
Осуществляет перевод предоставленной строки/ключа с использованием ваших файлов локализации:
echo __('Welcome to your dashboard');
echo __('messages.welcome');

Теперь у вас появилась возможность использовать методы Str, составляя из них цепочки вслед за методом Str::of. Взгляните:
return (string) Str::of(' Go to bed!! ')
    ->trim()
    ->replace('town', 'bed')
    ->slug(); // Вернет "go-to-bed"
------------------------------------------------------------------------------------------------------------------------
// Пути приложения

// Возвращает путь к каталогу app:
app_path(); // Возвращает /home/forge/myapp.com/app

// Возвращает путь к корневому каталогу вашего приложения:
base_path(); // Возвращает /home/forge/myapp.com

// Возвращает путь к файлам конфигурации вашего приложения:
config_path(); // Возвращает /home/forge/myapp.com/config

// Возвращает путь к файлам базы данных вашего приложения:
database_path(); // Возвращает /home/forge/myapp.com/database

// Возвращает путь к каталогу хранения storage вашего приложения:
storage_path(); // Возвращает /home/forge/myapp.com/storage

// Возвращает путь к каталогу lang в вашем приложении:
lang_path(); // Возвращает /home/forge/myapp.com/resources/lang
------------------------------------------------------------------------------------------------------------------------
// URL-адреса

// Возвращает корректный URL-адрес для предоставленной пары имен контроллера и метода
action($action, $parameters = [], $absolute = true)
    <a href="{{ action('PeopleController@index') }}">See all People</a>
    // Или с использованием нотации кортежей:
    <a href=
    "{{ action([App\Http\Controllers\PeopleController::class, 'index']) }}">
    See all People
    </a>
    // Возвращает <a href="http://myapp.com/people">See all People</a>

// Возвращает URL-адрес маршрута с указанным именем
route($name, $parameters = [], $absolute = true)
    // routes/web.php
    Route::get('people', [PersonController::class, 'index'])
        ->name('people.index');
    // Где-нибудь в представлении
    <a href="{{ route('people.index') }}">See all People</a>
    // Возвращает <a href="http://myapp.com/people">See all People</a>

// Преобразует любую предоставленную строку пути в полностью квалифицированный URL-адрес
(secure_url() делает то же самое, что и url(), но использует протокол HTTPS):
url($string) и secure_url($string)
    url('people/3'); // Возвращает http://myapp.com/people/3
    url()->current(); // Возвращает http://myapp.com/abc
    url()->full(); // Возвращает http://myapp.com/abc?order=reverse
    url()->previous(); // Возвращает http://myapp.com/login
------------------------------------------------------------------------------------------------------------------------
// Генерируют HTTP-исключения
    abort($code, $message, $headers),
    abort_unless($boolean, $code, $message, $headers)
    и abort_if($boolean, $code, $message, $headers)
    public function controllerMethod(Request $request)
    {
        abort(403, 'You shall not pass');
        abort_unless(request()->filled('magicToken'), 403);
        abort_if(request()->user()->isBanned, 403);
    }

// Возвращает экземпляр аутентификатора фреймворка Laravel
auth()
    $user = auth()->user();
    $userId = auth()->id();
    if (auth()->check()) {
        // Выполнение некоторых действий
    }

// Формирует ответ «перенаправления назад», отправляя пользователя в предыдущее место:
back()
    Route::get('post', function () {
        // ...
        if ($condition) {
            return back();
        }
    });

// Принимает массив и возвращает те же данные, преобразованные в коллекцию:
collect($array)
    $collection = collect(['Rachel', 'Hototo']);

// Возвращает значение элемента конфигурации, указанного с помощью точечной нотации:
config($key)
    $defaultDbConnection = config('database.default');

// Возвращают полный HTML-код скрытого поля ввода (csrf_field()) или только значение
соответствующего токена (csrf_token()) для добавления CSRF-проверки при отправке формы:
csrf_field() и csrf_token()
    <form>
        {{ csrf_field() }}
        </form>
        // или
        <form>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>

// Выполняет вывод, напоминающий вывод var_dump(), для всех указанных параметров,
а затем вызывает метод exit() для завершения работы приложения (используется для целей отладки):
dump($variable), dd($variable...)
    // ...
    dump($var1, $var2); // Проверим вывод
    // ...
    dd($var1, $var2, $state); // Почему это не работает???

// Возвращает значение переменной среды для указанного ключа:
Помните, что метод env() не следует использовать за пределами конфигурационных файлов.
env($key, $default = null)
    $key = env('API_KEY', '');

// Отправляет задание:
dispatch($job)
    dispatch(new EmailAdminAboutNewUser($user));

// Запускает событие:
event($event)
    event(new ContactAdded($contact));

// Возвращает старое значение (из формы, отправленной пользователем в прошлый раз) для указанного ключа формы, если он существует:
old($key = null, $default = null)
    <input name="name" value="{{ old('value', 'Your name here') }}"

// Возвращает ответ перенаправления на указанный путь:
При вызове без параметров генерирует экземпляр класса Illuminate\Routing\Redirector.
redirect($path)
    Route::get('post', function () {
        ...
        return redirect('home');
    });

// При вызове с параметрами возвращает предварительно собранный экземпляр класса Response.
При вызове без параметров возвращает экземпляр фабрики класса Response:
response($content, $status = 200, $headers)
    return response('OK', 200, ['X-Header-Greatness' => 'Super great']);
    return response()->json(['status' => 'success']);

// Вызывает замыкание (второй аргумент), передавая ему первый аргумент, и возвращает первый аргумент
(вместо значения, возвращаемого замыканием):
tap($value, $callback = null)
    return tap(Contact::first(), function ($contact) {
        $contact->name = 'Aheahe';
        $contact->save();
    });

// Возвращает экземпляр представления:
view($viewPath)
    Route::get('home', function () {
        return view('home'); // Возвращает /resources/views/home.blade.php
    });

// Возвращает экземпляр Faker:
fake()
    @for($i = 0; $i <= 4; $i++)
        <td>Purchased by {{ fake()->unique()->name() }}</td>
    @endfor









*/