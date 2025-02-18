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

// Трейты тестирования
RefreshDatabase - выполняет однократный запуск миграций, запускает транзакцию перед каждым отдельным методом теста и откатывает ее после проверки
DatabaseMigrations - будет запускать весь набор миграций базы данных перед каждым тестом, выполняя команду php artisan migrate:fresh в методе setUp().
DatabaseTransactions - предполагает, что миграция базы данных уже была выполнена. Поэтому он просто запускает транзакцию базы данных перед каждым тестом и производит откат этой транзакции после выполнения теста.
WithoutMiddleware - отключает все промежуточное ПО при выполнении любого теста этого класса. Если нужно отключать промежуточное ПО только для одного метода, а не для всего класса, вызовите $this->withoutMiddleware() в его начале.

// Простой модульный тест
class GeometryTest extends TestCase
{
    public function test_it_calculates_area()
    {
        $square = new Square;
        $square->sideLength = 4;
        $calculator = new GeometryCalculator;
        $this->assertEquals(16, $calculator->area($square));
    }
}

// Более сложный модульный тест
class PopularityTest extends TestCase
{
    use RefreshDatabase;

    public function test_votes_matter_more_than_views()
    {
        $package1 = Package::make(['votes' => 1, 'views' => 0]);
        $package2 = Package::make(['votes' => 0, 'views' => 1]);
        $this->assertTrue($package1->popularity > $package2->popularity);
    }
}

// Тестирование простых страниц
$this->get($uri, $headers = []);
$this->post($uri, $data = [], $headers = []);
$this->put($uri, $data = [], $headers = []);
$this->patch($uri, $data = [], $headers = []);
$this->delete($uri, $data = [], $headers = []);
$this->option($uri, $data = [], $headers = []).

// Простейший пример тестирования с использованием метода post()
public function test_it_stores_new_packages()
{
    $response = $this->post(route('packages.store'), [
        'name' => 'The greatest package',
    ]);
    $response->assertOk();
}

// Тестирование API на базе JSON
$this->getJson($uri, $headers = []);
$this->postJson($uri, $data = [], $headers = []);
$this->putJson($uri, $data = [], $headers = []);
$this->patchJson($uri, $data = [], $headers = []);
$this->deleteJson($uri, $data = [], $headers = []);
$this->optionJson($uri, $data = [], $headers = []).

// Простейший пример тестирования с использованием метода postJSON()
public function test_the_api_route_stores_new_packages()
{
    $response = $this->postJSON(route('api.packages.store'), [
        'name' => 'The greatest package',
    ], ['X-API-Version' => '17']);
    $response->assertOk();
}

// Утверждения в отношении объекта $response
// $response->assertOk()
Проверяет утверждение, что код состояния ответа — 200
$response = $this->get('terms');
$response->assertOk();

// $response->assertSuccessful()
проверяет, принадлежит ли код состояния ответа группе кодов 200
$response = $this->post('articles', [
    'title' => 'Testing Laravel',
    'body' => 'My article about testing Laravel',
]);
$response->assertSuccessful();

// $response->assertUnauthorized()
Проверяет утверждение, что код состояния ответа — 401
$response = $this->patch('settings', ['password' => 'abc']);
$response->assertUnauthorized();

// $response->assertForbidden()
Проверяет утверждение, что код состояния ответа — 403
$response = $this->actingAs($normalUser)->get('admin');
$response->assertForbidden();

// $response->assertNotFound()
Проверяет утверждение, что код состояния ответа — 404
$response = $this->get('posts/first-post');
$response->assertNotFound();

// $response->assertStatus($status)
Проверяет утверждение, что код состояния ответа такой же, как указанный код состояния $status
$response = $this->get('admin');
$response->assertStatus(401); // Не авторизован

// $response->assertSee($text) и $response->assertDontSee($text)
Проверяет утверждение, что ответ содержит/не содержит указанный текст $text
$package = factory(Package::class)->create();
$response = $this->get(route('packages.index'));
$response->assertSee($package->name);

