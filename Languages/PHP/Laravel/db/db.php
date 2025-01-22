<?php

/*
https://github.com/barryvdh/laravel-debugbar


use Illuminate\Support\Facades\DB;

// выборка, возвращает массив
DB::select('SELECT * FROM users WHERE id = ?', [1]); // позиционные параметры
DB::select('SELECT * FROM users WHERE id = :id', ['id' => 1]); // именованные параметры

// Простая инструкция (можно выполнить любой SQL-запрос к базе данных, используя фасад DB и метод statement())
DB::statement('drop table users');

// выборка, возвращает одно значение
DB::scalar('SELECT count(*) as cnt FROM users);

// вставка, возвращает bool
DB::insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', ['John Doe', '2Kt6C@example.com', 'secret']);

// обновление, возвращает кол-во затронутых записей
DB::update('UPDATE users SET name = ?, email = ? WHERE id = ?', ['John Doe', '2Kt6C@example.com', 1]);

// удаление, возвращает кол-во затронутых записей
DB::delete('DELETE FROM users WHERE id = ?', [1]);

// автоматическая транзакция
try {
    DB::transaction(function () {
        DB::insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', ['John Doe', '2Kt6C@example.com', 'secret']);
        DB::insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', ['John Doe2', '2Kt6C@example.com', 'secret']);
    })
} catch (\Exception $e) {
    echo $e->getMessage();
}

// ручная транзакция
try {
    DB::beginTransaction();
        DB::insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', ['John Doe', '2Kt6C@example.com', 'secret']);
        DB::insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', ['John Doe2', '2Kt6C@example.com', 'secret']);
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack(); // отмена транзакции
    echo $e->getMessage();
}

// Соединения и другие сложные вызовы
DB::table('users')
    ->join('contacts', function ($join) {
        $join->on('users.id', '=', 'contacts.user_id')
            ->where('contacts.type', 'donor');
    })
    ->get();
------------------------------------------------------------------------------------------------------------------------
// Query builder

DB::table('users')->get(); // выборка всех записей

DB::table('users')->get(['id', 'name']); // выборка всех записей с указанными колонками
или
$emails = DB::table('contacts')
    ->select('email', 'email2 as second_email')
    ->get();
или
$emails = DB::table('contacts')
    ->select('email')
    ->addSelect('email2 as second_email')
    ->get();

$lastNames = DB::table('contacts')->select('city')->distinct()->get(); // выборка уникальных значений

DB::table('users')->first(); // выборка первой записи
DB::table('users')->where('id', '=', 1)->first(); // выборка по условию

// выборка по условию через and
$newVips = DB::table('contacts')
    ->where('vip', true)
    ->where('created_at', '>', now()->subDay());
или
$newVips = DB::table('contacts')->where([
    ['vip', true],
    ['created_at', '>', now()->subDay()],
]);

// выборка по условию через or
DB::table('users')
    ->where('id', '>', 1)
    ->orWhere('id', '<', 10)
    ->get();

Чтобы создать более сложный оператор OR WHERE с несколькими условиями, передайте в orWhere() замыкание:
$contacts = DB::table('contacts')
    ->where('vip', true)
    ->orWhere(function ($query) {
        $query->where('created_at', '>', now()->subDay())
            ->where('trial', false);
    })
    ->get();

DB::table('users')
    ->whereRaw('(id beetween ? and ?) or (id between ? and ?)', [1, 10, 20, 30])
    ->get(); // выборка сырому условию
DB::table('users')->where('id', '=', 1)->value('name'); // выборка одного значения
DB::table('users')->where('id', '>', 1)->orderBy('name', 'desc')->get(); // выборка с сортировкой
DB::table('users')->where('id', '>', 1)->orderByDesc('name')->get(); // выборка с обратной сортировкой
DB::table('users')->whereIn('id', [1, 2, 3])->get(); // выборка по списку значений
DB::table('users')->where('name', 'like', 'John%')->get(); // like

// Группирует результаты по столбцу
$populousCities = DB::table('contacts')
    ->groupBy('city')
    ->havingRaw('count(contact_id) > 30')
    ->get();

// beetween (включая их)
$mediumDrinks = DB::table('drinks')
    ->whereBetween('size', [6, 12])
    ->get();

// whereNull(colName) и whereNotNull(colName)
Позволяют выбрать только строки, в которых столбец colName равен NULL или NOT NULL соответственно.

// Позволяет выбрать только те записи, для которых вложенный подзапрос возвращают хотя бы одну запись.
$commenters = DB::table('users')
    ->whereExists(function ($query) {
        $query->select('id')
            ->from('comments')
            ->whereRaw('comments.user_id = users.id');
    })
    ->get();

// возвращает строки 31-40
$page4 = DB::table('contacts')->skip(30)->take(10)->get();

DB::table('users')->find(1, ['id', 'name']); // выборка по id, массив колонок можно опустить
DB::table('users')->pluck('name'); // выборка всех значений колонки
DB::table('users')->pluck('name', 'id'); // выборка всех значений колонки, ключами будут значения 2й колонки
DB::table('users')->orderBy('name')->chunk(100, function (Collection $users) {
    foreach ($users as $user) {
        // обработка выборки
        return false; // отменить дальнейшую выборку
    }
}); // выборка с пагинацией

// агрегатные функции
DB::table('users')->count(); // кол-во записей
DB::table('users')->max('id'); // максимальное значение
DB::table('users')->min('id'); // минимальное значение
DB::table('users')->avg('id'); // среднее значение
DB::table('users')->sum('id'); // сумма значений

DB::table('users')
    ->join('posts', 'users.id', '=', 'posts.user_id')
    ->get(); // соединение таблиц

DB::table('users')
    ->insert([
        'name' => 'John Doe',
        'email' => '2Kt6C@example.com',
        'password' => 'secret'
    ]);
DB::table('users')
    ->insert([
        ['name' => 'John Doe', 'email' => '2Kt6C@example.com', 'password' => 'secret'],
        ['name' => 'John Doe2', 'email' => '2Kt6C@example.com', 'password' => 'secret'],
    ]);
DB::table('users')
    ->insertGetId([
        'name' => 'John Doe',
        'email' => '2Kt6C@example.com',
        'password' => 'secret'
    ]); // с возвращением id новой записи

DB::table('users')
    ->where('id', '=', 1)
    ->update([
        'name' => 'John Doe',
        'email' => '2Kt6C@example.com',
        'password' => 'secret'
    ]);

DB::table('users')->delete(2);
DB::table('users')
    ->where('id', '>', 3)
    ->delete();
DB::table('users')->truncate(); // удаление всех записей и сброс счетчика

Так можно запросить конкретное соединение:
$users = DB::connection('secondary')->select('select * from users');

// latest(colName) и oldest(colName)
Сортировать по переданному столбцу (или по столбцу created_at, если имя столбца не передано)
в порядке убывания (latest()) или возрастания (oldest()).

// inRandomOrder()
Сортирует результат случайным образом

// Если задан верный первый параметр, применяется модификация запроса, содержащаяся в замыкании.
$posts = DB::table('posts')
    ->when($ignoreDrafts, function ($query) {
        return $query->where('draft', false);
    })
    ->get();

// Завершающие/возвращающие методы
get() // Получает все результаты построенного запроса:
first() и firstOrFail() // Получает только первый результат — то же, что и get(), но с дополнительной инструкцией LIMIT 1
find(id) и findOrFail(id) // Действуют подобно first(), но принимают значение идентификатора
value() // Выбирает значение только из одного поля из первой записи. Действует подобно first()
count()
min() и max()
sum() и avg()
dd(), dump() // Выводят сам SQL-запрос со связанными параметрами. Метод dd() дополнительно завершает сценарий


// raw
$contacts = DB::table('contacts')
    ->select(DB::raw('*, (score * 100) AS integer_score'))
    ->get();

// Объединения
$first = DB::table('contacts')
    ->whereNull('first_name');
$contacts = DB::table('contacts')
    ->whereNull('last_name')
    ->union($first)
    ->get();

// быстро увеличивать/уменьшать значения столбцов, применяя методы increment() и decrement().
DB::table('contacts')->increment('tokens', 5);
DB::table('contacts')->decrement('tokens');

// Операции JSON
При наличии столбцов JSON можно обновлять или выбирать записи на основе аспектов структуры JSON,
используя стрелочный синтаксис для обхода дочерних элементов:
// Выбрать все записи, где свойство "isAdmin" столбца "options"
// JSON установлено в true
DB::table('users')->where('options->isAdmin', true)->get();
// Обновить все записи, устанавливая свойство "verified"
// столбца "options" JSON в true
DB::table('users')->update(['options->isVerified', true]);





















*/