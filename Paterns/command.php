<?php

/*

Этот паттерн позволяет инкапсулировать запрос на выполнение операции как объект,
тем самым отделяя отправителя запроса от объекта, который его выполняет.

*/

// Пример: Умный дом — включение и выключение света

// Интерфейс команды

interface Command {
    public function execute(): void;
}


// Конкретные команды
class LightOnCommand implements Command {
    private Light $light;

    public function __construct(Light $light) {
        $this->light = $light;
    }

    public function execute(): void {
        $this->light->on();
    }
}

class LightOffCommand implements Command {
    private Light $light;

    public function __construct(Light $light) {
        $this->light = $light;
    }

    public function execute(): void {
        $this->light->off();
    }
}


// Получатель (Receiver)
class Light {
    public function on(): void {
        echo "Свет включён\n";
    }

    public function off(): void {
        echo "Свет выключен\n";
    }
}


// Инициатор (Invoker)
class RemoteControl {
    private ?Command $command = null;

    public function setCommand(Command $command): void {
        $this->command = $command;
    }

    public function pressButton(): void {
        if ($this->command) {
            $this->command->execute();
        }
    }
}


// Клиент
$light = new Light();

$lightOn = new LightOnCommand($light);
$lightOff = new LightOffCommand($light);

$remote = new RemoteControl();

$remote->setCommand($lightOn);
$remote->pressButton(); // Свет включён

$remote->setCommand($lightOff);
$remote->pressButton(); // Свет выключен