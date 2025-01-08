<?php

/*
Настройка ключа маршрута для модели Eloquent
Чтобы поиск на основе URL производился по другому столбцу, добавьте в модель метод с именем getRouteKeyName():
public function getRouteKeyName() {
    return 'slug';
}
Теперь, получив URL вида conference/{conference}, модель будет выполнять поиск в столбце slug, а не в столбце с идентификаторами.




*/