<?php
/*
Паттерн Фасад — это структурный паттерн проектирования, который предоставляет простой интерфейс к сложной системе.
Если по-простому, это "упрощённый вход" к чему-то сложному. Вместо того чтобы разбираться со множеством классов
и методов, ты используешь один класс (фасад), который внутри делегирует вызовы этим компонентам.
*/

class AudioSystem {
    public function turnOn() {
        echo "Audio system is turned on.\n";
    }
}

class VideoSystem {
    public function turnOn() {
        echo "Video system is turned on.\n";
    }
}

class TextSystem {
    public function loadSubtitles() {
        echo "Subtitles are loaded.\n";
    }
}

class HomeTheaterFacade {
    private $audio;
    private $video;
    private $text;

    public function __construct() {
        $this->audio = new AudioSystem();
        $this->video = new VideoSystem();
        $this->text = new TextSystem();
    }

    public function startMovie() {
        echo "Starting the movie...\n";
        $this->audio->turnOn();
        $this->video->turnOn();
        $this->text->loadSubtitles();
        echo "Movie is ready to play!\n";
    }
}

$homeTheater = new HomeTheaterFacade();
$homeTheater->startMovie();

/*
Преимущества:
Упрощение интерфейса: Пользователь работает с одним объектом (фасадом), не зная деталей.
Инкапсуляция: Сложная система скрыта за фасадом.
Гибкость: Если логика компонентов изменится, код пользователя не пострадает.
*/