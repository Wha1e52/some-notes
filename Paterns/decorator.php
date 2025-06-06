<?php

// Позволяет добавлять поведение объекту на лету, не изменяя его класс.


// 1. Интерфейс компонента
interface Coffee {
    public function cost(): int;
    public function description(): string;
}

// 2. Базовая реализация
class SimpleCoffee implements Coffee {
    public function cost(): int {
        return 100;
    }

    public function description(): string {
        return 'Обычный кофе';
    }
}

// 3. Абстрактный декоратор (реализует интерфейс и хранит объект)
abstract class CoffeeDecorator implements Coffee {
    protected Coffee $coffee;

    public function __construct(Coffee $coffee) {
        $this->coffee = $coffee;
    }
}

// 4. Конкретные декораторы
class MilkDecorator extends CoffeeDecorator {
    public function cost(): int {
        return $this->coffee->cost() + 20;
    }

    public function description(): string {
        return $this->coffee->description() . ', молоко';
    }
}

class SugarDecorator extends CoffeeDecorator {
    public function cost(): int {
        return $this->coffee->cost() + 10;
    }

    public function description(): string {
        return $this->coffee->description() . ', сахар';
    }
}


$coffee = new SimpleCoffee();
echo $coffee->description() . ' — ' . $coffee->cost() . " руб.\n";

// Добавим молоко
$coffee = new MilkDecorator($coffee);
echo $coffee->description() . ' — ' . $coffee->cost() . " руб.\n";

// Добавим сахар
$coffee = new SugarDecorator($coffee);
echo $coffee->description() . ' — ' . $coffee->cost() . " руб.\n";