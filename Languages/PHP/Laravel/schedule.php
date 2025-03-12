<?php
/*
https://laravel.com/docs/12.x/scheduling#schedule-frequency-options

Вот как выглядит задание cron для запуска этой команды:
* * * * * cd /home/myapp.com && php artisan schedule:run >> /dev/null 2>&1

// Планирование выполнения замыкания с интервалом в одну минуту
// app/Console/Kernel.php
public function schedule(Schedule $schedule): void
{
    $schedule->call(function () {
        CalculateTotals::dispatch();
    })->everyMinute();
}
или
$schedule->command('scores:tally --reset-cache')->everyMinute();
или
$schedule->exec('/home/myapp.com/bin/build.sh')->everyMinute();

// Еженедельный запуск по воскресеньям в 23:50
$schedule->call(function () {
    // Еженедельный запуск по воскресеньям в 23:50
})->weekly()->sundays()->at('23:50');

// Некоторые примеры запланированных событий
    // В обоих случаях еженедельный запуск по воскресеньям в 23:50
    $schedule->command('do:thing')->weeklyOn(0, '23:50');
    $schedule->command('do:thing')->weekly()->sundays()->at('23:50');

    // Запуск с периодичностью один час по рабочим дням с 8 утра до 5 вечера
    $schedule->command('do:thing')->weekdays()->hourly()->when(function () {
        return date('H') >= 8 && date('H') <= 17;
    });

    // Запуск с периодичностью один час по рабочим дням с 8 утра до 5 вечера
    // с использованием метода between
    $schedule->command('do:thing')->weekdays()->hourly()->between('8:00', '17:00');

    // Запуск с периодичностью 30 минут, за исключением того случая,
    // когда SkipDetector отменяет запуск
    $schedule->command('do:thing')->everyThirtyMinutes()->skip(function () {
        return app('SkipDetector')->shouldSkip();
    });

// Определение часовых поясов для запланированных задач
$schedule->command('do:it')->weeklyOn(0, '23:50')->timezone('America/Chicago');
или определите метод scheduleTimezone() в классе App\Console\Kernel:
protected function scheduleTimezone()
{
    return 'America/Chicago';
}

// Блокирование и наложение
$schedule->command('do:thing')->everyMinute()->withoutOverlapping();

// Обработка выходных данных задачи
    Для записи возвращаемых задачей данных в файл воспользуйтесь методом sendOutputTo():
    $schedule->command('do:thing')->daily()->sendOutputTo($filePath);
    Если вместо этого нужно добавить данные в уже имеющийся файл, примените метод appendOutputTo():
    $schedule->command('do:thing')->daily()->appendOutputTo($filePath);

// Запустить что-то до или после определенной задачи можно с помощью методов-ловушек before() и after():
$schedule->command('do_thing')
    ->daily()
    ->before(function () {
        // Подготовка
    })
    ->after(function () {
        // Очистка
    });



*/