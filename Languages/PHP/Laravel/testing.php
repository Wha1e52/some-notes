<?php

/*
Если понадобится протестировать конкретные действия пользователя на странице и в ваших формах,
то подключите пакет тестирования Laravel Dusk.
------------------------------------------------------------------------------------------------------------------------
// команда для запуска тестов
php artisan test

// команда для генерации теста
php artisan make:test SubscriptionTest --unit
Если нужно, чтобы тест был сгенерирован в каталоге Unit, а не в Feature, добавьте в команду флаг --unit

// Именование тестов
По умолчанию система тестирования Laravel запускает любые файлы в каталоге tests,
имена которых заканчиваются словом Test
В тестах PHPUnit выполняются только методы, имена которых начинаются со слова test,
или методы с блоком документации @test.























------------------------------------------------------------------------------------------------------------------------
use RefreshDatabase; // Resetting the Database After Each Test (it will only execute the test within a database transaction.)

Написание простого теста маршрута POST
// tests/Feature/AssignmentTest.php
public function test_post_creates_new_assignment() {
    $this->post('/assignments', [
        'title' => 'My great assignment',
    ]);

    $this->assertDatabaseHas('assignments', [
        'title' => 'My great assignment',
    ]);
}

Написание простого теста маршрута GET
// AssignmentTest.php
public function test_list_page_shows_all_assignments() {
    $assignment = Assignment::create([
        'title' => 'My great assignment',
    ]);

    $this->get('/assignments')
        ->assertSee('My great assignment');
}

// Тестирование взаимодействия с базой данных с помощью простых тестов приложения
public function test_active_page_shows_active_and_not_inactive_contacts()
{
    $activeContact = Contact::factory()->create();
    $inactiveContact = Contact::factory()->inactive()->create();
    $this->get('active-contacts')
        ->assertSee($activeContact->name)
        ->assertDontSee($inactiveContact->name);
}

// Использование assertDatabaseHas() для проверки определенных записей в базе данных
public function test_contact_creation_works()
{
    $this->post('contacts', [
        'email' => 'jim@bo.com'
    ]);
    $this->assertDatabaseHas('contacts', [
        'email' => 'jim@bo.com'
    ]);
}

// Тестирование аксессоров, мутаторов и областей действия
public function test_full_name_accessor_works()
{
    $contact = Contact::factory()->make([
        'first_name' => 'Alphonse',
        'last_name' => 'Cumberbund'
    ]);
    $this->assertEquals('Alphonse Cumberbund', $contact->fullName);
}
public function test_vip_scope_filters_out_non_vips()
{
    $vip = Contact::factory()->vip()->create();
    $nonVip = Contact::factory()->create();
    $vips = Contact::vips()->get();
    $this->assertTrue($vips->contains('id', $vip->id));
    $this->assertFalse($vips->contains('id', $nonVip->id));
}


// Проверка появления ожидаемых ошибок в сессии
public function test_missing_email_field_errors()
{
    $this->post('person/create', ['name' => 'Japheth']);
    $this->assertSessionHasErrors(['email']);
}


// Проверка отклонения недопустимого ввода
public function test_input_missing_a_title_is_rejected()
{
    $response = $this->post('posts', ['body' => 'This is the body of my post']);
    $response->assertRedirect();
    $response->assertSessionHasErrors();
}

// Проверка благополучной обработки допустимого ввода
public function test_valid_input_should_create_a_post_in_the_database()
{
    $this->post('posts', ['title' => 'Post Title', 'body' => 'This is the body']);
    $this->assertDatabaseHas('posts', ['title' => 'Post Title']);
}

// Вызов команд Artisan из теста
public function test_empty_log_command_empties_logs_table()
{
    DB::table('logs')->insert(['message' => 'Did something']);
    $this->assertCount(1, DB::table('logs')->get());
    $this->artisan('logs:empty'); // То же, что и Artisan::call('logs:empty');
    $this->assertCount(0, DB::table('logs')->get());
}

// Проверка ввода и вывода команд Artisan
public function testItCreatesANewUser()
{
    $this->artisan('myapp:create-user')
        ->expectsQuestion("What's the name of the new user?", "Wilbur Powery")
        ->expectsQuestion("What's the email of the new user?", "wilbur@thisbook.co")
        ->expectsQuestion("What's the password of the new user?", "secret")
        ->expectsOutput("User Wilbur Powery created!");
    $this->assertDatabaseHas('users', [
        'email' => 'wilbur@thisbook.co'
    ]);
}

// Аутентификация пользователя в тестах приложения
public function test_it_creates_a_new_contact()
{
    $user = User::factory()->create();
    $this->be($user);
    $this->post('contacts', [
        'email' => 'my@email.com',
    ]);
    $this->assertDatabaseHas('contacts', [
        'email' => 'my@email.com',
        'user_id' => $user->id,
    ]);
}

public function test_it_creates_a_new_contact()
{
    $user = User::factory()->create();
    $this->actingAs($user)->post('contacts', [
        'email' => 'my@email.com',
    ]);
    $this->assertDatabaseHas('contacts', [
        'email' => 'my@email.com',
        'user_id' => $user->id,
    ]);
}

// Тестирование правил авторизации
public function test_non_admins_cant_create_users()
{
    $user = User::factory()->create([
        'admin' => false,
    ]);
    $this->be($user);
    $this->post('users', ['email' => 'my@email.com']);
    $this->assertDatabaseMissing('users', [
        'email' => 'my@email.com',
    ]);
}

// Тестирование правил авторизации путем проверки кода состояния
public function test_non_admins_cant_create_users()
{
    $user = User::factory()->create([
        'admin' => false,
    ]);
    $this->be($user);
    $response = $this->post('users', ['email' => 'my@email.com']);
    $response->assertStatus(403);
}

// Тестирование маршрутов аутентификации
public function test_users_can_register()
{
    $this->post('register', [
        'name' => 'Sal Leibowitz',
        'email' => 'sal@leibs.net',
        'password' => 'abcdefg123',
        'password_confirmation' => 'abcdefg123',
    ]);
    $this->assertDatabaseHas('users', [
        'name' => 'Sal Leibowitz',
        'email' => 'sal@leibs.net',
    ]);
}
public function test_users_can_log_in()
{
    $user = User::factory()->create([
        'password' => Hash::make('abcdefg123')
    ]);
    $this->post('login', [
        'email' => $user->email,
        'password' => 'abcdefg123',
    ]);
    $this->assertTrue(auth()->check());
    $this->assertTrue($user->is(auth()->user()));
}

Если при проверке приложения требуется отключить промежуточное ПО, импортируйте в этот тест трейт WithoutMiddleware.
Можно отключить промежуточное ПО для отдельного метода тестирования, используя метод $this->withoutMiddleware().

// Переопределение привязки в тестах
public function test_it_does_something()
{
    app()->bind(Interfaces\Logger, function () {
        return new DevNullLogger;
    });
    // Выполнение определенных действий
}

// Переопределение привязки для всех тестов
class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    public function setUp()
    {
        parent::setUp();
        app()->bind('whatever', 'whatever else');
    }
}
При использовании Mockery обычно создается имитация, шпион или заглушка класса,
затем этот объект привязывается к контейнеру вместо исходного класса.












*/