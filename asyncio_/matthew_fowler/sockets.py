"""
Сокет – это низкоуровневая абстракция отправки и получения дан-
ных по сети. Именно с ее помощью производится обмен данными
между клиентами и серверами. Сокеты поддерживают две основ-
ные операции: отправку и получение байтов. Мы записываем байты
в сокет, затем они передаются по адресу назначения, чаще всего на
какой-то сервер. Отправив байты, мы ждем, пока сервер пришлет от-
вет в наш сокет. Когда байты окажутся в сокете, мы сможем прочитать
результат.

Если нужно получить содержимое страницы example.com, то мы от-
крываем сокет, подключенный к серверу example.com. Затем записы-
ваем в сокет запрос и ждем ответа от сервера, в данном случае HTML-
кода веб-страницы.

По умолчанию сокеты блокирующие. Это значит, что на все вре-
мя ожидания ответа от сервера приложение приостанавливается
или блокируется. Следовательно, оно не может ничего делать, пока
не придут данные от сервера или произойдет ошибка или случится
тайм-аут.

На уровне операционной системы эта блокировка ни к чему. Со-
кеты могут работать в неблокирующем режиме, когда мы просто на-
чинаем операцию чтения или записи и забываем о ней, а сами зани-
маемся другими делами. Но позже операционная система уведомляет
нас о том, что байты получены, и в этот момент мы можем уделить
им внимание. Это позволяет приложению не ждать прихода байтов,
а делать что-то полезное. Для реализации такой схемы применяются
различные системы уведомления с помощью событий, разные в разных ОС.
Библиотека asyncio_ абстрагирует различия между системами
уведомления, а именно:
- kqueue – FreeBSD и MacOS;
- epoll – Linux;
- IOCP (порт завершения ввода-вывода) – Windows.

Эти системы наблюдают за неблокирующими сокетами и уведом-
ляют нас, когда с сокетом можно начинать работу. Именно они лежат
в основе модели конкурентности в asyncio_. В этой модели имеется
только один поток, исполняющий Python-код. Встретив операцию
ввода-вывода, интерпретатор передает ее на попечение системы
уведомления, входящей в состав ОС. Совершив этот акт, поток Python
волен исполнять другой код или открыть другие неблокирующие со-
кеты, о которых позаботится ОС. По завершении операции система
«пробуждает» задачу, ожидающую результата, после чего выполня-
ется код, следующий за этой операцией.

Для создания сокета нужно выполнить несколько шагов. Сначала
с помощью
функции socket создается сокет:

import socket

server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
address = (127.0.0.1, 8000)
server_socket.bind(server_address)
server_socket.listen()
connection, client_address = server_socket.accept()


Функция socket принимает два параметра. Первый, socket.AF_INET, – тип адреса,
в данном случае адрес будет содержать имя хоста и номер порта.
Второй, socket.SOCK_STREAM, означает, что для взаимодействия будет использоваться протокол TCP.

Мы также вызываем функцию setsockopt, чтобы установить флаг
SO_REUSEADDR в 1. Это позволит повторно использовать номер порта,
после того как мы остановим и заново запустим приложение, избежав
тем самым ошибки «Адрес уже используется». Если этого не
сделать, то операционной системе потребуется некоторое время, что-
бы освободить порт, после чего приложение сможет запуститься без
ошибок.

Функция socket.socket создает сокет, но начать взаимодействие по
нему мы еще не можем, потому что сокет не привязан к адресу, по
которому могут обращаться клиенты (у почтового отделения должен
быть адрес!). В данном случае мы привяжем сокет к адресу своего соб-
ственного компьютера 127.0.0.1 и выберем произвольный порт 8000.

Далее мы должны активно прослушивать запросы от клиентов,
желающих подключиться к нашему серверу. Для этого вызывается
метод сокета listen. Затем мы ждем запроса на подключение с помощью
метода accept. Этот метод блокирует программу до получения
запроса, после чего возвращает объект подключения и адрес подклю-
чившегося клиента. Объект подключения – это еще один сокет, ко-
торый можно использовать для чтения данных от клиента и записи
адресованных ему данных.

В классе socket имеется метод recv, который позволяет получать данные из
сокета. Метод принимает целое число, показывающее, сколько байтов мы хотим прочитать.
Это важно, потому что мы не можем прочитать из сокета сразу все данные,
а должны сохранять их в буфере, пока не дойдем до конца.

Создание неблокирующего сокета отличается от создания блокирующего только вызовом метода setblocking
с параметром False. По умолчанию это значение равно True, т. е. сокет блокирующий.

Использование модуля selectors для построения цикла событий сокетов

Эта библиотека предоставляет абстрактный базовый класс BaseSelector,
имеющий реализации для каждой системы уведомления.
Кроме того, имеется класс DefaultSelector, который автоматически
выбирает реализацию, подходящую для конкретной системы.
У класса BaseSelector есть несколько важных концепций. Первая из
них – регистрация. Если мы хотим получать уведомления для какого-
то сокета, то регистрируем его, сообщая, какие именно события нас
интересуют, например чтение и запись. Наоборот, если сокет нас
больше не интересует, то его регистрацию можно отменить.
Вторая концепция – селекция. Функция select блокирует выпол-
нение, пока не произойдет какое-то событие, после чего возвраща-
ет список сокетов, готовых для обработки, а также событие, которое
произошло с каждым сокетом. Поддерживается также тайм-аут – если
в течение указанного времени ничего не произошло, то возвращается
пустой список сокетов.

"""
# server
import selectors
import socket
from selectors import SelectorKey
from typing import List, Tuple
# selector = selectors.DefaultSelector()
# server_socket = socket.socket()
# server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
# server_address = ('127.0.0.1', 8000)
# server_socket.setblocking(False)
# server_socket.bind(server_address)
# server_socket.listen()
# selector.register(server_socket, selectors.EVENT_READ)
# while True:
#     events: List[Tuple[SelectorKey, int]] = selector.select(timeout=1)
#     if len(events) == 0:
#         print('Событий нет, подожду еще!')
#     for event, _ in events:
#         event_socket = event.fileobj
#         if event_socket == server_socket:
#             connection, address = server_socket.accept()
#             connection.setblocking(False)
#             print(f"Получен запрос на подключение от {address}")
#             selector.register(connection, selectors.EVENT_READ)
#         else:
#             data = event_socket.recv(1024)
#             print(f"Получены данные: {data}")
#             event_socket.send(data)


# client

sock = socket.socket()
sock.connect(('localhost', 8000))
sock.send(b'boom\r\n')
while True:
    data = sock.recv(1024)
# sock.close()
    print(data.decode('utf-8'))
