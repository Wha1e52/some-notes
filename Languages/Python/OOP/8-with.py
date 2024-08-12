# Контекстный менеджер - способ высвободить ресурсы автоматически, не отвлекаясь на них

from contextlib import contextmanager


# первый метод

@contextmanager
def open_resource(*args):
    file = None
    try:
        file = open(*args)
        yield file
    except Exception:
        raise
    finally:
        file.close()


with open_resource('some_file.txt') as f:
    pass


# ______________________________________________________________________________________________________________________

# второй метод

class Test:
    def __init__(self, v):
        self.__v = v

    def __enter__(self):
        self.__temp = '11111'
        return self.__temp  # будет передано в переменную после "as": with Test(aaa) as some_list

    def __exit__(self, exc_type, exc_val, exc_tb):
        pass
        print('!')

        # exc_type: Тип исключения, которое было поднято в блоке with. Если исключений не было, то значение равно None.

        # exc_val: Экземпляр исключения, которое было поднято. Если исключений не было, то значение равно None.

        # exc_tb: Объект трассировки стека, связанный с исключением. Если исключений не было, то значение равно None.

        # return True: исключения будут проигнорированы и не будут подняты


aaa = [1, 2, 3]

with Test(aaa) as some_list:
    raise ValueError()

# ______________________________________________________________________________________________________________________

# асинхронный контекстный менеджер

import asyncio
import socket


class ConnectedSocket:
    def __init__(self, server_socket):
        self._connection = None
        self._server_socket = server_socket

    async def __aenter__(self):
        print('Вход в контекстный менеджер, ожидание подключения')
        loop = asyncio.get_event_loop()
        connection, address = await loop.sock_accept(self._server_socket)
        self._connection = connection
        print('Подключение подтверждено')
        return self._connection

    async def __aexit__(self, exc_type, exc_val, exc_tb):
        print('Выход из контекстного менеджера')
        self._connection.close()
        print('Подключение закрыто')


async def main():
    loop = asyncio.get_event_loop()
    server_socket = socket.socket()
    server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server_address = ('127.0.0.1', 8000)
    server_socket.setblocking(False)
    server_socket.bind(server_address)
    server_socket.listen()
    async with ConnectedSocket(server_socket) as connection:
        data = await loop.sock_recv(connection, 1024)
        print(data)

asyncio.run(main())
