<?php

/*

Этот паттерн позволяет разделить абстракцию и реализацию, чтобы они могли развиваться независимо.


С Bridge:
- Заказы (Order) и способы оплаты (PaymentGateway) независимы:
  - Добавляешь новый способ оплаты — меняешь только реализацию PaymentGateway, не трогаешь заказы.
  - Добавляешь новый тип заказа — меняешь только Order-подкласс, не трогаешь способы оплаты.
- Код становится более гибким и модульным.

*/


// Интерфейс реализации (Bridge) — PaymentGateway
interface PaymentGateway
{
    public function processPayment(float $amount): string;
}


// Конкретные реализации
class PayPalGateway implements PaymentGateway
{
    public function processPayment(float $amount): string
    {
        return "Оплата через PayPal на сумму $amount руб.";
    }
}

class CreditCardGateway implements PaymentGateway
{
    public function processPayment(float $amount): string
    {
        return "Оплата через Кредитную карту на сумму $amount руб.";
    }
}


// Абстракция — Order
abstract class Order
{
    protected PaymentGateway $gateway;

    public function __construct(PaymentGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    abstract public function checkout(float $amount): string;
}

// Конкретные заказы
class PhysicalProductOrder extends Order
{
    public function checkout(float $amount): string
    {
        return "Физический товар: " . $this->gateway->processPayment($amount);
    }
}

class DigitalProductOrder extends Order
{
    public function checkout(float $amount): string
    {
        return "Цифровой товар: " . $this->gateway->processPayment($amount);
    }
}


// Создаем способы оплаты
$paypal = new PayPalGateway();
$card = new CreditCardGateway();

// Физический заказ через PayPal
$order1 = new PhysicalProductOrder($paypal);
echo $order1->checkout(1500) . PHP_EOL;

// Цифровой заказ через Карту
$order2 = new DigitalProductOrder($card);
echo $order2->checkout(500) . PHP_EOL;