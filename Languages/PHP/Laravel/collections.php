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











*/