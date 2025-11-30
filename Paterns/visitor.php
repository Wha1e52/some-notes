<?php

/*

Паттерн Visitor позволяет вынести операции, которые можно выполнить над элементами объекта,
в отдельный класс, не изменяя сами классы этих элементов.

Это удобно, когда нужно выполнять разные операции над объектами разных типов,
не засоряя сами классы логикой этих операций.

*/

interface Visitable {
    public function accept(Visitor $visitor): void;
}

interface Visitor {
    public function visitDiv(DivElement $element): void;
    public function visitSpan(SpanElement $element): void;
}

class DivElement implements Visitable {
    public string $content;

    public function __construct(string $content) {
        $this->content = $content;
    }

    public function accept(Visitor $visitor): void {
        $visitor->visitDiv($this);
    }
}

class SpanElement implements Visitable {
    public string $text;

    public function __construct(string $text) {
        $this->text = $text;
    }

    public function accept(Visitor $visitor): void {
        $visitor->visitSpan($this);
    }
}

//  Конкретный посетитель: Рендерит HTML
class HtmlRenderVisitor implements Visitor {
    public function visitDiv(DivElement $element): void {
        echo "<div>{$element->content}</div>\n";
    }

    public function visitSpan(SpanElement $element): void {
        echo "<span>{$element->text}</span>\n";
    }
}

// Конкретный посетитель: Считает общее количество символов
class CharacterCountVisitor implements Visitor {
    public int $total = 0;

    public function visitDiv(DivElement $element): void {
        $this->total += strlen($element->content);
    }

    public function visitSpan(SpanElement $element): void {
        $this->total += strlen($element->text);
    }
}

// Клиентский код
$elements = [
    new DivElement("Привет, мир!"),
    new SpanElement("Текст в span"),
];

$renderVisitor = new HtmlRenderVisitor();
$countVisitor = new CharacterCountVisitor();

foreach ($elements as $element) {
    $element->accept($renderVisitor);
    $element->accept($countVisitor);
}

echo "Всего символов: {$countVisitor->total}\n";