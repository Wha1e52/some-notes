class Test:
    __slots__ = ('x', 'y')  # разрешает работать только с этими локальными атрибутами

    def __init__(self, x, y):
        self.x = x
        self.y = y


a = Test(1, 2)

a.z = 3  # создать не получится