// $response->assertJson(array $json)
Проверяет утверждение, что переданный массив представлен (в формате JSON) в возвращаемом JSON-сообщении
$this->postJson(route('packages.store'), ['name' => 'GreatPackage2000']);
$response = $this->getJson(route('packages.index'));
$response->assertJson(['name' => 'GreatPackage2000']);

// $response->assertViewHas($key, $value = null)
Проверяет утверждение, что представление посещенной страницы содержит фрагмент данных, доступный по ключу $key.
Опционально проверяет, что значение этой переменной равняется значению $value
$package = factory(Package::class)->create();
$response = $this->get(route('packages.show'));
$response->assertViewHas('name', $package->name);

// $response->assertSessionHas($key, $value = null)
Проверяет утверждение о том, что сессия содержит фрагмент данных с ключом $key.
Опционально проверяет, что значение этой переменной равняется значению $value:
$response = $this->get('beta/enable');
$response->assertSessionHas('beta-enabled', true);

// $response->assertSessionHasInput($key, $value = null)
Проверяет утверждение о том, что заданные ключ $key и значение $value присутствуют в массиве входных данных сессии.
С помощью этого метода можно проверить, возвращаются ли правильные старые значения с сообщением об ошибке валидации:
$response = $this->post('users', ['name' => 'Abdullah']);
// Предполагая, что ошибка произошла и мы проверяем присутствие введенного имени;
$response->assertSessionHasInput('name', 'Abdullah');

// $response->assertSessionHasErrors()
Без параметров проверяет утверждение, что в специальном контейнере сессии errors фреймворка Laravel определена хотя бы одна ошибка.
В первом параметре можно передать массив пар «ключ/значение», описывающих определяемые ошибки, а во втором — строку, используемую для представления сообщений об ошибке, как показано ниже:
// Предполагается, что маршрут "/form" требует, чтобы было заполнено поле для адреса электронной почты; мы отправляем ему пустую форму, чтобы вызвать ошибку
$response = $this->post('form', []);
$response->assertSessionHasErrors();
$response->assertSessionHasErrors([
    'email' => 'The email field is required.',
]);
$response->assertSessionHasErrors(
    ['email' => '<p>The email field is required.</p>'],
    '<p>:message</p>'
);

// $response->assertCookie($name, $value = null)
Проверяет утверждение, что ответ содержит cookie-файл с именем $name.
Опционально проверяет, что этот файл содержит значение $value:
$response = $this->post('settings', ['dismiss-warning']);
$response->assertCookie('warning-dismiss', true);

// $response->assertCookieExpired($name)
Проверяет утверждение, что ответ содержит cookie-файл с именем $name и его срок действия истек:
$response->assertCookieExpired('warning-dismiss');

// $response->assertCookieNotExpired($name)
Проверяет утверждение, что ответ содержит cookie-файл с именем $name и его срок действия не истек:
$response->assertCookieNotExpired('warning-dismiss');

// $response->assertRedirect($uri)
Проверяет утверждение о том, что запрошенный маршрут возвращает перенаправление на указанный URI-адрес:
$response = $this->post(route('packages.store'), [
    'email' => 'invalid'
]);
$response->assertRedirect(route('packages.create'));
Полный список вы можете найти в документации

// Простейшая аутентификация при тестировании
public function test_guests_cant_view_dashboard()
{
    $user = User::factory()->guest()->create();
    $response = $this->actingAs($user)->get('dashboard');
    $response->assertStatus(401); // Не авторизован
}
public function test_members_can_view_dashboard()
{
    $user = User::factory()->member()->create();
    $response = $this->actingAs($user)->get('dashboard');
    $response->assertOk();
}
public function test_members_and_guests_cant_view_statistics()
{
    $guest = User::factory()->guest()->create();
    $response = $this->actingAs($guest)->get('statistics');
    $response->assertStatus(401); // Не авторизован
    $member = User::factory()->member()->create();
    $response = $this->actingAs($member)->get('statistics');
    $response->assertStatus(401); // Не авторизован
}
public function test_admins_can_view_statistics()
{
    $user = User::factory()->admin()->create();
    $response = $this->actingAs($user)->get('statistics');
    $response->assertOk();
}



