<?php
/*

// Внедрение экземпляра кэша
Route::get('users', function (Illuminate\Contracts\Cache\Repository $cache) {
    return $cache->get('users');
});

// Использование глобальной функции cache()
// Извлечение данных из кэша
$users = cache('key', 'default value');
$users = cache()->get('key', 'default value');
// Сохранение данных в течение количества секунд, указанного в переменной $seconds
$users = cache(['key' => 'value'], $seconds);
$users = cache()->put('key', 'value', $seconds);

// Методы, доступные в экземплярах кэшей
cache()->get($key, $fallbackValue) и
cache()->pull($key, $fallbackValue)
    Метод get() извлекает значение любого указанного ключа.
    pull() действует аналогично, но удаляет значение из кэша после его извлечения.

cache()->put($key, $value, $secondsOrExpiration)
    cache()->put('key', 'value', now()->addDay());

cache()->add($key, $value)
    Метод add() аналогичен put(), но не позволяет задать уже существующее значение.
    Он также возвращает логическое значение, указывающее, было произведено добавление или нет:
    $someDate = now();
    cache()->add('someDate', $someDate); // вернет true
    $someOtherDate = now()->addHour();
    cache()->add('someDate', $someOtherDate); // вернет false

cache()->forever($key, $value)
    Метод forever() сохраняет в кэш значение указанного ключа.
    В отличие от put(), оно хранится бесконечно долго (пока не будет удалено с помощью forget()).

cache()->has($key)
    Метод has() возвращает логическое значение, указывающее, существует или нет значение с указанным ключом.

cache()->remember($key, $seconds, $closure) и
cache()->rememberForever($key, $closure)
    // Либо извлекает из кэша значение ключа "users", либо получает результат
    // метода User::all(), сохраняет его в кэше с ключом "users" и возвращает его
    $users = cache()->remember('users', 7200, function () {
        return User::all();
    });

cache()->increment($key, $amount) и
cache()->decrement($key, $amount)
    Методы increment() и decrement() позволяют увеличивать и уменьшать на единицу содержащиеся в кэше целочисленные значения.
    Если в кэше нет значения с указанным ключом, то оно считается равным 0.
    Кроме того, можно увеличивать и уменьшать значение на некоторое другое значение, передав величину приращения во втором параметре.

cache()->forget($key) и
cache()->flush()
    Метод forget() аналогичен forget() фасада Session: стирает значение указанного ключа.
    Метод flush() стирает все содержимое кэша.




*/