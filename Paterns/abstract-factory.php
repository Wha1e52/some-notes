<?php

/*
используется для создания семейств связанных объектов без указания их конкретных классов


Этот паттерн особенно полезен, когда вам нужно поддерживать разные семейства продуктов
(например, UI-компоненты под разные платформы), но вы не хотите жёстко привязываться к конкретным классам.

Классы AbstractFactory часто реализуются фабричными методами, но могут быть реализованы и с помощью паттерна прототип.
Конкретная фабрика часто описывается паттерном одиночка.
*/

// 1. Абстрактные продукты
interface Button {
    public function render(): string;
}

interface Checkbox {
    public function render(): string;
}


// 2. Конкретные продукты
class WindowsButton implements Button {
    public function render(): string {
        return "Рендерим кнопку в стиле Windows";
    }
}

class MacOSButton implements Button {
    public function render(): string {
        return "Рендерим кнопку в стиле MacOS";
    }
}

class WindowsCheckbox implements Checkbox {
    public function render(): string {
        return "Рендерим чекбокс в стиле Windows";
    }
}

class MacOSCheckbox implements Checkbox {
    public function render(): string {
        return "Рендерим чекбокс в стиле MacOS";
    }
}


// 3. Абстрактная фабрика
interface GUIFactory {
    public function createButton(): Button;
    public function createCheckbox(): Checkbox;
}


// 4. Конкретные фабрики
class WindowsFactory implements GUIFactory {
    public function createButton(): Button {
        return new WindowsButton();
    }

    public function createCheckbox(): Checkbox {
        return new WindowsCheckbox();
    }
}

class MacOSFactory implements GUIFactory {
    public function createButton(): Button {
        return new MacOSButton();
    }

    public function createCheckbox(): Checkbox {
        return new MacOSCheckbox();
    }
}


// 5. Клиентский код
function renderUI(GUIFactory $factory) {
    $button = $factory->createButton();
    $checkbox = $factory->createCheckbox();

    echo $button->render() . PHP_EOL;
    echo $checkbox->render() . PHP_EOL;
}

// Пример использования
$os = 'Windows'; // Или 'MacOS'

if ($os === 'Windows') {
    $factory = new WindowsFactory();
} else {
    $factory = new MacOSFactory();
}

renderUI($factory);
















