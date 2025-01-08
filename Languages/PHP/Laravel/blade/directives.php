<?php

/*
// директивы

Каждый файл должен расширять только один другой файл, и директива @extends должна находиться в первой строке файла.
@extends('layouts.main')


вставляет указанное частичное представление и при необходимости передает в него данные.
@include('layout.footer', ['text' => 'See just how great it is']) // вторым параметром можно передать массив данных
{{-- Включить представление, если оно существует --}}
@includeIf('sidebars.admin', ['some' => 'data'])
{{-- Включить представление, если переданная переменная равна true --}}
@includeWhen($user->isAdmin(), 'sidebars.admin', ['some' => 'data'])
{{-- Включить первое представление из данного массива представлений --}}
@includeFirst(['customs.header', 'header'], ['some' => 'data'])

проверка на существование переменной
@isset($some_var)
    <p>{{ $some_var }}</p>
@endisset

// условия
@if (count($talks) === 1)
    There is one talk at this time period.
@elseif (count($talks) === 0)
    There are no talks at this time period.
@else
    There are {{ count($talks) }} talks at this time period.
@endif

противоположность @if. @unless($condition) совпадает с <?php if (!$condition).
@unless ($user->hasPaid())
    You can complete your payment by switching to the payment tab.
@endunless


внутри можно работать с пхп
@php
    $var = 'hello';
    $isActive = false;
    $hasError = true;
@endphp

// модификаторы
применяет классы к элементу в зависимости от условий, условия в значениях
<span @class([
    'p-4',
    'font-bold' => $isActive,
    'text-gray-500' => ! $isActive,
    'bg-red' => $hasError,
])>some text</span>
аналогично со стилем
<span @style([
    'background-color: red',
    'font-weight: bold' => $isActive,
])></span>

// циклы
в директивах @foreach и @forelse есть объект $loop у которого есть разные свойства
$loop->index	    The index of the current loop iteration (starts at 0). (индекс текущего элемента в цикле; 0 — первый элемент.)
$loop->iteration	The current loop iteration (starts at 1). (индекс текущего элемента в цикле; 1 — первый элемент.)
$loop->remaining	The iterations remaining in the loop. (количество элементов, которые еще предстоит обойти в цикле.)
$loop->count	    The total number of items in the array being iterated. (общее количество элементов.)
$loop->first	    Whether this is the first iteration through the loop. (логическое значение, указывающее, является ли данный элемент первым элементом в цикле.)
$loop->last	        Whether this is the last iteration through the loop. (логическое значение, указывающее, является ли данный элемент последним элементом в цикле.)
$loop->even	        Whether this is an even iteration through the loop. (логическое значение, указывающее, является ли текущая итерация четной.)
$loop->odd	        Whether this is an odd iteration through the loop. (логическое значение, указывающее, является ли текущая итерация нечетной.)
$loop->depth	    The nesting level of the current loop. (уровень вложенности текущего цикла: 1 для внешнего цикла, 2 — для цикла, вложенного в другой цикл, и т. д.)
$loop->parent	    When in a nested loop, the parent's loop variable. (ссылка на переменную $loop родительского цикла, если текущий цикл вложен в другой цикл @foreach; иначе — null.)

цикл с условием, выполнить действия, которые должны выполняться, если перебираемый объект пуст.
@forelse($users as $user)
    <p>{{ $user->name }}</p>
@empty
    <p>No users.</p>
@endforelse

цикл foreach
@foreach($users as $user)
    <p>{{ $user->name }}</p>
@endforeach

цикл for
@for ($i = 0; $i < 10; $i++)
    @if ($i == 2)
        @continue
    @endif
    <p>{{ $i }}</p>
    @if ($i == 3)
        @break
    @endif
@endfor

цикл while
@while ($item = array_pop($items))
    {{ $item->orSomething() }}<br>
@endwhile

@each
Первый параметр — это имя частичного представления.
Второй — массив или коллекция для итерации.
Третий — имя переменной, через которую каждый элемент (элемент в массиве $modules) будет передан представлению.
И необязательный четвертый параметр — это представление для отображения, если массив или коллекция окажется пустым
(при желании в этом параметре можно передать строку, которая будет использоваться в качестве вашего шаблона).

<!-- resources/views/sidebar.blade.php -->
<div class="sidebar">
    @each('partials.module', $modules, 'module', 'partials.empty-module')
</div>

<!-- resources/views/partials/module.blade.php -->
<div class="sidebar-module">
    <h1>{{ $module->title }}</h1>
</div>

<!-- resources/views/partials/empty-module.blade.php -->
<div class="sidebar-module">
    No modules :(
</div>

Привязка пользовательской директивы Blade в сервис-провайдере
public function boot()
{
    Blade::directive('ifGuest', function () {
        return "<?php if (auth()->guest()): ?>";
    });
}

Создание директивы Blade с параметрами
// Связывание
Blade::directive('newlinesToBr', function ($expression) {
    return "<?php echo nl2br({$expression}); ?>";
});
// Использование
<p>@newlinesToBr($message->body)</p>

Упрощенные пользовательские директивы для операторов if
// Привязка
Blade::if('ifPublic', function () {
    return (app('context'))->isPublic();
});
вместо
Blade::directive('ifPublic', function () {
    return "<?php if (app('context')->isPublic()): ?>";
});

// в каждой форме нужно установить
@csrf









*/