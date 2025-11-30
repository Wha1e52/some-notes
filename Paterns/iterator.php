<?php

/*

Iterator - позволяет последовательно обходить элементы коллекции, не раскрывая ее внутреннюю структуру.

*/

class Book {
    private string $title;
    private string $author;

    public function __construct(string $title, string $author) {
        $this->title = $title;
        $this->author = $author;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }
}

class BookIterator implements Iterator {
    private array $books;
    private int $position = 0;

    public function __construct(array $books) {
        // Допустим, хотим итерировать в обратном порядке:
        $this->books = array_reverse($books);
    }

    public function current(): Book {
        return $this->books[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        $this->position++;
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function valid(): bool {
        return isset($this->books[$this->position]);
    }
}

class BookCollection implements IteratorAggregate {
    private array $books = [];

    public function addBook(Book $book): void {
        $this->books[] = $book;
    }

    public function getIterator(): Traversable {
        return new BookIterator($this->books);
    }
}


$collection = new BookCollection();
$collection->addBook(new Book("1984", "George Orwell"));
$collection->addBook(new Book("Brave New World", "Aldous Huxley"));
$collection->addBook(new Book("Fahrenheit 451", "Ray Bradbury"));

foreach ($collection as $book) {
    echo $book->getTitle() . " by " . $book->getAuthor() . PHP_EOL;
}