Если нужно задавать для своих запросов переменные сессии, можно включить в цепочку вызовов метод withSession():
$response = $this->withSession([
    'alert-dismissed' => true,
])->get('dashboard');
Для определения заголовков запросов в текучем стиле включите в цепочку вызовов метод withHeaders():
$response = $this->withHeaders([
    'X-THE-ANSWER' => '42',
])->get('the-restaurant-at-the-end-of-the-universe');


// Временное отключение обработки исключений в одном тесте
// tests/Feature/ExceptionsTest.php
public function test_exception_in_route()
{
    // Здесь выдается ошибка
    $this->withoutExceptionHandling();
    $this->get('/has-exceptions');
    $this->assertTrue(true);
}
А если по какой-либо причине нужно снова включить обработчик исключений
(например, вы отключили его в методе setUp() и надо вновь его включить только для одного теста),
то поможет вызов $this->withExceptionHandling().

// Отладка ответов
$response = $this->get('/');
$response->dumpHeaders();
$response->dump();
$response->dd();
$response->dumpSession();
$response->dumpSession(['message']);

// Проверка утверждений в отношении базы данных
$this->assertDatabaseHas() и $this->assertDatabaseMissing(),
а также $this->assertDeleted() и $this>assertSoftDeleted().
Все эти утверждения принимают в первом параметре имя таблицы,
во втором — искомые данные и в третьем необязательном параметре — соединение с конкретной базой данных

// Примеры тестов базы данных
public function test_create_package_page_stores_package()
{
    $this->post(route('packages.store'), [
        'name' => 'Package-a-tron',
    ]);
    $this->assertDatabaseHas('packages', ['name' => 'Package-a-tron']);
}

// Проверка утверждения о существовании модели
public function test_undeletable_packages_cant_be_deleted()
{
    // Создать неудаляемую модель
    $package = Package::factory()->create([
        'name' => 'Package-a-tron',
        'is_deletable' => false,
    ]);
    $this->post(route('packages.delete', $package));
    // Проверить наличие модели и была ли выполнена операция мягкого удаления
    $this->assertModelExists($package);
    $this->assertNotSoftDeleted($package);
    $package->update(['is_deletable' => true]);
    $this->post(route('packages.delete', $package));
    // Проверить отсутствие модели и была ли выполнена операция мягкого удаления
    $this->assertModelMissing($package);
    $this->assertSoftDeleted($package);
}

// Заполнение начальными данными в тестах
$this->seed(); // Заполнение всех данных
$this->seed(UserSeeder::class); // Заполнение пользователей

// Подавление событий без добавления утверждений
public function test_controller_does_some_thing()
{
    Event::fake();
    // Вызываем контроллер и проверяем нужные вам элементы его поведения, не беспокоясь об отправке им данных в Slack
}

// Проверка утверждений в отношении событий
public function test_signing_up_users_notifies_slack()
{
    Event::fake();
    // Выполняем регистрацию пользователя
    Event::assertDispatched(UserJoined::class, function ($event) use ($user) {
        return $event->user->id === $user->id;
    });
    // Или выполняем регистрацию нескольких пользователей и убеждаемся в том, что это событие было отправлено дважды
    Event::assertDispatched(UserJoined::class, 2);
    // Или выполняем регистрацию с неудачной валидацией и убеждаемся в том, что это событие не было отправлено
    Event::assertNotDispatched(UserJoined::class);
}

