<?php

/*

// команда для создания уведомления
php artisan make:notification NewChirp

class NewChirp extends Notification
{
    use Queueable;

    public function __construct(public Chirp $chirp)
    {
        //
    }
 ...
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("New Chirp from {$this->chirp->user->name}")
                    ->greeting("New Chirp from {$this->chirp->user->name}")
                    ->line(Str::limit($this->chirp->message, 50))
                    ->action('Go to Chirper', url('/'))
                    ->line('Thank you for using our application!');
    }
 ...
}

// команда для создания события
php artisan make:event ChirpCreated

class ChirpCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public Chirp $chirp)
    {
        //
    }
 ...
}

class Chirp extends Model
{
    ...
    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];
}

// команда для создания слушателя
php artisan make:listener SendChirpCreatedNotifications --event=ChirpCreated

class SendChirpCreatedNotifications implements ShouldQueue
{
 ...
    public function handle(ChirpCreated $event): void
    {
        foreach (User::whereNot('id', $event->chirp->user_id)->cursor() as $user) {
            $user->notify(new NewChirp($event->chirp));
        }
    }
}

*/