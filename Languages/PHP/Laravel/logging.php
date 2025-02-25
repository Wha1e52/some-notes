<?php
/*

// Запись сообщений в журналы
Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);

Log::error('Failed to upload user image.', ['user' => $user]);

// Каналы журналирования (stack, single, daily, slack, stderr, syslog и errorlog)

// Канал single
    Канал single записывает журнальные записи в общий файл, путь к которому задается в ключе path.
// Канал daily
    Канал daily (ежедневный) создает новый файл для каждого нового дня.
    Данный канал сходен с single, но здесь можно указать срок хранения журналов в днях до их очистки, а к указанному нами имени файла добавляется дата.
// Канал slack
    Канал slack позволяет отправлять журналы (все или некоторые) в Slack.
// Канал stack
    Канал stack позволяет передавать все журналы сразу в несколько каналов, указанных в массиве channels.
    Ваши приложения Laravel настраиваются на этот канал по умолчанию.
    В силу того что по умолчанию в channels содержит только значение 'single',
    в действительности приложение будет использовать канал 'single'.
// Настройка драйвера stack
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'slack'],
    ],
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'info',
        'days' => 14,
    ],
    'slack' => [
        'driver' => 'slack',
        'url' => env('LOG_SLACK_WEBHOOK_URL'),
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
    ],
]

// Запись сообщений в конкретные каналы журналирования
Log::channel('slack')->info("This message will go to Slack.");










*/