<?php

/*
Этот паттерн позволяет изменять поведение объекта во время выполнения, не меняя его класс.

Допустим, у нас есть класс, который считает стоимость доставки в зависимости от способа (курьер, почта, дрон и т.д.).
Каждый способ — своя стратегия.


Основные условия для применения паттерна стратегия:

    - наличие множества родственных классов, отличающихся только поведением.
    Стратегия позволяет настроить класс одним из многих возможных вариантов поведения;

    - наличие нескольких разновидностей алгоритма. Например, можно определить два варианта алгоритма,
    один из которых требует больше времени, а другой — больше памяти.
    Стратегии разрешается применять, когда варианты алгоритмов реализованы в виде иерархии классов;

    - в алгоритме содержатся данные, о которых клиент не должен «знать».
    Используйте паттерн стратегия, чтобы не раскрывать сложные, специфичные для алгоритма структуры данных;

    - в классе определено много вариантов поведения, представленных разветвленными условными операторами.
    В этом случае проще перенести код из ветвей в отдельные классы стратегий.

*/

interface DeliveryStrategy {
    public function calculateCost(float $weight): float;
}



class CourierDelivery implements DeliveryStrategy {
    public function calculateCost(float $weight): float {
        return 300 + $weight * 10;
    }
}

class PostDelivery implements DeliveryStrategy {
    public function calculateCost(float $weight): float {
        return 150 + $weight * 5;
    }
}

class DroneDelivery implements DeliveryStrategy {
    public function calculateCost(float $weight): float {
        return 500 + $weight * 20;
    }
}



class DeliveryService {
    private DeliveryStrategy $strategy;

    public function __construct(DeliveryStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function setStrategy(DeliveryStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function getDeliveryCost(float $weight): float {
        return $this->strategy->calculateCost($weight);
    }
}


$weight = 2.5; // вес посылки

$service = new DeliveryService(new CourierDelivery());
echo "Курьер: " . $service->getDeliveryCost($weight) . "\n";

$service->setStrategy(new PostDelivery());
echo "Почта: " . $service->getDeliveryCost($weight) . "\n";

$service->setStrategy(new DroneDelivery());
echo "Дрон: " . $service->getDeliveryCost($weight) . "\n";