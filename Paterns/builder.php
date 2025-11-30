<?php

/*

Builder - Позволяет создавать сложные объекты пошагово, отделяя логику построения объекта от его представления.

*/

// Класс продукта — автомобиль
class Car {
    public $engine;
    public $wheels;
    public $color;

    public function specifications() {
        return "Engine: {$this->engine}, Wheels: {$this->wheels}, Color: {$this->color}";
    }
}

// Интерфейс строителя
interface CarBuilderInterface {
    public function buildEngine();
    public function buildWheels();
    public function paint();
    public function getCar(): Car;
}

// Конкретный строитель — строит спортивный автомобиль
class SportsCarBuilder implements CarBuilderInterface {
    private Car $car;

    public function __construct() {
        $this->car = new Car();
    }

    public function buildEngine() {
        $this->car->engine = 'V8 engine';
    }

    public function buildWheels() {
        $this->car->wheels = '18 inch sport wheels';
    }

    public function paint() {
        $this->car->color = 'Red';
    }

    public function getCar(): Car {
        return $this->car;
    }
}

// Конкретный строитель — строит городской автомобиль
class CityCarBuilder implements CarBuilderInterface {
    private Car $car;

    public function __construct() {
        $this->car = new Car();
    }

    public function buildEngine() {
        $this->car->engine = 'Electric engine';
    }

    public function buildWheels() {
        $this->car->wheels = '15 inch wheels';
    }

    public function paint() {
        $this->car->color = 'White';
    }

    public function getCar(): Car {
        return $this->car;
    }
}

// Директор — управляет процессом построения
class Director {
    private CarBuilderInterface $builder;

    public function setBuilder(CarBuilderInterface $builder) {
        $this->builder = $builder;
    }

    public function buildCar() {
        $this->builder->buildEngine();
        $this->builder->buildWheels();
        $this->builder->paint();
    }

    public function getCar(): Car {
        return $this->builder->getCar();
    }
}

// Использование

$director = new Director();

$sportsCarBuilder = new SportsCarBuilder();
$director->setBuilder($sportsCarBuilder);
$director->buildCar();
$sportsCar = $director->getCar();
echo "Sports Car: " . $sportsCar->specifications() . PHP_EOL;

$cityCarBuilder = new CityCarBuilder();
$director->setBuilder($cityCarBuilder);
$director->buildCar();
$cityCar = $director->getCar();
echo "City Car: " . $cityCar->specifications() . PHP_EOL;