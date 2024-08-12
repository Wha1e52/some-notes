"""
publisher всегда пишет в exchange
publisher определяет delivery mode(1 по-умолчанию и не сохранит на диск. 2 - сохранит) для каждого сообщения

в exchange ставим durable()
типы exchange:
- fanout - публикует во все очереди (30k mps)
- direct - статический роутинг(по-умолчанию) (30k mps)
- topic - роутинг с вайлдкардами (5k mps)
- headers - роутинг по заголовкам (1k mps)

queue
durable включает сохранение (при перезагрузке без него не сохранится даже если deliver mode = 2 )

message
основные поля:
- payload (рекомендуется использовать не больше 128 мегабайт)
- routingkey (для маршрутизации типа direct, topic. может быть одно на сообщение)
- headers

consumer подписывается на определенную queue (1 consumer - 1 логика, 1 канал - 1 queue. золотое правило)
prefetch_count - кол-во неподтвержденных сообщений в один момент работы рэбита

By default, RabbitMQ will send each message to the next consumer, in sequence.
On average every consumer will get the same number of messages. This way of distributing messages is called round-robin.
"""