// Подделка заданий, не помещенных и помещенных в очередь
public function test_popularity_is_calculated()
{
    Bus::fake();
    // Синхронизируем данные пакета...
    // Убеждаемся в том, что задание было распределено
    Bus::assertDispatched(
        CalculatePopularity::class,
        function ($job) use ($package) {
            return $job->package->id === $package->id;
        }
    );
    // Убеждаемся в том, что задание не было распределено
    Bus::assertNotDispatched(DestroyPopularityMaybe::class);
}
public function test_popularity_calculation_is_queued()
{
    Queue::fake();
    // Синхронизируем данные пакета...
    // Убеждаемся в том, что задание было помещено в очередь
    Queue::assertPushed(
        CalculatePopularity::class,
        function ($job) use ($package) {
            return $job->package->id === $package->id;
        }
    );
    // Убеждаемся в том, что задание было помещено в очередь "popularity"
    Queue::assertPushedOn('popularity', CalculatePopularity::class);
    // Убеждаемся в том, что задание было помещено в очередь дважды
    Queue::assertPushed(CalculatePopularity::class, 2);
    // Убеждаемся в том, что задание не было помещено в очередь
    Queue::assertNotPushed(DestroyPopularityMaybe::class);
}

// Проверка утверждений в отношении электронной почты
public function test_package_authors_receive_launch_emails()
{
    Mail::fake();
    // Сначала делаем пакет публичным...
    // Убеждаемся, что сообщение было отправлено
    // на указанный адрес электронной почты
    Mail::assertSent(PackageLaunched::class, function ($mail) use ($package) {
        return $mail->package->id === $package->id;
    });
    // Убеждаемся, что сообщение было отправлено
    // на указанные адреса электронной почты
    Mail::assertSent(PackageLaunched::class, function ($mail) use ($package) {
        return $mail->hasTo($package->author->email) &&
            $mail->hasCc($package->collaborators) &&
            $mail->hasBcc('admin@novapackages.com');
    });
    // Или запускаем два пакета...
    // Убеждаемся в том, что сообщение было отправлено дважды
    Mail::assertSent(PackageLaunched::class, 2);
    // Убеждаемся в том, что сообщение не было отправлено
    Mail::assertNotSent(PackageLaunchFailed::class);
}

// Подделка фасада Notification
public function test_users_are_notified_of_new_package_ratings()
{
    Notification::fake();
    // Производим оценку пакета...
    // Убеждаемся в том, что автор был уведомлен
    Notification::assertSentTo(
        $package->author,
        PackageRatingReceived::class,
        function ($notification, $channels) use ($package) {
            return $notification->package->id === $package->id;
        }
    );
    // Убеждаемся в том, что уведомление было отправлено
    // указанным пользователям
    Notification::assertSentTo(
        [$package->collaborators], PackageRatingReceived::class
    );
    // Или производим повторную оценку пакета...
    // Убеждаемся в том, что уведомление не было отправлено
    Notification::assertNotSentTo(
        [$package->author], PackageRatingReceived::class
    );
}

// Тестирование каналов уведомлений
public function test_users_are_notified_by_their_preferred_channel()
{
    Notification::fake();
    $user = User::factory()->create(['slack_preferred' => true]);
    // Производим оценку пакета...
    // Убеждаемся в том, что автор был уведомлен через Slack
    Notification::assertSentTo(
        $user,
        PackageRatingReceived::class,
        function ($notification, $channels) use ($package) {
            return $notification->package->id === $package->id
                && in_array('slack', $channels);
        }
    );
}

// Тестирование хранилища и выгрузки файлов на сервер с подделкой хранилища
public function test_package_screenshot_upload()
{
    Storage::fake('screenshots');
    // Загружаем на сервер поддельное изображение
    $response = $this->postJson('screenshots', [
        'screenshot' => UploadedFile::fake()->image('screenshot.jpg'),
    ]);
    // Убеждаемся в том, что файл был сохранен
    Storage::disk('screenshots')->assertExists('screenshot.jpg');
    // Или убеждаемся в том, что файл не существует
    Storage::disk('screenshots')->assertMissing('missing.jpg');
}

