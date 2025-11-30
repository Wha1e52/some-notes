<?php

// Constructor Property Promotion
class User { // название класса - Существительные
    public function __construct(public $name, public $email) {}
}

// equal to:
class User {
    public $name;
    public $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }
}

$obj = new User('John Doe', '2Kt6C@example.com');
echo $obj::class; // возвращает строку с именем класса объекта


/*
Разница между self::class и static::class заключается в том, как они определяют класс при наследовании.

| Свойство             | self::class                          | static::class                         |
|----------------------|--------------------------------------|---------------------------------------|
| Возвращает           | Имя класса, где написан метод.       | Имя класса, который вызывает метод.   |
|----------------------|--------------------------------------|---------------------------------------|
| Статичное/Динамичное | Статичное (на этапе компиляции).     | Динамичное (определяется на этапе выполнения)
|----------------------|--------------------------------------|---------------------------------------|
| Используется для     | Обращения к текущему классу.         | Поддержки наследования и полиморфизма.|

Когда использовать:
self::class:
    Когда вы точно знаете, что используете базовый класс, и наследование не должно влиять на результат.
    Для вызовов внутри строго определённого класса.

static::class:
    Когда вы хотите поддерживать полиморфизм и учитывать, какой класс вызвал метод.
    Для методов или свойств, которые должны "реагировать" на наследование.
*/
________________________________________________________________________________________________________________________

// названия методов давать так: скажи вслух что он должен делать ? берем глагол
________________________________________________________________________________________________________________________

// Интерфейсы

interface SomeInterface {
    public function someMethod($param1, $param2);
}

class SomeClass implements SomeInterface {
    public function someMethod($param1, $param2) {
        // ...
    }
}

class SomeClass2 implements SomeInterface {
    public function someMethod($param1, $param2) {
        // ...
    }
}

class MainClass {
    public function __construct(public SomeInterface $service) {}

    public function mainMethod(...) {
        // ...
        $this->service->someMethod($param1, $param2);
        // ...
    }
}

$mainClass = new MainClass(new SomeClass2());

________________________________________________________________________________________________________________________

// Абстрактные классы

abstract class AbstractPayment {
    public function process(float $amount): void {
        try {
            $this->logStart($amount);
            $this->pay($amount);
            $this->logSuccess();
        } catch (\Throwable $e) {
            $this->logFailure($e);
        }
    }

    abstract protected function pay(float $amount): void;

    protected function logStart(float $amount): void {
        Log::info("Starting payment of $amount");
    }

    protected function logSuccess(): void {
        Log::info("Payment successful");
    }

    protected function logFailure(\Throwable $e): void {
        Log::error("Payment failed: " . $e->getMessage());
    }
}

class StripePayment extends AbstractPayment {
    protected function pay(float $amount): void {
        // Stripe API logic
    }
}

________________________________________________________________________________________________________________________










