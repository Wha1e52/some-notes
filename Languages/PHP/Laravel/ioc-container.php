<?php

/*

// Простой пример внедрения зависимостей
class UserMailer
{
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function welcome($user)
    {
        return $this->mailer->mail($user->email, 'Welcome!');
    }
}

// использовать глобальную вспомогательную функцию app() для создания экземпляра класса
app('FQCN')
$app->make('FQCN')
$app['FQCN']


// Простой пример привязки к контейнеру
В любом сервис-провайдере (например, в провайдере LoggerServiceProvider)
public function register()
{
    $this->app->bind(Logger::class, function ($app) {
        return new Logger('\log\path\here', 'error');
    });
}

// Использование переданного экземпляра $app в коде привязки к контейнеру
Обратите внимание, что данная привязка не несет никакой практической
пользы, поскольку все, что она делает, уже обеспечено автоматическим
внедрением в контейнер.
$this->app->bind(UserMailer::class, function ($app) {
    return new UserMailer(
        $app->make(Mailer::class),
        $app->make(Logger::class),
        $app->make(Slack::class)
    );
});

// Привязка singleton к контейнеру
public function register()
{
    $this->app->singleton(Logger::class, function () {
        return new Logger('\log\path\here', 'error');
    });
}

// Назначение псевдонимов для классов и строк
Когда запрашивается "Logger", выдается FirstLogger
$this->app->bind(Logger::class, FirstLogger::class);
Когда запрашивается "log", выдается FirstLogger
$this->app->bind('log', FirstLogger::class);
Когда запрашивается "log", выдается FirstLogger
$this->app->alias(FirstLogger::class, 'log');

// Указание интерфейса в подсказке типа и привязка к интерфейсу
...
use Interfaces\Mailer as MailerInterface;
class UserMailer
{
    protected $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
}
Сервис-провайдер
public function register()
{
    $this->app->bind(\Interfaces\Mailer::class, function () {
        return new MailgunMailer(...);
    });
}


// Контекстная привязка
В сервис-провайдере
public function register(): void
{
    $this->app->when(FileWrangler::class)
        ->needs(Interfaces\Logger::class)
        ->give(Loggers\Syslog::class);
    $this->app->when(Jobs\SendWelcomeEmail::class)
        ->needs(Interfaces\Logger::class)
        ->give(Loggers\PaperTrail::class);
}

// Внедрение зависимостей в контроллер
...
class MyController extends Controller
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function index()
    {
        // Выполнение некоторых действий
        $this->logger->error('Something happened');
    }
}

// Внедрение зависимостей в метод контроллера
...
class MyController extends Controller
{
    // Зависимости метода могут указываться перед или после параметров маршрута.
    public function show(Logger $logger, $id)
    {
        // Выполнение некоторых действий
        $logger->error('Something happened');
    }
}

// Вызов вручную метода класса с помощью метода call() контейнера
class Foo
{
    public function bar($parameter1) {}
}
app()->call('Foo@bar', ['parameter1' => 'value']); // Вызывает метод 'bar' класса 'Foo' с первым параметром 'value'

// Использование фасадов реального времени
namespace App;
class Charts
{
    public function burndown()
    {
        // ...
    }
}
<h2>Burndown Chart</h2>
{{ Facades\App\Charts::burndown() }}
Нестатический метод burndown() становится доступным в качестве статического метода в фасаде реального времени,
который создается путем добавления префикса Facades\ к полному имени класса.



























*/