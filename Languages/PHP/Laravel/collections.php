<?php

/*
https://laravel.com/docs/11.x/collections#available-methods

// создать коллекцию
$collection2 = collect([
    ['name' => 'John', 'age' => 30],
    ['name' => 'Jane', 'age' => 25],
    ['name' => 'Joe', 'age' => 20],
    ['name' => 'Jill', 'age' => 35],
]);

$collection->avg('age'); // среднее значение
$collection->chunk(2); // разбивает коллекцию на части
$collection->sum(age); // сумма значений

// отфильтровать четные числа
$collection = collect([1, 2, 3]);
$odds = $collection->reject(function ($item) {
    return $item % 2 === 0;
});

// перебрать коллекцию
$multiplied = $collection->map(function ($item) {
    return $item * 10;
});


$sum = $collection
    ->filter(function ($item) {
        return $item % 2 == 0;
    })->map(function ($item) {
        return $item * 10;
    })->sum();
------------------------------------------------------------------------------------------------------------------------
// Ленивые коллекции

Если вы используете метод cursor, то модели Eloquent будут возвращать экземпляр LazyCollection вместо экземпляра Collection.
При использовании ленивых коллекций ваше приложение будет загружать записи в память по одной:
$verifiedContacts = App\Contact::cursor()->filter(function ($contact) {
    return $contact->isVerified();
});
------------------------------------------------------------------------------------------------------------------------
Пользовательские классы Collection для моделей Eloquent

class OrderCollection extends Collection
{
    public function sumBillableAmount()
    {
        return $this->reduce(function ($carry, $order) {
            return $carry + ($order->billable ? $order->amount : 0);
        }, 0);
    }
}

class Order extends Model
{
    public function newCollection(array $models = [])
    {
        return new OrderCollection($models);
    }
}
Теперь любая возвращаемая коллекция Orders (например, из Order::all()) фактически будет экземпляром класса OrderCollection:
$orders = Order::all();
$billableAmount = $orders->sumBillableAmount();
------------------------------------------------------------------------------------------------------------------------
// Некоторые операции с коллекциями
// https://laravel.com/docs/12.x/collections#available-methods

all() и toArray()
    $users = User::all();
    $users->toArray();
    // Возвращает
    [
        ['id' => '1', 'name' => 'Agouhanna'],
        ...
    ]

    $users->all();
    // Возвращает
    [
        Объект Eloquent { id : 1, name: 'Agouhanna' },
        ...
    ]

filter() и reject()
    $users = collect([...]);
    $admins = $users->filter(function ($user) {
        return $user->isAdmin;
    });

    $paidUsers = $user->reject(function ($user) {
        return $user->isTrial;
    });

where()
для всего, что можно сделать с помощью метода where(),
подходит и метод filter(), это сокращенный псевдоним для распространенного сценария:
    $users = collect([...]);
    $admins = $users->where('role', 'admin');

whereNull(), whereNotNull()
    $users = collect([...]);
    $active = $users->whereNull('deleted_at');
    $deleted = $users->whereNotNull('deleted_at');

first() и last()
    $users = collect([...]);
    $owner = $users->first(function ($user) {
        return $user->isOwner;
    });
    $firstUser = $users->first();
    $lastUser = $users->last();

each()
    $users = collect([...]);
    $users->each(function ($user) {
        EmailUserAThing::dispatch($user);
    });

map()
    $users = collect([...]);
    $users = $users->map(function ($user) {
        return [
            'name' => $user['first'] . ' ' . $user['last'],
            'email' => $user['email'],
        ];
    });

reduce()
Чтобы получить из коллекции одно значение — результат некоторого подсчета или строку
    $users = collect([...]);
    $points = $users->reduce(function ($carry, $user) {
        return $carry + $user['points'];
    }, 0); // Начинаем с аккумулятора, равного 0

pluck()
Чтобы извлечь только значения заданного ключа, содержащиеся в каждом элементе коллекции
    $users = collect([...]);
    $emails = $users->pluck('email')->toArray();

chunk() и take()
Метод chunk() позволяет легко разбить коллекцию на группы заданного размера,
а метод take() извлекает заданное количество элементов
    $users = collect([...]);
    $rowsOfUsers = $users->chunk(3); // Разбивает на группы по три элемента
    $topThree = $users->take(3); // Извлекает первые три элемента

takeUntil(), takeWhile()
    $items = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $subset = $items->takeUntil(function ($item) {
        return $item >= 5;
    })->toArray(); // [1, 2, 3, 4]

    $subset = $items->takeWhile(function ($item) {
        return $item < 4;
    })->toArray(); // [1, 2, 3]

groupBy()
    $users = collect([...]);
    $usersByRole = $users->groupBy('role');
        // Возвращает:
        [
            'member' => [...],
            'admin' => [...],
        ]

    $heroes = collect([...]);
    $heroesByAbilityType = $heroes->groupBy(function ($hero) {
        if ($hero->canFly() && $hero->isInvulnerable()) {
            return 'Kryptonian';
        }

        if ($hero->bitByARadioactiveSpider()) {
            return 'Spidermanesque';
        }

        if ($hero->color === 'green' && $hero->likesSmashing()) {
            return 'Hulk-like';
        }

        return 'Generic';
    });

reverse() и shuffle()
    $numbers = collect([1, 2, 3]);
    $numbers->reverse()->toArray(); // [3, 2, 1]
    $numbers->shuffle()->toArray(); // [2, 3, 1]

skip()
    $numbers = collect([1, 2, 3, 4, 5]);
    $numbers->skip(3)->values(); // [4, 5]

skipUntil()
// Пропускает элементы в начале коллекции, пока обратный вызов не вернет true
    $numbers = collect([1, 2, 3, 4, 5]);
    $numbers->skipUntil(function ($item) {
        return $item > 3;
    })->values(); // [4, 5]

    $numbers->skipUntil(3)->values();  // [3, 4, 5]

skipWhile()
// Пропускает элементы, пока обратный вызов возвращает true
    $numbers = collect([1, 2, 3, 4, 5]);
    $numbers->skipWhile(function ($item) {
        return $item <= 3;
    })->toArray(); // [4, 5]

sort(), sortBy() и sortByDesc()
    $sortedNumbers = collect([1, 7, 6])->sort()->toArray(); // [1, 6, 7]
    $users = collect([...]);

    // Сортировка массива пользователей по свойству 'email'
    $users->sort('email');

    // Сортировка массива пользователей по свойству 'email'
    $users->sortBy(function ($user, $key) {
        return $user['email'];
    });

countBy()
    $collection = collect([10, 10, 20, 20, 20, 30]);
    $collection->countBy()->all(); // [10 => 2, 20 => 3, 30 => 1]

    $collection = collect(['laravel.com', 'tighten.co']);
    $collection->countBy(function ($address) {
        return Str::after($address, '.');
    })->all();  // all: ["com" => 1, "co" => 1]

count(), isEmpty() и isNotEmpty()
    $numbers = collect([1, 2, 3]);
    $numbers->count(); // 3
    $numbers->isEmpty(); // false
    $numbers->isNotEmpty() // true

avg() и sum()
    collect([1, 2, 3])->sum(); // 6
    collect([1, 2, 3])->avg(); // 2

    $users = collect([...]);
    $sumPoints = $users->sum('points');
    $avgPoints = $users->avg('points');

join()
Можно также передать необязательный параметр с разделителем,
который должен вставляться перед последним элементом в объединенной строке
    $collection = collect(['a', 'b', 'c', 'd', 'e']);
    $collection->join(', ', ', and '); // 'a, b, c, d, and e'

*/