# Паттерн "Моносостояние"

class ThreadData:
    __shared_attr = {
        'name': 'thread1',
        'data': {},
        'id': 1
    }

    def __init__(self):
        self.__dict__ = self.__shared_attr


th1 = ThreadData()
th2 = ThreadData()
