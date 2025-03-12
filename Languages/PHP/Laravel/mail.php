<?php
/*

// команда для создания класса PHP, созданного для представления электронных писем
php artisan make:mail AssignmentCreated

// Пример класса отправления
    <?php
    namespace App\Mail;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Mail\Mailables\Address;
    use Illuminate\Mail\Mailables\Content;
    use Illuminate\Mail\Mailables\Envelope;
    use Illuminate\Queue\SerializesModels;
    class AssignmentCreated extends Mailable
    {
        use Queueable, SerializesModels;
        public function __construct(public $trainer, public $trainee){}
        public function envelope(): Envelope
        {
            return new Envelope(
                subject: 'New assignment from ' . $this->trainer->name,
                from: new Address($this->trainer->email, $this->trainer->name),
            );
        }

        public function content(): Content
        {
            return new Content(
                view: 'emails.assignment-created'
            );
        }
        public function attachments(): array
        {
            return [];
        }
    }


// Несколько способов отсылки отправлений
    $mail = new AssignmentCreated($trainer, $trainee);

    // Простая отправка
    Mail::to($user)->send($mail);

    // С направлением копии/скрытой копии/и т.д.
    Mail::to($user1))
        ->cc($user2)
        ->bcc($user3)
        ->send($mail);

    // С использованием коллекций
    Mail::to('me@app.com')
    ->bcc(User::all())
    ->send($mail)

// Возможный вариант шаблона электронного письма о новом задании
    <!-- resources/views/emails/assignment-created.blade.php -->
    <p>Hey {{ $trainee->name }}!</p>
    <p>You have received a new training assignment from <b>{{ $trainer->name }}</b>.
    Check out your <a href="{{ route('training-dashboard') }}">training dashboard</a> now!</p>

// Встраивание изображений
    <!-- emails/image.blade.php -->
    Here is an image:
    <img src="{{ $message->embed(storage_path('embed.jpg')) }}">
    Or, the same image embedding the data:
    <img src="{{ $message->embedData(
    file_get_contents(storage_path('embed.jpg')), 'embed.jpg'
    ) }}">

// Определение переменных шаблона
    use Illuminate\Mail\Mailables\Content;
    public function content(): Content
    {
        return new Content(
            view: 'emails.assignment-created',
            with: ['assignment' => $this->event->name],
        );
    }

// часто используемых параметров метода envelope(), которые можно использовать для настройки электронного письма.
from: Address // Задает адрес и имя отправителя.
subject: string // Задает тему письма.
cc: Address // Задает адрес для отправки копии.
bcc: Address // Задает адрес для отправки скрытой копии.
replyTo: Address // Задает адрес для ответа.
tags: array // Задает теги, если они поддерживаются вашим механизмом отправки электронной почты.
metadata: array // Задает метаданные, если они поддерживаются вашим механизмом отправки электронной почты.

// Прикрепление файлов или данных к отправлениям
    use Illuminate\Mail\Mailables\Attachment;
    // Прикрепляем файл, используя его локальное имя
    public function attachments(): array
    {
        return [
            Attachment::fromPath('/absolute/path/to/file'),
        ];
    }

    // Прикрепляем файл, хранимый на одном из дисков файловой системы
    public function attachments(): array
    {
        return [
            // Прикрепить файл с диска по умолчанию
            Attachment::fromStorage('/path/to/file'),
            // Прикрепить файл со стороннего диска
            Attachment::fromStorageDisk('s3', '/path/to/file'),
        ];
    }

    // Прикрепляем файл, передавая необработанные данные
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => file_get_contents($this->pdf), 'whitepaper.pdf')
                ->withMime('application/pdf'),
        ];
    }

// Маршрут для визуализации отправления
Route::get('preview-assignment-created-mailable', function () {
    $trainer = Trainer::first();
    $trainee = Trainee::first();
    return new \App\Mail\AssignmentCreated($trainer, $trainee);
});

// как будет выглядеть уведомление
Route::get('preview-notification', function () {
    $trainer = Trainer::first();
    $trainee = Trainee::first();
    return (new App\Notifications\AssignmentCreated($trainer, $trainee))
        ->toMail($trainee);
});

// очереди
queue()
Для помещения объекта отправления в очередь вместо его немедленной отправки передайте его методу Mail::queue(), а не Mail::send():
Mail::to($user)->queue(new AssignmentCreated($trainer, $trainee));
later()
Метод Mail::later() аналогичен Mail::queue(), но позволяет добавить задержку, задав ее величину в минутах
либо передав объект DateTime или Carbon с датой и временем, когда нужно извлечь из очереди и отправить электронное письмо:
$when = now()->addMinutes(30);
Mail::to($user)->later($when, new AssignmentCreated($trainer, $trainee));
Обоим методам, queue() и later(), можно указать, какую именно очередь и подключение к очереди следует использовать, вызвав методы onConnection() и onQueue() в объекте отправления:
$message = (new AssignmentCreated($trainer, $trainee))
    ->onConnection('sqs')
    ->onQueue('emails');
Mail::to($user)->queue($message);
Если нужно, чтобы определенное отправление всегда помещалось в очередь, то реализуйте в его классе интерфейс Illuminate\Contracts\Queue\ShouldQueue.

------------------------------------------------------------------------------------------------------------------------
// Тестирование

// Проверка данных, определяемых методом envelope()
$mailable = new AssignmentCreated($trainer, trainee);
$mailable->assertFrom('noreply@mytrainingapp.com');
$mailable->assertTo('user@gmail.com');
$mailable->assertHasCc('trainer@mytrainingapp.com');
$mailable->assertHasBcc('records@mytrainingapp.com');
$mailable->assertHasReplyTo('trainer@mytrainingap.com');
$mailable->assertHasSubject('New assignment from Faith Elizabeth');
$mailable->assertHasTag('assignments');
$mailable->assertHasMetadata('clientId', 4);

// Проверка содержимого почтового сообщения
$mailable->assertSeeInHtml($trainee->name);
$mailable->assertSeeInHtml('You have received a new training assignment');
$mailable->assertSeeInOrderInHtml(['Hey', 'You have received']);
$mailable->assertSeeInText($trainee->name);
$mailable->assertSeeInOrderInText(['Hey', 'You have received']);

// Проверка вложений, отправляемых по почте
$mailable->assertHasAttachment('/pdfs/assignment-24.pdf');
$mailable->assertHasAttachment(Attachment::fromPath('/pdfs/assignment-24.pdf'));
$mailable->assertHasAttachedData($pdfData, 'assignment-24.pdf', [
    'mime' => 'application/pdf',
]);
$mailable->assertHasAttachmentFromStorage(
    '/pdfs/assignment-24.pdf',
    'assignment-24.pdf',
    ['mime' => 'application/pdf']
);
$mailable->assertHasAttachmentFromStorageDisk(
    's3',
    '/pdfs/assignment-24.pdf',
    'assignment-24.pdf',
    ['mime' => 'application/pdf']
);

// Проверка факта отправки почты
Mail::fake();
// Вызов кода, отправляющего электронные письма
// Убедиться, что никаких отправлений не было
Mail::assertNothingSent();
// Убедиться, что отправления были отосланы
Mail::assertSent(AssignmentCreated::class);
// Убедиться, что отправление отослано определенное число раз
Mail::assertSent(AssignmentCreated::class, 4);
// Убедиться, что отправление не было отослано
Mail::assertNotSent(AssignmentCreated::class);
// Убедиться, что отправление поставлено в очередь
Mail::assertQueued(AssignmentCreated::class);
Mail::assertNotQueued(AssignmentCreated::class);
Mail::assertNothingQueued();

// Проверка свойств электронного письма в утверждениях
Mail::assertSent(
    AssignmentCreated::class,
    function (AssignmentCreated $mail) use ($trainer, $trainee) {
        return $mail->hasTo($trainee->email) && $mail->hasSubject('New assignment from ' . $trainer->name);
    }
);
Можно также использовать методы hasCc(), hasBcc(), hasReplyTo() и hasFrom().

*/