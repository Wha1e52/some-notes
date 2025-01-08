<?php

/*
https://github.com/barryvdh/laravel-debugbar


use Illuminate\Support\Facades\DB;

// выборка, возвращает массив
DB::select('SELECT * FROM users WHERE id = ?', [1]); // позиционные параметры
DB::select('SELECT * FROM users WHERE id = :id', ['id' => 1]); // именованные параметры

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

// Query builder

DB::table('users')->get(); // выборка всех записей
DB::table('users')->get(['id', 'name']); // выборка всех записей с указанными колонками
DB::table('users')->first(); // выборка первой записи
DB::table('users')->where('id', '=', 1)->first(); // выборка по условию
DB::table('users')
    ->where('id', '>', 1)
    ->where('id', '<', 10)
    ->get(); // выборка по условию через and
DB::table('users')
    ->where('id', '>', 1)
    ->orWhere('id', '<', 10)
    ->get(); // выборка по условию через or
DB::table('users')
    ->whereRaw('(id beetween ? and ?) or (id between ? and ?)', [1, 10, 20, 30])
    ->get(); // выборка сырому условию
DB::table('users')->where('id', '=', 1)->value('name'); // выборка одного значения
DB::table('users')->where('id', '>', 1)->orderBy('name', 'desc')->get(); // выборка с сортировкой
DB::table('users')->where('id', '>', 1)->orderByDesc('name')->get(); // выборка с обратной сортировкой
DB::table('users')->whereIn('id', [1, 2, 3])->get(); // выборка по списку значений
DB::table('users')->where('name', 'like', 'John%')->get(); // like

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


*/