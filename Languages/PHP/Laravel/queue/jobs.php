<?php
/*

// команда для создания задачи
php artisan make:job CrunchReports

// Пример задания
    ...
    use App\ReportGenerator;
    class CrunchReports implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        protected $user;

        public function __construct($user)
        {
            $this->user = $user;
        }

        public function handle(ReportGenerator $generator): void
        {
            $generator->generateReportsForUser($this->user);
            Log::info('Generated reports.');
        }
    }

// Отправка заданий
$user = auth()->user();
$daysToCrunch = 7;
\App\Jobs\CrunchReports::dispatch($user, $daysToCrunch);

// При наличии сразу нескольких подключений к очереди можно указать конкретное подключение,
пристыковав к методу dispatch() метод onConnection():
    DoThingJob::dispatch()->onConnection('redis');

// В случае использования сервера очередей можно указать, в какую именованную очередь следует поместить задание.
Например, вы можете различать задания по уровню важности, используя две очереди с названиями low (низкий) и high (высокий).
    DoThingJob::dispatch()->onQueue('high');

// Задержка на пять минут перед передачей задания обработчикам очередей
Данный метод принимает либо целое число, представляющее длительность задержки в секундах,
либо экземпляр класса DateTime/Carbon
    $delay = now()->addMinutes(5);
    DoThingJob::dispatch()->delay($delay);

// Объединение заданий в цепочки
Каждое очередное задание будет ожидать, пока завершится предыдущее, и если одно задание завершится неудачей,
то следующие за ним не будут выполняться.
    $user = auth()->user();
    $daysToCrunch = 7;
    Bus::chain([
        new CrunchReports($user, $daysToCrunch),
        new SendReport($user),
    ])->dispatch();
Когда одно из заданий в цепочке завершается сбоем, этот сбой можно обработать с помощью метода catch():
    $user = auth()->user();
    $daysToCrunch = 7;
    Bus::chain([
        new CrunchReports($user, $daysToCrunch),
        new NotifyNewReportsDone($user)
    ])->catch(function (Throwable $e) {
        new ReportsNotCrunchedNotification($user)
    })->dispatch($user);

// Пакетная обработка заданий
Для отслеживания пакетных заданий нужна таблица в базе данных; ее можно создать командой Artisan:
php artisan queue:batches-table
php artisan migrate
Чтобы отметить задание как пакетное, включите трейт Illuminate\Bus\Batchable. Он добавит в класс задания метод batch(),
позволяющий получить информацию о текущем пакете, в котором выполняется задание.
    ...
    class SampleBatchableJob implements ShouldQueue
    {
        use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        public function handle(): void
        {
            // Не выполнять задание в случае отмены пакета
            if ($this->batch()->cancelled()) {
                return;
            }

            // Иначе выполнить его как обычно
            // ...
        }
    }
Отправка пакетных заданий
    use App\Jobs\CrunchReports;
    use Illuminate\Support\Facades\Bus;
    $user = auth()->user();
    $admin = User::admin()->first();
    $supervisor = User::supervisor()->first();
    $daysToCrunch = 7;
    Bus::batch([
        new CrunchReports::dispatch($user, $daysToCrunch),
        new CrunchReports::dispatch($admin, $daysToCrunch),
        new CrunchReports::dispatch($supervisor, $daysToCrunch)
    ])->then(function (Batch $batch) {
        // Выполнить, если пакет обработан успешно
    })->catch(function (Batch $batch, Throwable $e) {
        // Выполнить, если какое-то из заданий потерпит неудачу
    })->finally(function (Batch $batch) {
        // Выполнить по завершении обработки пакета
    })->dispatch();

// Добавление заданий в пакеты из задания
public function handle(): void
{
    if ($this->batch()->cancelled()) {
        return;
    }
    $this->batch()->add([
        new \App\Jobs\ImportContacts,
        new \App\Jobs\ImportContacts,
        new \App\Jobs\ImportContacts,
    ]);
}

// Отмена пакета
public function handle(): void
{
    if (Веская причина отменить обработку пакета) {
        return $this->batch()->cancel();
    }
    // ...
}

// Сбои при обработке пакетов
$batch = Bus::batch([
    // ...
])->allowFailures()->dispatch();

// Очистка таблицы пакетов
$schedule->command('queue:prune-batches')->daily();

// Проверка количества попыток выполнить задание
public function handle(): void
{
    ...
    if ($this->attempts() > 3) {
        //
    }
}

// Для выполнения этого задания можно предпринять до десяти попыток
public $tries = 10;
// Если задание сгенерировало исключение три раза, то прекратить дальнейшие попытки выполнить его
public $maxExceptions = 3;

// Можно также указать предельное время ожидания выполнения задания.
В этом случае фреймворк будет пытаться выполнить задание неограниченное количество раз в течение указанного периода времени.
Для этого определите метод retryUntil() в классе задания и верните из него экземпляр DateTime/Carbon:
public function retryUntil()
{
    return now()->addSeconds(30);
}

// Задержка перед выполнением повторных попыток
public $retryAfter = 10;
Если время задержки вычисляется по какому-то сложному алгоритму, определите метод retryAfter и
верните из него количество минут ожидания
public function retryAfter() {...}

// Запуск заданий из промежуточного ПО
...
use App\Jobs\Middleware\MyMiddleware;
...
public function middleware()
{
    return [new MyMiddleware];
}
Нужное промежуточное ПО можно также указать при отправке задания с помощью метода through:
DoThingJob::dispatch()->through([new MyMiddleware]);

// Пример использования промежуточного ПО для ограничения частоты выполнения заданий
// В сервис-провайдере
public function boot(): void
{
    RateLimiter::for('imageConversions', function (object $job) {
        return $job->user->paidForPriorityConversions()
            ? Limit::none()
            : Limit::perHour(1)->by($job->user->id);
    });
}

// Обработка неудачно выполненных заданий
нужно создать таблицу базы данных для неудачно выполненных заданий.
php artisan queue:failed-table
php artisan migrate
В эту таблицу будут заноситься все задания, превысившие максимально допустимое количество повторных попыток
// Определение метода, вызываемого в случае неудачного выполнения задания
...
class CrunchReports implements ShouldQueue
{
    ...
    public function failed()
    {
        // Выполняем любые необходимые действия,
        // например уведомляем администратора
    }
}

// Регистрация глобального обработчика для неудачно выполненных заданий
// Некоторый сервис-провайдер
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
...
public function boot()
{
    Queue::failing(function (JobFailed $event) {
        // $event->connectionName
        // $event->job
        // $event->exception
    });
}



















*/