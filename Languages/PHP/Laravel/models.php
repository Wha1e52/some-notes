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
    protected $hidden = ['password', 'remember_token']; // скрываем поля при переводе в json или toArray
    public $visible = ['name', 'email', 'status']; // белый список с атрибутами, которые должны помещаться в JSON
    protected $fillable = ['SomeColumn1', 'SomeColumn2']; // разрешаем массово заполнять поля в create() или update() или глобально для всех моделей в провайдере в boot, Model::unguard();
    protected $guarded = ['id', 'created_at', 'updated_at', 'owner_id']; // запрещаем массово заполнять поля, если оставим пустым, то запрета не будет и можно убрать $fillable
    public $timestamps = false; // убираем поля created_at и updated_at
    protected $dateFormat = 'U'; // задаем формат даты для меток времени


    // кастомные методы для модели
    public function passengersStatus()
    {
        return $this->status ? 1 : 0;
    }

}

// Можно сделать атрибут видимым только для одного вызова с помощью метода Eloquent makeVisible():
$array = $user->makeVisible('remember_token')->toArray();

Настройка ключа маршрута для модели Eloquent
Чтобы поиск на основе URL производился по другому столбцу, добавьте в модель метод с именем getRouteKeyName():
public function getRouteKeyName() {
    return 'slug';
}
Теперь, получив URL вида conference/{conference}, модель будет выполнять поиск в столбце slug, а не в столбце с идентификаторами.

------------------------------------------------------------------------------------------------------------------------
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
------------------------------------------------------------------------------------------------------------------------
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
$users = User::with('phones')->get(); // жадная загрузка (избавляемся от N+1 проблемы)
$users = User::withCount('phones')->get(); // подсчет количества связанных записей в поле phones_count
$contacts = Contact::with('phoneNumbers', 'addresses')->get();
$authors = Author::with('posts.comments')->get();
$contacts = Contact::with(['addresses' => function ($query) {
    $query->where('mailable', true);
}])->get();

// отключить lazy loading
в boot методе App\Providers\AppServiceProvider
Model::preventLazyLoading();

Model::preventLazyLoading(! $this->app->isProduction());

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

$donors = $user->contacts->filter(function ($contact) {
    return $contact->status == 'donor';
});

$lifetimeValue = $contact->orders->reduce(function ($carry, $order) {
    return $carry + $order->amount;
}, 0);


class User extends Model
{
    public function newestContact(): HasOne
    {
        return $this->hasOne(Contact::class)->latestOfMany();
    }
    public function oldestContact(): HasOne
    {
        return $this->hasOne(Contact::class)->oldestOfMany();
    }
    public function emergencyContact(): HasOne
    {
        return $this->hasOne(Contact::class)->ofMany('priority', 'max');
    }
}

------------------------------------------------------------------------------------------------------------------------
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
------------------------------------------------------------------------------------------------------------------------
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
        // return $this->belongsToMany(Role::class)
                ->withTimestamps() // created_at и updated_at
                ->withPivot('active');
    }
}
$user = User::find(1);
foreach ($user->roles as $role) {
    // ...
}
$roles = User::find(1)->roles()->orderBy('name')->get();

// Получение данных из сводной записи связанного элемента
$user = User::first();
$user->contacts->each(function ($contact) {
    echo sprintf(
        'Contact associated with this user at: %s',
        $contact->pivot->created_at
    );
});

// Настройка имени атрибута pivot
// Модель User
public function groups()
{
    return $this->belongsToMany(Group::class)
        ->withTimestamps()
        ->as('membership');
}
// Использование этого отношения:
User::first()->groups->each(function ($group) {
    echo sprintf(
        'User joined this group at: %s',
        $group->membership->created_at
    );
});



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

$user->roles->each(function ($role) {
// сделать что-нибудь
});

$donors = $user->roles()->where('status', 'donor')->get();

$post->refresh(); // обновляем
// All comments, including the newly saved comment...
$post->comments;


------------------------------------------------------------------------------------------------------------------------
Поскольку сводная таблица может иметь собственные свойства, нужна возможность установки этих свойств при присоединении элемента, связанного отношением «многие ко многим». Это можно сделать, передав массив во втором параметре в save():
$user = User::first();
$contact = Contact::first();
$user->contacts()->save($contact, ['status' => 'donor']);
Кроме того, вы можете использовать attach() и detach() и вместо экземпляра связанного элемента передать его идентификатор. Они работают так же, как save(), но могут принимать массив идентификаторов без необходимости переименовывать метод во что-то вроде attachMany():
$user = User::first();
$user->contacts()->attach(1);
$user->contacts()->attach(2, ['status' => 'donor']);
$user->contacts()->attach([1, 2, 3]);
$user->contacts()->attach([
    1 => ['status' => 'donor'],
    2,
    3,
]);
$user->contacts()->detach(1);
$user->contacts()->detach([1, 2]);
$user->contacts()->detach(); // Отсоединяет все контакты
Если ваша цель не присоединение или отсоединение, а просто инвертирование текущего состояния связывания, используйте toggle(). Если данный идентификатор в данный момент присоединен, он будет отсоединен, и наоборот:
$user->contacts()->toggle([1, 2, 3]);
Вы также можете использовать updateExistingPivot(), чтобы изменить только сводную запись:
$user->contacts()->updateExistingPivot($contactId, [
    'status' => 'inactive',
]);
Если нужно заменить текущие отношения, эффективно отсоединив все предыдущие и добавив новые, передайте массив в sync():
$user->contacts()->sync([1, 2, 3]);
$user->contacts()->sync([
    1 => ['status' => 'donor'],
    2,
    3,
]);

