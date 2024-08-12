"""
https://www.mankier.com/1/redis-cli#Examples_(TL;DR)

todo Подключение:

# Подключиться с параметрами по умолчанию - Host: 127.0.0.1, Port: 6379
redis-cli

# явное указание
redis-cli -h 127.0.0.1 -p 6379

# тоже самое только используя URI
redis-cli -u redis://localhost:6379

# с использованием пароля используя URI
redis-cli -u redis://password@localhost:6379

# с указанием пароля и базы данных (0-15)
redis-cli -u redis://password@localhost:6379/2

# с использованием пароля
redis-cli -a Passw0Rd

# подключиться к базе данных #2
redis-cli -n 2
________________________________________________________________________________________________________________________
redis-cli -r 3 incr counter                       # Запуск команды incr 3 раза
redis-cli -r 3 -i 0.5 incr counter                # Запуск команды incr 3 раза c интервалом 0.5 секунды
redis-cli -r 3 -i 0.5 -n 2 incr counter           # Запуск команды incr 3 раза c интервалом 0.5 секунды и выполнить данную команду в базе #2.
redis-cli --raw incr counter > counter.log        # Запуск команды incr и сохранение результата во внешний файл
redis-cli -x set file < example-10.sh             # Прочитать содержимое example-10.sh и записать в ключ file
redis-cli --csv lrange mylist 0 -1                # Выводим результат в формате CSV
redis-cli --stat                                  # Получаем статистику по серверу
redis-cli --latency                               # Получаем статистику по задержкам
redis-cli --latency-history -i 5                  # Выводим статистику по задержкам и ограничиваем интервал вывода 5 секунд
redis-cli --bigkeys                               # находим самые большие ключи или списки
redis-cli --memkeys                               # находим самые большие ключи или списки (занимаемая память)
redis-cli --scan                                  # находим самые большие ключи или списки (сложность)
redis-cli --scan --pattern '*l*'
redis-cli --eval /home/user/script.lua            # выполнить внешний скрипт
redis-cli dbsize                                  # Получить размер всех 16 баз(кол-во ключей?)
redis-cli -n 2 dbsize                             # Получить размер базы #2

select 2                                          # Команда переключит нас на базу #2 в рамках одного сервера
5 incr orders                                     # Выполнит команду incr для ключа orders 5 раз
AUTH password                                     # Аутентифицирует клиента
BGSAVE                                            # сохранит данные на диск
BGREWRITEAOF                                      # сжимает данные файла appendonly
CLIENT LIST                                       # Получим список подключённых клиентов
CLIENT HELP                                       # Подсказка по команде CLIENT
CONFIG SET                                        # установить параметр конфигурации например CONFIG SET AUTH requirepass


EXISTS key     # возвращает 1 если есть, 0 если нет
FLUSHALL       # удаляет все данные
KEYS *         # возвращает список ключей. очень медленная, использовать только в отладочных целях
________________________________________________________________________________________________________________________
todo Strings

SET key value                   # сохраняет пару ключ-значение
MSET key1 value1 key2 value2    # сохраняет несколько значений

SET foo 'hello' EX 20           # сохраняется на 20 секунд
SET bar 'world' PX 20           # сохраняется на 20 миллисекунд
SET baz 'xyz' NX                # сохраняется если нет ключа

SETEX key seconds value         # сохраняется на seconds секунд(DEPRECATED)
PSETEX key milliseconds value   # сохраняется на milliseconds миллисекунд(DEPRECATED)
SETNX key value                 # SET if Not eXists(DEPRECATED)
MSETNX key1 value1 key2 value2  # will not perform any operation at all even if just a single key already exists.

STRLEN key                      # возвращает длину строки

GET key                         # возвращает значение по ключу

GETSET key value                # возвращает старое значение и устанавливает новое
GETSET foo 'xyz'                # вернет 'hello' и установит 'xyz'

APPEND foo ' world'             # добавляет значение в конец строки и возвращает длину строки, если ключа нет - создаст

GETRANGE key start end          # вернет строку между start и end включительно
SETRANGE key offset value       # заменит часть строки на value, начиная с offset(индекс). Все что после длинны value не заменится

INCR key  # увеличивает значение на 1 и возвращает итоговое значение (если ключа не существует, то создаст и увеличит значение на 1)
INCR key --raw   # выводить только значение, без типа данных
DECR key  # уменьшает значение на 1
INCRBY key increment   # увеличивает значение на increment
INCRBYFLOAT key increment  # увеличивает значение на increment с плавающей точкой
DECRBY key decrement   # уменьшает значение на decrement
________________________________________________________________________________________________________________________
todo Hash

HSET key field value             # добавляет пару ключ-значение
HSET person1 name 'John'
HSET person1 age 18
HSETNX key field value           # добавляет пару ключ-значение если нет такого поля

HGET key field                   # возвращает значение
HGETALL key                      # возвращает последовательно key, value
HVALS key                        # возвращает все значения
HKEYS key                        # возвращает все ключи
HDEL key field                   # удаляет пару ключ-значение

HEXISTS key field                # возвращает 1 если есть, 0 если нет
HINCRBY key field increment      # увеличивает значение на increment
HLEN key                         # возвращает длинну словаря
HMGET key field1 field2          # возвращает значения нескольких полей
HMSET key field1 value1 field2 value2

________________________________________________________________________________________________________________________
todo Множества

SADD key value          # добавляет элемент в множество, можно сразу несколько значений
SADD persons 'John' 'Bob'
SADD persons 'Tom'

SMEMBERS key                        # возвращает список элементов множества
SISMEMBER key value                 # возвращает 1 если элемент есть в множестве
SRANDMEMBER key                     # возвращает случайное значение из множества
SCARD key                           # возвращает количество элементов множества
SUNION key1 key2                    # возвращает новое объединенное множество уникальных элементов
SUNIONSTORE dest key1 key2          # возвращает объединенное множество и сохраняет в dest
SDIFF key1 key2                     # возвращает разность множеств (из первого вычитаем второе и возвращаются элементы из первого, которых нет во втором)
SDIFFSTORE dest key1 key2           # возвращает разность множеств и сохраняет в dest
SINTER key1 key2                    # возвращает пересечение множеств
SINTERSTORE dest key1 key2          # возвращает пересечение множеств и сохраняет в dest
SPOP key                            # возвращает случайное значение из множества и удаляет его, можно указать кол-во
SREM key value                      # удаляет элемент из множества
SMOVE source destination value      # перемещает элемент из одного множества в другое
________________________________________________________________________________________________________________________
todo Списки

LPUSH key value         # добавляет элемент в начало списка, можно передать сразу несколько значений
LPUSHX key value        # добавляет элемент в начало списка если ключ существует
LRANGE key start stop   # возвращает элементы списка в диапазоне. (0 и -1 тоже работают)
RPUSH key value         # добавляет элемент в конец списка
LPOP key                # возвращает первый элемент списка и удаляет его
RPOP key                # возвращает последний элемент списка и удаляет его
LSET key index value    # устанавливает элемент списка по индексу(заменяет значение этого индекса)
LINDEX key index        # возвращает элемент списка по индексу
LLEN key                # возвращает длину списка
LREM key count value    # удаляет count первых вхождений value из списка. Если count отрицательный, то удаляются с конца
LINSERT key BEFORE|AFTER pivot value                # вставляет value перед/после pivot
LTRIM key start stop    # удаляет все элементы списка кроме диапазона
RPOPLPUSH key1 key2     # возвращает и удаляет последний элемент из key1 и добавляет его в начало key2
BLPOP key1 key2 timeout # If none of the specified keys exist, BLPOP blocks the connection until another client performs an LPUSH or RPUSH operation against one of the keys. Once new data is present on one of the lists, the client returns with the name of the key unblocking it and the popped value.


________________________________________________________________________________________________________________________
todo Упорядоченные множества

ZADD key score value    # добавляет элемент в множество, сортирует по score
ZADD teachers 1990 'John'
ZADD teachers 1970 'Max'


ZCARD key                                           # возвращает количество элементов упорядоченного множества
ZRANGE key start stop (WITHSCORES) (REV) (BYSCORE)                                  # возвращает элементы множества в диапазоне. WITHSCORES вернет и их score, REV - в обратном порядке
ZINCRBY key increment member                # увеличивает score элемента на increment
ZSCORE key member                           # возвращает score элемента
ZRANK key member                            # возвращает индекс элемента
ZCOUNT key min max                          # возвращает количество элементов в диапазоне score
ZREM key member                             # удаляет элемент из множества
ZREMRANGEBYSCORE key min max                # удаляет элементы множества в диапазоне по score


ZREVRANGE key start stop (WITHSCORES)       # возвращает элементы множества в обратном порядке(DEPRECATED)
ZRANGEBYSCORE key min max (WITHSCORES)      # возвращает элементы множества в диапазоне по score(DEPRECATED)
ZREVRANGEBYSCORE key max min (WITHSCORES)   # возвращает элементы множества в обратном порядке по score(DEPRECATED)
________________________________________________________________________________________________________________________
todo Транзакции

MULTI # начинает транзакцию(на самом деле не транзакция, а просто позволяет выполнять несколько команд в одном запросе)
EXEC # завершает транзакцию
DISCARD # прерывает транзакцию

MULTI
ZADD teachers 1990 'John'
INCR counter
EXEC
________________________________________________________________________________________________________________________
todo Подписки (сервер сообщений)

SUBSCRIBE channel # подписывается на канал или множество каналов
PSUBSCRIBE pattern # подписывается на канал по шаблону
PUBLISH channel message # публикует сообщение в канал
UNSUBSCRIBE channel # отписывается от канала





"""






























