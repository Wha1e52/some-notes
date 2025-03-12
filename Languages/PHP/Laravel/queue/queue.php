<?php

/*


// команда для запуска задач в очереди
php artisan queue:work
php artisan queue:work redis --timeout=60 --sleep=15 --tries=3 --queue=high,medium
можно также настроить для обработки единственного задания, добавив ключ --once
Если параметр --tries не задан или задан равным 0, прослушиватель очереди будет предпринимать бесконечное количество попыток

!!!!!!!!!!!!!!!!!!!!!!!!!!!! ALWAYS RESTART THE WORKER AFTER MAKING A CODE CHANGE !!!!!!!!!!!!!!!!!

// отправить задачу в очередь
dispatch(function() {
    logger('hello from queue')
})->delay(5);



// команда для создания задач
php artisan make:job SomeJob

// отправить задачу в очередь
$post = Post::find(1);
SomeJob::dispatch($post);


class SomeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Post $post) {}

    public function handle()
    {
        AI::translate($this->post->description, 'ru');
    }
}

// Команда queue:failed отображает список неудачно выполненных заданий.
php artisan queue:failed

// Взяв из этого списка идентификатор выполнить его повторно с помощью команды queue:retry:
php artisan queue:retry 9
php artisan queue:retry all // повторяет выполнение всех неудачно выполненных заданий

php artisan queue:forget 5 // удаляет задание
// удалить все неудачно выполненные задания старше определенного срока (по умолчанию это 24 часа,
но можно задать пользовательское значение с помощью --hours=48):
php artisan queue:prune-failed

php artisan queue:flush // удаляет все задания

// Возврат задания в очередь
public function handle()
{
    ...
    if (condition) {
        $this->release($numberOfSecondsToDelayBeforeRetrying);
    }
}

// Удаление задания
public function handle()
{
    ...
    if ($jobShouldBeDeleted) {
        return;
    }
}





*/