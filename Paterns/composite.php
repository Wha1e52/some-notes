<?php

/*
 Этот паттерн позволяет клиенту работать с отдельными объектами и их композициями одинаково.
 */


// Общий интерфейс для листьев и контейнеров
interface FileSystemComponent {
    public function show(int $indent = 0): void;
}

// Лист — простой объект, например, файл
class File implements FileSystemComponent {
    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function show(int $indent = 0): void {
        echo str_repeat("  ", $indent) . "- File: {$this->name}\n";
    }
}

// Контейнер — может содержать другие компоненты
class Folder implements FileSystemComponent {
    private string $name;
    private array $children = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function add(FileSystemComponent $component): void {
        $this->children[] = $component;
    }

    public function show(int $indent = 0): void {
        echo str_repeat("  ", $indent) . "+ Folder: {$this->name}\n";
        foreach ($this->children as $child) {
            $child->show($indent + 1);
        }
    }
}

// Пример использования:
$root = new Folder("root");
$root->add(new File("readme.txt"));
$root->add(new File("composer.json"));

$src = new Folder("src");
$src->add(new File("index.php"));
$src->add(new File("utils.php"));

$root->add($src);

// Выводим структуру
$root->show();
/*
+ Folder: root
  - File: readme.txt
  - File: composer.json
  + Folder: src
    - File: index.php
    - File: utils.php
*/