<?php

/*
// компоненты

сгенерировать компонент
php artisan make:component modal --view

Если также требуется сгенерировать класс PHP, то исключите этот флаг:
php artisan make:component modals.cancellation

Использование:
<x-modals.cancellation />

Передача данных в компоненты через атрибуты
<!-- Передача данных в компонент -->
<x-modal title="Title here yay" :width="$width" />
<!-- Доступ к данным в шаблоне -->
<div style="width: {{ $width }}">
    <h1>{{ $title }}</h1>
</div>


нихуя не понял:
class Modal extends Component
{
public function __construct(
    public string $title,
    public string $width,
) {}
}

@props([
    'width',
    'title',
])
<div style="width: {{ $width }}">
    <h1>{{ $title }}</h1>
</div>

<x-modal>
    <x-slot:title>
        <h2 class="uppercase">Password requirements not met</h2>
    </x-slot>
    <p>The password you have provided is not valid.
        Here are the rules for valid passwords: [...]</p>
    <p><a href="#">...</a></p>
</x-modal>

Определение и вызов методов компонента
// в определении компонента
public function isPromoted($item)
{
    return $item->promoted_at !== null && ! $item->promoted_at->isPast();
}
<!-- в шаблоне -->
<div>
@if ($isPromoted($item))
    <!-- показать промо-значок -->
@endif
    <!-- ... -->
</div>

<!-- Объединить классы по умолчанию с переданными классами -->
<!-- Определение -->
<div {{ $attributes->merge(['class' => 'p-4 m-4']) }}>
    {{ $message }}
</div>

<!-- Использование -->
<x-notice class="text-blue-200">
    Message here
</x-notice>

<!-- Вывод: -->
<div class="p-4 m-4 text-blue-200">
    Message here
</div>

Использование стеков Blade
<!-- resources/views/layouts/app.blade.php -->
<html>
<head>
<link href="/css/global.css">
<!-- место, куда будет помещено содержимое стека -->
@stack('styles')
</head>
<body>
<!-- // -->
</body>
</html>
<!-- resources/views/jobs.blade.php -->
@extends('layouts.app')
@push('styles')
<!-- втолкнуть что-то в конец стека -->
<link href="/css/jobs.css">
@endpush
<!-- resources/views/jobs/apply.blade.php -->
@extends('jobs')
@prepend('styles')
<!-- втолкнуть что-то в начало стека -->
<link href="/css/jobs--apply.css">
@endprepend
Это приводит к следующему результату:
<html>
    <head>
        <link href="/css/global.css">
        <!-- место, куда будет помещено содержимое стека -->
        <!-- втолкнуть что-то в начало стека -->
        <link href="/css/jobs--apply.css">
        <!-- втолкнуть что-то в конец стека -->
        <link href="/css/jobs.css">
    </head>
    <body>
        <!-- // -->
    </body>
</html>


*/