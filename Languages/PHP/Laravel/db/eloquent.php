<?php

/*

Все действия, поддерживаемые генератором запросов фасада DB, доступны и при работе с объектами Eloquent.
$newestContacts = Contact::orderBy('created_at', 'desc')
    ->take(10)
    ->get();


Post::all(); // получить все записи
Post::first(); // получить первую запись

Post::find(1); // получить одну запись по id
Post::findOrFail(1); // получить одну запись по id, если не нашли, то выкинуть 404
Post::where('id', '=', 1)
    ->first();

// агрегатные функции
Post::where('id', '>', 10)->count(); // кол-во записей
Post::max('id'); // максимальное значение
Post::min('id'); // минимальное значение
Post::avg('id'); // среднее значение
Post::sum('id'); // сумма значений

------------------------------------------------------------------------------------------------------------------------
// Вставки
$post = new Post();
$post->isDraft = 1;
$post->title = 'Post name';
$post->save(); // вставить новую запись
либо
Post::create([
    'isDraft' => 1,
    'title' => 'Post name',
]);
// вот еще
$contact = new Contact([
    'name' => 'Ken Hirata',
    'email' => 'ken@hirata.com',
]);
$contact->save();
// или
$contact = Contact::make([
    'name' => 'Ken Hirata',
    'email' => 'ken@hirata.com',
]);
$contact->save();
------------------------------------------------------------------------------------------------------------------------
// Обновления
$contact = Contact::find(1);
$contact->email = 'natalie@parkfamily.com';
$contact->save();

Contact::where('created_at', '<', now()->subYear())
->update(['longevity' => 'ancient']);
// или
$contact = Contact::find(1);
$contact->update(['longevity' => 'ancient']);
------------------------------------------------------------------------------------------------------------------------
// Методы firstOrCreate() и firstOrNew()
Они отыщут и извлекут первую запись, соответствующую этим параметрам,
а если такой записи нет, то создадут экземпляр с такими свойствами;
firstOrCreate() сохранит этот экземпляр в базе данных, а затем вернет, а firstOrNew() вернет его без сохранения.
$contact = Contact::firstOrCreate(['email' => 'luis.ramos@myacme.com']);
Если вы передадите массив значений во втором параметре, значения будут добавлены
в созданную запись (если она была создана), но не будут использоваться для поиска и выяснения существования записи.
------------------------------------------------------------------------------------------------------------------------
// Удаление
$contact = Contact::find(5);
$contact->delete();

Contact::destroy(1);
// или
Contact::destroy([1, 5, 7]);

Contact::where('updated_at', '<', now()->subYear())->delete();

Если вы используете мягкое удаление Eloquent, каждый ваш запрос будет игнорировать их по умолчанию,
если только вы явно не скажете вернуть их обратно.
Функция мягкого удаления Eloquent требует добавления в таблицу столбца deleted_at.
Как только вы включите мягкое удаление в модель Eloquent, каждый написанный вами запрос
(если вы явно не включите мягко удаленные записи) будет игнорировать мягко удаленные записи.

// Включение мягкого удаления
class Contact extends Model
{
    use SoftDeletes;
}

// Миграция для добавления столбца мягкого удаления в таблицу
Schema::table('contacts', function (Blueprint $table) {
    $table->softDeletes();
});

После того как вы внесете эти изменения, каждый вызов delete() и destroy() будет устанавливать
в столбце deleted_at вашей записи текущие дату и время вместо фактического удаления этой записи.
И все будущие запросы будут исключать эту строку из возвращаемых результатов.

// включить в выборку мягко удаленные записи
$allHistoricContacts = Contact::withTrashed()->get();
И затем воспользоваться методом trashed(), чтобы посмотреть, был ли конкретный экземпляр удален мягко:
if ($contact->trashed()) {
    // сделать что-нибудь
}

// можно получить только мягко удаленные элементы:
$deletedContacts = Contact::onlyTrashed()->get();

// Чтобы восстановить мягко удаленный элемент, вызовите метод restore() экземпляра или запроса:
$contact->restore();
// или
Contact::onlyTrashed()->where('vip', true)->restore();

// Окончательно удалить мягко удаленный объект можно вызовом метода forceDelete() экземпляра или запроса:
$contact->forceDelete();
// или
Contact::onlyTrashed()->forceDelete();
------------------------------------------------------------------------------------------------------------------------
// firstWhere() — сокращенный вариант комбинации методов where() и first()
// С помощью where() и first()
Contact::where('name', 'Wilbur Powery')->first();
// С помощью firstWhere()
Contact::firstWhere('name', 'Wilbur Powery');

// *?Использование get() вместо all()
Повсюду, где применяется all(), можно использовать get(). Contact::get() даст тот же ответ, что и Contact::all().
Однако, если вы решите изменить запрос, например добавив фильтр where(), то с методом all() не сможете это сделать, а с get() сможете.
Поэтому, несмотря на популярность all(), я бы рекомендовал использовать get() во всех случаях и позабыть про существование all().

$users = User::with('phones')->paginate(10); // пагинация по 10 записей
$users = User::with('phones')->simplePaginate(10); // пагинация без вывода нумерации
$users = User::with('phones')->cursorPaginate(10); // пагинация по курсору
// Для управления количеством ссылок, отображаемых по обе стороны текущей страницы,
можно использовать метод onEachSide():
DB::table('posts')->paginate(10)->onEachSide(3);
// Выведет: 5 6 7 [8] 9 10 11

// Разбивка на страницы вручную
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
Route::get('people', function (Request $request) {
    $people = [...]; // огромный список персон
    $perPage = 15;
    $offsetPages = $request->input('page', 1) – 1;
    // Класс Paginator не будет нарезать для вас ваш массив
    $people = array_slice(
        $people,
        $offsetPages * $perPage,
        $perPage
    );
    return new Paginator(
        $people,
        $perPage
    );
});

в шаблоне используем метод links() для вывода пагинации {{ $users->links() }}

// Разделение запроса Eloquent для ограничения использования памяти
Contact::chunk(100, function ($contacts) {
    foreach ($contacts as $contact) {
        // Действия с $contact
    }
});

// Выбор только записей со связанным элементом.
$postsWithComments = Post::has('comments')->get();
$postsWithManyComments = Post::has('comments', '>=', 5)->get();
$usersWithPhoneBooks = User::has('contacts.phoneNumbers')->get();

// Получает все контакты с номером телефона, содержащим строку "867-5309"
$jennyIGotYourNumber = Contact::whereHas('phoneNumbers', function ($query) {
    $query->where('number', 'like', '%867-5309%');
})->get();
// Сокращенная версия того же запроса
$jennyIGotYourNumber = Contact::whereRelation(
    'phoneNumbers',
    'number',
    'like',
    '%867-5309'
)->get();



















*/