// прикрепление связи
$account = Account::find(10);
$user->account()->associate($account);
$user->save();

// отвязывание связи
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
------------------------------------------------------------------------------------------------------------------------
// Определение отношения «доступ ко многим через»
class User extends Model
{
    public function phoneNumbers()
    {
        // Новый синтаксис на основе строк
        return $this->through('contact')->has('phoneNumber');

        // Традиционный синтаксис
        return $this->hasManyThrough(PhoneNumber::class, Contact::class);
    }
}

// Определение отношения «доступ к одному через»
class User extends Model
{
    public function phoneNumber()
    {
        // Новый синтаксис на основе строк
        return $this->through('company')->has('phoneNumber');

        // Традиционный синтаксис
        return $this->hasOneThrough(PhoneNumber::class, Company::class);
    }
}







------------------------------------------------------------------------------------------------------------------------
// выводит сводную информацию о модели
model:show

$user->roles()->get(); // получаем все, если $user->roles не обновилась
$user->roles()->get()->pluck('name'); // получить массив значений из столбца name

------------------------------------------------------------------------------------------------------------------------
// Определение локальной области видимости в модели
class Contact extends Model
{
    public function scopeActiveVips($query)
    {
        return $query->where('vip', true)->where('trial', false);
    }
}
Чтобы определить локальную область видимости, нужно добавить в класс Eloquent метод,
имя которого начинается со слова scope и содержит имя области видимости в «верблюжьем» регистре.
Метод должен принимать и возвращать генератор запросов

// Можно также определять области видимости, которые принимают параметры
class Contact extends Model
{
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
$friends = Contact::status('friend')->get();

// Добавление глобальной области видимости с помощью замыкания
class Contact extends Model
{
    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder){
            $builder->where('active', true);
        });
    }
}
Мы только что добавили глобальную область с именем active, и теперь каждый запрос в этой модели
будет возвращать только записи, столбец active в которых имеет значение true.

// Добавление глобальной области видимости через класс
php artisan make:scope ActiveScope

class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('active', true);
    }
}

class Contact extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }
}

// Удаление глобальных областей видимости.
Если вы удаляете область видимости на основе замыкания, то передайте в первом параметре ключ,
который использовали при регистрации вызовом addGlobalScope():
$allContacts = Contact::withoutGlobalScope('active')->get();

Если вы удаляете одну глобальную область видимости на основе класса,
то передайте имя класса в withoutGlobalScope() или withoutGlobalScopes():
Contact::withoutGlobalScope(ActiveScope::class)->get();
Contact::withoutGlobalScopes([ActiveScope::class, VipScope::class])->get();

Или просто отключите все глобальные области видимости для запроса:
Contact::withoutGlobalScopes()->get();
------------------------------------------------------------------------------------------------------------------------
// Аксессоры

Чтобы определить аксессор, добавьте в свою модель метод с именем, совпадающим с именем свойства,
но в «верблюжьем» регистре. То есть, если свойство имеет имя first_name, то метод аксессора должен называться firstName.
Кроме того, этот метод должен возвращать значение типа Illuminate\Database\Eloquent\Casts\Attribute.

// Декорирование существующего столбца
class Contact extends Model
{
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ?: '(No name provided)',
        );
    }
}
// Использование аксессора:
$name = $contact->name;

// Определение атрибута без существующего столбца, используя аксессоры Eloquent
class Contact extends Model
{
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->last_name,
        );
    }
}
// Использование аксессора:
$fullName = $contact->full_name;


Если вы создали аксессор для несуществующего столбца — например, столбец full_name,
добавьте его в массив $appends в модели, чтобы добавить его в массив и вывод JSON:
class Contact extends Model
{
    protected $appends = ['full_name'];
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
------------------------------------------------------------------------------------------------------------------------
// Мутаторы

Мутаторы работают так же, как аксессоры, но определяют, как обрабатывать запись данных, а не их чтение.
По аналогии с аксессорами мутаторы можно использовать для изменения процесса записи данных в
существующие столбцы или установки столбцов, которых нет в базе данных.
Кроме того, вместо параметра get мутаторы определяют параметр set.

// Декорирование установки значения атрибута с использованием мутаторов Eloquent
class Order extends Model
{
    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $value > 0 ? $value : 0,
        );
    }
}
// Использование мутатора
$order->amount = '15';

