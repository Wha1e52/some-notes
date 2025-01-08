<?php

/*
// команда для создания миграции
php artisan make:migration create_flights_table // по конвенции так и называем create_название таблицы(во множественном)_table

// команда для выполнения миграций
php artisan migrate
php artisan migrate:status // с показом статуса выполнения миграций

// откатить последнюю пачку миграций
php artisan migrate:rollback

// откатить все миграции и применить снова
php artisan migrate:refresh

// дропнуть все таблицы в базе и применить миграции
php artisan migrate:fresh


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
            $table->timestamps(); // добавляет колонки created_at и updated_at, но они чета нихуя не заполняются(заполняются через orm)
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

!при фк все типы поля в обоих таблицах должны совпадать

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








*/