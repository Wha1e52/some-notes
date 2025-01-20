<?php

/*

// команда для создания модели
php artisan make:model Flight
(может принимать доп аргументы для создания еще и миграции, контролера и т.п)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $table = 'my_flights'; // явно указываем как называется таблица в базе данных
    public $incrementing = false; // указываем что id не инкрементируется
    protected $keyType = 'string'; // указываем что id является строкой
    protected $primaryKey = 'SomeColumn'; // указываем pk
    protected $hidden = ['SomeColumn1', 'SomeColumn2']; // скрываем поля при переводе в json или toArray
    protected $fillable = ['SomeColumn1', 'SomeColumn2']; // разрешаем массово заполнять поля
    protected $guarded = ['SomeColumn1', 'SomeColumn2']; // запрещаем массово заполнять поля
    public $timestamps = false; // убираем поля created_at и updated_at
    protected $dateFormat = 'U'; // задаем формат даты для меток времени


    // кастомные методы для модели
    public function passengersStatus()
    {
        return $this->status ? 1 : 0;
    }

}

Настройка ключа маршрута для модели Eloquent
Чтобы поиск на основе URL производился по другому столбцу, добавьте в модель метод с именем getRouteKeyName():
public function getRouteKeyName() {
    return 'slug';
}
Теперь, получив URL вида conference/{conference}, модель будет выполнять поиск в столбце slug, а не в столбце с идентификаторами.


// One to One
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public function phone(): HasOne
    {
        return $this->hasOne(Phone::class);
    }
}
$phone = User::find(1)->phone;

$user = User::find(1);
$user->phone()->where('id', '>', 1)->orderByDesc('id')->get()->toArray(); // можем дополнительно фильтровать и сортировать

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
$user = Phone::find(1)->user;

// One to Many

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public function phones(): HasMany
    {
        return $this->HasMany(Phone::class);
    }
}
$phones = User::find(1)->phones;
$users = User::with('phones')->get(); // жадная загрузка
$users = User::withCount('phones')->get(); // подсчет количества связанных записей

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
$user = Phone::find(1)->user;


// Many to Many (m2m)
relationship's table structure like so:

users
    id - integer
    name - string

roles
    id - integer
    name - string

role_user
    user_id - integer
    role_id - integer


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
        // By default, only the model keys will be present on the pivot model.
        // If your intermediate table contains extra attributes, you must specify them when defining the relationship:
        // return $this->belongsToMany(Role::class)->withPivot('active', 'created_by');
    }
}
$user = User::find(1);
foreach ($user->roles as $role) {
    // ...
}
$roles = User::find(1)->roles()->orderBy('name')->get();

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, foreignPivotKey: 'some_role_id'); // чтобы явно указать имя столбца, если не соответствует конвенции
        // в другой таблице указываем relatedPivotKey
    }

    public function latestActive(): HasOne // получаем последнюю активную запись
    {
        return $this->users()->one()->ofMany(
            ['order' => 'desc'],
            function (Builder $query) {
                $query->where('active', '=' true);
            });
    }
}

//Retrieving Intermediate Table Columns
foreach ($user->roles as $role) {
    echo $role->pivot->created_at; // через pivot получаем дополнительные колонки
}




// сохранения через связь не many to many (связь добавится автоматически)
The difference between save and create is
that save accepts a full Eloquent model instance while create accepts a plain PHP array.

$comment = new Comment(['message' => 'A new comment.']);
$post = Post::find(1);

$post->comments()->save($comment);
$post->comments()->create([
    'message' => 'A new comment.',
]);

$post->comments()->saveMany([
    new Comment(['message' => 'A new comment.']),
    new Comment(['message' => 'Another new comment.']),
]);
$post->comments()->createMany([
    ['message' => 'A new comment.'],
    ['message' => 'Another new comment.'],
]);


$post->refresh(); // обновляем
// All comments, including the newly saved comment...
$post->comments;



// прикрепление\отвязывание связи
$account = Account::find(10);
$user->account()->associate($account);
$user->save();

$user->account()->dissociate();
$user->save();

// Attaching / Detaching
$user = User::find(1);
$user->roles()->attach($roleId); // в таблицу role_user добавляем запись (user_id, role_id)

When attaching relationships to a model, you may also pass an array of additional data to be inserted into the intermediate table
$user->roles()->attach([
    1 => ['expires' => $expires],
    2 => ['expires' => $expires],
]);

$user->roles()->sync([1, 2, 3]); // добавятся только те, которых нет в бд, если бы делали через attach то было бы ошибка т.к повторы

// Detach a single role from the user...
$user->roles()->detach($roleId);

// Detach multiple roles from the user...
$user->roles()->detach([1, 2, 3]);

// Detach all roles from the user...
$user->roles()->detach();


$user->roles()->toggle([1, 2, 3]); // удаляем те которые уже есть в бд, и добавляем которых нет

// выводит сводную информацию о модели
model:show

$user->roles()->get(); // получаем все, если $user->roles не обновилась
$user->roles()->get()->pluck('name'); // получить массив значений из столбца name

*/