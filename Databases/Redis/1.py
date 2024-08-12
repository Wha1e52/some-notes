"""
Redis is not a replacement for your PostgreSQL database, but it does offer fast in-memory storage that is more
suitable for certain tasks. Add it to your stack and use it when you really feel it’s needed. The following
are some scenarios in which Redis could be useful:

    • Counting: As you have seen, it is very easy to manage counters with Redis. You can use incr()
    and incrby() for counting stuff.
    • Storing the latest items: You can add items to the start/end of a list using lpush() and rpush().
    Remove and return the first/last element using lpop()/rpop(). You can trim the list’s length
    using ltrim() to maintain its length.
    • Queues: In addition to push and pop commands, Redis offers the blocking of queue commands.
    • Caching: Using expire() and expireat() allows you to use Redis as a cache. You can also find
    third-party Redis cache backends for Django.
    • Pub/sub: Redis provides commands for subscribing/unsubscribing and sending messages to
    channels.
    • Rankings and leaderboards: Redis’ sorted sets with scores make it very easy to create leaderboards.
    • Real-time tracking: Redis’s fast I/O makes it perfect for real-time scenarios.

    - кеширование данных
    - чаты и системы обмена сообщениями
    - различные очереди задач

Очень быстрая база данных где данные хранятся в оперативной памяти. При этом имеет персистентное хранилище на диске.
Одновременно является key-value хранилищем, хранилищем сложных структур данных, сервером очередей и службой подписки
на сообщения.
"""
import redis
# Redis settings
REDIS_HOST = 'localhost'
REDIS_PORT = 6379
REDIS_DB = 1

# connect to redis
r = redis.Redis(host=REDIS_HOST,
                port=REDIS_PORT,
                db=REDIS_DB)


# pip install redis
# docker run -it --rm --name redis -p 6379:6379 redis
# docker exec -it redis sh
# redis-cli























