<?php

/*
Паттерн Шаблонный метод (Template Method) используется, когда есть общий алгоритм, который
нужно частично или полностью переопределить в подклассах.
Этот паттерн позволяет определить "скелет" алгоритма в базовом классе, а детали реализовать в подклассах.
*/
abstract class Beverage {
    // Шаблонный метод
    public function prepareRecipe() {
        $this->boilWater();
        $this->brew();
        $this->pourInCup();
        $this->addCondiments();
    }

    // Общие шаги для всех напитков
    private function boilWater() {
        echo "Boiling water...\n";
    }

    private function pourInCup() {
        echo "Pouring into cup...\n";
    }

    // Шаги, которые будут реализованы в подклассах
    abstract protected function brew();
    abstract protected function addCondiments();
}

class Tea extends Beverage {
    protected function brew() {
        echo "Steeping the tea...\n";
    }

    protected function addCondiments() {
        echo "Adding lemon...\n";
    }
}

class Coffee extends Beverage {
    protected function brew() {
        echo "Brewing the coffee...\n";
    }

    protected function addCondiments() {
        echo "Adding sugar and milk...\n";
    }
}

$tea = new Tea();
$coffee = new Coffee();

echo "Preparing tea:\n";
$tea->prepareRecipe();

echo "\nPreparing coffee:\n";
$coffee->prepareRecipe();

/*
Объяснение:
Шаблонный метод: prepareRecipe() определяет общий алгоритм.
Гибкость: Методы brew() и addCondiments() реализуются в подклассах, предоставляя различия для чая и кофе.
Преимущества: Код, общий для всех подклассов (boilWater, pourInCup), инкапсулирован в базовом классе.
Это уменьшает дублирование и упрощает расширение.
*/