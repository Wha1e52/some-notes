<?php

/*
// команда для создания миграции
php artisan make:migration create_flights_table // по конвенции так и называем create_название таблицы(во множественном)_table
Этой команде можно передать два необязательных флага.
--create=table_name предварительно заполняет миграцию кодом, предназначенным для создания таблицы с именем table_name, а
--table=table_name — кодом для изменений в существующей таблице. Вот несколько примеров:
php artisan make:migration create_users_table
php artisan make:migration add_votes_to_users_table --table=users
php artisan make:migration create_users_table --create=users

// Squashing Migrations
As you build your application, you may accumulate more and more migrations over time.
This can lead to your database/migrations directory becoming bloated with potentially hundreds of migrations.
If you would like, you may "squash" your migrations into a single SQL file.
To get started, execute the schema:dump command:
php artisan schema:dump
# Dump the current database schema and prune all existing migrations...
php artisan schema:dump --prune

// команда для выполнения миграций
php artisan migrate

// откатить последнюю пачку миграций
php artisan migrate:rollback

// откатить все миграции и применить снова (=migrate:reset, а затем migrate.)
php artisan migrate:refresh

// дропнуть все таблицы в базе и применить миграции
php artisan migrate:fresh

// Откатывает все миграции, применявшиеся к этому экземпляру базы данных.
migrate:reset

// Показывает список со всеми миграциями
php artisan migrate:status

return new class extends Migration
{
    Run the migrations.
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto_increment
            $table->increments('id'); // поле int serial
            $table->string('name', 100)->unique();
            $table->string('airline')->nullable();
            $table->boolean('status')->default(false);
            $table->enum(some_enum, [choiceOne, choiceTwo])
            $table->timestamps(); // добавляет колонки created_at и updated_at (заполняются через orm)
        });
    }

    Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};


// добавление
php artisan make:migration add_votes_field_to_users_table

return new class extends Migration
{
    Run the migrations.
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('votes', 100)->unique();
            $table->string('some_column', 100)->nullable()->after('last_name');
            $table->timestamp('some_time', 100)->useCurrent(); // CURRENT_TIMESTAMP в качестве значения по умолчанию.
        });
    }

    Reverse the migrations.
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('votes');
        });
    }
};

// изменение
php artisan make:migration change_votes_field_to_users_table

Чтобы изменить столбец, напишите код (как для создания нового столбца), а после добавьте вызов метода change().

return new class extends Migration
{
    Run the migrations.
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('votes', 50)->unique()->change(); // change - обязательно, т.к без него будет пытаться создать новую колонку
        });
    }

    Reverse the migrations.
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('votes', 100)->unique()->change();
        });
    }
};

Вот так можно переименовать столбец:
Schema::table('contacts', function (Blueprint $table)
{
    $table->renameColumn('promoted', 'is_promoted');
});

А так удалить столбец:
Schema::table('contacts', function (Blueprint $table)
{
    $table->dropColumn('votes');
});

!!!!!!!!!!!!!!!!!!!!!!!!! ПРИ ФК ВСЕ ТИПЫ ПОЛЯ В ОБОИХ ТАБЛИЦАХ ДОЛЖНЫ СОВПАДАТЬ !!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!! ПРИ ПРОМЕЖУТОЧНОЙ ТАБЛИЦЕ M2M ИМЕНА СОРТИРУЕМ В АЛФАВИТОМ ПОРЯДКЕ !!!!!!!!!!!!!!!!!!!!!!!!!

return new class extends Migration
{
    Run the migrations.
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->biginteger('some_column in table')->unsigned();
            $table->foreign('some_column in table')->references('some_column in another table')->on('another table');
        });
    }

    Reverse the migrations.
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['some_column in table']);
            $table->dropColumn('some_column in table');
        });
    }
};

// Добавление индексов в миграциях
// После того, как столбцы созданы...
$table->primary('primary_id'); // Первичный ключ;
// не нужно, если используется increments()
$table->primary(['first_name', 'last_name']); // Составные ключи
$table->unique('email'); // Уникальный индекс
$table->unique('email', 'optional_custom_index_name'); // Уникальный индекс
$table->index('amount'); // Простой индекс
$table->index('amount', 'optional_custom_index_name'); // Простой индекс

// Удаление индексов в миграциях
$table->dropPrimary('contacts_id_primary');
$table->dropUnique('contacts_email_unique');
$table->dropIndex('optional_custom_index_name');
// Если вы передадите массив имен столбцов в dropIndex,
// он сам определит имена индексов на основе правил генерации
$table->dropIndex(['email', 'amount']);

// Добавление и удаление внешних ключей
$table->foreign('user_id')->references('id')->on('users');
либо
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
либо
// 2м параметром можно указать имя колонки
$table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

Чтобы указать ограничения внешнего ключа, можно использовать
cascadeOnUpdate(), restrictOnUpdate(), cascadeOnDelete(), restrictOnDelete() и nullOnDelete().
Например:
$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->cascadeOnDelete();

// Удалить внешний ключ
$table->dropForeign('contacts_user_id_foreign');
Либо передав массив полей, на которые индекс ссылается в локальной таблице:
$table->dropForeign(['user_id']);


























*/