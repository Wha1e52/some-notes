<?php

/*



Post::all()->toArray(); // получить все записи
Post::all()->toJson(); // получить все записи в формате json
Post::first()->toArray(); // получить первую запись

Post::find(1, ['id', 'name']); // получить одну запись по id
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

*/