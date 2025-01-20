<?php

/*

Все действия, поддерживаемые генератором запросов фасада DB, доступны и при работе с объектами Eloquent.
$newestContacts = Contact::orderBy('created_at', 'desc')
    ->take(10)
    ->get();

$allContacts = Contact::all();
Post::all()->toArray(); // получить все записи в массиве
Post::all()->toJson(); // получить все записи в формате json
Post::first()->toArray(); // получить первую запись

Post::find(1); // получить одну запись по id
Post::findOrFail(1); // получить одну запись по id, если не нашли, то выкинуть 404
Post::where('id', '=', 1)
    ->first();

// агрегатные функции
Post::where('id', '>', 10)->count(); // кол-во записей
Post::max('id'); // максимальное значение
Post::min('id'); // минимальное значение
Post::avg('id'); // среднее значение
Post::sum('id'); // сумма значений


$post = new Post();
$post->isDraft = 1;
$post->title = 'Post name';
$post->save(); // вставить новую запись
либо
Post::create([
    'isDraft' => 1,
    'title' => 'Post name',
]);

// firstWhere() — сокращенный вариант комбинации методов where() и first()
// С помощью where() и first()
Contact::where('name', 'Wilbur Powery')->first();
// С помощью firstWhere()
Contact::firstWhere('name', 'Wilbur Powery');

// *?Использование get() вместо all()
Повсюду, где применяется all(), можно использовать get(). Contact::get() даст тот же ответ, что и Contact::all().
Однако, если вы решите изменить запрос, например добавив фильтр where(), то с методом all() не сможете это сделать, а с get() сможете.
Поэтому, несмотря на популярность all(), я бы рекомендовал использовать get() во всех случаях и позабыть про существование all().




























*/