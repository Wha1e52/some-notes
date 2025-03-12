<?php
/*

// команда чтобы создать запускаемое событие
php artisan make:event UserSubscribed

// Три способа запуска события
Event::fire(new UserSubscribed($user, $plan));
// или
$dispatcher = app(Illuminate\Contracts\Events\Dispatcher::class);
$dispatcher->fire(new UserSubscribed($user, $plan));
// или
event(new UserSubscribed($user, $plan));


// команда чтобы создать слушателя
php artisan make:listener EmailOwnerAboutSubscription --event=UserSubscribed

// Пример прослушивателя событий
    ...
    use App\Mail\UserSubscribed as UserSubscribedMessage;
    class EmailOwnerAboutSubscription
    {
        public function handle(UserSubscribed $event): void
        {
            Log::info('Emailed owner about new user: ' . $event->user->email);
            Mail::to(config('app.owner-email'))
                ->send(new UserSubscribedMessage($event->user, $event->plan);
        }
    }

// Привязка прослушивателей к событиям в провайдере EventServiceProvider
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\UserSubscribed::class => [
            \App\Listeners\EmailOwnerAboutSubscription::class,
        ],
    ];
}
Ключ каждого элемента массива представляет собой имя класса события, а значение — массив имен классов прослушивателей.

// Событие, рассылаемое по нескольким каналам
    ...
    use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
    class UserSubscribed implements ShouldBroadcast
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;
        public $user;
        public $plan;
        public function __construct($user, $plan)
        {
            $this->user = $user;
            $this->plan = $plan;
        }
        public function broadcastOn(): array
        {
            // Использование строк
            return [
                'users.' . $this->user->id,
                'admins'
            ];

            // Использование объектов Channel
            return [
                new Channel('users.' . $this->user->id),
                new Channel('admins'),
                // В случае закрытого канала: new PrivateChannel('admins'),
                // В случае канала присутствия: new PresenceChannel('admins'),
            ];
        }
    }

// Настройка данных рассылаемого события
public function broadcastWith()
{
    return [
        'userId' => $this->user->id,
        'plan' => $this->plan
    ];
}












------------------------------------------------------------------------------------------------------------------------
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