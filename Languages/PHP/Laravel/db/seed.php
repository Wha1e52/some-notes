<?php

/*

// Чтобы запустить заполнитель независимо
php artisan db:seed
php artisan db:seed VotesTableSeeder
Эта команда вызовет метод run() объекта DatabaseSeeder по умолчанию или класс заполнителя, если передать его имя.

// Чтобы запустить заполнитель вместе с миграцией, добавьте параметр --seed в любую команду применения миграции:
php artisan migrate --seed

// Создание заполнителя
php artisan make:seeder ContactsTableSeeder
добавим его в DatabaseSeeder
// database/seeds/DatabaseSeeder.php
...
public function run(): void
{
    $this->call(ContactsTableSeeder::class);
}

// Вставка записей базы данных в пользовательский заполнитель
class ContactsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contacts')->insert([
            'name' => 'Lupita Smith',
            'email' => 'lupita@gmail.com',
        ]);
    }
}

Теперь мы можем использовать статический метод factory() модели для создания экземпляра Contact в нашем заполнителе и в тестах:
// Создать одну запись
$contact = factory(Contact::class)->create();
// Создать множество записей
factory(Contact::class, 20)->create();



public function run(): void
    {
        $tags = Tag::factory(3)->create();

        Job::factory(20)->hasAttached($tags)->create();
        Job::factory(20)->hasAttached($tags)->create(new Sequence([
            'vip' => true
        ], [
            'vip' => false
            ]));
    }












*/