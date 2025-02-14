<?php

/*

php artisan make:policy

// почти тоже что и gate

class PostPolicy
{
    public function edit(User $user, Post $post): bool
    {
        return $post->user->is($user);
    }
}

Класс политики, генерируемый командой Artisan, не имеет специальных свойств или методов,
но каждый добавляемый вами метод будет интерпретироваться как ключ способности данного объекта.

// Регистрация политик в классе AuthServiceProvider
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Contact::class => ContactPolicy::class,
    ];
}

// Переопределение политик с помощью метода before()
public function before($user, $ability)
{
    if ($user->isAdmin()) {
        return true;
    }
}

*/
