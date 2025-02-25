<?php

/*

// Создание фабрики моделей
php artisan make:factory ContactFactory

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->email,
        ];
    }
}

Теперь нужно использовать трейт (trait) Illuminate\Database\Eloquent\Factories\HasFactory в модели:
class Contact extends Model
{
    use HasFactory;
}
// если не следовать конвенции по именованию, то можно указать имя фабрики в методе newFactory
...
protected static function newFactory()
{
    return \Database\Factories\Base\ContactFactory::new();
}


// Создать одну запись
Contact::factory()->create();

// Создать несколько записей
Contact::factory(20)->create();


// создать запись с зависимостями(при создании записи зависимость будет создана автоматически)
class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->email,
            'user_id' => User::factory(),
        ];
    }
}

Применение recycle() для использования одного и того же экземпляра модели каждой фабрикой в цепочке
$user = User::factory()->create();
$trip = Trip::factory()
    ->recycle($user)
    ->create();

// Возврат «поддельных» файлов с помощью Faker
public function definition ()
{
    return [
        'picture' => $faker->file(
            base_path('tests/stubs/images'), // Исходный каталог
            storage_path('app'), // Целевой каталог
            false, // Возвращаем только имя файла, а не полный путь
        ),
        'name' => $faker->name,
    ];
}
*/