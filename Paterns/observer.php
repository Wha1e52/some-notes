<?php
/*
Сценарий:
    Допустим, у нас есть Блог. Когда создаётся новая статья, мы хотим уведомить подписчиков и записать лог.
*/

// Определяем интерфейс Наблюдателя
interface Observer {
    public function update(string $message);
}

// Создаём класс "Субъекта" (Observable)
class Blog {
    private array $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function notify(string $message) {
        foreach ($this->observers as $observer) {
            $observer->update($message);
        }
    }

    public function addPost(string $title) {
        echo "Добавлена новая статья: $title\n";
        $this->notify("Новая статья опубликована: $title");
    }
}

// Реализуем наблюдателей
class EmailNotifier implements Observer {
    public function update(string $message) {
        echo "📧 Отправка email-уведомления: $message\n";
    }
}

class Logger implements Observer {
    public function update(string $message) {
        echo "📝 Запись в лог: $message\n";
    }
}

$blog = new Blog();

// Добавляем наблюдателей
$blog->attach(new EmailNotifier());
$blog->attach(new Logger());

// Добавляем статью
$blog->addPost("Шаблон Observer в PHP");