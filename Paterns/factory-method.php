<?php

/*

Factory Method - определяет интерфейс для создания объекта, но позволяет подклассам решать, какой класс инсталлировать.
То есть, создание объекта делегируется подклассам.

*/

// Продукт — общий интерфейс для уведомлений
interface Notification {
    public function send(string $message): void;
}

// Конкретные продукты — разные виды уведомлений
class EmailNotification implements Notification {
    public function send(string $message): void {
        echo "Sending Email: {$message}" . PHP_EOL;
    }
}

class SMSNotification implements Notification {
    public function send(string $message): void {
        echo "Sending SMS: {$message}" . PHP_EOL;
    }
}

class PushNotification implements Notification {
    public function send(string $message): void {
        echo "Sending Push Notification: {$message}" . PHP_EOL;
    }
}

// Создатель — определяет фабричный метод
abstract class NotificationFactory {
    // Фабричный метод — создаёт объект Notification
    abstract public function createNotification(): Notification;

    // Другие методы, которые используют продукт
    public function notify(string $message): void {
        $notification = $this->createNotification();
        $notification->send($message);
    }
}

// Конкретные создатели, реализуют фабричный метод
class EmailNotificationFactory extends NotificationFactory {
    public function createNotification(): Notification {
        return new EmailNotification();
    }
}

class SMSNotificationFactory extends NotificationFactory {
    public function createNotification(): Notification {
        return new SMSNotification();
    }
}

class PushNotificationFactory extends NotificationFactory {
    public function createNotification(): Notification {
        return new PushNotification();
    }
}

// Использование

function clientCode(NotificationFactory $factory, string $message) {
    $factory->notify($message);
}

clientCode(new EmailNotificationFactory(), "Hello via Email!");
clientCode(new SMSNotificationFactory(), "Hello via SMS!");
clientCode(new PushNotificationFactory(), "Hello via Push!");