Запись значения в несуществующий атрибут с использованием мутаторов Eloquent
class Order extends Model
{
    protected function workgroupName(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => [
                'email' => "{$value}@ourcompany.com",
            ],
        );
    }
}
// Использование мутатора
$order->workgroup_name = 'jstott';
------------------------------------------------------------------------------------------------------------------------
// Преобразование атрибутов

|----------------------------- Возможные типы столбцов приведения атрибутов ----------------------------|
| Тип                 | Описание                                                                        |
|---------------------|-------------------------------------------------------------------------------- |
| int|integer         | Совпадает с PHP (int)                                                           |
| real|float|double   | Совпадает с PHP (float)                                                         |
| decimal:<digits>    | Совпадает с PHP-функцией number_format(), которой передан аргумент digits       |
| string              | Совпадает с PHP (string)                                                        |
| bool|boolean        | Совпадает с PHP (bool)                                                          |
| object|json         | Преобразуется в/из JSON как объект stdClass                                     |
| array               | Преобразуется в/из JSON как массив                                              |
| collection          | Преобразуется в/из JSON как коллекция                                           |
| date|datetime       | Преобразуется из DATETIME БД в Carbon и обратно                                 |
| timestamp           | Преобразуется из TIMESTAMP БД в Carbon и обратно                                |
| encrypted           | Управляет шифрованием/дешифрованием строки                                      |
| enum                | Преобразуется в перечисление                                                    |
| hashed              | Управляет хешированием строки                                                   |
|-------------------------------------------------------------------------------------------------------|

class Contact extends Model
{
    protected $casts = [
        'vip' => 'boolean',
        'children_names' => 'array',
        'birthday' => 'date',
        'subscription' => SubscriptionStatus::class
    ];
}

// приведения к пользовательскому типу

namespace App\Casts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
class Encrypted implements CastsAttributes
{
    // Выполняет приведение данного значения.
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return Crypt::decrypt($value);
    }

    // Подготавливает данное значение к сохранению.
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return Crypt::encrypt($value);
    }
}

Приведения к пользовательским типам можно использовать в свойстве $casts модели Eloquent:
protected $casts = [
    'ssn' => \App\Casts\Encrypted::class,
];
------------------------------------------------------------------------------------------------------------------------
// Полиморфные отношения
class Star extends Model
{
    public function starrable()
    {
        return $this->morphTo();
    }
}
class Contact extends Model
{
    public function stars()
    {
        return $this->morphMany(Star::class, 'starrable');
    }
}
class Event extends Model
{
    public function stars()
    {
        return $this->morphMany(Star::class, 'starrable');
    }
}

$contact = Contact::first();
$contact->stars()->create();

// Получение экземпляров полиморфного отношения
$contact = Contact::first();
$contact->stars->each(function ($star) {
    // Делаем что-то
});

// Получение цели полиморфного экземпляра
$stars = Star::all();
$stars->each(function ($star) {
    var_dump($star->starrable); // Экземпляр Contact или Event
});

// Расширение полиморфной системы для дифференциации по пользователям
class Star extends Model
{
    public function starrable()
    {
        return $this->morphsTo;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
class User extends Model
{
    public function stars()
    {
        return $this->hasMany(Star::class);
    }
}
$user = User::first();
$event = Event::first();
$event->stars()->create(['user_id' => $user->id]);

// Полиморфное отношение «многие ко многим»
class Contact extends Model
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
class Event extends Model
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
class Tag extends Model
{
    public function contacts()
    {
        return $this->morphedByMany(Contact::class, 'taggable');
    }
    public function events()
    {
        return $this->morphedByMany(Event::class, 'taggable');
    }
}
$tag = Tag::firstOrCreate(['name' => 'likes-cheese']);
$contact = Contact::first();
$contact->tags()->attach($tag->id);

// Доступ к связанным элементам с обеих сторон полиморфного отношения «многие ко многим»
$contact = Contact::first();
$contact->tags->each(function ($tag) {
    // Делаем что-нибудь
});
$tag = Tag::first();
$tag->contacts->each(function ($contact) {
    // Делаем что-нибудь
});
------------------------------------------------------------------------------------------------------------------------
// Синхронное обновление меток времени в родительских и дочерних записях
// Обновление родительской записи при каждом обновлении дочерней записи
class PhoneNumber extends Model
{
    protected $touches = ['contact'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

------------------------------------------------------------------------------------------------------------------------
// События, которые посылает каждая модель Eloquent:
creating;
created;
updating;
updated;
saving;
saved;
deleting;
deleted;
restoring;
restored;
retrieved.
// saving запускается как для creating и updating, а saved — для created и updated.
------------------------------------------------------------------------------------------------------------------------
// Проверка на принадлежность пользователя
$model->user->is(Auth::user()) { // or isNot
    do something
}

// Проверка на разрешение
Auth::user->can('name from gate', $model) { // or cannot
    do something
}













*/