// Изменение времени в тесте
public function test_posts_are_no_longer_editable_after_thirty_minutes()
{
    $post = Post::create();
    $this->assertTrue($post->isEditable());
    $this->travel(30)->seconds();
    $this->assertTrue($post->isEditable());
    $this->travelTo($post->created_at->copy()->addMinutes(31));
    $this->assertFalse($post->isEditable());
}

// Изменение времени внутри теста с помощью замыканий
public function test_posts_are_no_longer_editable_after_thirty_minutes()
{
    $post = Post::create();
    $this->assertTrue($post->isEditable());
    $this->travel(30)->seconds(function () {
        $this->assertTrue($post->isEditable());
    });
    $this->travelTo($post->created_at->copy()->addMinutes(31), function () {
    $this->assertFalse($post->isEditable());
    });
}

// Использование Mockery в Laravel
// app/SlackClient.php
class SlackClient
{
    // ...
    public function send($message, $channel)
    {
        // Отправляет реальное сообщение в Slack
    }
}
// app/Notifier.php
class Notifier
{
    private $slack;
    public function __construct(SlackClient $slack)
    {
        $this->slack = $slack;
    }
    public function notifyAdmins($message)
    {
        $this->slack->send($message, 'admins');
    }
}
// tests/Unit/NotifierTest.php
public function test_notifier_notifies_admins()
{
    $slackMock = Mockery::mock(SlackClient::class)->shouldIgnoreMissing(); // Независимо от того, что будет вызывать объект Notifier в объекте $slackMock, последний будет просто принимать эти вызовы и возвращать значение null.
    $notifier = new Notifier($slackMock);
    $notifier->notifyAdmins('Test message');
}

// Использование метода shouldReceive() в имитации Mockery
public function test_notifier_notifies_admins()
{
    $slackMock = Mockery::mock(SlackClient::class);
    $slackMock->shouldReceive('send')->once(); // убедиться в том, что метод send() объекта $slackMock будет вызван только один раз

    $notifier = new Notifier($slackMock);
    $notifier->notifyAdmins('Test message');
}
Мы также могли бы написать здесь что-то вроде shouldReceive('send')->times(3) или shouldReceive('send')->never().
С помощью метода with() можно указать, какой параметр должен передаваться вместе с вызовом метода send(),
а с помощью andReturn() можно определить возвращаемое значение:
$slackMock->shouldReceive('send')->with('Hello, world!')->andReturn(true);

// Привязка экземпляра Mockery к контейнеру
public function test_notifier_notifies_admins()
{
    $slackMock = Mockery::mock(SlackClient::class);
    $slackMock->shouldReceive('send')->once();

    app()->instance(SlackClient::class, $slackMock);

    $notifier = app(Notifier::class);
    $notifier->notifyAdmins('Test message');
}

// Упрощенный способ привязки экземпляров Mockery к контейнеру
$this->mock(SlackClient::class, function ($mock) {
    $mock->shouldReceive('send')->once();
});

// Имитирование фасада
// PeopleController
public function index()
{
    return Cache::remember('people', function () {
        return Person::all();
    });
}
// PeopleTest
public function test_all_people_route_should_be_cached()
{
    $person = Person::factory()->create();
    Cache::shouldReceive('remember')
        ->once()
        ->andReturn(collect([$person]));
    $this->get('people')->assertJsonFragment(['name' => $person->name]);
}

// Фасады-шпионы
public function test_package_should_be_cached_after_visit()
{
    Cache::spy();
    $package = Package::factory()->create();
    $this->get(route('packages.show', [$package->id]));
    Cache::shouldHaveReceived('put')
        ->once()
        ->with('packages.' . $package->id, $package->toArray());
}

