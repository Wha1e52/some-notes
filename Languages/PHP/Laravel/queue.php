<?php

/*


// команда для запуска задач в очереди
php artisan queue:work

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










*/