// Частичная имитация фасадов
// Полная имитация
CustomFacade::shouldReceive('someMethod')->once();
CustomFacade::someMethod();
CustomFacade::anotherMethod(); // Ошибка
// Частичная имитация
CustomFacade::partialMock()->shouldReceive('someMethod')->once();
CustomFacade::someMethod(); // Использование поддельного объекта
CustomFacade::anotherMethod(); // Вызов метода реального фасада
------------------------------------------------------------------------------------------------------------------------
// Простые тесты команд Artisan
public function test_promote_console_command_promotes_user()
{
    $user = User::factory()->create();
    $this->artisan('user:promote', ['userId' => $user->id]);
    $this->assertTrue($user->isPromoted());
}

// Проверка вручную утверждений в отношении кодов возврата команд Artisan
$code = $this->artisan('do:thing', ['--flagOfSomeSort' => true]);
$this->assertEquals(0, $code); // 0 означает "команда не возвращает ошибки"

// Простейшие тесты в отношении «ожиданий» команд Artisan
// routes/console.php
Artisan::command('make:post {--expanded}', function () {
    $title = $this->ask('What is the post title?');
    $this->comment('Creating at ' . str_slug($title) . '.md');
    $category = $this->choice('What category?', ['technology', 'construction'], 0);
    // Создание сообщения
    $this->comment('Post created');
});
// Файл теста
public function test_make_post_console_commands_performs_as_expected()
{
    $this->artisan('make:post', ['--expanded' => true])
        ->expectsQuestion('What is the post title?', 'My Best Post Now')
        ->expectsOutput('Creating at my-best-post-now.md')
        ->expectsQuestion('What category?', 'construction')
        ->expectsOutput('Post created')
        ->assertExitCode(0);
}
------------------------------------------------------------------------------------------------------------------------
// Параллельное тестирование
Чтобы ускорить работу набора тестов, их можно запускать параллельно.
Для этого нужно будет установить зависимость под названием paratest:
composer require brianium/paratest --dev

// Параллельное выполнение тестов
# Использовать столько процессов, сколько процессоров в вашей системе
php artisan test --parallel
# Указать желаемое число процессов
php artisan test --parallel --processes=3
------------------------------------------------------------------------------------------------------------------------
// Тестирование с использованием Dusk
Для тестирования в браузере приложений, не являющихся одностраничными, я рекомендую использовать Dusk

                  !!!!!!!!! Не используйте трейт RefreshDatabase совместно с Dusk !!!!!!!!!
Ни в коем случае не используйте совместно с Dusk трейт RefreshDatabase! Лучше DatabaseMigrations,
поскольку транзакции, используемые в RefreshDatabase, не сохраняются при переходе от одного запроса к другому.

Чтобы установить Dusk, выполните следующие две команды:
composer require --dev laravel/dusk
php artisan dusk:install

// команда для запуска тестов
php artisan dusk

// Чтобы сгенерировать новый тест Dusk, используйте команду следующего вида:
php artisan dusk:make RatingTest

// Простой тест Dusk
public function testBasicExample()
{
    $user = User::factory()->create();
    $this->browse(function ($browser) use ($user) {
        $browser->visit('login')
            ->type('email', $user->email)
            ->type('password', 'secret')
            ->press('Login')
            ->assertPathIs('/home');
    });
}

// Проверка с помощью Dusk нескольких браузеров
$this->browse(function ($first, $second) {
    $first->loginAs(User::find(1))
        ->visit('home')
        ->waitForText('Message');

    $second->loginAs(User::find(2))
        ->visit('home')
        ->waitForText('Message')
        ->type('message', 'Hey Taylor')
        ->press('Send');

    $first->waitForText('Hey Taylor')
        ->assertSee('Jeffrey Way');
});

// Выбор элементов с помощью Dusk
<-- Шаблон -->
<div class="search"><input><button id="search-button"></button></div>
<button dusk="expand-nav"></button>
// Тесты Dusk
// Вариант 1: синтаксис в стиле jQuery
$browser->click('.search button');
$browser->click('#search-button');
// Вариант 2, рекомендуемый: синтаксис вида dusk="нужный-селектор"
$browser->click('@expand-nav');







------------------------------------------------------------------------------------------------------------------------










































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